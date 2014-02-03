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




global $mod_strings;
global $current_user;


if (!$GLOBALS['current_user']->isAdminForModule('Users')) sugar_die("Unauthorized access to administration.");

$focus = BeanFactory::getBean('Teams');

if(!isset($_REQUEST['record']) || !isset($_REQUEST['user_id'])) {
	sugar_die($mod_strings['ERR_ADD_RECORD']);
}
else {
	$record = $_REQUEST['record'];
	$user_id = $_REQUEST['user_id'];
	if(is_array($record)){
		foreach($record as $id){
			$focus->retrieve($id);
			$focus->add_user_to_team($user_id);
		}
	}
	else{
		$focus->retrieve($record);
		$focus->add_user_to_team($user_id);
	}
}
header("Location: index.php?module={$_REQUEST['return_module']}&action={$_REQUEST['return_action']}&record={$_REQUEST['return_id']}");
?>
