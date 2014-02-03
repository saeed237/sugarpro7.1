<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once('include/api/SugarApi.php');

class RevenueLineItemsApi extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'commitstage' => array(
                'reqType' => 'GET',
                'path' => array('RevenueLineItems', 'enum', 'commit_stage'),
                'pathVars' => array('', '', ''),
                'method' => 'commitStage',
                'shortHelp' => 'Returns commit stages array per config settings',
                'longHelp' => 'modules/RevenueLineItems/clients/base/api/help/RevenueLineItemsApiCommitStage.html',
            ),
        );
    }

    /**
     * Retrieves the commit_stage dropdown items based on the setting in the forecasts config
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return array
     */
    public function commitStage($api, $args)
    {
        global $app_list_strings;

        $adminBean = BeanFactory::getBean('Administration');
        $config = $adminBean->getConfigForModule('Forecasts', $api->platform);
        return $app_list_strings[$config['buckets_dom']];
    }
}
