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

 * Description:  Saves an Account record and then redirects the browser to the
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/SugarFolders/SugarFolders.php');
$folder = new SugarFolder();
$_REQUEST['name'] = $_REQUEST['groupFolderAddName'];
$_REQUEST['parent_folder'] = $_REQUEST['groupFoldersAdd'];
$_REQUEST['group_id'] = $_REQUEST['groupFoldersUser'];
require_once("modules/Teams/TeamSet.php");
$_REQUEST['team_id'] = $_REQUEST['primaryTeamId'];
$teamSet = BeanFactory::getBean('TeamSets');
$teamIds = explode(",", $_REQUEST['teamIds']);
$team_set_id = $teamSet->addTeams($teamIds);
$_REQUEST['team_set_id'] = $team_set_id;
if (empty($_REQUEST['record'])) {
	$folder->setFolder($_REQUEST);
} else {
	$folder->updateFolder($_REQUEST);
}
$body1 = "
	<script type='text/javascript'>
		function refreshOpener() {
			window.opener.refresh_group_folder_list('$folder->id','$folder->name')
			window.close();
		} // fn
		refreshOpener();
	</script>";
echo  $body1;
?>