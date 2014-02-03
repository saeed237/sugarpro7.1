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

require_once('modules/Contacts/ContactOpportunityRelationship.php');




$focus = new ContactOpportunityRelationship();

$focus->retrieve($_REQUEST['record']);

foreach($focus->column_fields as $field)
{
	safe_map($field, $focus, true);
}

foreach($focus->additional_column_fields as $field)
{
	safe_map($field, $focus, true);
}

// send them to the edit screen.
if(isset($_REQUEST['record']) && $_REQUEST['record'] != "")
{
    $recordID = $_REQUEST['record'];
}

$focus->save();
$recordID = $focus->id;

$GLOBALS['log']->debug("Saved record with id of ".$recordID);

$header_URL = "Location: index.php?action={$_REQUEST['return_action']}&module={$_REQUEST['return_module']}&record={$_REQUEST['return_id']}";
$GLOBALS['log']->debug("about to post header URL of: $header_URL");

header($header_URL);
?>