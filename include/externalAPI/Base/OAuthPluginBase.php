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


require_once('include/externalAPI/Base/ExternalAPIBase.php');
require_once('include/SugarOauth.php');

/**
 * External API based on OAuth
 * @api
 */
class OAuthPluginBase extends ExternalAPIBase implements ExternalOAuthAPIPlugin {
    public $authMethod = 'oauth';
    protected $oauthParams = array();
    protected $oauth_keys_initialized = false;

    public function __construct()
    {
    }

    /**
     * Setup oauth parameters from connector
     */
    public function setupOauthKeys()
    {
        if($this->oauth_keys_initialized) return;

        $connector = $this->getConnector();
        if(!empty($connector)) {
            $cons_key = $connector->getProperty('oauth_consumer_key');
            if(!empty($cons_key)) {
                $this->oauthParams['consumerKey'] = $cons_key;
            }
            $cons_secret = $connector->getProperty('oauth_consumer_secret');
            if(!empty($cons_secret)) {
                $this->oauthParams['consumerSecret'] = $cons_secret;
            }
        }
        $this->oauth_keys_initialized = true;
    }

    /**
     * Load data from EAPM bean
     * @see ExternalAPIBase::loadEAPM()
     */
    public function loadEAPM($eapmBean)
    {
        if ( !parent::loadEAPM($eapmBean) ) { return false; }

        $this->oauth_token = $eapmBean->oauth_token;
        $this->oauth_secret = $eapmBean->oauth_secret;

        return true;
    }

    /**
     * Check login
     * @param EAPM $eapmBean
     * @see ExternalAPIBase::checkLogin()
     */
    public function checkLogin($eapmBean = null)
    {
        $reply = parent::checkLogin($eapmBean);
        if ( !$reply['success'] ) {
            return $reply;
        }

        if ( $this->checkOauthLogin() ) {
            return array('success' => true);
        }
    }

    public function quickCheckLogin()
    {
        $reply = parent::quickCheckLogin();

        if ( !$reply['success'] ) {
            return $reply;
        }

        if ( !empty($this->oauth_token) && !empty($this->oauth_secret) ) {
            return array('success'=>true);
        } else {
            return array('success'=>false,'errorMessage'=>translate('LBL_ERR_NO_TOKEN','EAPM'));
        }
    }

    protected function checkOauthLogin()
    {
        if ( empty($this->oauth_token) || empty($this->oauth_secret) ) {
            return $this->oauthLogin();
        } else {
            return false;
        }
    }

    public function getOauthParams()
    {
        return $this->getValue("oauthParams");
    }

    public function getOauthRequestURL()
    {
        return $this->getValue("oauthReq");
    }

    public function getOauthAuthURL()
    {
        return $this->getValue("oauthAuth");
    }

    public function getOauthAccessURL()
    {
        return $this->getValue("oauthAccess");
    }

    /**
     * Get OAuth client
     * @return SugarOauth
     */
    public function getOauth()
    {
        $this->setupOauthKeys();
        $oauth = new SugarOAuth($this->oauthParams['consumerKey'], $this->oauthParams['consumerSecret'], $this->getOauthParams());

        if ( isset($this->oauth_token) && !empty($this->oauth_token) ) {
            $oauth->setToken($this->oauth_token, $this->oauth_secret);
        }

        return $oauth;
    }

   public function oauthLogin()
   {
        global $sugar_config;
        $oauth = $this->getOauth();
        if(isset($_SESSION['eapm_oauth_secret']) && isset($_SESSION['eapm_oauth_token']) && isset($_REQUEST['oauth_token']) && isset($_REQUEST['oauth_verifier'])) {
            $stage = 1;
        } else {
            $stage = 0;
        }
        if($stage == 0) {
            $oauthReq = $this->getOauthRequestURL();
            $callback_url = $sugar_config['site_url'].'/index.php?module=EAPM&action=oauth&record='.$this->eapmBean->id;
            $callback_url = $this->formatCallbackURL($callback_url);

            $GLOBALS['log']->debug("OAuth request token: {$oauthReq} callback: $callback_url");

            $request_token_info = $oauth->getRequestToken($oauthReq, $callback_url);

            $GLOBALS['log']->debug("OAuth token: ".var_export($request_token_info, true));

            if(empty($request_token_info['oauth_token_secret']) || empty($request_token_info['oauth_token'])){
                return false;
            }else{
                // FIXME: error checking here
                $_SESSION['eapm_oauth_secret'] = $request_token_info['oauth_token_secret'];
                $_SESSION['eapm_oauth_token'] = $request_token_info['oauth_token'];
                $authReq = $this->getOauthAuthURL();
                SugarApplication::redirect("{$authReq}?oauth_token={$request_token_info['oauth_token']}");
            }
        } else {
            $accReq = $this->getOauthAccessURL();
            $oauth->setToken($_SESSION['eapm_oauth_token'],$_SESSION['eapm_oauth_secret']);
            $GLOBALS['log']->debug("OAuth access token: {$accReq}");
            $access_token_info = $oauth->getAccessToken($accReq);
            $GLOBALS['log']->debug("OAuth token: ".var_export($access_token_info, true));
            // FIXME: error checking here
            $this->oauth_token = $access_token_info['oauth_token'];
            $this->oauth_secret = $access_token_info['oauth_token_secret'];
            $this->eapmBean->oauth_token = $this->oauth_token;
            $this->eapmBean->oauth_secret = $this->oauth_secret;
            $oauth->setToken($this->oauth_token, $this->oauth_secret);
            $this->eapmBean->validated = 1;
            $this->eapmBean->save();
            unset($_SESSION['eapm_oauth_token']);
            unset($_SESSION['eapm_oauth_secret']);
            return true;
        }
        return false;
	}
}