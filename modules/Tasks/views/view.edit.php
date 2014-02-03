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


class TasksViewEdit extends ViewEdit
{
    /**
 	 * @see SugarView::preDisplay()
 	 */
 	public function preDisplay()
 	{
 		if($_REQUEST['module'] != 'Tasks' && isset($_REQUEST['status']) && empty($_REQUEST['status'])) {
	       $this->bean->status = '';
 		} //if
 		if(!empty($_REQUEST['status']) && ($_REQUEST['status'] == 'Completed')) {
	       $this->bean->status = 'Completed';
 		}
 		parent::preDisplay();
 	}

 	/**
 	 * @see SugarView::display()
 	 */
 	public function display()
 	{
 		if($this->ev->isDuplicate){
	       $this->bean->status = $this->bean->getDefaultStatus();
 		} //if
 		parent::display();
 	}
}
