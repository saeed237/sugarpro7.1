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

/*
 * Created on Apr 13, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once('include/MVC/View/views/view.detail.php');

class ViewQuick extends ViewDetail{
	var $type ='detail';
	
 	function ViewQuick(){
 		parent::SugarView();
 		$this->options['show_subpanels'] = false;
 		$this->options['show_title'] = false;
		$this->options['show_header'] = false;
		$this->options['show_footer'] = false; 
		$this->options['show_javascript'] = false; 
 	}
 	
 	function display(){
 		 $this->dv->showVCRControl = false;
 		 $this->dv->th->ss->assign('hideHeader', true);
 		 if(empty($this->bean->id)){
			global $app_strings;
			sugar_die($app_strings['ERROR_NO_RECORD']);
		}				
		$this->dv->process();
		ob_clean();
		echo json_encode(array('title'=> $this->bean->name, 'url'=>'index.php?module=' . $this->bean->module_dir . '&action=DetailView&record=' . $this->bean->id ,'html'=> $this->dv->display(false)));	
 	}
}
