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






class SugarWidgetSubPanelRemoveButton extends SugarWidgetField
{
	function displayHeaderCell(&$layout_def)
	{
		return '&nbsp;';
	}

	function displayList(&$layout_def)
	{
		
		global $app_strings;
        global $subpanel_item_count;

		$unique_id = $layout_def['subpanel_id']."_remove_".$subpanel_item_count; //bug 51512
		
		$parent_record_id = $_REQUEST['record'];
		$parent_module = $_REQUEST['module'];

		$action = 'DeleteRelationship';
		$record = $layout_def['fields']['ID'];
		$current_module=$layout_def['module'];
		//in document revisions subpanel ,users are now allowed to 
		//delete the latest revsion of a document. this will be tested here
		//and if the condition is met delete button will be removed.
		$hideremove=false;
		if ($current_module=='DocumentRevisions') {
			if ($layout_def['fields']['ID']==$layout_def['fields']['LATEST_REVISION_ID']) {
				$hideremove=true;
			}
		}
		// Implicit Team-memberships are not "removeable" 
		elseif ($_REQUEST['module'] == 'Teams' && $current_module == 'Users') {
			if($layout_def['fields']['UPLINE'] != translate('LBL_TEAM_UPLINE_EXPLICIT', 'Users')) {
				$hideremove = true;
			}	
			
			//We also cannot remove the user whose private team is set to the parent_record_id value
			$user = BeanFactory::getBean('Users', $layout_def['fields']['ID']);
			if($parent_record_id == $user->getPrivateTeamID())
			{
			    $hideremove = true;
			}
		}
		
		
		$return_module = $_REQUEST['module'];
		$return_action = 'SubPanelViewer';
		$subpanel = $layout_def['subpanel_id'];
		$return_id = $_REQUEST['record'];
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
		
         if($linked_field == 'get_emails_by_assign_or_link')
            $linked_field = 'emails';
		//based on listview since that lets you select records
		if($layout_def['ListView'] && !$hideremove) {
            $retStr = "<a href=\"javascript:sub_p_rem('$subpanel', '$linked_field'" 
                    .", '$record', $refresh_page);\"" 
			. ' class="listViewTdToolsS1"'
            . "id=$unique_id"
			. " onclick=\"return sp_rem_conf();\""
			. ">$icon_remove_text</a>";
        return $retStr;
            
		}else{
			return '';
		}
	}
}
