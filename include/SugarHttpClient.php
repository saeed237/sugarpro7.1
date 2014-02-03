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


/**
 * Very basic HTTP client
 * @api
 * Used in various places of the code and can be mocked out.
 * Presently does only one op - POST to url.
 * If you need more complex stuff, use Zend_Http_Client
 */
class SugarHttpClient
{
    protected $last_error = '';
    /**
     * sends POST request to REST service via CURL
     * @param string $url URL to call
     * @param string $postArgs POST args
     */
    public function callRest($url, $postArgs)
    {
        if(!function_exists("curl_init")) {
            $this->last_error = 'ERROR_NO_CURL';
            $GLOBALS['log']->fatal("REST call failed - no cURL!");
            return false;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, (string)$postArgs);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $GLOBALS['log']->debug("HTTP client call: $url -> $postArgs");
        $response = curl_exec($curl);
        if($response === false) {
            $this->last_error = 'ERROR_REQUEST_FAILED';
            $curl_errno = curl_errno($curl);
            $curl_error = curl_error($curl);
            $GLOBALS['log']->error("HTTP client: cURL call failed: error $curl_errno: $curl_error");
            return false;
        }
        $GLOBALS['log']->debug("HTTP client response: $response");
        curl_close($curl);
        return $response;
    }

    /**
     * Returns code of last error that happened to the client
     * @return string
     */
    public function getLastError()
    {
        return $this->last_error;
    }
}
