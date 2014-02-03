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





class SugarWidgetSubPanelDeleteButton extends SugarWidgetField
{
	function displayList($layout_def)
	{
		global $app_strings;
        global $subpanel_item_count;
		$return_module = $_REQUEST['module'];
		$return_id = $_REQUEST['record'];
		$module_name = $layout_def['module'];
		$record_id = $layout_def['fields']['ID'];
        $unique_id = $layout_def['subpanel_id']."_delete_".$subpanel_item_count; //bug 51512

		// calls and meetings are held.
		$new_status = 'Held';

		switch($module_name)
		{
			case 'Tasks':
				$new_status = 'Completed';
				break;
		}
		$subpanel = $layout_def['subpanel_id'];
		if (isset($layout_def['linked_field_set']) && !empty($layout_def['linked_field_set'])) {
			$linked_field= $layout_def['linked_field_set'] ;
		} else {
			$linked_field = $layout_def['linked_field'];
		}
		$refresh_page = 0;
		if(!empty($layout_def['refresh_page'])){
			$refresh_page = 1;
		}

		$html = "<a id=\"$unique_id\" onclick='return sp_del_conf();' href=\"javascript:sub_p_del('$subpanel', '$module_name', '$record_id', $refresh_page);\">".$app_strings['LNK_DELETE']."</a>";
		return $html;

	}
}

?>