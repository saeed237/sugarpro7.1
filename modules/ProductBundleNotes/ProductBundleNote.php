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











class ProductBundleNote extends SugarBean {
	// Stored fields
	var $id;
	var $deleted;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;
	var $description;

	// These are for related fields
	var $type_name;
	var $type_id;
	var $quote_id;
	var $quote_name;
	var $manufacturer_name;
	var $manufacturer_id;
	var $category_name;
	var $category_id;
	var $account_name;
	var $account_id;
	var $contact_name;
	var $contact_id;
	var $related_product_id;

	var $table_name = "product_bundle_notes";
	var $rel_quotes = "product_bundle_quote";
	var $rel_products = "product_bundle_product";
	var $rel_notes = "product_bundle_note";

	var $module_dir = "ProductBundleNotes";
	var $object_name = "ProductBundleNote";

	var $new_schema = true;

	var $column_fields = Array("id"
		,"description"
		,"date_entered"
		,"date_modified"
		,"modified_user_id"
		, "created_by"
		);

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array();

	// This is the list of fields that are copied over from product template.


	// This is the list of fields that are in the lists.
	var $list_fields = array('id');
	// This is the list of fields that are required
	var $required_fields =  array( );

	//deletes related products might want to change this in the future if we allow for sharing of products
	function mark_deleted($id){
		$pb = BeanFactory::getBean('ProductBundleNotes');
		$pb->id = $id;
/*
		$products = $pb->get_products();
		foreach($products as $product){
			$product->mark_deleted($product->id);
		}
*/
		return parent::mark_deleted($id);
	}

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function ProductBundleNote()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();

		$this->disable_row_level_security=true;
	}

	function save_relationship_changes($is_update)
    {
    	// empty
    }

    function set_product_bundle_product_notes_relationship($bundle_id, $product_id, $note_id='', $note_index)
    {
    	if (empty($note_id)) $note_id = $this->id;

    	$query = "INSERT INTO $this->rel_notes SET id='".create_guid()."', bundle_id='".$bundle_id."', product_id='".$product_id."', note_id='".$note_id."', note_index='".$note_index."'";

    	$this->db->query($query, true, "Error setting note to product to product bundle relationship: "."<BR>$query");
    	$GLOBALS['log']->debug("Setting note to product to product bundle relationship for bundle_id: $bundle_id, product_id: $product_id, and note_id: $note_id");
    }

    function clear_product_bundle_product_notes_relationship($bundle_id)
    {
    	$query = "DELETE FROM $this->rel_notes WHERE (bundle_id='$bundle_id') AND deleted=0";

    	$this->db->query($query, true, "Error clearing note to product to product bundle relationship");
    }

	function mark_relationships_deleted($id)
	{
		//$this->clear_productbundle_product_relationship($id);
		//$this->clear_productbundle_quote_relationship($id);
		$this->clear_product_bundle_product_notes_relationship($note_id);
	}

	function fill_in_additional_list_fields()
	{
		$this->fill_in_additional_detail_fields();
	}

	function fill_in_additional_detail_fields()
	{
		// empty
	}

	function get_list_view_data()
	{
		// empty
	}

	/**
	 *	builds a generic search based on the query string using or
	 *	do not include any $this-> because this is called on without having the class instantiated
	 */
	function build_generic_where_clause ($the_query_string)
	{
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

	function save($check_notify = FALSE)
	{
		$this->id = parent::save($check_notify);

		return $this->id;
	}

}

?>
