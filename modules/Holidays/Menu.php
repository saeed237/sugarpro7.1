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

$module_menu = Array(

	Array("index.php?module=Holidays&action=EditView&return_module=Holidays&return_action=index", $mod_strings['LNK_NEW_HOLIDAY'],"CreateHolidays"),

);

if (is_admin($current_user)){
	array_push($module_menu, Array("index.php?module=Holidays&action=index", $mod_strings['LNK_HOLIDAYS'],"Holidays"));
}

?>