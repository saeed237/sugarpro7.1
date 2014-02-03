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



//this widget is used only by the contracts module..


class SugarWidgetSubPanelGetLatestButton extends SugarWidgetField
{
	function displayHeaderCell(&$layout_def)
	{
		return '&nbsp;';
	}

	function displayList(&$layout_def)
	{
		//if the contract has been executed or selected_revision is same as latest revision
		//then hide the latest button. 		
		//if the contract state is executed or document is not a template hide this action.
		if ((!empty($layout_def['fields']['CONTRACT_STATUS']) && $layout_def['fields']['CONTRACT_STATUS']=='executed') or
			$layout_def['fields']['SELECTED_REVISION_ID']== $layout_def['fields']['LATEST_REVISION_ID']) {
			return "";
		}
		
		global $app_strings;
		

		$href = 'index.php?module=' . $layout_def['module']
			. '&action=' . 'GetLatestRevision'
			. '&record=' . $layout_def['fields']['ID']
			. '&return_module=' . $_REQUEST['module']
			. '&return_action=' . 'DetailView'
			. '&return_id=' . $_REQUEST['record']
			. '&get_latest_for_id=' . $layout_def['fields']['LINKED_ID'];

		$edit_icon_html = SugarThemeRegistry::current()->getImage( 'getLatestDocument','align="absmiddle" border="0"',null,null,'.gif',$app_strings['LNK_GET_LATEST']);
		if($layout_def['EditView']){
			return '<a href="' . $href . '"' . "title ='". $app_strings['LNK_GET_LATEST_TOOLTIP']  ."'"
			. 'class="listViewTdToolsS1">' . $edit_icon_html . '&nbsp;' . $app_strings['LNK_GET_LATEST'] .'</a>&nbsp;';
		}else{
			return '';
		}
	}
		
}

?>