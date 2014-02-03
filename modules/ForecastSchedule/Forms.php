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
 ********************************************************************************/

/**
 * Create javascript to validate the data entered into a record.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_validate_record_js () {
	global $app_strings;
	global $current_language;
	
	$mod_strings = return_module_language($current_language, 'ForecastSchedule');

	$lbl_start_date = $mod_strings['LBL_FC_START_DATE'];
	$lbl_user = $mod_strings['LBL_FC_USER'];
	$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];

$the_script  = <<<EOQ

	<script type="text/javascript" language="Javascript">
	<!--  to hide script contents from old browsers

	function verify_data(form) {
		var isError = false;
		var errorMessage = "";
		if (trim(form.forecast_start_date.value) == "") {
			isError = true;
			errorMessage += "\\n$lbl_start_date";
		}
		if (trim(form.user_id.value) == "") {
			isError = true;
			errorMessage += "\\n$lbl_user";
		}
		if (isError == true) {
			alert("$err_missing_required_fields" + errorMessage);
			return false;
		}
		return true;
	}
	// end hiding contents from old browsers  -->
	</script>
EOQ;

	return $the_script;
}
?>