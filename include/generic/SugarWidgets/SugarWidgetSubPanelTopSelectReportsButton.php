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




require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopSelectButton.php');

class SugarWidgetSubPanelTopSelectReportsButton extends SugarWidgetSubPanelTopSelectButton
{
	//button_properties is a collection of properties associated with the widget_class definition. layoutmanager
	function SugarWidgetSubPanelTopSelectReportButton($button_properties=array())
	{
		$this->button_properties=$button_properties;
	}

    public function getWidgetId()
    {
    	$label = parent::getWidgetId();
        return str_replace("select_button", "select_reports_button", $label);
    }

}
?>
