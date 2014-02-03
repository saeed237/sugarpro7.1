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




global $app_list_strings, $app_strings, $current_user;

$mod_strings = return_module_language($GLOBALS['current_language'], 'Users');

$focus = BeanFactory::getBean('Users', $_REQUEST['record']);
if ( !is_admin($focus) ) {
    $sugar_smarty = new Sugar_Smarty();
    $sugar_smarty->assign('MOD', $mod_strings);
    $sugar_smarty->assign('APP', $app_strings);
    $sugar_smarty->assign('APP_LIST', $app_list_strings);
    
    $categories = ACLAction::getUserActions($_REQUEST['record'],true);
    
    //clear out any removed tabs from user display
    if(!$GLOBALS['current_user']->isAdminForModule('Users')){
        $tabs = $focus->getPreference('display_tabs');
        global $modInvisList;
        if(!empty($tabs)){
            foreach($categories as $key=>$value){
                if(!in_array($key, $tabs) &&  !in_array($key, $modInvisList) ){
                    unset($categories[$key]);
                    
                }
            }
            
        }
    }
    
    $names = array();
    $names = ACLAction::setupCategoriesMatrix($categories);
    if(!empty($names))$tdwidth = 100 / sizeof($names);
    $sugar_smarty->assign('APP', $app_list_strings);
    $sugar_smarty->assign('CATEGORIES', $categories);
    $sugar_smarty->assign('TDWIDTH', $tdwidth);
    $sugar_smarty->assign('ACTION_NAMES', $names);
    
    $title = getClassicModuleTitle( '',array($mod_strings['LBL_MODULE_NAME'],$mod_strings['LBL_ROLES_SUBPANEL_TITLE']), '');
    
    $sugar_smarty->assign('TITLE', $title);
    $sugar_smarty->assign('USER_ID', $focus->id);
    $sugar_smarty->assign('LAYOUT_DEF_KEY', 'UserRoles');
    echo $sugar_smarty->fetch('modules/ACLRoles/DetailViewUser.tpl');
    
    
    //this gets its layout_defs.php file from the user not from ACLRoles so look in modules/Users for the layout defs
    require_once('include/SubPanel/SubPanelTiles.php');
    $modules_exempt_from_availability_check=array('Users'=>'Users','ACLRoles'=>'ACLRoles',);
    $subpanel = new SubPanelTiles($focus, 'UserRoles');
    
    echo $subpanel->display(true,true);
}
if ( empty($hideTeams) ) {
    $focus_list =$focus->get_my_teams(TRUE);
    
    // My Teams subpanel should not be displayed for group and portal users
    if(!($focus->is_group=='1' || $focus->portal_only=='1')){
        include('modules/Teams/SubPanelViewUsers.php');
        $SubPanel = new SubPanelViewUsers();
        $SubPanel->setFocus($focus);
        $SubPanel->setTeamsList($focus_list);
        $SubPanel->ProcessSubPanelListView("modules/Teams/SubPanelViewUsers.html", $mod_strings, 'DetailView');
    }
}
