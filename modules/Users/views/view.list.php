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


require_once('include/MVC/View/views/view.list.php');

class UsersViewList extends ViewList
{
    public function preDisplay()
    {
        //bug #46690: Developer Access to Users/Teams/Roles
        if (!$GLOBALS['current_user']->isAdminForModule('Users') && !$GLOBALS['current_user']->isDeveloperForModule('Users'))
        {
            //instead of just dying here with unauthorized access will send the user back to his/her settings
            SugarApplication::redirect('index.php?module=Users&action=DetailView&record=' . $GLOBALS['current_user']->id);
        }
        $this->lv = new ListViewSmarty();
        $this->lv->delete = false;
        $this->lv->email = false;
    }

 	public function listViewProcess()
 	{
 		$this->processSearchForm();
		$this->lv->searchColumns = $this->searchForm->searchColumns;

		if(!$this->headers)
			return;
		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){
			$this->lv->ss->assign("SEARCH",true);
			if(!empty($this->where)){
					$this->where .= " AND";
			}
                        $this->where .= " (users.status !='Reserved' or users.status is null) ";
			$this->lv->setup($this->seed, 'include/ListView/ListViewGeneric.tpl', $this->where, $this->params);
			$savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
			echo $this->lv->display();
		}
 	}
}
