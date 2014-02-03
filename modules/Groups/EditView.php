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





global $app_strings;
global $app_list_strings;
global $mod_strings;
global $theme;


$focus = BeanFactory::getBean('Groups');

if (!is_admin($current_user) && $_REQUEST['record'] != $current_user->id) sugar_die("Unauthorized access to administration.");
if(isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
    //TODO figure out why i have to hard-code this data load?
    $focus->default_team = $focus->fetched_row['default_team'];
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
	$focus->user_name = "";
}

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$focus->last_name." (".$focus->user_name.")"), true);

$GLOBALS['log']->info("Groups edit view");
$xtpl= new XTemplate ('modules/Groups/EditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("USER_NAME", $focus->user_name);
$xtpl->assign("DESCRIPTION", $focus->description);
$r = $focus->db->query('SELECT id, name FROM teams WHERE deleted = 0 AND private = 0');
$k = array('' => '');
if(is_resource($r)) {
	while($a = $focus->db->fetchByAssoc($r)) {
		$k[$a['id']] = $a['name'];
	}
}
if(!empty($focus->default_team)) { $team_id = $focus->default_team; }
else $team_id = '';
$xtpl->assign('TEAMS', get_select_options_with_id($k, $team_id));

if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
// handle Create $module then Cancel
if (empty($_REQUEST['return_id'])) {
	$xtpl->assign("RETURN_ACTION", 'index');
}
$xtpl->parse("main");
$xtpl->out("main");

?>