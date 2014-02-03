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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/MySettings/TabController.php');

$tabs_def = urldecode(isset($_REQUEST['display_tabs_def']) ? $_REQUEST['display_tabs_def'] : '');
$DISPLAY_ARR = array();
parse_str($tabs_def,$DISPLAY_ARR);

//there was an issue where a non-admin user could use a proxy tool to intercept the save on their own Employee
//record and swap out their record_id with the admin employee_id which would cause the email address
//of the non-admin user to be associated with the admin user thereby allowing the non-admin to reset the password
//of the admin user.
if(isset($_POST['record']) && !is_admin($GLOBALS['current_user']) && !$GLOBALS['current_user']->isAdminForModule('Employees') && ($_POST['record'] != $GLOBALS['current_user']->id))
{
    sugar_die("Unauthorized access to administration.");
}
elseif (!isset($_POST['record']) && !is_admin($GLOBALS['current_user']) && !$GLOBALS['current_user']->isAdminForModule('Employees'))
{
    sugar_die ("Unauthorized access to user administration.");
}

$focus = BeanFactory::getBean('Employees', $_POST['record']);

//rrs bug: 30035 - I am not sure how this ever worked b/c old_reports_to_id was not populated.
$old_reports_to_id = $focus->reports_to_id;

populateFromRow($focus,$_POST);

$focus->save();
$return_id = $focus->id;

// If reports to has changed, call update team memberships to correct the membership tree
if ($old_reports_to_id != $focus->reports_to_id)
{
	$focus->update_team_memberships($old_reports_to_id);
}

if(isset($_POST['return_module']) && $_POST['return_module'] != "") $return_module = $_POST['return_module'];
else $return_module = "Employees";
if(isset($_POST['return_action']) && $_POST['return_action'] != "") $return_action = $_POST['return_action'];
else $return_action = "DetailView";
if(isset($_POST['return_id']) && $_POST['return_id'] != "") $return_id = $_POST['return_id'];

$GLOBALS['log']->debug("Saved record with id of ".$return_id);


header("Location: index.php?action=$return_action&module=$return_module&record=$return_id");


function populateFromRow(&$focus,$row){


	//only employee specific field values need to be copied.
	$e_fields=array('first_name','last_name','reports_to_id','description','phone_home','phone_mobile','phone_work','phone_other','phone_fax','address_street','address_city','address_state','address_country','address_country', 'address_postalcode', 'messenger_id','messenger_type');
	if ( is_admin($GLOBALS['current_user']) ) {
        $e_fields = array_merge($e_fields,array('title','department','employee_status'));
    }
    // Also add custom fields
    foreach ($focus->field_defs as $fieldName => $field ) {
        if ( isset($field['source']) && $field['source'] == 'custom_fields' ) {
            $e_fields[] = $fieldName;
        }
    }
    $nullvalue='';
	foreach($e_fields as $field)
	{
		$rfield = $field; // fetch returns it in lowercase only
		if(isset($row[$rfield]))
		{
			$focus->$field = $row[$rfield];
		}
	}
}
?>