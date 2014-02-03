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




class Group extends User {
	// User attribute overrides
	var $status			= 'Group';
	var $password		= ''; // to disallow logins
	var $default_team;
	var $importable = false;


    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Group()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
	}

	/** 
	 * overrides SugarBean method
	 */
	function mark_deleted($id) {
		SugarBean::mark_deleted($id);
	}

	function create_export_query($order_by, $where)
	{
		$query = "SELECT users.*";
		$query .= " FROM users ";
		$where_auto = " users.deleted = 0";
		if($where != "")
			$query .= " WHERE $where AND " . $where_auto;
		else
			$query .= " WHERE " . $where_auto;
		if($order_by != "")
			$query .= " ORDER BY $order_by";
		else
			$query .= " ORDER BY users.user_name";
		return $query;
	}
	
} // end class def 

?>