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






class SugarWidgetSubPanelConcat extends SugarWidgetField
{
	function displayList(&$layout_def)
	{
		$value='';
		if (isset($layout_def['source']) and is_array($layout_def['source']) and isset($layout_def['fields']) and is_array($layout_def['fields'])) {
			
			foreach ($layout_def['source'] as $field) {
			
				if (isset($layout_def['fields'][strtoupper($field)])) {
					$value.=$layout_def['fields'][strtoupper($field)];
				} else {
					$value.=$field;
				}	
			}
		}
		return $value;
	}
}
?>