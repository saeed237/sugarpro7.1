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

 ********************************************************************************/






global $theme;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user, $focus;

echo getClassicModuleTitle(
        "Administration", 
        array(
            "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
           $mod_strings['LBL_MODULE_NAME'],
           ), 
        false
        );

if($current_user->is_admin){
require_once('modules/Currencies/ListCurrency.php');

$focus = BeanFactory::getBean('Currencies');
$lc = new ListCurrency();
$lc->handleAdd();

if(isset($_REQUEST['merge']) && $_REQUEST['merge'] == 'true'){
	$isMerge = true;
	
}
if(isset($_REQUEST['domerge'])){
	$currencies = $_REQUEST['mergecur'];
	
	
	$opp = BeanFactory::getBean('Opportunities');
	$opp->update_currency_id($currencies, $_REQUEST['mergeTo'] );
	
	$product = BeanFactory::getBean('ProductTemplates');
	$product->update_currency_id($currencies, $_REQUEST['mergeTo'] );

	$quote = BeanFactory::getBean('Quotes');
	$quote->update_currency_id($currencies, $_REQUEST['mergeTo'] );
	foreach($currencies as $cur){
		if($cur != $_REQUEST['mergeTo'])
		$focus->mark_deleted($cur);
	}
}
$lc->lookupCurrencies();
if (isset($focus->id)) $focus_id = $focus->id;
else $focus_id='';
$merge_button = '';
$pretable = '';
if((isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'merge') || (isset($isMerge) && !$isMerge)){
$merge_button = '<form name= "MERGE" method="POST" action="index.php"><input type="hidden" name="module" value="Currencies"><input type="hidden" name="record" value="'.$focus_id.'"><input type="hidden" name="action" value="index"><input type="hidden" name="merge" value="true"><input title="'.$mod_strings['LBL_MERGE'].'"  class="button"  type="submit" name="button" value="'.$mod_strings['LBL_MERGE'].'" ></form>';
}
if(isset($isMerge) && $isMerge){
	$currencyList = new ListCurrency();
	$listoptions = $currencyList->getSelectOptions();
	$pretable =  <<<EOQ
		<form name= "MERGE" method="POST" action="index.php">
			<input type="hidden" name="module" value="Currencies">
			
			<input type="hidden" name="action" value="index">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="edit view">
			<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
			<td>{$mod_strings['LBL_MERGE_TXT']}</td><td width='20%'><select name='mergeTo'>{$listoptions}</select></td>
			</tr>
			<tr><td></td><td><input title="{$mod_strings['LBL_MERGE']}" class="button" type="submit" name="domerge" value="{$mod_strings['LBL_MERGE']}" >
		<input title="{$app_strings['LBL_CANCEL_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_CANCEL_BUTTON_KEY']}" class="button"  type="submit" name="button" value="{$app_strings['LBL_CANCEL_BUTTON_LABEL']}" > </td></tr>
			</table></td></tr></table><br>
EOQ;
	

}
$edit_botton = '<form name="EditView" method="POST" action="index.php" >';
			$edit_botton .= '<input type="hidden" name="module" value="Currencies">';
			$edit_botton .= '<input type="hidden" name="record" value="'.$focus_id.'">';
			$edit_botton .= '<input type="hidden" name="action">';
			$edit_botton .= '<input type="hidden" name="edit">';
			$edit_botton .= '<input type="hidden" name="return_module" value="Currencies">';
			$edit_botton .= '<input type="hidden" name="return_action" value="index">';
			$edit_botton .= '<input type="hidden" name="return_id" value="">';
		$edit_botton .= '<input title="'.$app_strings['LBL_SAVE_BUTTON_TITLE'].'" accessKey="'.$app_strings['LBL_SAVE_BUTTON_KEY'].'" class="button" onclick="this.form.edit.value=\'true\';this.form.action.value=\'index\';return check_form(\'EditView\');" type="submit" name="button" value="'.$app_strings['LBL_SAVE_BUTTON_LABEL'].'" > ';
		$edit_botton .= '<input title="'.$app_strings['LBL_CANCEL_BUTTON_TITLE'].'" accessKey="'.$app_strings['LBL_CANCEL_BUTTON_KEY'].'" class="button" onclick="this.form.edit.value=\'false\';this.form.action.value=\'index\';" type="submit" name="button" value="'.$app_strings['LBL_CANCEL_BUTTON_LABEL'].'" > ';
$header_text = '';
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){	
		$header_text = "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=ListView&from_module=".$_REQUEST['module'] ."'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDIT_LAYOUT'])."</a>";
	}
$ListView = new ListView();
$ListView->initNewXTemplate( 'modules/Currencies/ListView.html',$mod_strings);
$ListView->xTemplateAssign('PRETABLE', $pretable);
$ListView->xTemplateAssign('POSTTABLE', '</form>');
$ListView->xTemplateAssign("DELETE_INLINE_PNG",  SugarThemeRegistry::current()->getImage('delete_inline','align="absmiddle" border="0"', null,null,'.gif',$app_strings['LNK_DELETE']));
//$ListView->setHeaderTitle($mod_strings['LBL_LIST_FORM_TITLE']. $header_text );
$ListView->setHeaderText($merge_button);

$ListView->processListView($lc->list, "main", "CURRENCY");

if(isset($_GET['record']) && !empty($_GET['record']) && !isset($_POST['edit'])) { 
	$focus->retrieve($_GET['record']);
	$focus->conversion_rate = format_number($focus->conversion_rate, 10, 10);
}
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){	
		$header_text = "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=EditView&from_module=".$_REQUEST['module'] ."'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'", null,null,'.gif',$mod_strings['LBL_EDIT_LAYOUT'])."</a>";
}
if ( empty($focus->id) ) {
    echo get_form_header($app_strings['LBL_CREATE_BUTTON_LABEL'] . $header_text,$edit_botton , false); 
}
else {
    echo get_form_header($app_strings['LBL_EDIT_BUTTON_LABEL']." &raquo; ".$focus->name . $header_text,$edit_botton , false); 
}
$sugar_smarty = new Sugar_Smarty();

	$sugar_smarty->assign("MOD", $mod_strings);
	$sugar_smarty->assign("APP", $app_strings);

// Load in the full ISO 4217 list, so we can dynamically populate the currency strings
    require_once('modules/Currencies/iso4217.php');
    $json = getJSONobj();
    $js_iso4217 = $json->encode($fullIsoList);
    $sugar_smarty->assign('JS_ISO4217',$js_iso4217);
	
	if (isset($_REQUEST['return_module'])) $sugar_smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
	if (isset($_REQUEST['return_action'])) $sugar_smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
	if (isset($_REQUEST['return_id'])) $sugar_smarty->assign("RETURN_ID", $_REQUEST['return_id']);
	
	$sugar_smarty->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
	$sugar_smarty->assign("JAVASCRIPT", get_set_focus_js());
    $sugar_smarty->assign("THEME", SugarThemeRegistry::current()->__toString());
	$sugar_smarty->assign("ID", $focus->id);
	$sugar_smarty->assign('NAME', $focus->name);
	$sugar_smarty->assign('STATUS', $focus->status);
	$sugar_smarty->assign('ISO4217', $focus->iso4217);
	$sugar_smarty->assign('CONVERSION_RATE', $focus->conversion_rate);
	$sugar_smarty->assign('SYMBOL', $focus->symbol);
	$sugar_smarty->assign('STATUS_OPTIONS', get_select_options_with_id($mod_strings['currency_status_dom'], $focus->status));
	
	//if (empty($focus->list_order)) $xtpl->assign('LIST_ORDER', count($focus->get_manufacturers(false,'All'))+1); 
	//else $xtpl->assign('LIST_ORDER', $focus->list_order);
	
	$sugar_smarty->display("modules/Currencies/EditView.tpl");
	
	$javascript = new javascript();
	$javascript->setFormName('EditView');
	$javascript->setSugarBean($focus);
	$javascript->addAllFields('',array('iso4217'=>'iso4217'));
	echo $javascript->getScript();
    echo("<script type='text/javascript'>addToValidateMoreThan('EditView','conversion_rate','float',true,'".$mod_strings['LBL_BELOW_MIN']."',0.000001);</script>");
}
else
{
    echo $mod_strings['LBL_ADMIN_ONLY'];
}

?>
