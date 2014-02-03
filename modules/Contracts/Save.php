<?php
if(!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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





require_once ('include/formbase.php');



global $timedate;
if(!empty($_POST['expiration_notice_time_meridiem']) && !empty($_POST['expiration_notice_time'])) {
	$_POST['expiration_notice_time'] = $timedate->merge_time_meridiem($_POST['expiration_notice_time'],$timedate->get_time_format(), $_POST['expiration_notice_time_meridiem']);
}


$sugarbean = BeanFactory::getBean('Contracts');
$sugarbean = populateFromPost('', $sugarbean);

if (!$sugarbean->ACLAccess('Save')) {
	ACLController :: displayNoAccess(true);
	sugar_cleanup(true);
}
if(empty($sugarbean->id)) {
    $sugarbean->id = create_guid();
    $sugarbean->new_with_id = true;
}

$check_notify = isset($GLOBALS['check_notify']) ? $GLOBALS['check_notify'] : false;
$sugarbean->save($check_notify);
$return_id = $sugarbean->id;

if (!empty($_POST['type']) && $_POST['type'] !== $_POST['old_type']) {
	//attach all documents from contract type into contract.
	$ctype = BeanFactory::getBean('ContractTypes', $_POST['type']);
	if (!empty($ctype->id)) {
		$ctype->load_relationship('documents');
		$doc = BeanFactory::getBean('Documents');
		$documents=$ctype->documents->getBeans($doc);
		if (count($documents) > 0) {
			$sugarbean->load_relationship('contracts_documents');
			foreach($documents as $document) {
				$sugarbean->contracts_documents->add($document->id,array('document_revision_id'=>$document->document_revision_id));
			}			
		}	
	}
}
handleRedirect($return_id, 'Contracts');
?>