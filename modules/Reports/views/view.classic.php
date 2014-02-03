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

require_once('include/MVC/View/views/view.classic.php');

class ReportsViewClassic extends ViewClassic
{
 	/**
	 * @see SugarView::preDisplay()
	 */
	public function preDisplay()
 	{
 		if(!empty($this->view_object_map['action']))
 			$this->action = $this->view_object_map['action'];
 	}
 	
 	/**
	 * @see SugarView::display()
	 */
	public function display()
 	{
 		parent::display();
 		$this->action = $GLOBALS['action'];	
 	}	
}
