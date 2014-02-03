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


require_once('include/upload_file.php');

class KBDocumentSoap {
var $upload_file;

function KBDocumentSoap(){
	$this->upload_file = new UploadFile('uploadfile');
}

function retrieveFile($id){
	$filepath = $this->upload_file->get_upload_path($id);
	$s = '';
	if(file_exists($filepath)){
		
		$s = file_get_contents($filepath);
		return base64_encode($s);
	}
	return -1;
}

/**
 * retrieveFileName
 * This is a function to return the true file name value as listed
 * in the document_revisions table for the given id.
 * @param The id field of the row in document_revisions table to fetch file name for
 * @return The String file name or id if not found
 */
function retrieveFileName($id) {	
    
    $query = "select filename from document_revisions where id = '$id'";
    $bean = BeanFactory::getBean('KBDocuments');
    $result = $bean->db->query($query);
    if(isset($result)) {
       $row = $bean->db->fetchByAssoc($result);
       return isset($row) ? $row['filename'] : $id;	
    }
    return $id;
}

}

?>