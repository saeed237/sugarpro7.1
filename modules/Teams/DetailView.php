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





require_once('modules/Teams/Forms.php');
require_once('include/DetailView/DetailView.php');

global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

if (!$GLOBALS['current_user']->isAdminForModule('Users')) sugar_die("Unauthorized access to administration.");

$focus = BeanFactory::getBean('Teams');

$detailView = new DetailView();
$offset=0;
if (isset($_REQUEST['offset']) or isset($_REQUEST['record'])) {
	$result = $detailView->processSugarBean("TEAM", $focus, $offset);
	if($result == null) {
	    sugar_die($app_strings['ERROR_NO_RECORD']);
	}
	$focus=$result;
} else {
	header("Location: index.php?module=Accounts&action=index");
}

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME']. ": " . $focus->get_summary_text()), true);

$GLOBALS['log']->info("Team detail view");

$xtpl=new XTemplate ('modules/Teams/DetailView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("GRIDLINE", $gridline);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("RETURN_MODULE", "Teams");
$xtpl->assign("RETURN_ACTION", "DetailView");
$xtpl->assign("ACTION", "EditView");
$xtpl->assign("NAME", Team::getDisplayName($focus->name, $focus->name_2));
$xtpl->assign("DESCRIPTION", nl2br(url2html($focus->description)));

$buttons = array(<<<EOD
            <input type="submit" class="button" id="teamEditButton" title="{$app_strings['LBL_EDIT_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_EDIT_BUTTON_KEY']}" value="{$app_strings['LBL_EDIT_BUTTON_LABEL']}">
EOD
, <<<EOD
            <input id="duplicate_button" title="{$app_strings['LBL_DUPLICATE_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_DUPLICATE_BUTTON_KEY']}" class="button" onclick="document.DetailView.isDuplicate.value = 1;" type="submit" name="Duplicate" value=" {$app_strings['LBL_DUPLICATE_BUTTON_LABEL']} ">
EOD
, <<<EOD
            <input id="delete_button" title="{$app_strings['LBL_DELETE_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_DELETE_BUTTON_KEY']}" class="button" onclick="document.DetailView.return_action.value = 'ListView'; document.DetailView.action.value = 'Delete'; return confirm('{$app_strings['NTC_DELETE_CONFIRMATION']}')" type="submit" name="Delete" value=" {$app_strings['LBL_DELETE_BUTTON_LABEL']} ">
EOD
);
require_once('include/SugarSmarty/plugins/function.sugar_action_menu.php');
$action_button = smarty_function_sugar_action_menu(array(
    'id' => 'team_action_menu',
    'buttons' => $buttons,
    'class' => 'clickMenu fancymenu',
), $xtpl);

$xtpl->assign("ACTION_BUTTON", $action_button);

global $current_user;
if($current_user->isAdminForModule('Users') && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){

	$xtpl->assign("ADMIN_EDIT","<a href='index.php?action=index&module=DynamicLayout&from_action=".$_REQUEST['action'] ."&from_module=".$_REQUEST['module'] ."&record=".$_REQUEST['record']. "&mod_lang=Teams'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDITLAYOUT'])."</a>");
}

$detailView->processListNavigation($xtpl, "TEAM", $offset);
$xtpl->parse("main");
$xtpl->out("main");

$sub_xtpl = $xtpl;
$old_contents = ob_get_contents();
ob_end_clean();
ob_start();
echo $old_contents;

require_once('include/SubPanel/SubPanelTiles.php');
$subpanel = new SubPanelTiles($focus, 'Teams');
echo $subpanel->display();

$error_message = isset($_REQUEST['message']) ? $_REQUEST['message'] : '';
if(!empty($error_message))
{
   if($error_message == 'LBL_MASSUPDATE_DELETE_GLOBAL_TEAM')
   {
   	  $error_message = $app_strings['LBL_MASSUPDATE_DELETE_GLOBAL_TEAM'];
   } else if($error_message == 'LBL_MASSUPDATE_DELETE_USER_EXISTS') {
   	  $user = BeanFactory::getBean('Users', $focus->associated_user_id);
	  $error_message = string_format($app_strings['LBL_MASSUPDATE_DELETE_USER_EXISTS'], array(Team::getDisplayName($focus->name, $focus->name_2), $user->full_name));
   }

echo <<<EOQ
<script type="text/javascript">
	popup_window = new YAHOO.widget.SimpleDialog("emptyLayout", {
		width: "300px",
		draggable: true,
		constraintoviewport: true,
		modal: true,
		fixedcenter: true,
		text: "{$error_message}",
		bodyStyle: "padding:5px",
		buttons: [{
			text: SUGAR.language.get('app_strings', 'LBL_EMAIL_OK'),
			isDefault:true,
			handler: function(){
				popup_window.hide()
			}
		}]
	});
	popup_window.render(document.body);
	popup_window.show();
</script>
EOQ;

}

?>
