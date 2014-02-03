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

class EmployeesController extends SugarController{
	function EmployeesController(){
		parent::SugarController();
	}

	function action_editview(){
		if(is_admin($GLOBALS['current_user']) || $_REQUEST['record'] == $GLOBALS['current_user']->id) 
			$this->view = 'edit';
		else
			sugar_die("Unauthorized access to employees.");
		return true;
	}
	
	protected function action_delete()
	{
	    if($_REQUEST['record'] != $GLOBALS['current_user']->id && $GLOBALS['current_user']->isAdminForModule('Users'))
        {
            $u = BeanFactory::getBean('Users', $_REQUEST['record']);
            $u->deleted = 1;
            $u->status = 'Inactive';
            $u->employee_status = 'Terminated';
            $u->save();
            $GLOBALS['log']->info("User id: {$GLOBALS['current_user']->id} deleted user record: {$_REQUEST['record']}");
            
            if( !empty($u->user_name) ) //If user redirect back to assignment screen.
                SugarApplication::redirect("index.php?module=Users&action=reassignUserRecords&record={$u->id}");
            else 
                SugarApplication::redirect("index.php?module=Employees&action=index");
        }
        else 
            sugar_die("Unauthorized access to administration.");
	}
	
}
?>