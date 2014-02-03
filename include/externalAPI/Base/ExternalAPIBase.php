<?php
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


require_once ('include/externalAPI/Base/ExternalAPIPlugin.php');
require_once ('include/externalAPI/Base/ExternalOAuthAPIPlugin.php');
require_once('include/connectors/sources/SourceFactory.php');

/**
 * Base implementation for external API
 * @api
 */
abstract class ExternalAPIBase implements ExternalAPIPlugin
{
    public $account_name;
    public $account_password;
    public $authMethod = 'password';
    public $useAuth = true;
    public $requireAuth = true;

    const APP_STRING_ERROR_PREFIX = 'ERR_EXTERNAL_API_';
    protected $_appStringErrorPrefix = self::APP_STRING_ERROR_PREFIX;

    /**
     * Authorization data
     * @var EAPM
     */
    protected $authData;

    /**
     * Load authorization data
     * @param EAPM $eapmBean
     * @see ExternalAPIPlugin::loadEAPM()
     */
    public function loadEAPM($eapmBean)
    {
        // FIXME: check if the bean is validated, if not, refuse it?
        $this->eapmBean = $eapmBean;
        if ($this->authMethod == 'password') {
            $this->account_name = $eapmBean->name;
            $this->account_password = $eapmBean->password;
        }
        return true;
    }

    /**
     * Check login
     * @param EAPM $eapmBean
     * @see ExternalAPIPlugin::checkLogin()
     */
    public function checkLogin($eapmBean = null)
    {
        if(!empty($eapmBean)) {
            $this->loadEAPM($eapmBean);
        }

        if ( !isset($this->eapmBean) ) {
            return array('success' => false);
        }

        return array('success' => true);
    }

    public function quickCheckLogin()
    {
        if ( !isset($this->eapmBean) ) {
            return array('success' => false, 'errorMessage' => translate('LBL_ERR_NO_AUTHINFO','EAPM'));
        }

        if ( $this->eapmBean->validated==0 ) {
            return array('success' => false, 'errorMessage' => translate('LBL_ERR_NO_AUTHINFO','EAPM'));
        }

        return array('success' => true);
    }

    protected function getValue($value)
    {
        if(!empty($this->$value)) {
            return $this->$value;
        }
        return null;
    }

    public function logOff()
    {
        // Not sure if we should do anything.
        return true;
    }

    /**
     * Does API support this method?
     * @see ExternalAPIPlugin::supports()
     */
    public function supports($method = '')
	{
        return $method==$this->authMethod;
	}

	protected function postData($url, $postfields, $headers)
	{
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $proxy_config = Administration::getSettings('proxy');

        if( !empty($proxy_config) &&
            !empty($proxy_config->settings['proxy_on']) &&
            $proxy_config->settings['proxy_on'] == 1) {

            curl_setopt($ch, CURLOPT_PROXY, $proxy_config->settings['proxy_host']);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_config->settings['proxy_port']);
            if (!empty($proxy_settings['proxy_auth'])) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_settings['proxy_username'] . ':' . $proxy_settings['proxy_password']);
            }
        }

        if ( ( is_array($postfields) && count($postfields) == 0 ) ||
             empty($postfields) ) {
            curl_setopt($ch, CURLOPT_POST, false);
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

        $GLOBALS['log']->debug("ExternalAPIBase->postData Where: ".$url);
        $GLOBALS['log']->debug("Headers:\n".print_r($headers,true));
        // $GLOBALS['log']->debug("Postfields:\n".print_r($postfields,true));
        $rawResponse = curl_exec($ch);
        $GLOBALS['log']->debug("Got:\n".print_r($rawResponse,true));

        return $rawResponse;
	}

	/**
	 * Get connector for this API
	 * @return source|null
	 */
	public function getConnector()
	{
	    if(isset($this->connector)) {
	        if(empty($this->connector_source)) {
	            $this->connector_source = SourceFactory::getSource($this->connector, false);
                $this->connector_source->setEAPM($this);
	        }
	        return $this->connector_source;
	    }
	    return null;
	}

	/**
	 * Get parameter from source
	 * @param string $name
	 * @return mixed
	 */
	public function getConnectorParam($name)
	{
        $connector =  $this->getConnector();
        if(empty($connector)) return null;
        return $connector->getProperty($name);
	}


	/**
	 * formatCallbackURL
	 *
	 * This function takes a callback_url and checks the $_REQUEST variable to see if
	 * additional parameters should be appended to the callback_url value.  The $_REQUEST variables
	 * that are being checked deal with handling the behavior of closing/hiding windows/tabs that
	 * are displayed when prompting for OAUTH validation
	 *
	 * @param $callback_url String value of callback URL
	 * @return String value of URL with applicable formatting
	 */
	protected function formatCallbackURL($callback_url)
	{
		 // This is a tweak so that we can automatically close windows if requested by the external account system
	     if (isset($_REQUEST['closeWhenDone']) && $_REQUEST['closeWhenDone'] == 1 ) {
             $callback_url .= '&closeWhenDone=1';
         }

         //Pass back the callbackFunction to call on the window.opener object
         if (!empty($_REQUEST['callbackFunction']))
         {
             $callback_url .= '&callbackFunction=' . $_REQUEST['callbackFunction'];
         }

         //Pass back the id of the application that triggered this oauth login
         if (!empty($_REQUEST['application']))
         {
             $callback_url .= '&application=' . $_REQUEST['application'];
         }

	     //Pass back the id of the application that triggered this oauth login
         if (!empty($_REQUEST['refreshParentWindow']))
         {
             $callback_url .= '&refreshParentWindow=' . $_REQUEST['refreshParentWindow'];
         }

         return $callback_url;
	}

	/**
	 * Allow API clients to provide translated language strings for a given error code
	 *
	 * @param unknown_type $error_numb
	 */
	protected function getErrorStringFromCode($error_numb)
	{
	    $language_key = $this->_appStringErrorPrefix . $error_numb;
	    if( isset($GLOBALS['app_strings'][$language_key]) )
	       return $GLOBALS['app_strings'][$language_key];
	    else
	       return $GLOBALS['app_strings']['ERR_EXTERNAL_API_SAVE_FAIL'];
	}

    /**
     * Determine if mime detection extensions are available.
     *
     * @return bool
     */
    public function isMimeDetectionAvailable()
	{
	    return mime_is_detectable();
	}
}
