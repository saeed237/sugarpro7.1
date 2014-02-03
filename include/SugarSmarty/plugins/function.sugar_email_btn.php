<?php
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



 /**
 * smarty_function_sugar_email_btn
 * This is the constructor for the Smarty plugin.
 * This function exists so that the proper email button based on user prefs is loaded into the quotes module.
 * 
 * @param $params The runtime Smarty key/value arguments
 * @param $smarty The reference to the Smarty object used in this invocation
 */
function smarty_function_sugar_email_btn($params, &$smarty)
{
	global $app_strings, $current_user;
	$pdfButtons = '';
	$client = $current_user->getPreference('email_link_type');
	if ($client != 'sugar') {
		$pdfButtons = '<input title="'. $app_strings["LBL_EMAIL_COMPOSE"] . '" class="button" type="submit" name="button" value="'. $app_strings["LBL_EMAIL_COMPOSE"] . '" onclick="location.href=\'mailto:\';return false;"> ';
	} else {
		$pdfButtons = '<input id="email_as_pdf_button" title="'. $app_strings["LBL_EMAIL_PDF_BUTTON_TITLE"] . '" class="button" type="submit" name="button" value="'. $app_strings["LBL_EMAIL_PDF_BUTTON_LABEL"] . '" onclick="this.form.email_action.value=\'EmailLayout\';"> ';
	}
	return $pdfButtons;
}
?>
