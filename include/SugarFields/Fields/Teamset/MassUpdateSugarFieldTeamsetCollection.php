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


/**
 * MaassUpdateSugarFieldTeamsetCollection.php
 * This class handles rendering the team widget for the MassUpdate form.
 * 
 */

require_once('include/SugarFields/Fields/Collection/SugarFieldCollection.php');
require_once('include/SugarFields/Fields/Teamset/ViewSugarFieldTeamsetCollection.php');

class MassUpdateSugarFieldTeamsetCollection extends ViewSugarFieldTeamsetCollection {

	function MassUpdateSugarFieldTeamsetCollection($fill_data=false) {
    	parent::ViewSugarFieldTeamsetCollection($fill_data);
		$this->form_name = 'MassUpdate'; 
        $this->action_type = 'massupdate';		 	
    }

    function init_tpl() {   
        $this->tpl_path = 'include/SugarFields/Fields/Teamset/TeamsetCollectionMassupdateView.tpl';
        $this->ss->assign('quickSearchCode',$this->createQuickSearchCode());
        $this->createPopupCode();// this code populate $this->displayParams with popupdata.
        $this->ss->assign('displayParams',$this->displayParams);
        $this->ss->assign('vardef',$this->vardef);
        $this->ss->assign('module',$this->related_module);
        $default = array('primary'=>array('id'=>1, 'name'=>'admin'));
        if(!empty($this->bean)){
      	   $this->ss->assign('values',$this->bean->{$this->value_name});
        }
        $this->ss->assign('showSelectButton',$this->showSelectButton);
        $this->ss->assign('APP',$GLOBALS['app_strings']);
    }        
    
    function process() {
        $this->process_editview();	
    }    
    
}
?>