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


require_once('clients/base/api/ModuleApi.php');
require_once('modules/ProspectLists/ProspectListsService.php');

class ProspectListsApi extends ModuleApi
{
    public function registerApiRest()
    {
        return array(
            'addToList' => array(
                'reqType' => 'POST',
                'path' => array('<module>', 'addToList'),
                'pathVars' => array('', ''),
                'method' => 'addRecordsToProspectList',
                'shortHelp' => 'This method updates a target list with selected users/contacts/leads',
                'longHelp' => 'include/api/help/module_addtolist_post_help.html',
            ),
        );
    }

    /**
     * Adds records to a prospect list
     */
    public function addRecordsToProspectList($api, $args)
    {
        $moduleName = $args['module'];
        $prospectListId = $args['prospectListId'];
        $recordIds = $args['recordIds'];

        if (empty($moduleName)) {
            throw new SugarApiExceptionMissingParameter('The module parameter is missing');
        }
        if (empty($prospectListId)) {
            throw new SugarApiExceptionMissingParameter('The prospectlistId parameter is missing');
        }
        if (empty($recordIds)) {
            throw new SugarApiExceptionMissingParameter('The recordIds are missing');
        }

        $targetList = new ProspectListsService();
        $response = $targetList->addRecordsToProspectList($moduleName, $prospectListId, $recordIds);

        if($response === false) {
            throw new SugarApiExceptionNotFound('Could not find parent record ' . $prospectListId . ' in module ' . $moduleName);
        }

        return $response;
    }
}
