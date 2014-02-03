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


require_once('include/SugarObjects/templates/basic/Basic.php');
require_once('include/upload_file.php');
require_once('include/formbase.php');

class File extends Basic
{
	public $file_url;
	public $file_url_noimage;

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function File()
    {
        self::__construct();
    }

    public function __construct(){
		parent::__construct();
	}

	/**
	 * @see SugarBean::save()
	 */
	public function save($check_notify=false)
	{
		if (!empty($this->uploadfile)) {
			$this->filename = $this->uploadfile;
		}

		return parent::save($check_notify);
 	}

 	/**
	 * @see SugarBean::fill_in_additional_detail_fields()
	 */
	public function fill_in_additional_detail_fields()
 	{
		global $app_list_strings;
		global $img_name;
		global $img_name_bare;

		$this->uploadfile = $this->filename;

		// Bug 41453 - Make sure we call the parent method as well
		parent::fill_in_additional_detail_fields();

		if (!$this->file_ext) {
			$img_name = SugarThemeRegistry::current()->getImageURL(strtolower($this->file_ext)."_image_inline.gif");
			$img_name_bare = strtolower($this->file_ext)."_image_inline";
		}

		//set default file name.
		if (!empty ($img_name) && file_exists($img_name)) {
			$img_name = $img_name_bare;
		}
		else {
			$img_name = "def_image_inline"; //todo change the default image.
		}
		$this->file_url_noimage = $this->id;

		if(!empty($this->status_id)) {
	       $this->status = $app_list_strings['document_status_dom'][$this->status_id];
	    }
	}

	/**
	 * @see SugarBean::retrieve()
	 */
	public function retrieve($id = -1, $encode=true, $deleted=true)
	{
		$ret_val = parent::retrieve($id, $encode, $deleted);

		$this->name = $this->document_name;

		return $ret_val;
	}

    /**
     * Method to delete an attachment
     *
     * @param string $isduplicate
     * @return bool
     */
    public function deleteAttachment($isduplicate = "false")
    {
        if ($this->ACLAccess('edit')) {
            if ($isduplicate == "true") {
                return true;
            }
            $removeFile = "upload://{$this->id}";
        }
        if (file_exists($removeFile)) {
            if (!unlink($removeFile)) {
                $GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
            } else {
                $this->uploadfile = '';$this->uploadfile = '';
                $this->filename = '';
                $this->file_mime_type = '';
                $this->file_ext = '';
                $this->save();
                return true;
            }
        } else {
            $this->uploadfile = '';
            $this->filename = '';
            $this->file_mime_type = '';
            $this->file_ext = '';
            $this->save();
            return true;
        }
        return false;
    }
}
