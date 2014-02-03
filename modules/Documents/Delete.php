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

 * Description:  Deletes an Account record and then redirects the browser to the 
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/




global $mod_strings;



if(!isset($_REQUEST['record']))
	sugar_die($mod_strings['ERR_DELETE_RECORD']);
$focus = BeanFactory::getBean('Documents', $_REQUEST['record']);
if(!$focus->ACLAccess('Delete')){
	ACLController::displayNoAccess(true);
	sugar_cleanup(true);
}
if (isset($_REQUEST['object']) && $_REQUEST['object']="documentrevision") {
	//delete document revision.
	$focus = BeanFactory::getBean('DocumentRevisions');
	UploadFile::unlink_file($_REQUEST['revision_id'],$_REQUEST['filename']);
} else {
	//delete document and its revisions.
	$focus = BeanFactory::getBean('Documents', $_REQUEST['record']);

	$focus->load_relationships('revisions');	
	$revisions= $focus->get_linked_beans('revisions','DocumentRevision');

	if (!empty($revisions) && is_array($revisions)) {
		foreach($revisions as $key=>$thisversion) {
			UploadFile::unlink_file($thisversion->id,$thisversion->filename);
			//mark the version deleted.
			$thisversion->mark_deleted($thisversion->id);
		}				
	}

    //Remove the contracts relationships
    $focus->load_relationship('contracts');
    if(!empty($focus->contracts))
    {
        $focus->contracts->delete($focus->id);
    }

}

$focus->mark_deleted($_REQUEST['record']);
header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);
?>
