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


global $mod_strings;
global $current_user;
$actions = array('ModifyProperties', 'ModifyDisplay',
'ModifySearch',
'ModifyMapping', 'ConnectorSettings');
if(in_array($GLOBALS['action'], $actions)){
	$module_menu[]=Array("index.php?module=Connectors&action=ConnectorSettings", $mod_strings['LBL_ADMINISTRATION_MAIN'],"icon_Connectors");
	$module_menu[]=Array("index.php?module=Connectors&action=ModifyProperties", $mod_strings['LBL_MODIFY_PROPERTIES_TITLE'],"icon_ConnectorConfig_16");
	$module_menu[]=Array("index.php?module=Connectors&action=ModifyDisplay", $mod_strings['LBL_MODIFY_DISPLAY_TITLE'],"icon_ConnectorEnable_16");
	$module_menu[]=Array("index.php?module=Connectors&action=ModifyMapping", $mod_strings['LBL_MODIFY_MAPPING_TITLE'],"icon_ConnectorMap_16");


	$module_menu[]=Array("index.php?module=Connectors&action=ModifySearch", $mod_strings['LBL_MODIFY_SEARCH_TITLE'],"icon_ConnectorSearchFields_16");


}

if(!empty($_REQUEST['merge_module']) && ($GLOBALS['action'] == 'Step1' || $GLOBALS['action'] == 'Step2')) {
   $merge_module = $_REQUEST['merge_module'];
   $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $merge_module);
   foreach(SugarAutoLoader::existingCustom("modules/{$merge_module}/Menu.php") as $file) {
       require $file;
   }
   $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $GLOBALS['module']);
}
