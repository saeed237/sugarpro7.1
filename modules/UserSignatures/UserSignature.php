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

/**
 *  User is used to store customer information.
 */
class UserSignature extends SugarBean
{
	var $id;
	var $date_entered;
	var $date_modified;
	var $deleted;
	var $user_id;
	var $name;
	var $signature;
	var $table_name = 'users_signatures';
	var $module_dir = 'UserSignatures';
	var $object_name ='UserSignature';
	var $disable_custom_fields = true;
	var $disable_row_level_security = true;
    
	/**
	 * returns the bean name - overrides SugarBean's
	 */
	function get_summary_text() {
		return $this->name;
	}

	/**
	 * Override's SugarBean's
	 */
	function create_export_query($order_by, $where, $show_deleted = 0) {
		return $this->create_new_list_query($order_by, $where,array(),array(), $show_deleted = 0);
	}

	/**
	 * Override's SugarBean's
	 */
	function get_list_view_data(){
		global $mod_strings;
		global $app_list_strings;
		$temp_array = $this->get_list_view_array();
		$temp_array['MAILBOX_TYPE_NAME']= $app_list_strings['dom_mailbox_type'][$this->mailbox_type];
		return $temp_array;
	}

	/**
	 * Override's SugarBean's
	 */
	function fill_in_additional_list_fields() {
		$this->fill_in_additional_detail_fields();
	}

	/**
	 * Override's SugarBean's
	 */
	function fill_in_additional_detail_fields() {
	}
} // end class definition
