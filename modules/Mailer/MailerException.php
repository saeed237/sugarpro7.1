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


class MailerException extends Exception
{
    const ResourceNotFound              = 1;
    const InvalidConfiguration          = 2;
    const InvalidHeader                 = 3;
    const InvalidEmailAddress           = 4;
    const FailedToSend                  = 5;
    const FailedToConnectToRemoteServer = 6;
    const FailedToTransferHeaders       = 7;
    const InvalidMessageBody            = 8;
    const InvalidAttachment             = 9;
    const InvalidMailer                 = 10;

    static protected $errorMessageMappings = array(
        self::ResourceNotFound              => 'LBL_INTERNAL_ERROR',
        self::InvalidConfiguration          => 'LBL_INVALID_CONFIGURATION',
        self::InvalidHeader                 => 'LBL_INVALID_HEADER',
        self::InvalidEmailAddress           => 'LBL_INVALID_EMAIL',
        self::FailedToSend                  => 'LBL_INTERNAL_ERROR',
        self::FailedToConnectToRemoteServer => 'LBL_FAILED_TO_CONNECT',
        self::FailedToTransferHeaders       => 'LBL_INTERNAL_ERROR',
        self::InvalidAttachment             => 'LBL_INVALID_ATTACHMENT',
        self::InvalidMailer                 => 'LBL_INTERNAL_ERROR',
    );

    public function getLogMessage() {
        return "MailerException - @(" . basename($this->getFile()) . ":" .  $this->getLine() . " [" . $this->getCode() . "]" . ") - " . $this->getMessage();
    }
    public function getTraceMessage() {
        return "MailerException: (Trace)\n" . $this->getTraceAsString();
    }
    public function getUserFriendlyMessage() {
        $moduleName = 'Emails';
        if (isset(self::$errorMessageMappings[$this->getCode()])) {
            $exception_code = self::$errorMessageMappings[$this->getCode()];
        }
        if (empty($exception_code)) {
            $exception_code = 'LBL_INTERNAL_ERROR'; //use generic message if a user-friendly version is not available
        }
        return translate($exception_code, $moduleName);
    }
}
