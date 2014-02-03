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

require_once('include/SugarFields/Fields/Collection/SugarFieldCollection.php');
require_once('include/SugarFields/Fields/Teamset/ViewSugarFieldTeamsetCollection.php');

/**
 * ReportsSugarFieldTeamsetCollection.php
 * This class handles rendering the team widget for the Reports module.
 * 
 */

class ReportsSugarFieldTeamsetCollection extends ViewSugarFieldTeamsetCollection {

	var $showPrimaryChecked = true;
	
	function ReportsSugarFieldTeamsetCollection($fill_data=false) {
    	parent::ViewSugarFieldTeamsetCollection($fill_data);
		$this->form_name = "ReportsWizardForm";
		$this->action_type = 'reports'; 	 	
    }

    function init_tpl() {
        $this->ss->assign('quickSearchCode',$this->createQuickSearchCode());
        $this->createPopupCode();// this code populate $this->displayParams with popupdata.
		$this->displayParams['formName'] = $this->form_name;        
        $this->tpl_path = 'include/SugarFields/Fields/Teamset/TeamsetCollectionEditView.tpl'; 

        if(!empty($this->bean)) {      	
      	   $this->ss->assign('values',$this->bean->{$this->value_name});
           //Check if we have a primary team checked
	       $this->displayParams['primaryChecked'] = !empty($this->bean->{$this->value_name}['primary']) && $this->showPrimaryChecked;     	   
        }
        
        $this->ss->assign('displayParams',$this->displayParams);
        $this->ss->assign('vardef',$this->vardef);
        $this->ss->assign('module',$this->related_module);
                
        //do not show the hide/show toggle button
        $this->ss->assign('hideShowHideButton', true);
        $this->ss->assign('showSelectButton',$this->showSelectButton);
        $this->ss->assign('APP',$GLOBALS['app_strings']);
    }        
    
    function process() {
        $this->process_reports();
        $this->process_editview();
    }    
    
    private function process_reports() {
        require_once('include/SugarFields/SugarFieldHandler.php');
        $sfh = new SugarFieldHandler();  
        $sf = $sfh->getSugarField('Teamset', true);  					
        $teams = $sf->getTeamsFromRequest($this->name);
        $full_form_values = array();
        if(!empty($teams)) {	    	
        	if(isset($_REQUEST["primary_{$this->name}_collection"])){
	    		$this->ss->assign('hasPrimaryTeam', true);
	    		$primary = $_REQUEST["primary_{$this->name}_collection"];
	    		$key = "id_{$this->name}_collection_{$primary}"; //Get the $_REQUEST index key
	    		$primary = $_REQUEST[$key];	    
	    		$primaryTeam = array('id' => $primary, 'name'=>$teams[$primary]);
	    		$full_form_values['primary'] = $primaryTeam;
	    		unset($teams[$primary]); //Unset the primary team
	    	} else {
	    		//Here we technically don't have a primary team chosen, but we need to allocate
	    		//a primary team to display as the first team in the widget
	    	    foreach($teams as $team_id=>$team_name) {
	    		   $full_form_values['primary'] = array('id'=>$team_id, 'name'=>$team_name);
	    		   $this->showPrimaryChecked = false;
	    		   unset($teams[$team_id]);
	    		   break;
	    	    }   		
	    	}	    	
	    	
        	foreach($teams as $team_id=>$team_name) {
	    			$full_form_values['secondaries'][] = array('id'=>$team_id, 'name'=>$team_name);
	    	}
        	
	    	$this->bean->{$this->value_name}=array_merge($this->bean->{$this->value_name}, $full_form_values);
        }                   	  	
    }    
    
}
?>