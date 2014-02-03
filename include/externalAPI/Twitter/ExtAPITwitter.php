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

require_once('include/externalAPI/Base/OAuthPluginBase.php');
require_once('include/externalAPI/Base/WebFeed.php');


class ExtAPITwitter extends OAuthPluginBase implements WebFeed {
    public $authMethod = 'oauth';
    public $useAuth = true;
    public $requireAuth = true;
    protected $authData;
    public $needsUrl = false;
    public $supportedModules = array('Accounts', 'Contacts', 'Home');
    public $connector = "ext_rest_twitter";

    protected $oauthReq = "https://api.twitter.com/oauth/request_token";
    protected $oauthAuth = 'https://api.twitter.com/oauth/authorize';
    protected $oauthAccess = 'https://api.twitter.com/oauth/access_token';
    protected $oauthParams = array(
            'signatureMethod' => 'HMAC-SHA1',
        );

    /**
     * @deprecated This is a depreciated method and will be removed in version 7.3.
     */
    public function getLatestUpdates($maxTime, $maxEntries)
    {
        $td = $GLOBALS['timedate'];

        $twitter_json_url = 'http://api.twitter.com/1.1/statuses/user_timeline.json';
        $reply = $this->makeRequest('GET', $twitter_json_url,array('count'=>$maxEntries));

        if ( !$reply['success'] ) {
            $GLOBALS['log']->error('Twitter failed, reply said: '.print_r($reply,true));
            return $reply;
        }

        $messages = array();
        foreach ( $reply['responseJSON'] as $message ) {
            if ( empty($message['text']) ) {
                continue;
            }
            $unix_time = strtotime($message['created_at']);

            $fake_record = array();
            $fake_record['sort_key'] = $unix_time;
            $fake_record['ID'] = create_guid();
            $fake_record['DATE_ENTERED'] = $td->to_display_date_time(gmdate('Y-m-d H:i:s',$unix_time));
            $fake_record['NAME'] = $message['user']['name'].'</b>';
            if ( !empty($message['text']) ) 
            {
            	$message['text'] = SugarFeed::parseMessage($message['text']); 
            	$fake_record['NAME'] .= ' '.preg_replace('/\@(\w+)/', "<a target='_blank' href='http://twitter.com/\$1'>@\$1</a>", $message['text']);
            }
            $fake_record['NAME'] .= '<br><div class="byLineBox"><span class="byLineLeft">'.SugarFeed::getTimeLapse($fake_record['DATE_ENTERED']).'&nbsp;</span><div class="byLineRight">&nbsp;</div></div>';
            $fake_record['IMAGE_URL'] = $message['user']['profile_image_url'];

            $messages[] = $fake_record;
        }


        return array('success'=>true,'messages'=>$messages);
    }

    /**
     * Gets a twitter users last maxEntries
     * @param $twitterHandle twitter screen name
     * @param $maxTime
     * @param $maxEntries maximum number of entries to retrieve
     * @return array
     */
    public function getUserTweets($twitterHandle, $maxTime, $maxEntries)
    {
        $td = $GLOBALS['timedate'];

        $twitter_json_url = 'http://api.twitter.com/1.1/statuses/user_timeline.json';
        $reply = $this->makeRequest('GET', $twitter_json_url,array(
                'count'=>$maxEntries,
                'screen_name'=>$twitterHandle,
            ));

        if ( !$reply['success'] ) {
            $GLOBALS['log']->error('Twitter failed, reply said: '.print_r($reply,true));
            return $reply;
        }

        return $reply['responseJSON'];
    }

    /**
     * Gets a twitter users last maxEntries
     * @param $twitterHandle twitter screen name
     * @param $maxTime
     * @param $maxEntries maximum number of entries to retrieve
     * @return array
     */
    public function getCurrentUserInfo()
    {

        $twitter_json_url = 'http://api.twitter.com/1.1/account/verify_credentials.json';
        $reply = $this->makeRequest('GET', $twitter_json_url,array());

        if ( !$reply['success'] ) {
            $GLOBALS['log']->error('Twitter failed, reply said: '.print_r($reply,true));
            return $reply;
        }
        return $reply['responseJSON'];
    }

    // Internal functions
    protected function makeRequest($requestMethod, $url, $urlParams = null, $postData = null )
    {
        $headers = array(
            "User-Agent: SugarCRM",
            "Content-Type: application/x-www-form-urlencoded",
            "Content-Length: ".strlen($postData),
            );

        $oauth = $this->getOauth();

        $rawResponse = $oauth->fetch($url, $urlParams, $requestMethod, $headers);

        if ( empty($rawResponse) ) {
            return array('success'=>false,'errorMessage'=>translate('LBL_ERR_TWITTER', 'EAPM'));
        }
        $response = json_decode($rawResponse,true);
        if ( empty($response) ) {
            return array('success'=>false,'errorMessage'=>translate('LBL_ERR_TWITTER', 'EAPM'));
        }

        if ( isset($response['error']) ) {
            return array('success'=>false,'errorMessage'=>$response['error']);
        }

        return array('success'=>true, 'responseJSON'=>$response);
    }
}
