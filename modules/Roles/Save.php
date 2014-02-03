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








$focus = BeanFactory::getBean('Roles');

$tabs_def = urldecode($_REQUEST['display_tabs_def']);
$tabs_hide = urldecode($_REQUEST['hide_tabs_def']);

$allow_modules = explode(':::', $tabs_def);
$disallow_modules = explode(':::', $tabs_hide);

$focus->retrieve($_POST['record']);
print_r($_POST);
unset($_POST['id']);


foreach($focus->column_fields as $field)
{
	if(isset($_POST[$field]))
	{
		$value = $_POST[$field];
		$focus->$field = $value;

	}
}


$check_notify = FALSE;

$focus->save($check_notify);
$return_id = $focus->id;

$focus->clear_module_relationship($return_id);
$focus->set_module_relationship($return_id, $allow_modules, 1);
$focus->set_module_relationship($return_id, $disallow_modules, 0);



if(isset($_POST['return_module']) && $_POST['return_module'] != "") $return_module = $_POST['return_module'];
else $return_module = "Roles";
if(isset($_POST['return_action']) && $_POST['return_action'] != "") $return_action = $_POST['return_action'];
else $return_action = "DetailView";
if(isset($_POST['return_id']) && $_POST['return_id'] != "") $return_id = $_POST['return_id'];

	$GLOBALS['log']->debug("Saved record with id of ".$return_id);
	header("Location: index.php?action=$return_action&module=$return_module&record=$return_id");


?>
