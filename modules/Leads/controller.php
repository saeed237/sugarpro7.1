<?php
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

class LeadsController extends SugarController
{

    function pre_editview(){
		//IF we have a prospect id leads convert it to a lead
		if (empty($this->bean->id) && !empty($_REQUEST['return_module']) &&$_REQUEST['return_module'] == 'Prospects' ) {
			
			$prospect = BeanFactory::getBean('Prospects', $_REQUEST['return_id']);
			foreach($prospect->field_defs as $key=>$value)
			{
				if ($key == 'id' or $key=='deleted' )continue;
				if (isset($this->bean->field_defs[$key])) {
					$this->bean->$key = $prospect->$key;
				}
			}
			$_POST['is_converted']=true;
		}
		return true;
	}
	function action_editview(){
		$this->view = 'edit';
		return true;
	}

	protected function callLegacyCode(){
    	if(strtolower($this->do_action) == 'convertlead'){
        	if(SugarAutoLoader::existing('modules/Leads/ConvertLead.php') && !SugarAutoLoader::existing('custom/modules/Leads/metadata/convertdefs.php')){
	        	if(!empty($_REQUEST['emailAddressWidget'])) {
				   foreach($_REQUEST as $key=>$value) {
				   	  if(preg_match('/^Leads.*?emailAddress[\d]+$/', $key)) {
				   	  	 $_REQUEST['Leads_email_widget_id'] = 0;
				   	  	 break;
				   	  }
				   }
				}
        		$this->action_default();
                $this->_processed = true;
            }else{
            	$this->view = 'convertlead';
                $this->_processed = true;
            }
  		}else{
                parent::callLegacyCode();
        }
	}
}
?>