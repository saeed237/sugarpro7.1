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




global $app_list_strings, $app_strings, $mod_strings;

require_once('modules/Studio/TabGroups/TabGroupHelper.php');
require_once('modules/Studio/parsers/StudioParser.php');

$tabGroupSelected_lang = (!empty($_GET['lang'])?$_GET['lang']:$_SESSION['authenticated_user_language']);
$tg = new TabGroupHelper();
$smarty = new Sugar_Smarty();
if(empty($GLOBALS['tabStructure'])){
    SugarAutoLoader::requireWithCustom('include/tabConfig.php', true) ; // include custom/ too
}
$title=getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_CONFIGURE_GROUP_TABS']), false);

#30205
$selectedAppLanguages = return_application_language($tabGroupSelected_lang);
require_once('include/GroupedTabs/GroupedTabStructure.php');
$availableModules = $tg->getAvailableModules($tabGroupSelected_lang);
$smarty->assign('availableModuleList',$availableModules);
$modList = array_keys($availableModules);
$modList = array_combine($modList, $modList); // Bug #48693 We need full list of modules here instead of displayed modules
$groupedTabsClass = new GroupedTabStructure();
$groupedTabStructure = $groupedTabsClass->get_tab_structure($modList, '', true,true);
foreach($groupedTabStructure as $mainTab => $subModules){
 	$groupedTabStructure[$mainTab]['label'] = $mainTab;
 	$groupedTabStructure[$mainTab]['labelValue'] = $selectedAppLanguages[$mainTab];
}

$smarty->assign('tabs', $groupedTabStructure);
#end of 30205
$selectedLanguageModStrings = return_module_language($tabGroupSelected_lang , 'Studio');
$smarty->assign('TGMOD', $selectedLanguageModStrings);
$smarty->assign('MOD', $GLOBALS['mod_strings']);
$smarty->assign('otherLabel', 'LBL_TABGROUP_OTHER');
$selected_lang = (!empty($_REQUEST['dropdown_lang'])?$_REQUEST['dropdown_lang']:$_SESSION['authenticated_user_language']);
if(empty($selected_lang)){
    $selected_lang = $GLOBALS['sugar_config']['default_language'];
}

$smarty->assign('dropdown_languages', get_languages());


$imageSave = SugarThemeRegistry::current()->getImage( 'studio_save', '',null,null,'.gif',$mod_strings['LBL_SAVE']);

$buttons = array();
$buttons [] = array ( 'text' => $GLOBALS['mod_strings']['LBL_BTN_SAVEPUBLISH'],'actionScript'=>"onclick='studiotabs.generateForm(\"edittabs\");document.edittabs.submit()'" ) ;
$html = "" ;
foreach ( $buttons as $button )
{
    $html .= "<td><input type='button' valign='center' class='button' style='cursor:pointer' onmousedown='this.className=\"buttonOn\";return false;' onmouseup='this.className=\"button\"' onmouseout='this.className=\"button\"' {$button['actionScript']} value = '{$button['text']}' ></td>" ;
}
$smarty->assign('buttons', $html);
$smarty->assign('title', $title);
$smarty->assign('dropdown_lang', $selected_lang);

$editImage = SugarThemeRegistry::current()->getImage( 'edit_inline', '',null,null,'.gif',$mod_strings['LBL_EDIT']);
$smarty->assign('editImage',$editImage);
$deleteImage = SugarThemeRegistry::current()->getImage( 'delete_inline', '',null,null,'.gif',$mod_strings['LBL_MB_DELETE']);
$recycleImage = SugarThemeRegistry::current()->getImage('icon_Delete','',48,48,'.gif',$mod_strings['LBL_MB_DELETE'] );
$smarty->assign('deleteImage',$deleteImage);
$smarty->assign('recycleImage',$recycleImage);

//#30205
global $sugar_config;
if(isset($sugar_config['other_group_tab_displayed'])){
	if($sugar_config['other_group_tab_displayed']){
		$value = 'checked';
	}else{
		$value = null;
	}
	$smarty->assign('other_group_tab_displayed', $value);
}else{
	$smarty->assign('other_group_tab_displayed', 'checked');
}
$smarty->assign('tabGroupSelected_lang', $tabGroupSelected_lang);

$smarty->assign('available_languages', get_languages());
$smarty->display("modules/Studio/TabGroups/EditViewTabs.tpl");
?>
