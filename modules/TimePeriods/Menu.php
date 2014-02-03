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

global $mod_strings;
global $current_user;

$module_menu=Array();
if((is_admin($current_user)|| is_admin_for_module($current_user,'Forecasts')|| is_admin_for_module($current_user,'ForecastSchedule')))
{
$module_menu = Array(
	Array("index.php?module=TimePeriods&action=EditView&return_module=TimePeriods&return_action=DetailView", $mod_strings['LNK_NEW_TIMEPERIOD'],"CreateTimePeriods"),
	Array("index.php?module=TimePeriods&action=ListView&return_module=TimePeriods&return_action=DetailView", $mod_strings['LNK_TIMEPERIOD_LIST'],"TimePeriods"),
	);
}
?>
