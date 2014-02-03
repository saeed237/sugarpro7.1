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


require_once('include/Dashlets/Dashlet.php');


class CalendarDashlet extends Dashlet {
    var $view = 'week';

    function CalendarDashlet($id, $def) {
        $this->loadLanguage('CalendarDashlet','modules/Calendar/Dashlets/');

		parent::Dashlet($id); 
         
		$this->isConfigurable = true; 
		$this->hasScript = true;  
                
		if(empty($def['title'])) 
			$this->title = $this->dashletStrings['LBL_TITLE'];
		else 
			$this->title = $def['title'];  
			
		if(!empty($def['view']))
			$this->view = $def['view'];			
             
    }

    function display(){
		ob_start();
		
		if(isset($GLOBALS['cal_strings']))
			return parent::display() . "Only one Calendar dashlet is allowed.";
			
		require_once('modules/Calendar/Calendar.php');
		require_once('modules/Calendar/CalendarDisplay.php');
		require_once("modules/Calendar/CalendarGrid.php");
		
		global $cal_strings, $current_language;
		$cal_strings = return_module_language($current_language, 'Calendar');
		
		if(!ACLController::checkAccess('Calendar', 'list', true))
			ACLController::displayNoAccess(true);
						
		$cal = new Calendar($this->view);
		$cal->dashlet = true;
		$cal->add_activities($GLOBALS['current_user']);
		$cal->load_activities();
		
		$display = new CalendarDisplay($cal,$this->id);
		$display->display_calendar_header(false);		
		$display->display();
			
		$str = ob_get_contents();	
		ob_end_clean();
		
		return parent::display() . $str;
    }
    

    function displayOptions() {
        global $app_strings,$mod_strings;        
        $ss = new Sugar_Smarty();
        $ss->assign('MOD', $this->dashletStrings);        
        $ss->assign('title', $this->title);
        $ss->assign('view', $this->view);
        $ss->assign('id', $this->id);

        return parent::displayOptions() . $ss->fetch('modules/Calendar/Dashlets/CalendarDashlet/CalendarDashletOptions.tpl');
    }  

    function saveOptions($req) {
        global $sugar_config, $timedate, $current_user, $theme;
        $options = array();
        $options['title'] = $_REQUEST['title']; 
        $options['view'] = $_REQUEST['view'];       
         
        return $options;
    }

    function displayScript(){
	return "";
    }


}

?>
