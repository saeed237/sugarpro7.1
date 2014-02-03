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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/EmailTemplates/EmailTemplate.php');

$focus = BeanFactory::getBean('EmailTemplates');
if($_REQUEST['from'] == 'DetailView') {
	if(!isset($_REQUEST['record']))
		sugar_die("A record number must be specified to delete the template.");
	$focus->retrieve($_REQUEST['record']);
	if(check_email_template_in_use($focus)) {
		echo 'true';
		return;
	}
	echo 'false';
} else if($_REQUEST['from'] == 'ListView') {
	$returnString = '';
	$idArray = explode(',', $_REQUEST['records']);
	foreach($idArray as $key => $value) {
		if($focus->retrieve($value)) {
			if(check_email_template_in_use($focus)) {
				$returnString .= $focus->name . ',';
			}
		}
	}
	$returnString = substr($returnString, 0, -1);
	echo $returnString;
} else {
	echo '';
}

function check_email_template_in_use($focus)
{
	if($focus->is_used_by_email_marketing()) {
		return true;
	}
	$system = $GLOBALS['sugar_config']['passwordsetting'];
	if($focus->id == $system['generatepasswordtmpl'] || $focus->id == $system['lostpasswordtmpl']) {
	    return true;
	}
    return false;
}
