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


    require_once 'vendor/Zend/Oauth/Consumer.php';
    // use ZF oauth
    /**
     * Sugar Oauth consumer
     * @api
     */
    class SugarOAuth extends Zend_Oauth_Consumer
    {

        public $token;

        protected $_last = '';
        protected $_oauth_config = array();

        /**
         * Create OAuth client
         * @param string $consumer_key
         * @param string $consumer_secret
         * @param array $params OAuth options
         */
        public function __construct($consumer_key , $consumer_secret, $params = null)
        {
            $this->_oauth_config = array(
                'consumerKey' => $consumer_key,
                'consumerSecret' => $consumer_secret,
            );
            if(!empty($params)) {
                $this->_oauth_config = array_merge($this->_oauth_config, $params);
            }
            parent::__construct($this->_oauth_config);
        }

        /**
         * Enable debugging
         * @return SugarOAuth
         */
        public function enableDebug()
        {
            return $this;
        }

        /**
         * Set token
         * @param string $token
         * @param string $secret
         */
        public function setToken($token, $secret)
        {
            $this->token = array($token, $secret);
        }

        /**
         * Create request token object for current token
         * @return Zend_Oauth_Token_Request
         */
        public function makeRequestToken()
        {
            $token = new Zend_Oauth_Token_Request();
            if (isset($this->token[0])) {
                $token->setToken($this->token[0]);
            }
            if (isset($this->token[1])) {
                $token->setTokenSecret($this->token[1]);
            }
            return $token;
        }

        /**
         * Create access token object for current token
         * @return Zend_Oauth_Token_Access
         */
        public function makeAccessToken()
        {
            $token = new Zend_Oauth_Token_Access();
            if (isset($this->token[0])) {
                $token->setToken($this->token[0]);
            }
            if (isset($this->token[1])) {
                $token->setTokenSecret($this->token[1]);
            }
            return $token;
        }

        /**
         * Retrieve URL and params array from URL string
         * @param string $url
         * @return array
         */
        protected function parseUrl($url)
        {
            $urlString = '';
            $query = array();
            $components = parse_url($url);

            $urlString .= $components['scheme'] . '://';

            if (isset($components['user'])) {
                $urlString .= $components['user'];
                if (isset($components['pass'])) {
                    $urlString .= ':' . $components['pass'];
                }
                $urlString .= '@';
            }

            $urlString .= $components['host'];

            if (isset($components['path'])) {
                $urlString .= $components['path'];
            }

            if (isset($components['query'])) {
                parse_str($components['query'], $query);
            }

            return array($urlString, $query);
        }

        /**
         * Retrieve request token from URL
         * @param string $url
         * @param string $callback Callback URL
         * @param array $params Query params
         * @return array
         * @see Zend_Oauth_Consumer::getRequestToken()
         */
        public function getRequestToken($url, $callback = null, $params = array())
        {
            if(!empty($callback)) {
                $this->setCallbackUrl($callback);
            }

            list($url, $query_params) = $this->parseUrl($url);
            $params = array_merge($params, $query_params);

            $this->setRequestTokenUrl($url);
            try{
                $this->_last = $token = parent::getRequestToken($params);
                return array('oauth_token' => $token->getToken(), 'oauth_token_secret' => $token->getTokenSecret());
            }catch(Zend_Oauth_Exception $e){
                return array('oauth_token' => '', 'oauth_token_secret' => '');
            }
        }

        /**
         * Retrieve access token from url
         * @param string $url
         * @see Zend_Oauth_Consumer::getAccessToken()
         * @return array
         */
        public function getAccessToken($url)
        {
            $this->setAccessTokenUrl($url);
            $this->_last = $token = parent::getAccessToken($_REQUEST, $this->makeRequestToken());
            return array('oauth_token' => $token->getToken(), 'oauth_token_secret' => $token->getTokenSecret());
        }

       /**
        * Fetch URL with OAuth
        * @param string $url
        * @param string $params Query params
        * @param string $method HTTP method
        * @param array $headers HTTP headers
        * @return string
        */

        public function fetch($url, $params = array(), $method = 'GET', $headers = null)
        {
            $acc = $this->makeAccessToken();
            list($url, $query_params) = $this->parseUrl($url);
            $params = array_merge($params, $query_params);
            
            $client = $acc->getHttpClient($this->_oauth_config, $url);

            Zend_Loader::loadClass('Zend_Http_Client_Adapter_Proxy');
            $proxy_config = Administration::getSettings('proxy');

            if( !empty($proxy_config) &&
                !empty($proxy_config->settings['proxy_on']) &&
                $proxy_config->settings['proxy_on'] == 1) {

                $proxy_settings = array();
                $proxy_settings['proxy_host'] = $proxy_config->settings['proxy_host'];
                $proxy_settings['proxy_port'] = $proxy_config->settings['proxy_port'];

                if(!empty($proxy_config->settings['proxy_auth'])){
                    $proxy_settings['proxy_user'] = $proxy_config->settings['proxy_username'];
                    $proxy_settings['proxy_pass'] = $proxy_config->settings['proxy_password'];
                }

                $adapter = new Zend_Http_Client_Adapter_Proxy();
                $adapter->setConfig($proxy_settings);
                $client->setAdapter($adapter);
            }

            $client->setMethod($method);
            if(!empty($headers)) {
                $client->setHeaders($headers);
            }
            if(!empty($params)) {
                if($method == 'GET') {
                    $client->setParameterGet($params);
                } else {
                    $client->setParameterPost($params);
                }
            }
            $this->_last = $resp = $client->request();
            $this->_lastReq = $client->getLastRequest();
            return $resp->getBody();
       }

       /**
        * Get HTTP client
        * @return Zend_Oauth_Client
        */
       public function getClient()
       {
            $acc = $this->makeAccessToken();
            return $acc->getHttpClient($this->_oauth_config);
       }

       /**
        * Get last response
        * @return string
        */
       public function getLastResponse()
       {
            return $this->_last;
       }

       /**
        * Get last request
        * @return string
        */
       public function getLastRequest()
       {
            return $this->_lastReq;
       }
    }
