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

//updates the link between contract and document with latest revision of
//the document and sends the control back to calling page.

require_once('modules/Documents/Document.php');
require_once('include/formbase.php');
if (!empty($_REQUEST['record'])) {

	$document = BeanFactory::getBean('Documents', $_REQUEST['record']);
	if (!empty($document->document_revision_id) && !empty($_REQUEST['get_latest_for_id']))  {
		$query="update linked_documents set document_revision_id='{$document->document_revision_id}', date_modified='".TimeDate::getInstance()->nowDb()."' where id ='{$_REQUEST['get_latest_for_id']}' ";
		$document->db->query($query);
	}	
}
handleRedirect();
?>
