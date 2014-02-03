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




global $app_list_strings, $app_strings, $mod_strings, $locale;

require_once('modules/Studio/DropDowns/DropDownHelper.php');
require_once('modules/Studio/parsers/StudioParser.php');
$dh = new DropDownHelper();
$dh->getDropDownModules();
$smarty = new Sugar_Smarty();
$smarty->assign('MOD', $GLOBALS['mod_strings']);
$title=getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_RENAME_TABS']), false);
$smarty->assign('title', $title);
if (!empty($_REQUEST['dropdown_lang'])) {
    $selected_lang = $_REQUEST['dropdown_lang'];
} else {
    $selected_lang = $locale->getAuthenticatedUserLanguage();
}

if (empty($selected_lang)) {
    $selected_lang = $GLOBALS['sugar_config']['default_language'];
}
if ($selected_lang == $GLOBALS['current_language']) {
    $my_list_strings = $GLOBALS['app_list_strings'];
} else {
    $my_list_strings = return_app_list_strings_language($selected_lang);
}
foreach ($my_list_strings as $key=>$value) {
    if (!is_array($value)) {
        unset($my_list_strings[$key]);
    }
}
$modules = array_keys($dh->modules);
$dropdown_modules = array(''=>$GLOBALS['mod_strings']['LBL_DD_ALL']);
foreach ($modules as $module) {
    $dropdown_modules[$module] = (!empty($app_list_strings['moduleList'][$module]))?$app_list_strings['moduleList'][$module]: $module;
}
$smarty->assign('dropdown_modules',$dropdown_modules);
if (!empty($_REQUEST['dropdown_module']) && !empty($dropdown_modules[$_REQUEST['dropdown_module']])) {
    $smarty->assign('dropdown_module',$_REQUEST['dropdown_module']);
    $dropdowns = (!empty($dh->modules[$_REQUEST['dropdown_module']]))?$dh->modules[$_REQUEST['dropdown_module']]: array();
    foreach ($dropdowns as $ok=>$dk) {
        if (!isset($my_list_strings[$dk]) || !is_array($my_list_strings[$dk])) {
            unset($dropdowns[$ok]);
        }
    }
} else {
    if (!empty($_REQUEST['dropdown_module'])) {
        $smarty->assign('error', 'Module does not have any known dropdowns');
    }
    $dropdowns = array_keys($my_list_strings);
}
asort($dropdowns);
if (!empty($_REQUEST['newDropdown'])) {
    $smarty->assign('newDropDown',true);
} else {
    $keys = array_keys($dropdowns);
    $first_string = $dropdowns[$keys[0]];
    $smarty->assign('dropdowns',$dropdowns);
    if (empty($_REQUEST['dropdown_name']) || !in_array($_REQUEST['dropdown_name'], $dropdowns)) {
        $_REQUEST['dropdown_name'] = $first_string;
    }
    $selected_dropdown = $my_list_strings[$_REQUEST['dropdown_name']];

    foreach ($selected_dropdown as $key=>$value) {
        if (isset($_SESSION['authenticated_user_language'])
            && $selected_lang != $_SESSION['authenticated_user_language']
            && !empty($app_list_strings[$_REQUEST['dropdown_name']])
            && isset($app_list_strings[$_REQUEST['dropdown_name']][$key])
        ) {
            $selected_dropdown[$key]=array('lang'=>$value, 'user_lang'=> '['.$app_list_strings[$_REQUEST['dropdown_name']][$key] . ']');
        } else {
            $selected_dropdown[$key]=array('lang'=>$value);
        }
    }

    $selected_dropdown = $dh->filterDropDown($_REQUEST['dropdown_name'], $selected_dropdown);

    $smarty->assign('dropdown', $selected_dropdown);
    $smarty->assign('dropdown_name',$_REQUEST['dropdown_name']);
}

$smarty->assign('dropdown_languages', get_languages());
if (strcmp($_REQUEST['dropdown_name'], 'moduleList') == 0) {
    $smarty->assign('disable_remove', true);
    $smarty->assign('disable_add', true);
    $smarty->assign('use_push', 1);
} else {
    $smarty->assign('use_push', 0);
}

$imageSave = SugarThemeRegistry::current()->getImage( 'studio_save', '',null,null,'.gif',$mod_strings['LBL_SAVE']);
$imageUndo = SugarThemeRegistry::current()->getImage('studio_undo', '',null,null,'.gif',$mod_strings['LBL_UNDO']);
$imageRedo = SugarThemeRegistry::current()->getImage('studio_redo', '',null,null,'.gif',$mod_strings['LBL_REDO']);
$buttons = array();
$buttons[] = array('text'=>$mod_strings['LBL_BTN_UNDO'],'actionScript'=>"onclick='jstransaction.undo()'" );
$buttons[] = array('text'=>$mod_strings['LBL_BTN_REDO'],'actionScript'=>"onclick='jstransaction.redo()'" );
$buttons[] = array('text'=>$mod_strings['LBL_BTN_SAVE'],'actionScript'=>"onclick='if(check_form(\"editdropdown\")){document.editdropdown.submit();}'");
$buttonTxt = StudioParser::buildImageButtons($buttons);
$smarty->assign('buttons', $buttonTxt);
$smarty->assign('dropdown_lang', $selected_lang);

$editImage = SugarThemeRegistry::current()->getImage( 'edit_inline', '',null,null,'.gif',$mod_strings['LBL_INLINE']);
$smarty->assign('editImage',$editImage);
$deleteImage = SugarThemeRegistry::current()->getImage( 'delete_inline', '',null,null,'.gif',$mod_strings['LBL_DELETE']);
$smarty->assign('deleteImage',$deleteImage);
$smarty->display("modules/Studio/DropDowns/EditView.tpl");
