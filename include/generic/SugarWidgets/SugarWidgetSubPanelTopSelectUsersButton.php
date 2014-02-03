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






class SugarWidgetSubPanelTopSelectUsersButton extends SugarWidgetSubPanelTopSelectButton
{
	//button_properties is a collection of properties associated with the widget_class definition. layoutmanager
	function SugarWidgetSubPanelTopSelectUsersButton($button_properties=array())
	{
		$this->button_properties=$button_properties;
	}

    function getDisplayName()
    {
        return $GLOBALS['app_strings']['LBL_SELECT_USER_BUTTON_LABEL'];
    }
	//widget_data is the collection of attributes associated with the button in the layout_defs file.
	function display(&$widget_data)
	{
		global $app_strings;
		$initial_filter = '';

		$this->title = $app_strings['LBL_SELECT_USER_BUTTON_TITLE'];
		//$this->accesskey = $app_strings['LBL_SELECT_USER_BUTTON_KEY'];
		$this->value = $this->getDisplayName();

		$this->module_name = 'Users';

		if (is_array($this->button_properties)) {
			if( isset($this->button_properties['title'])) {
				$this->title = $app_strings[$this->button_properties['title']];
			}
			if( isset($this->button_properties['accesskey'])) {
				//$this->accesskey = $app_strings[$this->button_properties['accesskey']];
			}
			if( isset($this->button_properties['form_value'])) {
				$this->value = $app_strings[$this->button_properties['form_value']];
			}
			if( isset($this->button_properties['module'])) {
				$this->module_name = $this->button_properties['module'];
			}
		}

		$focus = $widget_data['focus'];
		if(ACLController::moduleSupportsACL($widget_data['module']) && !ACLController::checkAccess($widget_data['module'], 'list', true)){
			$button = ' <input type="button" name="' .$this->getWidgetId() . '" id="' .$this->getWidgetId() . '" class="button"' . "\"\n"
			. ' title="' . $this->title . '"'
			. ' value="' . $this->value . "\"\n"
			.' disabled />';
			return $button;
		}

		//refresh the whole page after end of action?
		$refresh_page = 0;
		if(!empty($widget_data['subpanel_definition']->_instance_properties['refresh_page'])){
			$refresh_page = 1;
		}

		$subpanel_definition = $widget_data['subpanel_definition'];

		$button_definition = $subpanel_definition->get_buttons();
		$subpanel_name = $subpanel_definition->get_module_name();
		if (empty($this->module_name)) {
			$this->module_name = $subpanel_name;
		}

		if ($subpanel_name == 'Project'){
			$link_field_name = 'user_resources';
		}
		else{
			$link_field_name = $subpanel_definition->get_data_source_name(true);
		}

		$popup_mode='Single';
		if(isset($widget_data['mode'])){
			$popup_mode=$widget_data['mode'];
		}
		if(isset($widget_data['initial_filter_fields'])){
			if (is_array($widget_data['initial_filter_fields'])) {
				foreach ($widget_data['initial_filter_fields'] as $value=>$alias) {
					if (isset($focus->$value) and !empty($focus->$value)) {
						$initial_filter.="&".$alias . '='.urlencode($focus->$value);
					}
				}
			}
		}

		if (!empty($widget_data['filter_out_is_admin'])) {
            $initial_filter.="&is_admin_advanced=0";
        }

		$create="true";
		if(isset($widget_data['create'])){
			$create=$widget_data['create'];
		}
		$return_module = $_REQUEST['module'];
		$return_action = 'SubPanelViewer';
		$return_id = $_REQUEST['record'];

		//field_to_name_array
		$fton_array= array('id' => 'subpanel_id');
		if(isset($widget_data['field_to_name_array']) && is_array($widget_data['field_to_name_array'])){
			$fton_array=array_merge($fton_array,$widget_data['field_to_name_array']);
		}

		$return_url = "index.php?module=$return_module&action=$return_action&subpanel=$subpanel_name&record=$return_id&sugar_body_only=1";

		$popup_request_data = array(
			'call_back_function' => 'set_return_and_save_background',
			'form_name' => 'DetailView',
			'field_to_name_array' => $fton_array,
			'passthru_data' => array(
				'child_field' => $this->module_name,
				'return_url' => urlencode($return_url),
				'link_field_name' => $link_field_name,
				'module_name' => $this->module_name,
				'refresh_page' => 1,
			),
		);

		if (is_array($this->button_properties) && !empty($this->button_properties['add_to_passthru_data'])) {
			$popup_request_data['passthru_data']= array_merge($popup_request_data['passthru_data'],$this->button_properties['add_to_passthru_data']);
		}

		if (is_array($this->button_properties) && !empty($this->button_properties['add_to_passthru_data']['return_type'])) {

			if ($this->button_properties['add_to_passthru_data']['return_type']=='report') {
				$initial_filter = "&module_name=". urlencode($widget_data['module']);
			}
		}
		$json_encoded_php_array = $this->_create_json_encoded_popup_request($popup_request_data);

		return '<form action="index.php">' . "\n"
			. ' <input type="button" name="' .$this->getWidgetId() . '" id="' .$this->getWidgetId() . '" class="button"' . "\"\n"
				. ' title="' . $this->title . '"'
			. ' value="' . $this->value . "\"\n"
			. " onclick='open_popup(\"$this->module_name\",600,400,\"$initial_filter\",true,true,$json_encoded_php_array,\"$popup_mode\",$create);' /></form>\n";
	}
}
?>
