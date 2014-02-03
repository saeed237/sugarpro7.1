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


/* Third-Party Library Imports */

/**
 * Required to establish the SMTP connection prior to PHPMailer's send for error handling purposes.
 */
require_once "vendor/PHPMailer/class.smtp.php";

class SMTPProxy extends SMTP
{
    public function Connect($host, $port = 0, $timeout = 30, $options = array())
    {
        $result = parent::Connect($host, $port, $timeout, $options);
        $this->handleError();

        return $result;
    }

    public function StartTLS()
    {
        $result = parent::StartTLS();
        $this->handleError();

        return $result;
    }

    public function Authenticate($username, $password, $authtype='LOGIN', $realm='', $workstation='')
    {
        $result = false;

        // check if the resource is valid
        if (!is_resource($this->smtp_conn)) {
            $this->error = array("error" => "Not a valid SMTP resource supplied");
        } else {
            $result = parent::Authenticate($username, $password, $authtype, $realm, $workstation);
        }

        $this->handleError();

        return $result;
    }

    public function Data($msg_data)
    {
        $result = parent::Data($msg_data);
        $this->handleError();

        return $result;
    }

    public function Hello($host = '')
    {
        $result = parent::Hello($host);
        $this->handleError();

        return $result;
    }

    public function Mail($from)
    {
        $result = parent::Mail($from);
        $this->handleError();

        return $result;
    }

    public function Quit($close_on_error = true)
    {
        $result = parent::Quit($close_on_error);
        $this->handleError();

        return $result;
    }

    public function Recipient($to)
    {
        $result = parent::Recipient($to);
        $this->handleError();

        return $result;
    }

    public function Reset()
    {
        $result = parent::Reset();
        $this->handleError();

        return $result;
    }

    public function SendAndMail($from)
    {
        $result = parent::SendAndMail($from);
        $this->handleError();

        return $result;
    }

    public function Turn()
    {
        $result = parent::Turn();
        $this->handleError();

        return $result;
    }

    public function client_send($data)
    {
        $result = parent::client_send($data);
        $this->handleError();

        return $result;
    }

    protected function handleError()
    {
        if (!is_null($this->error)) {
            $message = array("SMTP ->");
            $level   = "warn";

            if (is_array($this->error)) {
                if (array_key_exists("error", $this->error)) {
                    $message[] = "ERROR: {$this->error["error"]}.";
                }

                $hasErrno    = array_key_exists("errno", $this->error);
                $hasSmtpCode = array_key_exists("smtp_code", $this->error);

                if ($hasErrno || $hasSmtpCode) {
                    // the presence of "errno" or "smtp_code" keys seems to indicate that a more serious error occurred
                    // it was likely a failure when attempting to talk with an SMTP server
                    $level = "error";
                }

                if ($hasErrno) {
                    $message[] = "Code: {$this->error["errno"]}";
                } elseif ($hasSmtpCode) {
                    $message[] = "Code: {$this->error["smtp_code"]}";
                }

                if (array_key_exists("errstr", $this->error)) {
                    $message[] = "Reply: {$this->error["errstr"]}";
                } elseif (array_key_exists("smtp_msg", $this->error)) {
                    $message[] = "Reply: {$this->error["smtp_msg"]}";
                }
            } else {
                $message[] = "ERROR: {$this->error}";
            }

            $GLOBALS["log"]->$level(implode(" ", $message));
        }
    }
}
