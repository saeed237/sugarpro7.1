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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

class ReportsController extends SugarController
{	
	/** 
	 * @see SugarController::setup($module = '')
	 */
	
	public function setup($module = '')
	{
		$result = parent::setup($module);
		
		// bug 41860 fix
		if(!empty($_REQUEST['id']))
			$this->record = $_REQUEST['id'];
		// end bugfix
		
		return $result;
	}
	
    /**
     * @see SugarController::loadBean()
     */
	public function loadBean()
	{			
		if(!empty($_REQUEST['record']) && $_REQUEST['action'] == 'ReportsWizard'){
			$_REQUEST['id'] = $this->record;
			$_REQUEST['page'] = 'report';
			$this->view_object_map['action'] =  'ReportsWizard';
		}
		else if(empty($this->record) && !empty($_REQUEST['id'])){
			$this->record = $_REQUEST['id'];
			$GLOBALS['action'] = 'detailview';
			$this->view_object_map['action'] =  'ReportCriteriaResults';
		}
		elseif(!empty($this->record)){
			if ($_REQUEST['action'] == 'DetailView') {
				$_REQUEST['id'] = $this->record;
				unset($_REQUEST['record']);
			}else{
				$GLOBALS['action'] = 'detailview'; //bug 41860 
			}
			$_REQUEST['page'] = 'report';
			$this->view_object_map['action'] =  'ReportCriteriaResults';
		}
		
		parent::loadBean();
	}
	
	public function action_buildreportmoduletree() 
	{
	    $this->view = 'buildreportmoduletree';
	}
	
	public function action_add_schedule() 
	{
	    $this->view = 'schedule';
	}
	
	public function action_detailview()
	{
		$this->view = 'classic';
	}
	public function action_get_teamset_field() 
	{
		require_once('include/SugarFields/Fields/Teamset/ReportsSugarFieldTeamsetCollection.php');
		$view = new ReportsSugarFieldTeamsetCollection(true);
		$view->setup();
		$view->process();
		$view->init_tpl();
		echo $view->display();
	}
	public function action_get_quicksearch_defaults() 
	{
		global $global_json;
		$global_json = getJSONobj();
		require_once('include/QuickSearchDefaults.php');
		$qsd = QuickSearchDefaults::getQuickSearchDefaults();
		if (!empty($_REQUEST['parent_form']))
			$qsd->form_name = $_REQUEST['parent_form'];
		$quicksearch_js = '';
		if (isset($_REQUEST['parent_module']) && isset($_REQUEST['parent_field'])) {
			$sqs_objects = array($_REQUEST['parent_field'] => $qsd->getQSParent($_REQUEST['parent_module'])); 
    		foreach($sqs_objects as $sqsfield=>$sqsfieldArray){
        	    $quicksearch_js .= "sqs_objects['$sqsfield']={$global_json->encode($sqsfieldArray)};";
    		}
		}
		echo $quicksearch_js;
	}

    protected function action_massupdate(){
        //bug: 44857 - Reports calls MasUpdate passing back the 'module' parameter, but that is also a parameter in the database
        //so when we call MassUpdate with $addAllBeanFields then it will use this in the query.
        if(!empty($_REQUEST['current_query_by_page']))
        {
            $query = unserialize(base64_decode($_REQUEST['current_query_by_page']));
            if(!empty($query['module']))
            {
                unset($query['module']);
                $_REQUEST['current_query_by_page'] = base64_encode(serialize($query));
            }
        }
        parent::action_massupdate();
    }
}
