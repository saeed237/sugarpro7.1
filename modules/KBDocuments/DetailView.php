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

require_once('include/upload_file.php');

require_once('include/DetailView/DetailView.php');
require_once('modules/KBDocuments/SearchUtils.php');

global $app_strings;
global $mod_strings;
global $app_list_strings;
global $gridline;


$mod_strings = return_module_language($current_language, 'KBDocuments');

$focus = BeanFactory::getBean('KBDocuments');
$detailView = new DetailView();
$offset=0;

if (isset($_REQUEST['offset']) or isset($_REQUEST['record'])) {
	$result = $detailView->processSugarBean("KBDOCUMENT", $focus, $offset);
	if($result == null) {
	    sugar_die($app_strings['ERROR_NO_RECORD']);
	}
	$focus=$result;
} else {
	header("Location: index.php?module=Accounts&action=index");
}

$old_id="";
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {

	$focus->id = "";
}

$params = array();
$params[] = $focus->kbdocument_name;

echo getClassicModuleTitle("KBDocuments", $params, true);


$GLOBALS['log']->info("KBDocument detail view");

$xtpl=new XTemplate ('modules/KBDocuments/DetailView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
$xtpl->assign("ADVANCED_SEARCH_IMAGE", SugarThemeRegistry::current()->getImageURL('advanced_search.gif'));
$xtpl->assign("BASIC_SEARCH_IMAGE", SugarThemeRegistry::current()->getImageURL('basic_search.gif'));
$xtpl->assign("GRIDLINE", $gridline);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);

$xtpl->assign("DOCUMENT_NAME", $focus->kbdocument_name);
//$xtpl->assign("REVISION", $focus->latest_revision);
$xtpl->assign("REVISION",$focus->kbdocument_revision_number);


global $locale;

$xtpl->assign("KBDOC_TAGS",KBDocument::get_kbdoc_tags_heirarchy($focus->id,"Detail"));
//get the document body
$article_body = KBDocument::get_kbdoc_body_without_incrementing_count($focus->id);
$xtpl->assign("KBDOC_BODY",from_html($article_body));
$xtpl->assign("KBDOC_ATTS",KBDocument::get_kbdoc_attachments($focus->id,"Detail"));

if(isset($focus->status_id) && isset($app_list_strings['kbdocument_status_dom']) && isset($app_list_strings['kbdocument_status_dom'][$focus->status_id])){
	$xtpl->assign("STATUS", $app_list_strings['kbdocument_status_dom'][$focus->status_id]);
 }
$xtpl->assign("FILE_URL", $focus->file_url);
$xtpl->assign("ACTIVE_DATE", $focus->active_date);
$xtpl->assign("EXP_DATE", $focus->exp_date);
$xtpl->assign("FILE_NAME", $focus->filename);
$xtpl->assign("FILE_URL_NOIMAGE", $focus->file_url_noimage);
$xtpl->assign("LAST_REV_CREATOR", $focus->last_rev_created_name);

$buttons = array(
    <<<EOD
            <input title="{$app_strings['LBL_EDIT_BUTTON_TITLE']}" id="edit_button" accessKey="{$app_strings['LBL_EDIT_BUTTON_KEY']}" class="button primary" onclick="this.form.return_module.value='KBDocuments'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$focus->id}'; this.form.action.value='EditView'" type="submit" name="Edit" value="{$app_strings['LBL_EDIT_BUTTON_LABEL']}">
EOD
,
    <<<EOD
            <input title="{$app_strings['LBL_DUPLICATE_BUTTON_TITLE']}" id="duplicate_button" accessKey="{$app_strings['LBL_DUPLICATE_BUTTON_KEY']}" class="button" onclick="this.form.return_module.value='KBDocuments'; this.form.return_action.value='index'; this.form.isDuplicate.value=true; this.form.action.value='EditView'" type="submit" name="Duplicate" value="{$app_strings['LBL_DUPLICATE_BUTTON_LABEL']}">
EOD
,
    <<<EOD
            <input title="{$app_strings['LBL_DELETE_BUTTON_TITLE']}" id="delete_button" accessKey="{$app_strings['LBL_DELETE_BUTTON_KEY']}" class="button" onclick="this.form.return_module.value='KBDocuments'; this.form.return_action.value='SearchHome'; this.form.action.value='Delete'; return confirm('{$app_strings['NTC_DELETE_CONFIRMATION']}')" type="submit" name="Delete" value="{$app_strings['LBL_DELETE_BUTTON_LABEL']}">
EOD
,
    <<<EOD
            <input title="{$mod_strings['LBL_SEND_EMAIL']}" id="send_email_button" accessKey="{$app_strings['LBL_DELETE_BUTTON_KEY']}" class="button" onclick="document.getElementById('isDuplicate').parentNode.removeChild(document.getElementById('isDuplicate'));this.form.return_module.value='Emails'; this.form.return_action.value='DetailView'; this.form.action.value='Compose';this.form.module.value='Emails'" type="submit" name="Send Email" value="{$mod_strings['LBL_SEND_EMAIL']}">
EOD
);
require_once('include/SugarSmarty/plugins/function.sugar_action_menu.php');
$action_button = smarty_function_sugar_action_menu(array(
    'id' => 'detail_header_action_menu',
    'buttons' => $buttons,
    'class' => 'clickMenu fancymenu',
), $xtpl);

$xtpl->assign("ACTION_BUTTON", $action_button);


if (isset($focus->last_rev_create_date)) {
	$xtpl->assign("LAST_REV_DATE", $focus->last_rev_create_date);
} else {
	$xtpl->assign("LAST_REV_DATE",  "");
}
if (isset($focus->date_entered) && !empty($focus->date_entered)) {
    $xtpl->assign("DATE_ENTERED",$focus->date_entered);
}



if (!empty($focus->team_id)) {

	$team = BeanFactory::getBean('Teams', $focus->team_id,true);
	require_once('modules/Teams/TeamSetManager.php');
	$xtpl->assign("TEAM", TeamSetManager::getCommaDelimitedTeams($focus->team_set_id, $focus->team_id, true));
}
if (!empty($focus->kbdoc_approver_id)) {

	$user = BeanFactory::getBean('Users', $focus->kbdoc_approver_id);
	$xtpl->assign("KBDOC_APPROVED_BY", $user->name);
}
if (!empty($focus->assigned_user_id)) {

	$user = BeanFactory::getBean('Users', $focus->assigned_user_id);
	$xtpl->assign("KBARTICLE_AUTHOR_NAME", $user->name);
}

$xtpl->parse("main.pro");


if (!empty($focus->template_type)) {
	$xtpl->assign("TEMPLATE_TYPE", $app_list_strings['kbdocument_template_type_dom'][$focus->template_type]);
}

// adding custom fields:
require_once('modules/DynamicFields/templates/Files/DetailView.php');

$xtpl->parse("main");
$xtpl->out("main");


$savedSearch = BeanFactory::getBean('SavedSearch');
$json = getJSONobj();
$savedSearchSelects = $json->encode(array($GLOBALS['app_strings']['LBL_SAVED_SEARCH_SHORTCUT'] . '<br>' . $savedSearch->getSelect('KBDocuments')));
$str = "<script>
YAHOO.util.Event.addListener(window, 'load', SUGAR.util.fillShortcuts, $savedSearchSelects);
</script>";
echo $str;
?>
