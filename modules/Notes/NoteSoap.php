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

class NoteSoap
{
    var $upload_file;

    function NoteSoap()
    {
    	$this->upload_file = new UploadFile('uploadfile');
    }

    function saveFile($note, $portal = false)
    {
        global $sugar_config;

        $focus = BeanFactory::getBean('Notes');

                if($portal){
                        $focus->disable_row_level_security = true;
                }


        if(!empty($note['id'])){
                $focus->retrieve($note['id']);
                if(empty($focus->id)) {
                    return '-1';
                }
        }else{
                return '-1';
        }

        if(!empty($note['file'])){
                $decodedFile = base64_decode($note['file']);
                $this->upload_file->set_for_soap($note['filename'], $decodedFile);

                $ext_pos = strrpos($this->upload_file->stored_file_name, ".");
                $this->upload_file->file_ext = substr($this->upload_file->stored_file_name, $ext_pos + 1);
                if (in_array($this->upload_file->file_ext, $sugar_config['upload_badext'])) {
                        $this->upload_file->stored_file_name .= ".txt";
                        $this->upload_file->file_ext = "txt";
                }

                $focus->filename = $this->upload_file->get_stored_file_name();
                $focus->file_mime_type = $this->upload_file->getMimeSoap($focus->filename);
               	$focus->id = $note['id'];
                $return_id = $focus->save();
                $this->upload_file->final_move($focus->id);
        }else{
                return '-1';
        }

        return $return_id;
    }

    function newSaveFile($note, $portal = false){
        global $sugar_config;

        $focus = BeanFactory::getBean('Notes');

        if($portal){
        	$focus->disable_row_level_security = true;
        }

        if(!empty($note['id'])){
        	$focus->retrieve($note['id']);
            if(empty($focus->id)) {
                return '-1';
            }
        } else {
           	return '-1';
        }

        if(!empty($note['file'])){
            $decodedFile = base64_decode($note['file']);
            $this->upload_file->set_for_soap($note['filename'], $decodedFile);

            $ext_pos = strrpos($this->upload_file->stored_file_name, ".");
            $this->upload_file->file_ext = substr($this->upload_file->stored_file_name, $ext_pos + 1);
            if (in_array($this->upload_file->file_ext, $sugar_config['upload_badext'])) {
                    $this->upload_file->stored_file_name .= ".txt";
                    $this->upload_file->file_ext = "txt";
            }

            $focus->filename = $this->upload_file->get_stored_file_name();
            $focus->file_mime_type = $this->upload_file->getMimeSoap($focus->filename);
            $focus->save();
        }

        $return_id = $focus->id;

        if(!empty($note['file'])){
        	$this->upload_file->final_move($focus->id);
        }

		if (!empty($note['related_module_id']) && !empty($note['related_module_name'])) {
        	$focus->process_save_dates=false;
        	$module_name = $note['related_module_name'];
        	$module_id = $note['related_module_id'];
			if($module_name != 'Contacts'){
				$focus->parent_type=$module_name;
				$focus->parent_id = $module_id;
			}else{
				$focus->contact_id=$module_id;
			}
			$focus->save();

        } // if
        return $return_id;
    }

    function retrieveFile($id, $filename)
    {
    	if(empty($filename)){
    		return '';
    	}

    	$this->upload_file->stored_file_name = $filename;
    	$filepath = $this->upload_file->get_upload_path($id);
    	if(file_exists($filepath)){
    		$file = file_get_contents($filepath);
    		return base64_encode($file);
    	}
    	return -1;
    }

}
