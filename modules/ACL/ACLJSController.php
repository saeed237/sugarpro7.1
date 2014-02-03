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



class ACLJSController{

	function ACLJSController($module,$form='', $is_owner=false){

		$this->module = $module;
		$this->is_owner = $is_owner;
		$this->form = $form;
	}

	function getJavascript(){
		global $action;
		if(!ACLController::moduleSupportsACL($this->module)){
			return '';
		}
		$script = "<SCRIPT>\n//BEGIN ACL JAVASCRIPT\n";

		if($action == 'DetailView'){
			if(!ACLController::checkAccess($this->module,'edit', $this->is_owner)){
			$script .= <<<EOQ
						if(typeof(document.DetailView) != 'undefined'){
							if(typeof(document.DetailView.elements['Edit']) != 'undefined'){
								document.DetailView.elements['Edit'].disabled = 'disabled';
							}
							if(typeof(document.DetailView.elements['Duplicate']) != 'undefined'){
								document.DetailView.elements['Duplicate'].disabled = 'disabled';
							}
						}
EOQ;
}
			if(!ACLController::checkAccess($this->module,'delete', $this->is_owner)){
			$script .= <<<EOQ
						if(typeof(document.DetailView) != 'undefined'){
							if(typeof(document.DetailView.elements['Delete']) != 'undefined'){
								document.DetailView.elements['Delete'].disabled = 'disabled';
							}
						}
EOQ;
}
		}
		if(SugarAutoLoader::fileExists('modules/'. $this->module . '/metadata/acldefs.php')){
			include('modules/'. $this->module . '/metadata/acldefs.php');

			foreach($acldefs[$this->module]['forms'] as $form_name=>$form){

				foreach($form as $field_name=>$field){

					if($field['app_action'] == $action){
						switch($form_name){
							case 'by_id':
								$script .= $this->getFieldByIdScript($field_name, $field);
								break;
							case 'by_name':
								$script .= $this->getFieldByNameScript($field_name, $field);
								break;
							default:
								$script .= $this->getFieldByFormScript($form_name, $field_name, $field);
								break;
						}
					}

				}
			}
		}
		$script .=  '</SCRIPT>';

		return $script;


	}

	function getHTMLValues($def){
		$return_array = array();
		switch($def['display_option']){
			case 'clear_link':
				$return_array['href']= "#";
				$return_array['className']= "nolink";
				break;
			default;
				$return_array[$def['display_option']] = $def['display_option'];
				break;

		}
		return $return_array;

	}

	function getFieldByIdScript($name, $def){
		$script = '';
		if(!ACLController::checkAccess($def['module'], $def['action_option'], true)){
		foreach($this->getHTMLValues($def) as $key=>$value){
			$script .=  "\nif(document.getElementById('$name'))document.getElementById('$name')." . $key . '="' .$value. '";'. "\n";
		}
		}
		return $script;

	}

	function getFieldByNameScript($name, $def){
		$script = '';
		if(!ACLController::checkAccess($def['module'], $def['action_option'], true)){

		foreach($this->getHTMLValues($def) as $key=>$value){
			$script .=  <<<EOQ
			var aclfields = document.getElementsByName('$name');
			for(var i in aclfields){
				aclfields[i].$key = '$value';
			}
EOQ;
		}
		}
		return $script;

	}

	function getFieldByFormScript($form, $name, $def){
		$script = '';


		if(!ACLController::checkAccess($def['module'], $def['action_option'], true)){
			foreach($this->getHTMLValues($def) as $key=>$value){
				$script .= "\nif(typeof(document.$form.$name.$key) != 'undefined')\n document.$form.$name.".$key . '="' .$value. '";';
			}
		}
		return $script;

	}








}



?>