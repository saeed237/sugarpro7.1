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

/*********************************************************************************

 * Description:  Contains a variety of utility functions used to display UI
 * components such as form headers and footers.  Intended to be modified on a per
 * theme basis.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**
 * Create javascript to validate the data entered into a record.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_validate_record_document_revision_js () {
global $mod_strings;
global $app_strings;

$lbl_version = $mod_strings['LBL_DOC_VERSION'];
$lbl_filename = $mod_strings['LBL_FILENAME'];


$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];


$the_script  = <<<EOQ

<script type="text/javascript" language="Javascript">

function verify_data(form) {
	var isError = false;
	var errorMessage = "";
	if (trim(form.revision.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_version";
	}	
	if (trim(form.uploadfile.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_filename";
	}

	if (isError == true) {
		alert("$err_missing_required_fields" + errorMessage);
		return false;
	}

	return true;
}
</script>

EOQ;

return $the_script;
}

function get_chooser_js()
{
$the_script  = <<<EOQ

<script type="text/javascript" language="Javascript">
<!--  to hide script contents from old browsers

function set_chooser()
{



var display_tabs_def = '';

for(i=0; i < object_refs['display_tabs'].options.length ;i++)
{
         display_tabs_def += "display_tabs[]="+object_refs['display_tabs'].options[i].value+"&";
}

document.EditView.display_tabs_def.value = display_tabs_def;



}
// end hiding contents from old browsers  -->
</script>
EOQ;

return $the_script;
}
function get_validate_record_js(){
	
global $mod_strings;
global $app_strings;

$lbl_name = $mod_strings['ERR_DOC_NAME'];
$lbl_start_date = $mod_strings['ERR_DOC_ACTIVE_DATE'];
$lbl_file_name = $mod_strings['ERR_FILENAME'];
$lbl_file_version=$mod_strings['ERR_DOC_VERSION'];
$sqs_no_match = $app_strings['ERR_SQS_NO_MATCH'];
$sqs_no_match .= ' : ' . $app_strings['LBL_LIST_TEAM'];
$lbl_list_team = $app_strings['LBL_LIST_TEAM'];
$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];

if(isset($_REQUEST['record'])) {
//do not validate upload file
	$the_upload_script="";


} else 
{

$the_upload_script  = <<<EOQ

	if (trim(form.uploadfile.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_file_name";
	}
EOQ;

}

$the_script  = <<<EOQ

<script type="text/javascript" language="Javascript">

function verify_data(form) {
	var isError = false;
	var errorMessage = "";
	if (trim(form.document_name.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_name";
	}
	
	$the_upload_script
	
	if (trim(form.active_date.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_start_date";
	}
	if (trim(form.revision.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_file_version";
	}

	if(trim(form.team_name.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_list_team";
	}
	if ((trim(form.team_id.value) == "" && trim(form.team_name.value) != "") || 
		 (trim(form.team_id.value) != "" && trim(form.team_name.value) == "")) {
		isError = true;
		errorMessage += "\\n$sqs_no_match";	
	}
	
	if (isError == true) {
		alert("$err_missing_required_fields" + errorMessage);
		return false;
	}
	
	//make sure start date is <= end_date

	return true;
}
</script>

EOQ;

return $the_script;
}

?>
