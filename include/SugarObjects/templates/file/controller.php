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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
 require_once('include/upload_file.php');
 require_once('include/formbase.php');
 class FileController extends SugarController{

 	function action_save(){
 		$move=false;
 		$file = new File();
 		$file = populateFromPost('', $file);
 		$upload_file = new UploadFile('uploadfile');
 		$return_id ='';
 		if (isset($_FILES['uploadfile']) && $upload_file->confirm_upload())
		{
    		$file->filename = $upload_file->get_stored_file_name();
    		$file->file_mime_type = $upload_file->mime_type;
			$file->file_ext = $upload_file->file_ext;
			$move=true;
		}
 		$return_id = $file->save();
 		if ($move) {
			$upload_file->final_move($file->id);
		}
 		handleRedirect($return_id, $this->object_name);
 	}

 }
