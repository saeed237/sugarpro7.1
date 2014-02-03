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







class SugarWidgetSubPanelActivitiesStatusField extends SugarWidgetField
{
	function displayList(&$layout_def)
	{
		global $current_language;
		$app_list_strings = return_app_list_strings_language($current_language);
		
		$module = empty($layout_def['module']) ? '' : $layout_def['module'];
		
		if(isset($layout_def['varname']))
		{
			$key = strtoupper($layout_def['varname']);
		}
		else
		{
			$key = $this->_get_column_alias($layout_def);
			$key = strtoupper($key);
		}

		$value = $layout_def['fields'][$key];
		// cn: bug 5813, removing double-derivation of lang-pack value
		return $value;
	}
}

?>