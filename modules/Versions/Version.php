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

 * Description:
 ********************************************************************************/










class Version extends SugarBean {
	// Stored fields
	var $id;
	var $deleted;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;
	var $field_name_map;
	var $name;
	var $file_version;
	var $db_version;
	var $table_name = 'versions';
	var $module_dir = 'Versions';
	var $object_name = "Version";

	var $new_schema = true;

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array();

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Version()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
		$this->team_id = 1; // make the item globally accessible
		$this->disable_row_level_security = true;
	}

	


	
	/**
		builds a generic search based on the query string using or
		do not include any $this-> because this is called on without having the class instantiated
	*/
	function build_generic_where_clause ($the_query_string) {
	$where_clauses = Array();
	$the_query_string = addslashes($the_query_string);
	array_push($where_clauses, "name like '$the_query_string%'");
	$the_where = "";
	foreach($where_clauses as $clause)
	{
		if($the_where != "") $the_where .= " or ";
		$the_where .= $clause;
	}


	return $the_where;
}


function is_expected_version($expected_version){
	foreach($expected_version as $name=>$val){
		if($this->$name != $val){
			return false;	
		}	
	}
	return true;
		
}
/**
 * Updates the version info based on the information provided
 */
function mark_upgraded($name, $dbVersion, $fileVersion){
	$query = "DELETE FROM versions WHERE name='$name'";
	$GLOBALS['db']->query($query);
	$version = BeanFactory::getBean('Versions');
	$version->name = $name;
	$version->file_version = $fileVersion;
	$version->db_version = $dbVersion;
	$version->save();
	
	if(isset($_SESSION['invalid_versions'][$name])) {
		unset($_SESSION['invalid_versions'][$name]);
	}
}

function get_profile(){
	return array('name'=> $this->name, 'file_version'=> $this->file_version, 'db_version'=>$this->db_version);	
}






}

?>