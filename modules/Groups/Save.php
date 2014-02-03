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



//_ppd($_REQUEST);
$focus = BeanFactory::getBean('Groups');

// New user
	// track the current reports to id to be able to use it if it has changed
	$old_reports_to_id = $focus->reports_to_id;

// Update
if(isset($_REQUEST['record']) && !empty($_REQUEST['record'])) {
	$focus->retrieve($_REQUEST['record']);
}

foreach($focus->column_fields as $field) {
	if(isset($_POST[$field])) {
		$value = $_POST[$field];
		$focus->$field = $value;
	}
}

foreach($focus->additional_column_fields as $field) {
	if(isset($_POST[$field])) {
		$value = $_POST[$field];
		$focus->$field = $value;
	}
}
if(isset($_REQUEST['user_name']) && !empty($_REQUEST['user_name'])) {
	$focus->user_name	= $_REQUEST['user_name'];
	$focus->last_name	= $_REQUEST['user_name'];
}
$focus->description	= $_REQUEST['description'];
$focus->default_team = $_REQUEST['team_id'];
$focus->save();


if(isset($_POST['return_module']) && $_POST['return_module'] != "") $return_module = $_POST['return_module'];
else $return_module = "Groups";
if(isset($_POST['return_action']) && $_POST['return_action'] != "") $return_action = $_POST['return_action'];
else $return_action = "DetailView";
if(isset($_POST['return_id']) && $_POST['return_id'] != "") $return_id = $_POST['return_id'];

$GLOBALS['log']->debug("Saved record with id of ".$return_id);

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id");
?>