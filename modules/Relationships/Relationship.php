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


class Relationship extends SugarBean {

	public $object_name='Relationship';
	public $module_dir = 'Relationships';
	public $new_schema = true;
	public $table_name = 'relationships';

	public $id;
	public $relationship_name;
	public $lhs_module;
	public $lhs_table;
	public $lhs_key;
	public $rhs_module;
	public $rhs_table;
	public $rhs_key;
	public $join_table;
	public $join_key_lhs;
	public $join_key_rhs;
	public $relationship_type;
	public $relationship_role_column;
	public $relationship_role_column_value;
	public $reverse;

	public $_self_referencing;

	/**
	 * Used to hold the listing of relationship names for use in existence checks.
	 * This addresses an issue in which the cap for queries was being reached by
	 * non admins given admin rights to make changes in studio.
	 * 
	 * @var array
	 */
	public static $relCacheInternal = array();

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Relationship()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
	}

	/*returns true if the relationship is self referencing. equality check is performed for both table and
	 * key names.
	 */
	function is_self_referencing() {
		if (empty($this->_self_referencing)) {
			$this->_self_referencing=false;

			//is it self referencing, both table and key name from lhs and rhs should  be equal.
			if ($this->lhs_table == $this->rhs_table && $this->lhs_key == $this->rhs_key) {
				$this->_self_referencing=true;
			}
		}
		return $this->_self_referencing;
	}

    /**
     * Returns true if a relationship with provided name exists
     * 
     * @param string $relationship_name The name of the relationship to check
     * @param DBManager $db A DBManager object
     * @return boolean
     */
    function exists($relationship_name,&$db) {
        // Cache the list of relationships internally to prevent an insane 
        // number of queries from running
        if (empty(self::$relCacheInternal)) {
            $query = "SELECT relationship_name FROM relationships WHERE deleted=0";
            $result = $db->query($query,true," Error searching relationships table..");
            while ($row = $db->fetchByAssoc($result)) {
                self::$relCacheInternal[$row['relationship_name']] = 1;
            }
        }

        return isset(self::$relCacheInternal[$relationship_name]);
    }

	function delete($relationship_name,&$db) {

		$query = "UPDATE relationships SET deleted=1 WHERE deleted=0 AND relationship_name = '".$relationship_name."'";
		$result = $db->query($query,true," Error updating relationships table for ".$relationship_name);

		// Unset this from the exists array in case we need it in the same request
		unset(self::$relCacheInternal[$relationship_name]);

		// Rebuild the cache
		$this->rebuild_relationship_cache();
	}


	function get_other_module($relationship_name, $base_module, &$db){
	//give it the relationship_name and base module
	//it will return the module name on the other side of the relationship

		$query = "SELECT relationship_name, rhs_module, lhs_module FROM relationships WHERE deleted=0 AND relationship_name = '".$relationship_name."'";
		$result = $db->query($query,true," Error searching relationships table..");
		$row  =  $db->fetchByAssoc($result);
		if ($row != null) {

			if($row['rhs_module']==$base_module){
				return $row['lhs_module'];
			}
			if($row['lhs_module']==$base_module){
				return $row['rhs_module'];
			}
		}

		return false;


	//end function get_other_module
	}

	function retrieve_by_sides($lhs_module, $rhs_module, &$db){
	//give it the relationship_name and base module
	//it will return the module name on the other side of the relationship

		$query = "SELECT * FROM relationships WHERE deleted=0 AND lhs_module = '".$lhs_module."' AND rhs_module = '".$rhs_module."'";
		$result = $db->query($query,true," Error searching relationships table..");
		$row  =  $db->fetchByAssoc($result);
		if ($row != null) {

			return $row;

		}

		return null;


	//end function retrieve_by_sides
	}

	function retrieve_by_modules($lhs_module, $rhs_module, &$db, $type =''){
	//give it the relationship_name and base module
	//it will return the module name on the other side of the relationship

		$query = "	SELECT * FROM relationships
					WHERE deleted=0
					AND (
					(lhs_module = '".$lhs_module."' AND rhs_module = '".$rhs_module."')
					OR
					(lhs_module = '".$rhs_module."' AND rhs_module = '".$lhs_module."')
					)
					";
		if(!empty($type)){
			$query .= " AND relationship_type='$type'";
		}
		$result = $db->query($query,true," Error searching relationships table..");
		$row  =  $db->fetchByAssoc($result);
		if ($row != null) {

			return $row['relationship_name'];

		}

		return null;


	//end function retrieve_by_sides
	}


	function retrieve_by_name($relationship_name) {

		if (empty($GLOBALS['relationships'])) {
			$this->load_relationship_meta();
		}

//		_ppd($GLOBALS['relationships']);

		if (array_key_exists($relationship_name, $GLOBALS['relationships'])) {

			foreach($GLOBALS['relationships'][$relationship_name] as $field=>$value)
			{
					$this->$field = $value;
			}
		}
		else {
			$GLOBALS['log']->fatal('Error fetching relationship from cache '.$relationship_name);
			return false;
		}
	}

	function load_relationship_meta() {
		if (!file_exists(Relationship::cache_file_dir().'/'.Relationship::cache_file_name_only())) {
			$this->build_relationship_cache();
		}
		include(Relationship::cache_file_dir().'/'.Relationship::cache_file_name_only());
		$GLOBALS['relationships']=$relationships;
	}

	function build_relationship_cache() {
		$query="SELECT * from relationships where deleted=0";
		$result=$this->db->query($query);

        $relationships = array();
		while (($row=$this->db->fetchByAssoc($result))!=null) {
			$relationships[$row['relationship_name']] = $row;
		}
		
		sugar_mkdir($this->cache_file_dir(), null, true);
        $out = "<?php \n \$relationships = " . var_export($relationships, true) . ";";
        sugar_file_put_contents_atomic(Relationship::cache_file_dir() . '/' . Relationship::cache_file_name_only(), $out);

        SugarRelationshipFactory::deleteCache();
	}


	public static function cache_file_dir() {
		return sugar_cached("modules/Relationships");
	}
	public static function cache_file_name_only() {
		return 'relationships.cache.php';
	}

	public static function delete_cache() {
		$filename=Relationship::cache_file_dir().'/'.Relationship::cache_file_name_only();
		if (file_exists($filename)) {
			unlink($filename);
		}
        SugarRelationshipFactory::deleteCache();
        
        // Delete the internal cache as well
        self::$relCacheInternal = array();
	}


	function trace_relationship_module($base_module, $rel_module1_name, $rel_module2_name=""){
		global $beanList;
		global $dictionary;

		$temp_module = BeanFactory::getBean($base_module);

		$rel_attribute1_name = $temp_module->field_defs[strtolower($rel_module1_name)]['relationship'];
		$rel_module1 = $this->get_other_module($rel_attribute1_name, $base_module, $temp_module->db);
		$rel_module1_bean = BeanFactory::getBean($rel_module1);

		if($rel_module2_name!=""){
			if($rel_module2_name == 'ProjectTask'){
				$rel_module2_name = strtolower($rel_module2_name);
			}
			$rel_attribute2_name = $rel_module1_bean->field_defs[strtolower($rel_module2_name)]['relationship'];
			$rel_module2 = $this->get_other_module($rel_attribute2_name, $rel_module1_bean->module_dir, $rel_module1_bean->db);
			$rel_module2_bean = BeanFactory::getBean($rel_module2);
			return $rel_module2_bean;

		} else {
			//no rel_module2, so return rel_module2 bean
			return $rel_module1_bean;
		}

	//end function trace_relationship_module
	}
	
	public function rebuild_relationship_cache()
	{
		self::delete_cache();
		$this->load_relationship_meta();
	}




}
