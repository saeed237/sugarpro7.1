<?php
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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldImage extends SugarFieldBase {

    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false) {
    	$displayParams['bean_id']='id';
    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
		return $this->fetch($this->findTemplate('EditView'));
    }

	function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false) {
		$displayParams['bean_id']='id';
		$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
		return $this->fetch($this->findTemplate('DetailView'));
	}

    function getUserEditView($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false) {
    	$displayParams['bean_id']='id';
    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex, false);
		return $this->fetch($this->findTemplate('UserEditView'));
    }

    function getUserDetailView($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false) {
    	$displayParams['bean_id']='id';
    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex, false);
		return $this->fetch($this->findTemplate('UserDetailView'));
    }

	public function save(&$bean, $params, $field, $properties, $prefix = ''){
		require_once('include/upload_file.php');
		$upload_file = new UploadFile($field);

		//remove file
		if (isset($_REQUEST['remove_imagefile_' . $field]) && $_REQUEST['remove_imagefile_' . $field] == 1)
		{
			$upload_file->unlink_file($bean->$field);
			$bean->$field="";
		}

		//uploadfile
		if (isset($_FILES[$field]))
		{
			//confirm only image file type can be uploaded
			if (verify_image_file($_FILES[$field]['tmp_name']))
			{
				if ($upload_file->confirm_upload())
				{
                    // for saveTempImage API
                    if (isset($params['temp']) && $params['temp'] === true) {

                        // Create the new field value
                        $bean->$field = create_guid();

                        // Move to temporary folder
                        if (!$upload_file->final_move($bean->$field, true)) {
                            // If this was a fail, reset the bean field to original
                            $this->error = $upload_file->getErrorMessage();
                        }
                    } else {

                        // Capture the old value in case of error
                        $oldvalue = $bean->$field;

                        // Create the new field value
                        $bean->$field = create_guid();

                        // Add checking for actual file move for reporting to consumers
                        if (!$upload_file->final_move($bean->$field)) {
                            // If this was a fail, reset the bean field to original
                            $bean->$field = $oldvalue;
                            $this->error = $upload_file->getErrorMessage();
                        }
                    }
				}
                else
                {
                    // Added error reporting
                    $this->error = $upload_file->getErrorMessage();
                }
			}
            else {
                $imgInfo = getimagesize($_FILES[$field]['tmp_name']);
                // if file is image then this image is no longer supported.
                if(false !== $imgInfo) {
                    $ext = end(explode('.', $_FILES[$field]['name']));
                    $this->error = string_format($GLOBALS['app_strings']['LBL_UPLOAD_IMAGE_FILE_NOT_SUPPORTED'], array($ext));
                } else {
                    $this->error = $GLOBALS['app_strings']["LBL_UPLOAD_IMAGE_FILE_INVALID"];
                }
            }
		}

		//Check if we have the duplicate value set and use it if $bean->$field is empty
		if(empty($bean->$field) && !empty($_REQUEST[$field . '_duplicate'])) {
           $bean->$field = $_REQUEST[$field . '_duplicate'];
		}
	}

}
?>
