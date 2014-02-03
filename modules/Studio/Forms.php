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




//for users
function user_get_validate_record_js() {
}
function user_get_chooser_js() {
}
function user_get_confsettings_js() {
};
//end for users
function get_chooser_js() {
	// added here for compatibility
}
function get_validate_record_js() {
}
function get_new_record_form() {

	if(empty($_SESSION['studio']['module']))return '';

	global $mod_strings;
	$module_name = $_SESSION['studio']['module'];
	$debug = true;
	$html = "";


	$html = get_left_form_header($mod_strings['LBL_TOOLBOX']);
	$add_field_icon = SugarThemeRegistry::current()->getImage("plus_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_ADD_FIELD']);
	$minus_field_icon = SugarThemeRegistry::current()->getImage("minus_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_ADD_FIELD']);
	$edit_field_icon = SugarThemeRegistry::current()->getImage("edit_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_ADD_FIELD']);
	$delete = SugarThemeRegistry::current()->getImage("delete_inline", "border='0' style='margin-left:4px;margin-right:4px;'",null,null,'.gif',$mod_strings['LBL_DELETE']);
	$show_bin = true;
	if (isset ($_REQUEST['edit_subpanel_MSI']))
	global $sugar_version, $sugar_config;
		$show_bin = false;

	$html .= "

			<script type=\"text/javascript\" src=\"modules/DynamicLayout/DynamicLayout_3.js\">
			</script>
			<p>
		";

	if (isset ($_REQUEST['edit_col_MSI'])) {
		// do nothing
	} else {
		$html .= <<<EOQ


	   <link rel="stylesheet" type="text/css" href="include/javascript/yui-old/assets/container.css" />
		            	<script type="text/javascript" src="include/javascript/yui-old/container.js"></script>
					<script type="text/javascript" src="include/javascript/yui-old/PanelEffect.js"></script>



EOQ;

		$field_style = '';
		$bin_style = '';

		$add_icon = SugarThemeRegistry::current()->getImage("plus_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_MAXIMIZE']);
		$min_icon = SugarThemeRegistry::current()->getImage("minus_inline", 'style="margin-left:4px;margin-right:4px;"  border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_MINIMIZE']);
	   $del_icon = SugarThemeRegistry::current()->getImage("delete_inline", 'style="margin-left:4px;margin-right:4px;" border="0" align="absmiddle"',null,null,'.gif',$mod_strings['LBL_MINIMIZE']);
		$html .=<<<EOQ
		              <br><br><table  cellpadding="0" cellspacing="0" border="1" width="100%"   id='s_field_delete'>
							<tr><td colspan='2' align='center'>
					       $del_icon <br>Drag Fields Here To Delete
						</td></tr></table>
					<div id="s_fields_MSIlink" style="display:none">
						<a href="#" onclick="toggleDisplay('s_fields_MSI');">
							 $add_icon {$mod_strings['LBL_VIEW_SUGAR_FIELDS']}
						</a>
					</div>
					<div id="s_fields_MSI" style="display:inline">

						<table  cellpadding="0" cellspacing="0" border="0" width="100%" id="studio_fields">
							<tr><td colspan='2'>

									<a href="#" onclick="toggleDisplay('s_fields_MSI');">$min_icon</a>{$mod_strings['LBL_SUGAR_FIELDS_STAGE']}
								    <br><select id='studio_display_type' onChange='filterStudioFields(this.value)'><option value='all'>All<option value='custom'>Custom</select>
									</td>
							</tr>
						</table>
					</div>

EOQ;

	}
	$html .= get_left_form_footer();
	if (!$debug)
		return $html;
	return $html.<<<EOQ

EOQ;
}
?>
