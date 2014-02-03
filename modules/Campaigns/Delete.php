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

if(!isset($_REQUEST['record']))
{
	sugar_die("A record number must be specified to delete the campaign.");
}

$focus = BeanFactory::getBean('Campaigns', $_REQUEST['record']);

if (isset($_REQUEST['mode']) and $_REQUEST['mode']=='Test') {
	//deletes all data associated with the test run.
    require_once('modules/Campaigns/DeleteTestCampaigns.php');
    $deleteTest = new DeleteTestCampaigns();
    $deleteTest->deleteTestRecords($focus);
} else {
	if(!$focus->ACLAccess('Delete')){
		ACLController::displayNoAccess(true);
		sugar_cleanup(true);
	}
	$focus->mark_deleted($_REQUEST['record']);
}

$return_id=!empty($_REQUEST['return_id'])?$_REQUEST['return_id']:$focus->id;
require_once ('include/formbase.php');
handleRedirect($return_id, $_REQUEST['return_module']);