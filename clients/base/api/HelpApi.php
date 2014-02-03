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


require_once('data/BeanFactory.php');

class HelpApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'getHelp' => array(
                'reqType' => 'GET',
                'path' => array('help'),
                'pathVars' => array(''),
                'method' => 'getHelp',
                'shortHelp' => 'Shows Help information',
                'longHelp' => 'include/api/help/help_get_help.html',
                'rawReply' => true,
                // Everyone needs some help sometimes.
                'noLoginRequired' => true,
            ),
        );
    }

    public function getHelp($api, $args) {
        // This function needs to peer into the deep, twisted soul of the RestServiceDictionary
        $dir = $api->dict->dict;

        if ( empty($args['platform']) ) {
            $platform = 'base';
        } else {
            $platform = $args['platform'];
        }

        $endpointList = array();
        foreach ( $dir as $startDepth => $dirPart ) {
            if ( isset($dirPart[$platform]) ) {
                $endpointList = array_merge($endpointList, $this->getEndpoints($dirPart[$platform],$startDepth));
            }
        }

        // Add in the full endpoint paths, so we can sort by them
        foreach ( $endpointList as $idx => $endpoint ) {
            $fullPath = '';
            foreach ( $endpoint['path'] as $pathIdx => $pathPart ) {
                if ( $pathPart == '?' ) {
                    // pull in the path variable in here so the documentation is readable
                    $pathPart = ':'.$endpoint['pathVars'][$pathIdx];
                }
                $fullPath .= '/'.$pathPart;
            }
            $endpointList[$idx]['fullPath'] = $fullPath;
        }
        // Sort the endpoint list
        usort($endpointList,array('HelpApi','cmpEndpoints'));

        ob_start();
        require('include/api/help/extras/helpList.php');
        $endpointHtml = ob_get_clean();

        $api->setHeader('Content-Type', 'text/html');
        return $endpointHtml;
    }

    /**
     * This function is called recursively to pull the endpoints out of the pre-optimized arrays that the service dictionary stores them in. It's complicated and slow, but since this function is only called when the developer wants some docs, it's not worth the cost of storing this information elsewhere.
     * @param $dirPart array required, the section of the directory you are looking at
     * @param $depth int required, how much deeper you need to go before you actually find the endpoints.
     * @return array An array of endpoints for that directory part.
     */
    protected function getEndpoints($dirPart, $depth) {
        if ( $depth == 0 ) {
            $endpoints = array();
            foreach ( $dirPart as $subEndpoints ) {
                $endpoints = array_merge($endpoints, $subEndpoints);
            }

            return $endpoints;
        }

        $newDepth = $depth - 1;
        $endpoints = array();
        foreach ( $dirPart as $subDir ) {
            $endpoints = array_merge($endpoints, $this->getEndpoints($subDir, $newDepth));
        }

        return $endpoints;
    }

    /**
     * This function compares endpoints, it would be an anonymous function but we have to support older versions of PHP
     * @param $endpoint1 hash required, This should be one endpoint element in the endpoint list. Should look pretty close to something registered through registerApiRest()
     * @param $endpoint2 hash required, Second verse, same as the first.
     * @return int +1 if endpoint1 is greater than endpoint2, -1 otherwise
     */
    public static function cmpEndpoints($endpoint1, $endpoint2) {
        return ( $endpoint1['fullPath'] > $endpoint2['fullPath'] ) ? +1 : -1;
    }
}
