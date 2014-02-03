<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/



$modListHeader = array();
require_once('modules/Reports/SavedReport.php');
require_once('modules/Reports/schedule/ReportSchedule.php');
require_once('modules/Reports/templates/templates_pdf.php');
require_once('include/modules.php');
require_once('config.php');
require_once "modules/Mailer/MailerFactory.php"; // imports all of the Mailer classes that are needed

global $sugar_config,
       $current_language,
       $app_list_strings,
       $app_strings,
       $locale;

$language         = $sugar_config['default_language']; // here we'd better use English, because pdf coding problem.
$app_list_strings = return_app_list_strings_language($language);
$app_strings      = return_application_language($language);

$reportSchedule = new ReportSchedule();
$reportsToEmail = $reportSchedule->get_reports_to_email();


global $report_modules,
       $modListHeader,
       $current_user;

foreach ($reportsToEmail as $scheduleInfo) {
    $GLOBALS["log"]->debug("-----> in Reports foreach() loop");

    $user = BeanFactory::getBean('Users', $schedule_info['user_id']);

    $current_user = $user; // this changes the global $current_user

    $modListHeader  = query_module_access_list($current_user);
    $report_modules = getAllowedReportModules($modListHeader);

    $theme       = $sugar_config['default_theme'];
    $savedReport = BeanFactory::getBean('Reports', $schedule_info['report_id']);

    $GLOBALS["log"]->debug("-----> Generating Reporter");
    $reporter = new Report(html_entity_decode($savedReport->content));

    $mod_strings = return_module_language($current_language, 'Reports');

    // prevent invalid report from being processed
    if (!$reporter->is_definition_valid()) {
        $invalidFields = $reporter->get_invalid_fields();
        $args          = array($scheduleInfo['report_id'], implode(', ', $invalidFields));
        $message       = string_format($mod_strings['ERR_REPORT_INVALID'], $args);

        $GLOBALS["log"]->fatal("-----> {$message}");

        try {
            require_once 'modules/Reports/utils.php';

            BeanFactory::getBean('Users', $savedReport->assigned_user_id);
            $reportOwner = new User();
            $reportOwner->retrieve($savedReport->assigned_user_id);

            $reportsUtils = new ReportsUtilities();
            $reportsUtils->sendNotificationOfInvalidReport($reportOwner, $message);
        } catch (MailerException $me) {
            //@todo consider logging the error at the very least
        }
    } else {
        $GLOBALS["log"]->debug("-----> Reporter settings attributes");
        $reporter->layout_manager->setAttribute("no_sort", 1);

        $GLOBALS["log"]->debug("-----> Reporter Handling PDF output");
        $reportFilename = template_handle_pdf($reporter, false);

        // get the recipient's data...

        // first get all email addresses known for this recipient
        $recipientEmailAddresses = array($user->email1, $user->email2);
        $recipientEmailAddresses = array_filter($recipientEmailAddresses);

        // then retrieve first non-empty email address
        $recipientEmailAddress = array_shift($recipientEmailAddresses);

        // get the recipient name that accompanies the email address
        $recipientName = $locale->getLocaleFormattedName($user->first_name, $user->last_name);

        try {
            $GLOBALS["log"]->debug("-----> Generating Mailer");
            $mailer = MailerFactory::getMailerForUser($current_user);

            // set the subject of the email
            $subject = empty($savedReport->name) ? "Report" : $savedReport->name;
            $mailer->setSubject($subject);

            // add the recipient
            $mailer->addRecipientsTo(new EmailIdentity($recipientEmailAddress, $recipientName));

            // attach the report, using the subject as the name of the attachment
            $charsToRemove  = array("\r", "\n");
            $attachmentName = str_replace($charsToRemove, "", $subject); // remove these characters from the attachment name
            $attachmentName = str_replace(" ", "_", "{$attachmentName}.pdf"); // replace spaces with the underscores
            $attachment     = new Attachment($reportFilename, $attachmentName, Encoding::Base64, "application/pdf");
            $mailer->addAttachment($attachment);

            // set the body of the email
            $body = $mod_strings["LBL_HELLO"];

            if ($recipientName != "") {
                $body .= " {$recipientName}";
            }

            $body .= ",\n\n" .
                     $mod_strings["LBL_SCHEDULED_REPORT_MSG_INTRO"] .
                     $savedReport->date_entered .
                     $mod_strings["LBL_SCHEDULED_REPORT_MSG_BODY1"] .
                     $savedReport->name .
                     $mod_strings["LBL_SCHEDULED_REPORT_MSG_BODY2"];

            $textOnly = EmailFormatter::isTextOnly($body);
            if ($textOnly) {
                $mailer->setTextBody($body);
            } else {
                $textBody = strip_tags(br2nl($body)); // need to create the plain-text part
                $mailer->setTextBody($textBody);
                $mailer->setHtmlBody($body);
            }

            $GLOBALS["log"]->debug("-----> Sending PDF via Email to [ {$recipientEmailAddress} ]");
            $mailer->send();

            $GLOBALS["log"]->debug("-----> Send successful");
            $reportSchedule->update_next_run_time(
                $scheduleInfo["id"],
                $scheduleInfo["next_run"],
                $scheduleInfo["time_interval"]
            );
        } catch (MailerException $me) {
            switch ($me->getCode()) {
                case MailerException::InvalidEmailAddress:
                    $GLOBALS["log"]->info("No email address for {$recipientName}");
                    break;
                default:
                    $GLOBALS["log"]->fatal("Mail error: " . $me->getMessage());
                    break;
            }
        }

        $GLOBALS["log"]->debug("-----> Removing temporary PDF file");
        unlink($reportFilename);
    }
}

sugar_cleanup(false); // continue script execution so that if run from Scheduler, job status will be set back to "Active"
