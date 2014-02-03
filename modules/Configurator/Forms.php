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

 * Description:  Contains a variety of utility functions specific to this module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

function get_configsettings_js() {
	global $mod_strings;
	global $app_strings;

	$lbl_last_name = $mod_strings['LBL_NOTIFY_FROMADDRESS'];
	$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];

	return <<<EOQ

<script type="text/javascript" language="Javascript">
<!--  to hide script contents from old browsers

function notify_setrequired(f) {

	return true;
}

function add_checks(f) {
	removeFromValidate('ConfigureSettings', 'mail_smtpserver');
	removeFromValidate('ConfigureSettings', 'mail_smtpport');
	removeFromValidate('ConfigureSettings', 'mail_smtpuser');
	removeFromValidate('ConfigureSettings', 'mail_smtppass');
	
	removeFromValidate('ConfigureSettings', 'proxy_port');
	removeFromValidate('ConfigureSettings', 'proxy_host');
	removeFromValidate('ConfigureSettings', 'proxy_username');
	removeFromValidate('ConfigureSettings', 'proxy_password');
	
	removeFromValidate('ConfigureSettings', 'list_max_entries_per_page');
	removeFromValidate('ConfigureSettings', 'list_max_entries_per_subpanel');	
	
	if (typeof f.mail_sendtype != "undefined" && f.mail_sendtype.value == "SMTP") {
		addToValidate('ConfigureSettings', 'mail_smtpserver', 'varchar', 'true', '{$mod_strings['LBL_MAIL_SMTPSERVER']}');
		addToValidate('ConfigureSettings', 'mail_smtpport', 'int', 'true', '{$mod_strings['LBL_MAIL_SMTPPORT']}');
		if (f.mail_smtpauth_req.checked) {
			addToValidate('ConfigureSettings', 'mail_smtpuser', 'varchar', 'true', '{$mod_strings['LBL_MAIL_SMTPUSER']}');
			addToValidate('ConfigureSettings', 'mail_smtppass', 'varchar', 'true', '{$mod_strings['LBL_MAIL_SMTPPASS']}');
		}
	}
	
	if (typeof f.proxy_on != "undefined" && f.proxy_on.checked ) {
		addToValidate('ConfigureSettings', 'proxy_port', 'int', 'true', '{$mod_strings['LBL_PROXY_PORT']}');
		addToValidate('ConfigureSettings', 'proxy_host', 'varchar', 'true', '{$mod_strings['LBL_PROXY_HOST']}');
		if (f.proxy_auth.checked ) {
			addToValidate('ConfigureSettings', 'proxy_username', 'varchar', 'true', '{$mod_strings['LBL_PROXY_USERNAME']}');
			addToValidate('ConfigureSettings', 'proxy_password', 'varchar', 'true', '{$mod_strings['LBL_PROXY_PASSWORD']}');
		}
	}
	
	addToValidateMoreThan('ConfigureSettings', 'list_max_entries_per_page', 'int', true, '', 1);
	addToValidateMoreThan('ConfigureSettings', 'list_max_entries_per_subpanel', 'int', true, '', 1);
	
	return true;
}

notify_setrequired(document.ConfigureSettings);

// end hiding contents from old browsers  -->
</script>

EOQ;
}


?>
