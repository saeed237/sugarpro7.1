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


require_once('include/upload_file.php');

class DocumentSoap{
var $upload_file;
	public function DocumentSoap(){
        self::__construct();
    }

    public function __construct() {
		$this->upload_file = new UploadFile('filename_file');
	}

	function saveFile($document, $portal = false){
        global $sugar_config;

        $focus = BeanFactory::getBean('Documents');

                if($portal){
                        $focus->disable_row_level_security = true;
                }


        if(!empty($document['id'])){
                $focus->retrieve($document['id']);
                if(empty($focus->id)) {
                    return '-1';
                }
        }else{
                return '-1';
        }

        if(!empty($document['file'])){
                $decodedFile = base64_decode($document['file']);
                $this->upload_file->set_for_soap($document['filename'], $decodedFile);

                $ext_pos = strrpos($this->upload_file->stored_file_name, ".");
                $this->upload_file->file_ext = substr($this->upload_file->stored_file_name, $ext_pos + 1);
                if (in_array($this->upload_file->file_ext, $sugar_config['upload_badext'])) {
                        $this->upload_file->stored_file_name .= ".txt";
                        $this->upload_file->file_ext = "txt";
                }

                $revision = BeanFactory::getBean('DocumentRevisions');
				$revision->filename = $this->upload_file->get_stored_file_name();
          		$revision->file_mime_type = $this->upload_file->getMimeSoap($revision->filename);
				$revision->file_ext = $this->upload_file->file_ext;
				//$revision->document_name = ;
				$revision->revision = $document['revision'];
				$revision->document_id = $document['id'];
				$revision->save();

               	$focus->document_revision_id = $revision->id;
               	$focus->save();
                $return_id = $revision->id;
                $this->upload_file->final_move($revision->id);
        }else{
                return '-1';
        }
        return $return_id;
	}
}
?>