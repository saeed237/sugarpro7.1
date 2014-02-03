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
require_once('include/formbase.php');

$focus = BeanFactory::getBean('CampaignTrackers', $_POST['record']);
if(!$focus->ACLAccess('Save')){
	ACLController::displayNoAccess(true);
	sugar_cleanup(true);
}

$check_notify = FALSE;
foreach($focus->column_fields as $field) {
	if(isset($_POST[$field])) {
		$value = $_POST[$field];
		$focus->$field = $value;
	}
}

foreach($focus->additional_column_fields as $field) {
	if(isset($_POST[$field])) {
		$value = $_POST[$field];
		$focus->$field = $value;

	}
}
//set check box states.
if (isset($_POST['is_optout']) && $_POST['is_optout'] =='on') {
	$focus->is_optout=1;
	$focus->tracker_url='index.php?entryPoint=removeme';
} else {
	$focus->is_optout=0;
}

$focus->save($check_notify);
$return_id = $focus->id;
$GLOBALS['log']->debug("Saved record with id of ".$return_id);
handleRedirect('', '');
?>