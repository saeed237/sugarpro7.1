<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


class SugarApiException extends Exception
{
    public $httpCode = 400;
    public $errorLabel = 'unknown_exception';
    public $messageLabel = 'EXCEPTION_UNKNOWN_EXCEPTION';
    public $msgArgs = null;
    protected $moduleName = null;
    
    /**
     * Extra data attached to the exception
     * @var array
     */
    public $extraData = array();

    /**
     * @param string $messageLabel optional Label for error message.  Used to load the appropriate translated message.
     * @param array $msgArgs optional set of arguments to substitute into error message string
     * @param string|null $moduleName Provide module name if $messageLabel is a module string, leave empty if
     *  $messageLabel is in app strings.
     * @param int $httpCode
     * @param string $errorLabel
     */
    function __construct($messageLabel = null, $msgArgs = null, $moduleName = null, $httpCode = 0, $errorLabel = null)
    {

        if(!empty($messageLabel)) {
            $this->messageLabel = $messageLabel;
        }

        if (!empty($errorLabel)) {
            $this->errorLabel = $errorLabel;
        }

        if ($httpCode != 0) {
            $this->httpCode = $httpCode;
        }

        if(!empty($moduleName)){
            $this->moduleName = $moduleName;
        }

        if(!empty($msgArgs)){
            $this->msgArgs = $msgArgs;
        }

        $this->setMessage($this->messageLabel, $this->msgArgs, $this->moduleName);

        parent::__construct($this->message);
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * Each Sugar API exception should have a unique label that clients can use to identify which
     * Sugar API exception was thrown.
     *
     * @return null|string Unique error label
     */
    public function getErrorLabel()
    {
        return $this->errorLabel;
    }

    /**
     * Sets the user locale appropriate message that is suitable for clients to display to end users.
     * Message is based upon the message label provided when this SugarApiException was constructed.
     *
     * If the message label isn't found in app_strings or mod_strings, we'll use the label itself as the message.
     *
     * @param string $messageLabel required Label for error message.  Used to load the appropriate translated message.
     * @param array $msgArgs optional set of arguments to substitute into error message string
     * @param string|null $moduleName Provide module name if $messageLabel is a module string, leave empty if
     *  $messageLabel is in app strings.
     */
    public function setMessage($messageLabel, $msgArgs = null, $moduleName = null){
        // If no message label, don't bother looking it up
        if(empty($messageLabel)){
            $this->message = null;
            return;
        }
        $message = translate($messageLabel, $moduleName);

        // If no arguments provided, return message.
        // If there are arguments, insert into message then return formatted message
        if(empty($msgArgs)){
            $this->message = $message;
        } else {
            $this->message = string_format($message,$msgArgs);
        }
    }

    /**
     * Set exception extra data
     * @param string $key
     * @param mixed $data
     * @return SugarApiException
     */
    public function setExtraData($key, $data)
    {
        $this->extraData[$key] = $data;
        return $this;
    }

}
/**
 * General error, no specific cause known.
 */
class SugarApiExceptionError extends SugarApiException
{
    public $httpCode = 500;
    public $errorLabel = 'fatal_error';
    public $messageLabel = 'EXCEPTION_FATAL_ERROR';
}

/**
 * Incorrect API version
 */
class SugarApiExceptionIncorrectVersion extends SugarApiException
{
    public $httpCode = 301;
    public $errorLabel = 'incorrect_version';
    public $messageLabel = 'EXCEPTION_INCORRECT_VERSION';
}

/**
 * Token not supplied or token supplied is invalid.
 * The client should display the username and password screen
 */
class SugarApiExceptionNeedLogin extends SugarApiException
{
    public $httpCode = 401;
    public $errorLabel = 'need_login';
    public $messageLabel = 'EXCEPTION_NEED_LOGIN';
}

/**
 * The user's session is invalid
 * The client should get a new token and retry.
 */
class SugarApiExceptionInvalidGrant extends SugarApiException
{
    public $httpCode = 401;
    public $errorLabel = 'invalid_grant';
    public $messageLabel = 'EXCEPTION_INVALID_TOKEN';
}

/**
 * This action is not allowed for this user.
 */
class SugarApiExceptionNotAuthorized extends SugarApiException
{
    public $httpCode = 403;
    public $errorLabel = 'not_authorized';
    public $messageLabel = 'EXCEPTION_NOT_AUTHORIZED';
}
/**
 * This user is not active.
 */
class SugarApiExceptionPortalUserInactive extends SugarApiException
{
    public $httpCode = 403;
    public $errorLabel = 'inactive_portal_user';
    public $messageLabel = 'EXCEPTION_INACTIVE_PORTAL_USER';
}
/**
 * Portal is not activated by configuration.
 */
class SugarApiExceptionPortalNotConfigured extends SugarApiException
{
    public $httpCode = 403;
    public $errorLabel = 'portal_not_configured';
    public $messageLabel = 'EXCEPTION_PORTAL_NOT_CONFIGURED';
}
/**
 * URL does not resolve into a valid REST API method.
 */
class SugarApiExceptionNoMethod extends SugarApiException
{
    public $httpCode = 404;
    public $errorLabel = 'no_method';
    public $messageLabel = 'EXCEPTION_NO_METHOD';
}
/**
 * Resource specified by the URL does not exist.
 */
class SugarApiExceptionNotFound extends SugarApiException
{
    public $httpCode = 404;
    public $errorLabel = 'not_found';
    public $messageLabel = 'EXCEPTION_NOT_FOUND';
}
/**
 * Thrown when the client attempts to edit the data on the server that was already edited by
 * different client.
 */
class SugarApiExceptionEditConflict extends SugarApiException
{
    public $httpCode = 409;
    public $errorLabel = 'edit_conflict';
    public $messageLabel = 'EXCEPTION_EDIT_CONFLICT';
}

class SugarApiExceptionInvalidHash extends SugarApiException
{
    public $httpCode = 412;
    public $errorLabel = 'metadata_out_of_date';
    public $messageLabel = 'EXCEPTION_METADATA_OUT_OF_DATE';
}

class SugarApiExceptionRequestTooLarge extends SugarApiException
{
    public $httpCode = 413;
    public $errorLabel = 'request_too_large';
    public $messageLabel = 'EXCEPTION_REQUEST_TOO_LARGE';
}
/**
 * One of the required parameters for the request is missing.
 */
class SugarApiExceptionMissingParameter extends SugarApiException
{
    public $httpCode = 422;
    public $errorLabel = 'missing_parameter';
    public $messageLabel = 'EXCEPTION_MISSING_PARAMTER';
}
/**
 * One of the required parameters for the request is incorrect.
 */
class SugarApiExceptionInvalidParameter extends SugarApiException
{
    public $httpCode = 422;
    public $errorLabel = 'invalid_parameter';
    public $messageLabel = 'EXCEPTION_INVALID_PARAMETER';
}
/**
 * The API method is unable to process parameters due to some of them being wrong.
 */
class SugarApiExceptionRequestMethodFailure extends SugarApiException
{
    public $httpCode = 424;
    public $errorLabel = 'request_failure';
    public $messageLabel = 'EXCEPTION_REQUEST_FAILURE';
}

/**
 * The client is out of date for this version
 */
class SugarApiExceptionClientOutdated extends SugarApiException
{
    public $httpCode = 433;
    public $errorLabel = 'client_outdated';
    public $messageLabel = 'EXCEPTION_CLIENT_OUTDATED';
}

/**
 * We're in the maintenance mode
 */
class SugarApiExceptionMaintenance extends SugarApiException
{
    public $httpCode = 503;
    public $errorLabel = 'maintenance';
    public $messageLabel = 'EXCEPTION_MAINTENANCE';
}
