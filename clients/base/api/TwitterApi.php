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

include('include/externalAPI/Twitter/ExtAPITwitter.php');
// A simple example class
class TwitterApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getCurrentUser' => array(
                'reqType' => 'GET',
                'path' => array('connector','twitter', 'currentUser'),
                'pathVars' => array('connector','module', 'twitterId'),
                'method' => 'getCurrentUser',
                'shortHelp' => 'Gets current tweets for a user',
                'longHelp' => 'include/api/help/twitter_get_help.html',
            ),
            'getTweets' => array(
                'reqType' => 'GET',
                'path' => array('connector','twitter', '?'),
                'pathVars' => array('connector','module', 'twitterId'),
                'method' => 'getTweets',
                'shortHelp' => 'Gets current tweets for a user',
                'longHelp' => 'include/api/help/twitter_get_help.html',
            ),
        );
    }

    /**
     * gets twitter EAPM
     * @return array|bool|ExternalAPIBase
     */
    public function getEAPM()
    {
        // ignore auth and load to just check if connector configured
        $twitterEAPM = ExternalAPIFactory::loadAPI('Twitter', true);

        if (!$twitterEAPM) {
            $source = SourceFactory::getSource('ext_rest_twitter');
            if ($source && $source->hasTestingEnabled()) {
                try {
                    if (!$source->test()) {
                        return array('error' =>'ERROR_NEED_OAUTH');
                    }
                } catch (Exception $e) {
                    return array('error' =>'ERROR_NEED_OAUTH');
                }
            }
            return array('error' =>'ERROR_NEED_OAUTH');
        }

        $twitterEAPM->getConnector();

        $eapmBean = EAPM::getLoginInfo('Twitter');

        if (empty($eapmBean->id)) {
            return array('error' =>'ERROR_NEED_AUTHORIZE');
        }

        //return a fully authed EAPM
        $twitterEAPM = ExternalAPIFactory::loadAPI('Twitter');
        return $twitterEAPM;
    }

    /**
     * Gets Tweets for a user via proxy call to twitter
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function getTweets($api, $args)
    {
        $args2params = array(
            'twitterId' => 'screen_name',
            'count' => 'count'
        );
        $params = array();
        foreach ($args2params as $argKey => $paramKey) {
            if (isset($args[$argKey])) {
                $params[] = $args[$argKey];
            }
        }

        if (count($params) === 0) {
            throw new SugarApiExceptionMissingParameter('Error: Missing argument.', $args);
        }

        $extApi = $this->getEAPM();

        if (is_array($extApi) && isset($extApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, $args, null, 424, $extApi['error']);
        }

        if ($extApi === false) {
           throw new SugarApiExceptionRequestMethodFailure($GLOBALS['app_strings']['ERROR_UNABLE_TO_RETRIEVE_DATA'], $args);
        }

        $result = $extApi->getUserTweets($args['twitterId'], 0, $args['count']);
        if (isset($result['errors'])) {
            $errorString = '';
            foreach($result['errors'] as $errorKey => $error) {
                if ($error['code'] === 34) {
                    throw new SugarApiExceptionNotFound('errors_from_twitter: '.$errorString, $args);
                }
                $errorString .= $error['code'].str_replace(' ', '_', $error['message']);
            }
            throw new SugarApiExceptionRequestMethodFailure('errors_from_twitter: '.$errorString, $args);
        }
        return $result;
    }

    /**
     * Gets Tweets for a user via proxy call to twitter
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function getCurrentUser($api, $args)
    {
        $extApi = $this->getEAPM();
        if (is_array($extApi) && isset($extApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, $args, null, 424, $extApi['error']);
        }

        if ($extApi === false) {
            throw new SugarApiExceptionRequestMethodFailure($GLOBALS['app_strings']['ERROR_UNABLE_TO_RETRIEVE_DATA'], $args);
        }

        $result = $extApi->getCurrentUserInfo();
        if (isset($result['errors'])) {
            $errorString = '';
            foreach($result['errors'] as $errorKey => $error) {
                $errorString .= $error['code'].str_replace(' ', '_', $error['message']);
            }
            throw new SugarApiExceptionRequestMethodFailure('errors_from_twitter: '.$errorString, $args);
        }
        return $result;
    }
}
