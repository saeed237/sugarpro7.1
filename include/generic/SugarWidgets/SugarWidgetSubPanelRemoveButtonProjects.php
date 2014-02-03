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






class SugarWidgetSubPanelRemoveButtonProjects extends SugarWidgetField
{
	function displayHeaderCell(&$layout_def)
	{
		return '&nbsp;';
	}

	function displayList(&$layout_def)
	{
		global $app_strings;
		
		global $current_user;
		
		$parent_record_id = $_REQUEST['record'];
		$parent_module = $_REQUEST['module'];

		if ($layout_def['module'] == 'Holidays'){
			$action = 'DeleteHolidayRelationship';
		}
		else if ($layout_def['module'] == 'Users' || $layout_def['module'] == 'Contacts'){
			$action = 'DeleteResourceRelationship';
		}
		else{
			$action = 'DeleteRelationship';
		}

		$record = $layout_def['fields']['ID'];
		$current_module=$layout_def['module'];	
		$hideremove=false;			
		
		$return_module = $_REQUEST['module'];
		$return_action = 'SubPanelViewer';
		$subpanel = $layout_def['subpanel_id'];
		$return_id = $_REQUEST['record'];
		
		
		$focus = BeanFactory::getBean('Project', $return_id);
		
		if ($current_user->id == $focus->assigned_user_id || is_admin($current_user)){
			$is_owner = true;
		}
		else{
			$is_owner = false;
		}
				
		if (isset($layout_def['linked_field_set']) && !empty($layout_def['linked_field_set'])) {
			$linked_field= $layout_def['linked_field_set'] ;
		} else {
			$linked_field = $layout_def['linked_field'];
		}
		$refresh_page = 0;
		if(!empty($layout_def['refresh_page'])){
			$refresh_page = 1;
		}
		$return_url = "index.php?module=$return_module&action=$return_action&subpanel=$subpanel&record=$return_id&sugar_body_only=1&inline=1";

		$icon_remove_text = strtolower($app_strings['LBL_ID_FF_REMOVE']);
		$icon_remove_html = SugarThemeRegistry::current()->getImage( 'delete_inline', 'align="absmiddle" border="0"',null,null,'.gif','');//setting alt to blank on purpose on subpanels for 508
		$remove_url = $layout_def['start_link_wrapper']
			. "index.php?module=$parent_module"
			. "&action=$action"
			. "&record=$parent_record_id"
			. "&linked_field=$linked_field"
			. "&linked_id=$record"
			. "&return_url=" . urlencode(urlencode($return_url))
			. "&refresh_page=1"
			. $layout_def['end_link_wrapper'];
		$remove_confirmation_text = $app_strings['NTC_REMOVE_CONFIRMATION'];
		//based on listview since that lets you select records
		if($layout_def['ListView'] && !$hideremove && $is_owner) {
			return '<a href="' . $remove_url . '"'
			. ' class="listViewTdToolsS1"'
			. " onclick=\"return confirm('$remove_confirmation_text');\""
			. ">$icon_remove_html&nbsp;$icon_remove_text</a>";
		}else{
			return '';
		}
	}
}
?>