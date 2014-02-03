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






class SugarWidgetSubPanelEditRoleButton extends SugarWidgetField
{
	function displayHeaderCell(&$layout_def)
	{
		return '&nbsp;';
	}

	function displayList(&$layout_def)
	{
		global $app_strings;
        global $subpanel_item_count;
        $unique_id = $layout_def['subpanel_id']."_edit_".$subpanel_item_count; //bug 51512
	
		$href = 'index.php?module=' . $layout_def['module']
			. '&action=' . 'ContactOpportunityRelationshipEdit'
			. '&record=' . $layout_def['fields']['OPPORTUNITY_ROLE_ID']
			. '&return_module=' . $_REQUEST['module']
			. '&return_action=' . 'DetailView'
			. '&return_id=' . $_REQUEST['record'];
			
	//based on listview since that lets you select records
	if($layout_def['ListView']){
		return '<a href="' . $href . '"'
            . "id=\"$unique_id\""
			. 'class="listViewTdToolsS1">' . $app_strings['LNK_EDIT'] .'</a>&nbsp;';
	}else{
		return '';
	}
	}
}

?>