<?php
if(!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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

function getDocumentsExternalApiDropDown($focus = null, $name = null, $value = null, $view = null) {
    require_once('include/externalAPI/ExternalAPIFactory.php');

    $apiList = ExternalAPIFactory::getModuleDropDown('Documents');

    $apiList = array_merge(array('Sugar'=>$GLOBALS['app_list_strings']['eapm_list']['Sugar']),$apiList);
    if(!empty($value) && empty($apiList[$value])){
        $apiList[$value] = $value;
    }
    return $apiList;

}
 
