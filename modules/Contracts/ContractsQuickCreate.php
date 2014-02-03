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

 
require_once('include/EditView/QuickCreate.php');



class ContractsQuickCreate extends QuickCreate {
    
    var $javascript;
    
    function process() {
        global $current_user, $timedate, $app_list_strings, $current_language, $mod_strings;
        $mod_strings = return_module_language($current_language, 'Contracts');
        
        parent::process();
  
        if($this->viaAJAX) { // override for ajax call
            $this->ss->assign('saveOnclick', "onclick='if(check_form(\"contractsQuickCreate\")) return SUGAR.subpanelUtils.inlineSave(this.form.id, \"contracts\"); else return false;'");
            $this->ss->assign('cancelOnclick', "onclick='return SUGAR.subpanelUtils.cancelCreate(\"subpanel_contracts\")';");
        }
        
        $this->ss->assign('viaAJAX', $this->viaAJAX);

        $this->javascript = new javascript();
        $this->javascript->setFormName('contractsQuickCreate');
        
        $focus = BeanFactory::getBean('Contracts');
        $this->javascript->setSugarBean($focus);
        $this->javascript->addAllFields('');

		$status_options = isset ($focus->status) ?
			get_select_options_with_id($app_list_strings['contract_status_dom'], $focus->status) :
			get_select_options_with_id($app_list_strings['contract_status_dom'], '');
		$this->ss->assign('STATUS_OPTIONS', $status_options);
		
        $json = getJSONobj();
        
		$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => 'contractsQuickCreate',
			'field_to_name_array' => array(
				'id' => 'account_id',
				'name' => 'account_name',
			),
		);
	
		$encoded_popup_request_data = $json->encode($popup_request_data);
		$this->ss->assign('encoded_popup_request_data', $encoded_popup_request_data);     
		
		$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => 'contractsQuickCreate',
			'field_to_name_array' => array(
				'id' => 'team_id',
				'name' => 'team_name',
			),
		);
		$this->ss->assign('encoded_team_popup_request_data', $json->encode($popup_request_data));

        $this->ss->assign('additionalScripts', $this->javascript->getScript(false));
    }   
}
?>