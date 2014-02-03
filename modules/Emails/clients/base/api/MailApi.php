<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

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


require_once('clients/base/api/ModuleApi.php');
require_once('modules/Emails/MailRecord.php');
require_once('modules/Emails/EmailRecipientsService.php');
require_once('modules/Emails/EmailUI.php');

class MailApi extends ModuleApi
{
    /*-- API Argument Constants --*/
    const EMAIL_CONFIG  = "email_config";
    const TO_ADDRESSES  = "to_addresses";
    const CC_ADDRESSES  = "cc_addresses";
    const BCC_ADDRESSES = "bcc_addresses";
    const ATTACHMENTS   = "attachments";
    const TEAMS         = "teams";
    const RELATED       = "related";
    const SUBJECT       = "subject";
    const HTML_BODY     = "html_body";
    const TEXT_BODY     = "text_body";
    const STATUS        = "status";

    /*-- API Fields with default values --*/
    public static $fields = array(
        self::EMAIL_CONFIG  => '',
        self::TO_ADDRESSES  => array(),
        self::CC_ADDRESSES  => array(),
        self::BCC_ADDRESSES => array(),
        self::ATTACHMENTS   => array(),
        self::TEAMS         => array(),
        self::RELATED       => array(),
        self::SUBJECT       => '',
        self::HTML_BODY     => '',
        self::TEXT_BODY     => '',
        self::STATUS        => '',
    );

    /*-- Supported API Status values --*/
    static private $apiStatusValues = array(
        "draft",     // draft
        "ready",     // ready to be sent
    );

    /*-- Supported API Attachment Type values --*/
    static private $apiAttachmentTypes = array(
        "document",
        "template",
        "upload",
    );

    private $emailRecipientsService;

    public function registerApiRest()
    {
        $api = array(
            'createMail'      => array(
                'reqType'   => 'POST',
                'path'      => array('Mail'),
                'pathVars'  => array(''),
                'method'    => 'createMail',
                'shortHelp' => 'Create Mail Item',
                'longHelp'  => 'modules/Emails/clients/base/api/help/mail_post_help.html',
            ),
            //TODO: Implement updateMail fully
//            'updateMail'      => array(
//                'reqType'   => 'PUT',
//                'path'      => array('Mail', '?'),
//                'pathVars'  => array('', 'email_id'),
//                'method'    => 'updateMail',
//                'shortHelp' => 'Update Mail Item',
//                'longHelp'  => 'modules/Emails/clients/base/api/help/mail_record_put_help.html',
//            ),
            'recipientLookup' => array(
                'reqType'   => 'POST',
                'path'      => array('Mail', 'recipients', 'lookup'),
                'pathVars'  => array(''),
                'method'    => 'recipientLookup',
                'shortHelp' => 'Lookup Email Recipient Info',
                'longHelp'  => 'modules/Emails/clients/base/api/help/mail_recipients_lookup_post_help.html',
            ),
            'listRecipients'  => array(
                'reqType'   => 'GET',
                'path'      => array('Mail', 'recipients', 'find'),
                'pathVars'  => array(''),
                'method'    => 'findRecipients',
                'shortHelp' => 'Search For Email Recipients',
                'longHelp'  => 'modules/Emails/clients/base/api/help/mail_recipients_find_get_help.html',
            ),
            'validateEmailAddresses'  => array(
                'reqType'   => 'POST',
                'path'      => array('Mail', 'address', 'validate'),
                'pathVars'  => array(''),
                'method'    => 'validateEmailAddresses',
                'shortHelp' => 'Validate One Or More Email Address',
                'longHelp'  => 'modules/Emails/clients/base/api/help/mail_address_validate_post_help.html',
            ),
            'saveAttachment' => array(
                'reqType' => 'POST',
                'path' => array('Mail', 'attachment'),
                'pathVars' => array('', ''),
                'method' => 'saveAttachment',
                'rawPostContents' => true,
                'shortHelp' => 'Saves a mail attachment.',
                'longHelp' => 'modules/Emails/clients/base/api/help/mail_attachment_post_help.html',
            ),
            'removeAttachment' => array(
                'reqType' => 'DELETE',
                'path' => array('Mail', 'attachment', '?'),
                'pathVars' => array('', '', 'file_guid'),
                'method' => 'removeAttachment',
                'rawPostContents' => true,
                'shortHelp' => 'Removes a mail attachment',
                'longHelp' => 'modules/Emails/clients/base/api/help/mail_attachment_record_delete_help.html',
            ),
            'clearUserCache' => array(
                'reqType' => 'DELETE',
                'path' => array('Mail', 'attachment', 'cache'),
                'pathVars' => array('', '', ''),
                'method' => 'clearUserCache',
                'rawPostContents' => true,
                'shortHelp' => 'Clears the user\'s attachment cache directory',
                'longHelp' => 'modules/Emails/clients/base/api/help/mail_attachment_cache_delete_help.html',
            ),
        );

        return $api;
    }

    /**
     * @param $api
     * @param $args
     * @return array
     */
    public function createMail($api, $args)
    {
        return $this->handleMail($api, $args);
    }

    /**
     * @param $api
     * @param $args
     * @return array
     */
    public function updateMail($api, $args)
    {
        $email = new Email();

        if (isset($args['email_id']) && !empty($args['email_id'])) {
            if ((!$email->retrieve($args['email_id'])) || ($email->id != $args['email_id'])) {
                throw new SugarApiExceptionMissingParameter();
            }

            if ($email->status != 'draft') {
                throw new SugarApiExceptionRequestMethodFailure();
            }
        } else {
            throw new SugarApiExceptionInvalidParameter();
        }

        return $this->handleMail($api, $args);
    }

    /**
     * @param $api
     * @param $args
     * @return array
     */
    protected function handleMail($api, $args)
    {
        // Perform Front End argument validation per the Mail API architecture
        // Non-compliant arguments will result in an Invalid Parameter Exception Thrown
        $this->validateArguments($args);

        $mailRecord = $this->initMailRecord($args);

        try {
            if ($args[self::STATUS] == "ready") {
                $response = $mailRecord->send();          // send immediately
            } else {
                $response = $mailRecord->saveAsDraft();   // save as draft
            }
        } catch (MailerException $e) {
            $eMessage = $e->getUserFriendlyMessage();
            if (isset($GLOBALS["log"])) {
                $GLOBALS["log"]->error("MailApi: Request Failed - Message: {$eMessage}");
            }
            throw new SugarApiExceptionRequestMethodFailure($eMessage, null, 'Emails');
        }

        return $response;
    }

    /**
     * This endpoint accepts an array of one or more recipients and tries to resolve unsupplied arguments.
     * EmailRecipientsService::lookup contains the lookup and resolution rules.
     *
     * @param $api
     * @param $args
     * @return array
     */
    public function recipientLookup($api, $args)
    {
        $recipients = $args;
        unset($recipients['__sugar_url']);

        $emailRecipientsService = $this->getEmailRecipientsService();

        $result = array();
        foreach ($recipients as $recipient) {
            $result[] = $emailRecipientsService->lookup($recipient);
        }

        return $result;
    }

    /**
     * Finds recipients that match the search term.
     *
     * Arguments:
     *    q           - search string
     *    module_list -  one of the keys from $modules
     *    order_by    -  columns to sort by (one or more of $sortableColumns) with direction
     *                   ex.: name:asc,id:desc (will sort by last_name ASC and then id DESC)
     *    offset      -  offset of first record to return
     *    max_num     -  maximum records to return
     *
     * @param $api
     * @param $args
     * @return array
     */
    public function findRecipients($api, $args) {
        ini_set("max_execution_time", 300);
        $term    = (isset($args["q"])) ? trim($args["q"]) : "";
        $offset  = 0;
        $limit   = (!empty($args["max_num"])) ? (int)$args["max_num"] : 20;
        $orderBy = array();

        if (!empty($args["offset"])) {
            if ($args["offset"] === "end") {
                $offset = "end";
            } else {
                $offset = (int)$args["offset"];
            }
        }

        $modules = array(
            "users"     => "users",
            "accounts"  => "accounts",
            "contacts"  => "contacts",
            "leads"     => "leads",
            "prospects" => "prospects",
            "all"       => "LBL_DROPDOWN_LIST_ALL",
        );
        $module  = $modules["all"];

        if (!empty($args["module_list"])) {
            $moduleList = strtolower($args["module_list"]);

            if (array_key_exists($moduleList, $modules)) {
                $module = $modules[$moduleList];
            }
        }

        if (!empty($args["order_by"])) {
            $orderBys = explode(",", $args["order_by"]);

            foreach ($orderBys as $sortBy) {
                $column    = $sortBy;
                $direction = "ASC";

                if (strpos($sortBy, ":")) {
                    // it has a :, it's specifying ASC / DESC
                    list($column, $direction) = explode(":", $sortBy);

                    if (strtolower($direction) == "desc") {
                        $direction = "DESC";
                    } else {
                        $direction = "ASC";
                    }
                }

                // only add column once to the order-by clause
                if (empty($orderBy[$column])) {
                    $orderBy[$column] = $direction;
                }
            }
        }

        $records    = array();
        $nextOffset = -1;

        if ($offset !== "end") {
            $emailRecipientsService = $this->getEmailRecipientsService();
            $totalRecords           = $emailRecipientsService->findCount($term, $module);
            $records                = $emailRecipientsService->find($term, $module, $orderBy, $limit, $offset);
            $trueOffset             = $offset + $limit;

            if ($trueOffset < $totalRecords) {
                $nextOffset = $trueOffset;
            }
        }

        return array(
            "next_offset" => $nextOffset,
            "records"     => $records,
        );
    }

    /**
     * Perform Audit Validation on Input Arguments and normalize
     *
     * @param array  - $args
     */
    public function validateArguments(&$args)
    {
        global $app_list_strings;
        $relatedToModules = array_keys($app_list_strings['parent_type_display']);

        /*--- Validate status value ---*/
        if (empty($args[self::STATUS]) || !in_array($args[self::STATUS], self::$apiStatusValues)) {
            $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_VALUE', array(self::STATUS));
        }

        /*--- Validate Mail Configuration ---*/
        if ($args[self::STATUS] !== "draft" && empty($args[self::EMAIL_CONFIG])) {
            $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_VALUE', array(self::EMAIL_CONFIG));
        }

        /*--- Validate TO Recipients ---*/
        $this->validateRecipients($args, self::TO_ADDRESSES);

        /*--- Validate CC Recipients ---*/
        $this->validateRecipients($args, self::CC_ADDRESSES);

        /*--- Validate BCC Recipients ---*/
        $this->validateRecipients($args, self::BCC_ADDRESSES);

        /*--- Validate Attachments ---*/
        if (isset($args[self::ATTACHMENTS])) {
            if (!is_array($args[self::ATTACHMENTS])) {
                $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array(self::ATTACHMENTS));
            }
            foreach ($args[self::ATTACHMENTS] as $attachment) {
                if (!is_array($attachment)) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array(self::ATTACHMENTS));
                }
                if (empty($attachment['type']) || !in_array($attachment['type'], self::$apiAttachmentTypes)) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::ATTACHMENTS, 'type'));
                }
                if (empty($attachment['id']) || !is_string($attachment['id'])) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::ATTACHMENTS, 'id'));
                }
                if ($attachment['type'] == 'upload' && empty($attachment['name'])) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::ATTACHMENTS, 'name'));
                }
            }
        }

        /*--- Validate Teams ---*/
        if (isset($args[self::TEAMS])) {
            if (!is_array($args[self::TEAMS])) {
                $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array(self::TEAMS));
            }
            /* Primary is REQUIRED if Teams supplied */
            if (!isset($args[self::TEAMS]["primary"]) || !is_string($args[self::TEAMS]["primary"]) || empty($args[self::TEAMS]["primary"])) {
                $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::TEAMS, 'primary'));
            }
            if (isset($args[self::TEAMS]["others"])) {
                if (!is_array($args[self::TEAMS]["others"])) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::TEAMS, 'others'));
                }
                foreach ($args[self::TEAMS]["others"] as $otherTeam) {
                    if (!is_string($otherTeam) || empty($otherTeam)) {
                        $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::TEAMS, 'others'));
                    }
                }
            }
        }

        /*--- Validate Related ---*/
        if (isset($args[self::RELATED])) {
            if (!is_array($args[self::RELATED])) {
                $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array(self::RELATED));
            }
            if (!empty($args[self::RELATED])) {
                if (empty($args[self::RELATED]["id"]) || !is_string($args[self::RELATED]["id"])) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::RELATED, 'id'));
                }
                if (empty($args[self::RELATED]["type"]) || !is_string($args[self::RELATED]["type"])) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::RELATED, 'type'));
                }
                if (!in_array($args[self::RELATED]["type"], $relatedToModules)) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array(self::RELATED, 'type'));
                }
            }
        }

        /*--- Validate Subject ---*/
        if (isset($args[self::SUBJECT]) && !is_string($args[self::SUBJECT])) {
            $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array(self::SUBJECT));
        }

        /*--- Validate html_body ---*/
        if (isset($args[self::HTML_BODY]) && !is_string($args[self::HTML_BODY])) {
            $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array(self::HTML_BODY));
        }

        /*--- Validate text_body ---*/
        if (isset($args[self::TEXT_BODY]) && !is_string($args[self::TEXT_BODY])) {
            $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array(self::TEXT_BODY));
        }

        /*--- Initialize any Unprovided Arguments to their Defaults ---*/
        foreach (self::$fields AS $k => $v) {
            if (!isset($args[$k])) {
                $args[$k] = $v;
            }
        }

        /*--- If Sending Mail, make sure there is at least One Recipient specified --*/
        if (($args[self::STATUS] !== "draft") &&
            empty($args[self::TO_ADDRESSES]) &&
            empty($args[self::CC_ADDRESSES]) &&
            empty($args[self::BCC_ADDRESSES])) {
            $this->invalidParameter('LBL_MAILAPI_NO_RECIPIENTS');
        }

    }

    /**
     * Validate Recipient List
     *
     * @param $args - array
     * @param $argName - string
     */
     protected function validateRecipients($args, $argName) {
        if (isset($args[$argName])) {
            if (!is_array($args[$argName])) {
                $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array($argName));
            }
            foreach ($args[$argName] as $recipient) {
                if (!is_array($recipient)) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FORMAT', array($argName));
                }
                if (empty($recipient['email'])) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array($argName, "email"));
                }
                if (!is_string($recipient['email'])) {
                    $this->invalidParameter('LBL_MAILAPI_INVALID_ARGUMENT_FIELD', array($argName, "email"));
                }
            }
        }
    }

    /**
     * Log Audit Errors and Throw Appropriate Exception
     *
     * @param $message - string
     * @param $msgArgs - array
     */
    protected function invalidParameter($message, $msgArgs=null) {
        throw new SugarApiExceptionInvalidParameter($message, $msgArgs, 'Emails');
    }

    /**
     * Instantiate and initialize the MaiRecord from the incoming api arguments
     *
     * @param string  - $message
     */
    protected function initMailRecord($args)
    {
        $mailRecord               = new MailRecord();
        $mailRecord->mailConfig   = $args[self::EMAIL_CONFIG];
        $mailRecord->toAddresses  = $args[self::TO_ADDRESSES];
        $mailRecord->ccAddresses  = $args[self::CC_ADDRESSES];
        $mailRecord->bccAddresses = $args[self::BCC_ADDRESSES];
        $mailRecord->attachments  = $args[self::ATTACHMENTS];
        $mailRecord->teams        = $args[self::TEAMS];
        $mailRecord->related      = $args[self::RELATED];
        $mailRecord->subject      = $args[self::SUBJECT];
        $mailRecord->html_body    = $args[self::HTML_BODY];
        $mailRecord->text_body    = $args[self::TEXT_BODY];

        return $mailRecord;
    }

    /**
     * Validates email addresses. The return value is an array of key-value pairs where the keys are the email
     * addresses and the values are booleans indicating whether or not the email address is valid.
     *
     * @param $api
     * @param $args
     * @return array
     */
    public function validateEmailAddresses($api, $args)
    {
        unset($args["__sugar_url"]);
        $validatedEmailAddresses = array();
        $emailRecipientsService  = $this->getEmailRecipientsService();
        $emailAddresses          = $args;

        foreach ($emailAddresses as $emailAddress) {
            $validatedEmailAddresses[$emailAddress] = $emailRecipientsService->isValidEmailAddress($emailAddress);
        }

        return $validatedEmailAddresses;
    }

    protected function getEmailRecipientsService()
    {
        if (!($this->emailRecipientsService instanceof EmailRecipientsService)) {
            $this->emailRecipientsService = new EmailRecipientsService;
        }

        return $this->emailRecipientsService;
    }

    /**
     * Saves an email attachment using the POST method
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return array metadata about the attachment including name, guid, and nameForDisplay
     */
    public function saveAttachment($api, $args)
    {
        $email = $this->getEmailBean();
        $email->email2init();
        $metadata = $email->email2saveAttachment();
        return $metadata;
    }

    /**
     * Removes an email attachment
     *
     * @param ServiceBase $api The service base
     * @param array $args The request args
     * @return bool
     * @throws SugarApiExceptionRequestMethodFailure
     */
    public function removeAttachment($api, $args)
    {
        $email = $this->getEmailBean();
        $email->email2init();
        $fileGUID = $args['file_guid'];
        $fileName = $email->et->userCacheDir . "/" . $fileGUID;
        $filePath = clean_path($fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        return true;
    }

    /**
     * Clears the user's attachment cache directory
     *
     * @param ServiceBase $api The service base
     * @param array $args The request args
     * @return bool
     * @throws SugarApiExceptionRequestMethodFailure
     */
    public function clearUserCache($api, $args)
    {
        $em = new EmailUI();
        $em->preflightUserCache();
        return true;
    }

    /**
     * Returns a new Email bean, used for testing purposes
     *
     * @return Email
     */
    protected function getEmailBean()
    {
        return new Email();
    }
}
