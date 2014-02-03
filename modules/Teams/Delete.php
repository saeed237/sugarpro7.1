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

global $current_user;

if (!$GLOBALS['current_user']->isAdminForModule('Users')) sugar_die("Unauthorized access to administration.");

global $mod_strings;
global $app_strings;


$focus = BeanFactory::getBean('Teams', $_REQUEST['record']);

//Check if there are module records where this team is assigned to in a team_set_id
//if so, redirect to prompt the Administrator to select a new team
if($focus->has_records_in_modules()) {
   header("Location: index.php?module=Teams&action=ReassignTeams&record={$focus->id}");
} else {
	//todo: Verify that no items are still assigned to this team.
	if($focus->id == $focus->global_team) {
		$msg = $GLOBALS['app_strings']['LBL_MASSUPDATE_DELETE_GLOBAL_TEAM'];
		$GLOBALS['log']->fatal($msg);
        $error_message = $app_strings['LBL_MASSUPDATE_DELETE_GLOBAL_TEAM'];
         SugarApplication::appendErrorMessage($error_message);
		header('Location: index.php?module=Teams&action=DetailView&record='.$focus->id);
		return;
	}
	
	//Check if the associated user is deleted
	$user = BeanFactory::getBean('Users', $focus->associated_user_id);
	if($focus->private == 1 && (!empty($user->id) && $user->deleted != 1))
	{
		$msg = string_format($GLOBALS['app_strings']['LBL_MASSUPDATE_DELETE_USER_EXISTS'], array(Team::getDisplayName($focus->name, $focus->name_2), $user->full_name));
		$GLOBALS['log']->error($msg);
        SugarApplication::appendErrorMessage($msg);
		header('Location: index.php?module=Teams&action=DetailView&record='.$focus->id);
		return;
	}

	//Call mark_deleted function
	$focus->mark_deleted();
	header("Location: index.php?module=Teams&action=index");	
}
?>
