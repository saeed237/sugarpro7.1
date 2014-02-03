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






class SugarWidgetSubPanelTopSelectAccountButton extends SugarWidgetSubPanelTopSelectButton {
	function display(&$widget_data)
	{
		/*
		* i.dymovsky
		* Because when user role can't edit Accounts, it also can't edit Membership Organizations. Select button leads to change MO list
		* See bug 25633
		* Bug25633 code change start
		*/
		if (!ACLController::checkAccess($widget_data["module"], "edit", true)) {
			return ;
		}
		/*
		* Bug25633 code change end
		*/
		
		return parent::display($widget_data);
	}
}
