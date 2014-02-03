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


require_once "modules/Mailer/MailerFactory.php"; // imports all of the Mailer classes that are needed

class ReportsUtilities
{
    private $user;
    private $language;

    public function __construct() {
        global $current_user,
               $current_language;

        $this->user     = $current_user;
        $this->language = $current_language;
    }

    /**
     * Notify the report owner of an invalid report definition.
     *
     * @param User   $recipient required
     * @param string $message   required
     * @throws MailerException Allows exceptions to bubble up for the caller to report if desired.
     */
    public function sendNotificationOfInvalidReport($recipient, $message) {
        $mailer = MailerFactory::getSystemDefaultMailer();

        // set the subject of the email
        $mod_strings = return_module_language($this->language, "Reports");
        $mailer->setSubject($mod_strings["ERR_REPORT_INVALID_SUBJECT"]);

        // set the body of the email...

        $textOnly = EmailFormatter::isTextOnly($message);
        if ($textOnly) {
            $mailer->setTextBody($message);
        } else {
            $textBody = strip_tags(br2nl($message)); // need to create the plain-text part
            $mailer->setTextBody($textBody);
            $mailer->setHtmlBody($message);
        }

        // add the recipient...

        // first get all email addresses known for this recipient
        $recipientEmailAddresses = array($recipient->email1, $recipient->email2);
        $recipientEmailAddresses = array_filter($recipientEmailAddresses);

        // then retrieve first non-empty email address
        $recipientEmailAddress = array_shift($recipientEmailAddresses);

        // a MailerException is raised if $email is invalid, which prevents the call to send below
        $mailer->addRecipientsTo(new EmailIdentity($recipientEmailAddress));

        // send the email
        $mailer->send();
    }
}
