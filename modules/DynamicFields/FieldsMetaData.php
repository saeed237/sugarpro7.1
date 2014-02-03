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













class FieldsMetaData extends SugarBean {
	// database table columns
	var $id;
	var $name;
	var $vname;
  	var $custom_module;
  	var $type;
  	var $len;
  	var $required;
  	var $default_value;
  	var $deleted;
  	var $ext1;
  	var $ext2;
  	var $ext3;
	var $audited;
    var $duplicate_merge;
    var $reportable;
	var $required_fields =  array("name"=>1, "date_start"=>2, "time_start"=>3,);

	var $table_name = 'fields_meta_data';
	var $object_name = 'FieldsMetaData';
	var $module_dir = 'DynamicFields';
	var $column_fields = array(
		'id',
		'name',
		'vname',
		'custom_module',
		'type',
		'len',
		'required',
		'default_value',
		'deleted',
		'ext1',
		'ext2',
		'ext3',
		'audited',
		'massupdate',
        'duplicate_merge',
        'reportable',
	);

	var $list_fields = array(
		'id',
		'name',
		'vname',
		'type',
		'len',
		'required',
		'default_value',
		'audited',
		'massupdate',
        'duplicate_merge',
        'reportable',
	);

	var $field_name_map;
	var $new_schema = true;
	public $disable_row_level_security = true;

	//////////////////////////////////////////////////////////////////
	// METHODS
	//////////////////////////////////////////////////////////////////


    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function FieldsMetaData()
    {
        self::__construct();
    }


	public function __construct()
	{
		parent::__construct();
		$this->disable_row_level_security = true;
	}
	
	function mark_deleted($id)
	{
		$query = "DELETE FROM $this->table_name WHERE  id='$id'";
		$this->db->query($query, true,"Error deleting record: ");
		$this->mark_relationships_deleted($id);

	}

	function get_list_view_data(){
	    $data = parent::get_list_view_data();
	    $data['VNAME'] = translate($this->vname, $this->custom_module);
	    $data['NAMELINK'] = '<input class="checkbox" type="checkbox" name="remove[]" value="' . $this->id . '">&nbsp;&nbsp;<a href="index.php?module=Studio&action=wizard&wizard=EditCustomFieldsWizard&option=EditCustomField&record=' . $this->id . '" >';
	    return $data;
	}


	function get_summary_text()
	{
		return $this->name;
	}
}
?>
