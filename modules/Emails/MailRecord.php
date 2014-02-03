<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once 'modules/Mailer/EmailIdentity.php';
require_once 'modules/Mailer/MailerException.php';

class MailRecord
{
    static private $statuses = array(
        // Initial Status -  "Create" or "Update"
        "draft",     // draft
        "scheduled", // scheduled for future date time
        "ready",     // ready to be sent

        // Intermediate 'In-Progess' Status
        "sending", // transient status

        // Terminal Status
        "sent",
    );

    const ATTACHMENT_TYPE_UPLOAD = 'upload';
    const ATTACHMENT_TYPE_DOCUMENT = 'document';
    const ATTACHMENT_TYPE_TEMPLATE = 'template';

    public $mockEmailBean=null;  // For Testing Purposes Only

    public $mailConfig;
    public $toAddresses;
    public $ccAddresses;
    public $bccAddresses;
    public $attachments;
    public $teams;
    public $related;
    public $subject;
    public $html_body;
    public $text_body;

    function __construct() {}

    /**
     * Saves the email as a draft.
     *
     * @return array
     */
    public function saveAsDraft()
    {
        return $this->toEmailBean("draft");
    }

    /**
     * Saves and sends the email.
     *
     * @return array
     */
    public function send()
    {
        return $this->toEmailBean("ready");
    }

    /**
     * Prepares and executes the email request according to the expectations of the status.
     *
     * @param $status
     * @return array - Mail API Response Record
     * @throws MailerException
     */
    protected function toEmailBean($status)
    {
        if (!empty($this->mockEmailBean)) {
            $email = $this->mockEmailBean; // Testing purposes only
        } else {
            $email = new Email();
        }
        $email->email2init();

        $fromAccount = null;

        if (!empty($this->mailConfig)) {
            $fromAccount = $this->mailConfig;
        }

        $to  = $this->addRecipients($this->toAddresses);
        $cc  = $this->addRecipients($this->ccAddresses);
        $bcc = $this->addRecipients($this->bccAddresses);

        $attachments = $this->splitAttachments($this->attachments);

        $request  = $this->setupSendRequest($status, $fromAccount, $to, $cc, $bcc, $attachments);
        $_REQUEST = array_merge($_REQUEST, $request);

        $errorData  = null;

        try {
            $this->startCapturingOutput();
            $email->email2Send($request);
            $errorData  = $this->endCapturingOutput();

            if (strlen($errorData) > 0) {
                throw new MailerException('Email2Send returning unexpected output: ' . $errorData);
            }

            $response = $this->toApiResponse($status, $email);
            return $response;

        } catch (Exception $e) {
            if (is_null($errorData)) {
                $errorData = $this->endCapturingOutput();
            }
            if (!($e instanceof MailerException)) {
                $e = new MailerException($e->getMessage());
            }
            if (empty($errorData)) {
                $GLOBALS["log"]->error("Message: ".$e->getLogMessage());
            } else {
                $GLOBALS["log"]->error("Message: ".$e->getLogMessage()."  Data: ".$errorData);
            }

            throw $e;
        }
    }

    /**
     * Constructs the email request that will passed on.
     *
     * @param string $status
     * @param null   $from
     * @param string $to
     * @param string $cc
     * @param string $bcc
     * @param array $attachments
     * @return array
     */
    protected function setupSendRequest(
        $status = "ready",
        $from = null,
        $to = "",
        $cc = "",
        $bcc = "",
        $attachments = array()
    ) {
        $request = array(
            "fromAccount"     => $from,
            "sendSubject"     => $this->subject,
            "sendTo"          => $to,
            "sendCc"          => $cc,
            "sendBcc"         => $bcc,
            "saveToSugar"     => "1",
            "sendDescription" => "", // defaulted to an empty string
        );

        if (!empty($this->html_body)) {
            $request["sendDescription"] = urldecode($this->html_body);
            $request["setEditor"]       = "1";
        } elseif (!empty($this->text_body)) {
            $request["sendDescription"] = urldecode($this->text_body);
        }

        $requestKeys = array(
            self::ATTACHMENT_TYPE_UPLOAD => 'attachments',
            self::ATTACHMENT_TYPE_DOCUMENT => 'documents',
            self::ATTACHMENT_TYPE_TEMPLATE => 'templateAttachments',
        );
        foreach ($attachments as $key => $value) {
            $requestKey = isset($requestKeys[$key]) ? $requestKeys[$key] : $key;
            $request[$requestKey] = implode('::', $attachments[$key]);
        }

        if (is_array($this->related) && !empty($this->related["type"]) && !empty($this->related["id"])) {
            $request["parent_type"] = $this->related["type"];
            $request["parent_id"]   = $this->related["id"];
        }

        if (is_array($this->teams) && !empty($this->teams["primary"])) {
            $request["primaryteam"] = $this->teams["primary"];
            $teamIds                = array($this->teams["primary"]);

            if (isset($this->teams["other"]) && is_array(($this->teams["other"]))) {
                foreach ($this->teams["other"] as $teamId) {
                    $teamIds[] = $teamId;
                }
            }

            $request["teamIds"] = implode(",", $teamIds);
        }

        if ($status == "draft") {
            $request["saveDraft"] = "true"; // send ("ready") is the default behavior
        }

        return $request;
    }

    /**
     * Starts the output buffer. Wraps the function call so that it is possible to mock/stub this behavior.
     */
    protected function startCapturingOutput()
    {
        ob_start();
    }

    /**
     * Collects the contents from the output buffer and cleans the buffer. Wraps the function calls so that it is
     * possible to mock/stub this behavior.
     *
     * @return string
     */
    protected function endCapturingOutput()
    {
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    /**
     * Format recipient addresses as comma-separated strings.
     *
     * @param array $recipients
     * @return string
     */
    protected function addRecipients($recipients = array())
    {
        $addedRecipients = array();

        if (is_array($recipients)) {
            foreach ($recipients as $recipient) {
                $identity = $this->generateEmailIdentity($recipient);

                if ($identity) {
                    $formattedRecipient = array();
                    $name               = $identity->getName();

                    if (!empty($name)) {
                        $formattedRecipient[] = $name;
                    }

                    $formattedRecipient[] = "<" . $identity->getEmail() . ">";

                    // add the formatted recipient to the array of all recipients to be imploded
                    // separate the name and email address by a single space
                    $addedRecipients[] = implode(" ", $formattedRecipient);
                }
            }
        }

        return implode(", ", $addedRecipients);
    }

    /**
     * Split attachment list into separate lists by type
     *
     * @param array $attachments
     * @return array
     */
    protected function splitAttachments($attachments = array())
    {
        $addedAttachments = array();

        if (is_array($attachments)) {
            foreach ($attachments as $attachment) {
                $type = $attachment['type'];
                if (!array_key_exists($type, $addedAttachments)) {
                    $addedAttachments[$type] = array();
                }
                if ($type === self::ATTACHMENT_TYPE_UPLOAD) {
                    $addedAttachments[$type][] = $attachment['id'] . $attachment["name"];
                } else {
                    $addedAttachments[$type][] = $attachment['id'];
                }
            }
        }

        return $addedAttachments;
    }

    /**
     * Returns an EmailIdentity object from the set of recipients data that is passed in.
     *
     * @param $data
     * @return EmailIdentity
     */
    protected function generateEmailIdentity($data)
    {
        $recipient = null;

        if (is_array($data) && !empty($data['email'])) {
            $email = $data['email'];
            $name  = null;

            if (isset($data['name'])) {
                $name = $data['name'];
            }

            $recipient = new EmailIdentity($email, $name);
        }

        return $recipient;
    }

    /**
     * Returns the Api Response Record
     *
     * @param $status    - Status that came in on the request
     * @param $bean      - Email Bean
     * @return $response - array
     */
    protected function toApiResponse($status, $email)
    {
        $response = array(
            "id"               => $email->id,
            "date_entered"     => $email->date_entered,
            "date_modified"    => $email->date_modified,
            "assigned_user_id" => $email->assigned_user_id,
            "modified_user_id" => $email->modified_user_id,
            "created_by"       => $email->created_by,
            "deleted"          => $email->deleted,
            "to_addresses"     => $this->toAddresses,
            "cc_addresses"     => $this->ccAddresses,
            "bcc_addresses"    => $this->bccAddresses,
            "attachments"      => $this->attachments,
            "teams"            => $this->teams,
            "related"          => $this->related,
            "subject"          => $this->subject,
            "html_body"        => $this->html_body,
            "text_body"        => $this->text_body,
            "status"           => ($status == 'ready') ? 'sent' : $status,
        );

        return $response;
    }
}
