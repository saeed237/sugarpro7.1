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


//Create User Teams
$globalteam = BeanFactory::getBean('Teams', '1');
if(isset($globalteam->name)){
    echo 'Global '.$mod_strings['LBL_UPGRADE_TEAM_EXISTS'].'<br>';
    if($globalteam->deleted) {
        $globalteam->mark_undeleted($globalteam->id);
    }
} else {
    $globalteam->create_team("Global", $mod_strings['LBL_GLOBAL_TEAM_DESC'], $globalteam->global_team);
}

$results = $GLOBALS['db']->query("SELECT id, user_name FROM users WHERE default_team != '' AND default_team IS NOT NULL");

$team = BeanFactory::getBean('Teams');
$user = BeanFactory::getBean('Users');
while($row = $GLOBALS['db']->fetchByAssoc($results)) {
	$results2 = $GLOBALS['db']->query("SELECT id, name FROM teams WHERE associated_user_id = '" . $row['id'] . "'");
	$row2 = $GLOBALS['db']->fetchByAssoc($results2);
	if(empty($row2['id'])) {
		$user->retrieve($row['id']);
		$team->new_user_created($user);
		// BUG 10339: do not display messages for upgrade wizard
		if(!isset($_REQUEST['upgradeWizard'])){
			echo $mod_strings['LBL_UPGRADE_TEAM_CREATE'].' '. $row['user_name']. '<br>';
		}
	}else{
		echo $row2['name'] .' '.$mod_strings['LBL_UPGRADE_TEAM_EXISTS'].'<br>';
	}

	$globalteam->add_user_to_team($row['id']);
}

echo '<br>' . $mod_strings['LBL_DONE'];
