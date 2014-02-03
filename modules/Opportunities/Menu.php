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

/*********************************************************************************

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $mod_strings, $app_strings, $sugar_config;
$module_menu = Array();
if(ACLController::checkAccess('Opportunities','edit',true)){
	$module_menu[]=	Array("index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView", $mod_strings['LNK_NEW_OPPORTUNITY'],"CreateOpportunities");
}
if(ACLController::checkAccess('Opportunities','list',true)){
	$module_menu[]=	Array("index.php?module=Opportunities&action=index&return_module=Opportunities&return_action=DetailView", $mod_strings['LNK_OPPORTUNITY_LIST'],"Opportunities");
}
if(empty($sugar_config['disc_client'])){
	if(ACLController::checkAccess('Opportunities','view',true)){
		$module_menu[]=	Array("index.php?module=Reports&action=index&view=opportunities", $mod_strings['LNK_OPPORTUNITY_REPORTS'],"OpportunityReports", 'Opportunities');
	}
}
if(ACLController::checkAccess('Opportunities','import',true)){
	$module_menu[]=  Array("index.php?module=Import&action=Step1&import_module=Opportunities&return_module=Opportunities&return_action=index", $mod_strings['LNK_IMPORT_OPPORTUNITIES'],"Import");
}

?>