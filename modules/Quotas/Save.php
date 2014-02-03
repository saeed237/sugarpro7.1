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

 * Description:  
 ********************************************************************************/



$focus = BeanFactory::getBean('Quotas');

require_once('include/formbase.php');
$focus = populateFromPost('', $focus);

if ($_REQUEST['committed'] == 'on')
	$focus->committed = 1;
else
	$focus->committed = 0;
	
$focus->assigned_user_id = $focus->user_id;

/* get the conversion rate and update the correct value for the base currency */
if ($focus->currency_id != -99)
	$convertRate = $focus->getConversionRate($focus->currency_id);
else
	$convertRate = 1;

$focus->amount_base_currency = floor($focus->amount / $convertRate);
	
if ($focus->isManager($focus->user_id) && $current_user->id != $focus->user_id){
	$focus->quota_type = "Rollup";
}
else
{
	$focus->quota_type = "Direct";
}

// Save the edited or newly created quota
if ($focus->committed == 1 && ($_POST['user_id'] != $current_user->id))
	$focus->save(true);
else
	$focus->save();

// Check to see if current user is a top level manager
if ($focus->isTopLevelManager()){
	$topLevelFocus = BeanFactory::getBean('Quotas');
	
	$topLevelFocus->timeperiod_id = $_REQUEST['timeperiod_id'];
	$topLevelFocus->user_id = $current_user->id;
	$topLevelFocus->quota_type = 'Rollup';
	$topLevelFocus->currency_id = -99;	
	
	$focus->resetGroupQuota($_REQUEST['timeperiod_id']);
	$topLevelFocus->amount = $focus->getGroupQuota($_REQUEST['timeperiod_id'], false);
	$topLevelFocus->amount_base_currency = $focus->getGroupQuota($_REQUEST['timeperiod_id'], false);
	$topLevelFocus->committed = 1;
	
	$quota_id = $focus->getTopLevelRecord($_REQUEST['timeperiod_id']);
	
	if (!empty($quota_id))
		$topLevelFocus->id = $quota_id;
		
	// save the top level manager's quota record		
	$topLevelFocus->save();	
	
	$GLOBALS['log']->debug("Saved top level manager's record with id of ".$topLevelFocus->id);
}


// Here are the return fields for returning to the correct page
$return_id = $focus->id;

$edit='';
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Quotas";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];
if(isset($_REQUEST['return_user_id']) && $_REQUEST['return_user_id'] != "") $return_user_id = $_REQUEST['return_user_id'];
if(isset($_REQUEST['return_timeperiod_id']) && $_REQUEST['return_timeperiod_id'] != "") $return_timeperiod_id = $_REQUEST['return_timeperiod_id'];
if(!empty($_REQUEST['edit'])) {
	$return_id='';
	$edit='&edit=true';
}
$GLOBALS['log']->debug("Saved record with id of ".$return_id);

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&user_id=$return_user_id&timeperiod_id=$return_timeperiod_id$edit");
?>
