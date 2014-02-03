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






class SugarWidgetSubPanelDetailViewLink extends SugarWidgetField
{
	function displayList(&$layout_def)
	{
		global $focus;

		$module = '';
		$record = '';

		if(isset($layout_def['varname']))
		{
			$key = strtoupper($layout_def['varname']);
		}
		else
		{
			$key = $this->_get_column_alias($layout_def);
			$key = strtoupper($key);
		}
		if (empty($layout_def['fields'][$key])) {
			return "";
		} else {
			$value = $layout_def['fields'][$key];
		}


		if(empty($layout_def['target_record_key']))
		{
			$record = $layout_def['fields']['ID'];
		}
		else
		{
			$record_key = strtoupper($layout_def['target_record_key']);
			$record = $layout_def['fields'][$record_key];
		}

		if(!empty($layout_def['target_module_key'])) {
			if (!empty($layout_def['fields'][strtoupper($layout_def['target_module_key'])])) {
				$module=$layout_def['fields'][strtoupper($layout_def['target_module_key'])];
			}
		}

        if (empty($module)) {
			if(empty($layout_def['target_module']))
			{
				$module = $layout_def['module'];
			}
		else
			{
				$module = $layout_def['target_module'];
			}
		}

        //links to email module now need additional information.
        //this is to resolve the information about the target of the emails. necessitated by feature that allow
        //only on email record for the whole campaign.
        $parent='';
        if (!empty($layout_def['parent_info'])) {
			if (!empty($focus)){
	            $parent="&parent_id=".$focus->id;
	            $parent.="&parent_module=".$focus->module_dir;
			}
        } else {
            if(!empty($layout_def['parent_id'])) {
                if (isset($layout_def['fields'][strtoupper($layout_def['parent_id'])])) {
                    $parent.="&parent_id=".$layout_def['fields'][strtoupper($layout_def['parent_id'])];
                }
            }
            if(!empty($layout_def['parent_module'])) {
                if (isset($layout_def['fields'][strtoupper($layout_def['parent_module'])])) {
                    $parent.="&parent_module=".$layout_def['fields'][strtoupper($layout_def['parent_module'])];
                }
            }
        }

		$action = 'DetailView';
		$value = $layout_def['fields'][$key];
		global $current_user;
		if(  !empty($record) &&
			($layout_def['DetailView'] && !$layout_def['owner_module'] 
			||  $layout_def['DetailView'] && !ACLController::moduleSupportsACL($layout_def['owner_module']) 
			|| ACLController::checkAccess($layout_def['owner_module'], 'view', $layout_def['owner_id'] == $current_user->id)))
        {
            $link = ajaxLink("index.php?module=$module&action=$action&record={$record}{$parent}");
            if ($module == 'EAPM')
            {
                $link = "index.php?module=$module&action=$action&record={$record}{$parent}";
            }
            return '<a href="' . $link . '" >'."$value</a>";

		}else{
			return $value;
		}
		
	}
}

?>