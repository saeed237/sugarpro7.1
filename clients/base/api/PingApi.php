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


// A simple example class
class PingApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'ping' => array(
                'reqType' => 'GET',
                'path' => array('ping'),
                'pathVars' => array(''),
                'method' => 'ping',
                'shortHelp' => 'An example API only responds with pong',
                'longHelp' => 'include/api/help/ping_get_help.html',
            ),
            'pingWithTime' => array(
                'reqType' => 'GET',
                'path' => array('ping', 'whattimeisit'),
                'pathVars' => array('', 'sub_method'),
                'method' => 'ping',
                'shortHelp' => 'An example API only responds with the current time in server format.',
                'longHelp' => 'include/api/help/ping_whattimeisit_get_help.html',
            ),
        );
    }

    public function registerApiSoap() {
        return array(
            'functions' => array(
                'ping' => array(
                    'methodName' => 'ping',
                    'requestVars' => array(
                    ),
                    'returnVars' => array(
                        'xsd:string',
                    ),
                    'method' => 'ping',
                    'shortHelp' => 'Sample/test API that only responds with pong',
                ),
                'pingWithTime' => array(
                    'methodName' => 'pingTime',
                    'requestVars' => array(
                    ),
                    'extraVars' => array(
                        'sub_method' => 'whattimeisit',
                    ),
                    'returnVars' => array(
                        'xsd:string',
                    ),
                    'method' => 'ping',
                    'shortHelp' => 'Sample/test API that responds with the curernt date/time',
                ),
            ),
            'types' => array(),
        );
    }

    public function ping($api, $args) {
        if ( isset($args['sub_method']) && $args['sub_method'] == 'whattimeisit' ) {
            require_once('include/SugarDateTime.php');
            $dt = new SugarDateTime();
            $td = new TimeDate();
            return $td->asIso($dt);
        }

        // Just a normal ping request
        return 'pong';
    }

}
