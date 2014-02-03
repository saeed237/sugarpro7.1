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






class SugarWidgetSubPanelTopSummaryButton extends SugarWidgetSubPanelTopButton
{
	function display($widget_data)
	{
		
		
		global $app_strings;
		global $currentModule;

		$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => 'EditView',
			'field_to_name_array' => array(),
		);

		$json_encoded_php_array = $this->_create_json_encoded_popup_request($popup_request_data);
		$title = $app_strings['LBL_ACCUMULATED_HISTORY_BUTTON_TITLE'];
		//$accesskey = $app_strings['LBL_ACCUMULATED_HISTORY_BUTTON_KEY'];
		$value = $app_strings['LBL_ACCUMULATED_HISTORY_BUTTON_LABEL'];
		$module_name = 'Activities';
		$id = $widget_data['focus']->id;
		$initial_filter = "&record=$id&module_name=$currentModule";
		if(ACLController::moduleSupportsACL($widget_data['module']) && !ACLController::checkAccess($widget_data['module'], 'detail', true)){
			$temp =  '<input disabled type="button" name="summary_button" id="summary_button"'
			. ' class="button"'
			. ' title="' . $title . '"'
			. ' value="' . $value . '"';
			return $temp;
		}
		return '<input type="button" name="summary_button" id="summary_button"'
			. ' class="button"'
			. ' title="' . $title . '"'
			. ' value="' . $value . '"'
			. " onclick='open_popup(\"$module_name\",600,400,\"$initial_filter\",false,false,$json_encoded_php_array);' />\n";
	}
}
?>