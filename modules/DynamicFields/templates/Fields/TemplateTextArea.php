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

require_once('modules/DynamicFields/templates/Fields/TemplateText.php');
class TemplateTextArea extends TemplateText{
	var $type = 'text';
	var $len = '';

	public function __construct()
	{
		$this->vardef_map['rows'] = 'ext2';
		$this->vardef_map['cols'] = 'ext3';
	}

	function set($values){
	   parent::set($values);
	    if(!empty($this->ext2)){
	       $this->rows = $this->ext2;
	   }
	    if(!empty($this->ext3)){
	       $this->cols = $this->ext3;
	   }
	   if(!empty($this->ext4)){
	       $this->default_value = $this->ext4;
	   }

	}


	function get_xtpl_detail(){
		$name = $this->name;
		return nl2br($this->bean->$name);
	}

	function get_field_def()
	{
		$def = parent::get_field_def();
		$def['studio'] = 'visible';

		if ( isset ( $this->ext2 ) && isset ($this->ext3))
		{
			$def[ 'rows' ] = $this->ext2 ;
			$def[ 'cols' ] = $this->ext3 ;
		}
	   if (isset( $this->rows ) && isset ($this->cols))
        {
            $def[ 'rows' ] = $this->rows ;
            $def[ 'cols' ] = $this->cols ;
        }
		return $def;
	}

	function get_db_default()
	{
	    // TEXT columns in MySQL cannot have a DEFAULT value - let the Bean handle it on save
        return null; // Bug 16612 - null so that the get_db_default() routine in TemplateField doesn't try to set DEFAULT
    }

}
