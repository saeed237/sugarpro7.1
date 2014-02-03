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

 * Description:  Base Form For Notes
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


class ProspectListFormBase {


function getForm($prefix, $mod='', $form=''){
	
	if(!ACLController::checkAccess('ProspectLists', 'edit', true)){
		return '';
	}
	
	if(!empty($mod)){
		global $current_language;
		$mod_strings = return_module_language($current_language, $mod);
	} else {
		global $mod_strings;
	}
	global $app_strings,$current_user;
	
	$lbl_save_button_title = $app_strings['LBL_SAVE_BUTTON_TITLE'];
	$lbl_save_button_key = $app_strings['LBL_SAVE_BUTTON_KEY'];
	$lbl_save_button_label = $app_strings['LBL_SAVE_BUTTON_LABEL'];
	$user_id = $current_user->id;


	$the_form = get_left_form_header($mod_strings['LBL_NEW_FORM_TITLE']);
	$the_form .= <<<EOQ
		<form name="${prefix}ProspectListSave" onSubmit="return check_form('${prefix}ProspectListSave');" method="POST" action="index.php">
			<input type="hidden" name="${prefix}module" value="ProspectLists">
			<input type="hidden" name="${prefix}action" value="Save">
			<input type="hidden" name="assigned_user_id" value='${user_id}'>
EOQ;

	$the_form .= $this->getFormBody($prefix, $mod, $prefix."ProspectListSave");
	$the_form .= <<<EOQ
		<p><input title="$lbl_save_button_title" accessKey="$lbl_save_button_key" class="button" type="submit" name="button" value="  $lbl_save_button_label  " ></p>
		</form>

EOQ;

	$the_form .= get_left_form_footer();
	$the_form .= get_validate_record_js();

	return $the_form;	
}

function getFormBody($prefix, $mod='',$formname='', $size='30',$script=true) {
	if(!ACLController::checkAccess('ProspectLists', 'edit', true)){
		return '';
	}
	global $mod_strings;
	$temp_strings = $mod_strings;
	if(!empty($mod)){
		global $current_language;
		$mod_strings = return_module_language($current_language, $mod);
	}
	global $app_strings;
	global $current_user;
	global $app_list_strings;
	
	$lbl_required_symbol = $app_strings['LBL_REQUIRED_SYMBOL'];
	$lbl_save_button_title = $app_strings['LBL_SAVE_BUTTON_TITLE'];
	$lbl_save_button_key = $app_strings['LBL_SAVE_BUTTON_KEY'];
	$lbl_save_button_label = $app_strings['LBL_SAVE_BUTTON_LABEL'];
	$user_id = $current_user->id;

	$list_options=get_select_options_with_id($app_list_strings['prospect_list_type_dom'], 'default');
	
	$lbl_prospect_list_name = $mod_strings['LBL_PROSPECT_LIST_NAME'];
	$lbl_list_type = $mod_strings['LBL_LIST_TYPE'];
	
	$form = <<<EOQ
			<p><input type="hidden" name="record" value="">
			$lbl_prospect_list_name&nbsp;<span class="required">$lbl_required_symbol</span><br>
			<input name='name' type="text" value=""><br>
			$lbl_list_type&nbsp;<span class="required">$lbl_required_symbol</span><br>
			<select name="list_type">$list_options</select></p>
EOQ;

	
	
	$javascript = new javascript();
	$javascript->setFormName($formname);
	$javascript->setSugarBean(BeanFactory::getBean('ProspectLists'));
	$javascript->addRequiredFields($prefix);
	$form .=$javascript->getScript();
	$mod_strings = $temp_strings;
	return $form;
}

	function handleSave($prefix,$redirect=true, $useRequired=false){
		
		
		require_once('include/formbase.php');
	
		
		$focus = BeanFactory::getBean('ProspectLists');
		if($useRequired &&  !checkRequired($prefix, array_keys($focus->required_fields))){
			return null;
		}
		$focus = populateFromPost($prefix, $focus);
		if(!$focus->ACLAccess('Save')){
			ACLController::displayNoAccess(true);
			sugar_cleanup(true);
		}
		if(empty($focus->name)){
			return null;
		}	
        if ( !isset($focus->assigned_user_id) || $focus->assigned_user_id == '' )
            $focus->assigned_user_id = $GLOBALS['current_user']->id;
	
		$return_id = $focus->save();
		if($redirect){
			$GLOBALS['log']->debug("Saved record with id of ".$return_id);
			handleRedirect($return_id, "ProspectLists");
		} else { 
			return $focus;
		}
	}
}
?>
