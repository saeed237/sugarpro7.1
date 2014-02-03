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
 * Needs the PHPMailer library to set up the proxy.
 */
require_once "vendor/PHPMailer/class.phpmailer.php";

/* Internal Module Imports */

require_once "SMTPProxy.php";

class PHPMailerProxy extends PHPMailer
{
    public function __construct()
    {
        // use PHPMailer with exceptions
        parent::__construct(true);

        // allow an "empty" body to be sent
        $this->AllowEmpty = true;
    }

    public function SmtpConnect($options = array())
    {
        if (!($this->smtp instanceof SMTPProxy)) {
            $this->smtp = new SMTPProxy;
        }

        $result = parent::SmtpConnect($options);
        if ($result === false) {
            throw new phpmailerException($this->Lang('smtp_connect_failed'), self::STOP_CRITICAL);
        }
        return $result;
    }

    public function SetError($msg)
    {
        parent::SetError($msg);

        $class = get_class($this);
        $GLOBALS["log"]->error("{$class} encountered an error: {$this->ErrorInfo}");
    }
}
