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


$focus = BeanFactory::getBean('Campaigns', $_POST['record']);
if(!$focus->ACLAccess('Save')){
	ACLController::displayNoAccess(true);
	sugar_cleanup(true);
}
if (!empty($_POST['assigned_user_id']) && ($focus->assigned_user_id != $_POST['assigned_user_id']) && ($_POST['assigned_user_id'] != $current_user->id)) {
	$check_notify = TRUE;
}
else {
	$check_notify = FALSE;
}

require_once('include/formbase.php');
$focus = populateFromPost('', $focus);

//store preformatted dates for 2nd save
$preformat_start_date = $focus->start_date;
$preformat_end_date = $focus->end_date;
//_ppd($preformat_end_date);

$focus->save($check_notify);
$return_id = $focus->id;

$GLOBALS['log']->debug("Saved record with id of ".$return_id);


//copy compaign targets on duplicate
if( !empty($_REQUEST['duplicateSave']) &&  !empty($_REQUEST['duplicateId']) ){
	$copyFromCompaign = BeanFactory::getBean('Campaigns', $_REQUEST['duplicateId']);
	$copyFromCompaign->load_relationship('prospectlists');

	$focus->load_relationship('prospectlists');
	$target_lists = $copyFromCompaign->prospectlists->get();
	if(count($target_lists)>0){
		foreach ($target_lists as $prospect_list_id){
			$focus->prospectlists->add($prospect_list_id);
		}
	}

	$focus->save();
}


//if type is set to newsletter then make sure there are prospect lists attached
if($focus->campaign_type =='NewsLetter'){
		//if this is a duplicate, and the "relate_to" and "relate_id" elements are not cleared out,
		//then prospect lists will get related to the original campaign on save of the prospect list, and then
		//will get related to the new newsletter campaign, meaning the same (un)subscription list will belong to
		//two campaigns, which is wrong
		if((isset($_REQUEST['duplicateSave']) && $_REQUEST['duplicateSave']) || (isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate']) ){
			$_REQUEST['relate_to'] = '';
			$_REQUEST['relate_id'] = '';

		}

        //add preformatted dates for 2nd save, to avoid formatting conversion errors
        $focus->start_date = $preformat_start_date ;
        $focus->end_date = $preformat_end_date ;

        $focus->load_relationship('prospectlists');
        $target_lists = $focus->prospectlists->get();
        if(count($target_lists)<1){
            global $current_user;
            global $mod_strings;
            //if no prospect lists are attached, then lets create a subscription and unsubscription
            //default prospect lists as these are required for newsletters.

             //create subscription list
             $subs = BeanFactory::getBean('ProspectLists');
             $subs->name = $focus->name.' '.$mod_strings['LBL_SUBSCRIPTION_LIST'];
             $subs->assigned_user_id= $current_user->id;
             $subs->list_type = "default";
             $subs->save();
             $focus->prospectlists->add($subs->id);

             //create unsubscription list
             $unsubs = BeanFactory::getBean('ProspectLists');
             $unsubs->name = $focus->name.' '.$mod_strings['LBL_UNSUBSCRIPTION_LIST'];
             $unsubs->assigned_user_id= $current_user->id;
             $unsubs->list_type = "exempt";
             $unsubs->save();
             $focus->prospectlists->add($unsubs->id);

             //create unsubscription list
             $test_subs = BeanFactory::getBean('ProspectLists');
             $test_subs->name = $focus->name.' '.$mod_strings['LBL_TEST_LIST'];
             $test_subs->assigned_user_id= $current_user->id;
             $test_subs->list_type = "test";
             $test_subs->save();
             $focus->prospectlists->add($test_subs->id);
        }
        //save new relationships
        $focus->save();

}//finish newsletter processing

handleRedirect($focus->id, 'Campaigns');


?>
