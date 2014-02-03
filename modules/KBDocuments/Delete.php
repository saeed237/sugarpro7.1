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
global $sugar_config;

if(!isset($_REQUEST['record']))
	sugar_die($mod_strings['ERR_DELETE_RECORD']);
$focus = BeanFactory::getBean('KBDocuments', $_REQUEST['record']);
if(!$focus->ACLAccess('Delete')){
	ACLController::displayNoAccess(true);
	sugar_cleanup(true);
}

//Retrieve all related kbdocument revisions.
$kbdocrevs = KBDocument::get_kbdocument_revisions($_REQUEST['record']);
//Loop through kbdocument revisions and delete one by one.
if (!empty($kbdocrevs) && is_array($kbdocrevs)) {
	foreach($kbdocrevs as $key=>$thiskbid) {
		$thiskbversion = BeanFactory::getBean('KBDocumentRevisions', $thiskbid);
		//Check for related documentrevision and delete.
        if($thiskbversion->document_revision_id != null){
	        $docrev_id = $thiskbversion->document_revision_id;
			$thisdocrev = BeanFactory::getBean('DocumentRevisions', $docrev_id);

           	UploadFile::unlink_file($docrev_id,$thisdocrev->filename);
           	UploadFile::unlink_file($docrev_id);
			//mark version deleted
			$thisdocrev->mark_deleted($thisdocrev->id);
        }
        //Also check for related kbcontent and delete.
        if($thiskbversion->kbcontent_id != null){
			BeanFactory::deleteBean('KBContents', $thiskbversion->kbcontent_id);
        }
		//Finally delete the kbdocument revision.
	   $thiskbversion->mark_deleted($thiskbversion->id);
	}
}

//delete kbdocuments_kbtags
$deleted=1;
$q = 'UPDATE kbdocuments_kbtags SET deleted = '.$deleted.' WHERE kbdocument_id = \''.$_REQUEST['record'].'\'';
$focus->db->query($q);

$focus->mark_deleted($_REQUEST['record']);

header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);
