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












// Product is used to store customer information.
class ProductBundle extends SugarBean {
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
	var $currency_id;
    var $base_rate;
	var $description;
	var $tax;
	var $shipping;
	var $subtotal;
	var $deal_tot;
	var $deal_tot_usdollar;
	var $new_sub;
	var $new_sub_usdollar;
	var $total;
	var $tax_usdollar;
	var $shipping_usdollar;
	var $subtotal_usdollar;
	var $total_usdollar;
	var $bundle_stage;
	var $is_template;
	var $is_editable;

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

	var $table_name = "product_bundles";
	var $rel_quotes = "product_bundle_quote";
	var $rel_products = "product_bundle_product";
	var $rel_notes = "product_bundle_note";
	var $module_dir = 'ProductBundles';
	var $object_name = "ProductBundle";

	var $new_schema = true;

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array();

	//deletes related products might want to change this in the future if we allow for sharing of products
	function mark_deleted($id){
		$pb = BeanFactory::getBean('ProductBundles');
		$pb->id = $id;
		$products = $pb->get_products();
		foreach($products as $product){
			$product->mark_deleted($product->id);
		}
		return parent::mark_deleted($id);
	}

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function ProductBundle()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
		$this->team_id = 1; // make the item globally accessible
	}

	/** Returns a list of the associated products
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_products()
	{
		// First, get the list of IDs.
		$query = "SELECT product_id as id
					from  $this->rel_products
					where bundle_id='$this->id' AND deleted=0 ORDER BY product_index";

		return $this->build_related_list($query, BeanFactory::getBean('Products'));
	}


	/** Returns a list of the associated products
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_quotes()
	{
		// First, get the list of IDs.
		$query = "SELECT quote_id as id
					from  $this->rel_quotes
					where bundle_id='$this->id' AND deleted=0";

		return $this->build_related_list($query, BeanFactory::getBean('Quotes'));
	}

	function get_notes()
	{
		$query = "SELECT note_id as id FROM $this->rel_notes WHERE bundle_id='$this->id' AND deleted=0 ORDER BY note_index";
		return $this->build_related_list($query, BeanFactory::getBean('ProductBundleNotes'));
	}

	function get_product_bundle_line_items() {
        $this->load_relationship('products');
        $this->load_relationship('product_bundle_notes');

        $bundle_list = array_merge(
                $this->products->getBeans(),
                $this->product_bundle_notes->getBeans()
        );

        usort($bundle_list, array(__CLASS__, 'compareProductOrNoteIndexAsc'));

        return $bundle_list;
	}


	/** Returns a list of the associated products
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	*/
/*

        function create_export_query(&$order_by, &$where)
        {
		$query = "SELECT $this->table_name.id, $this->table_name.name, $this->table_name.status,$this->table_name.cost_usdollar, $this->table_name.discount_usdollar, $this->table_name.list_usdollar, $this->table_name.cost_price, $this->table_name.discount_price, $this->table_name.list_price, $this->table_name.mft_part_num FROM $this->table_name ";
		$where_auto = "$this->table_name.deleted=0";

/*
                                $query = "SELECT
                                $this->table_name.*,
                                $this->rel_manufacturers.name as manufacturer_name,
                                $this->rel_categories.name as category_name,
                                $this->rel_types.name as type_name,
                                users.user_name as assigned_user_name
                                FROM $this->table_name
                                LEFT JOIN $this->rel_manufacturers
                                ON $this->table_name.manufacturer_id=$this->rel_manufacturers.id
								";

                $where_auto = "$this->table_name.deleted=0
								AND $this->rel_manufacturers.deleted=0
								";
*/

 /*               if($where != "")
                        $query .= "where ($where) AND ".$where_auto;
                else
                        $query .= "where ".$where_auto;

                if(!empty($order_by))
                        $query .= " ORDER BY $order_by";

                return $query;
        }


*/
	function save_relationship_changes($is_update)
    {


    }


	function clear_productbundle_product_relationship($bundle_id)
	{
		$query = "delete from $this->rel_products where (bundle_id='$bundle_id') and deleted=0";
		$this->db->query($query,true,"Error clearing product bundle to product relationship: ");
	}

	function clear_product_productbundle_relationship($product_id)
	{
		$query = "delete from $this->rel_products where (product_id='$product_id') and deleted=0";
		$this->db->query($query,true,"Error clearing product to product bundle relationship: ");
	}

	function retrieve_productbundle_from_product($product_id){
		$query = "SELECT bundle_id FROM $this->rel_products where (product_id='$product_id') and deleted=0";
		$result = $this->db->query($query,true,"Error retrieving product bundle for product $product_id ");
		if($row = $this->db->fetchByAssoc($result)){
			$this->retrieve($row['bundle_id']);
			return true;
		}
		return false;
	}

	function in_productbundle_from_product($product_id){
		$query = "SELECT bundle_id FROM $this->rel_products where (product_id='$product_id') and deleted=0";
		$result = $this->db->query($query,true,"Error retrieving product bundle for product $product_id ");
		if($row = $this->db->fetchByAssoc($result)){
			return true;
		}
		return false;
	}

	function set_productbundle_product_relationship($product_id, $product_index, $bundle_id='')
	{
		if(empty($bundle_id)){
			$bundle_id = $this->id;
		}
		$query = "insert into $this->rel_products (id,product_index,product_id,bundle_id, date_modified) VALUES ('".create_guid()."','$product_index', '$product_id', '$bundle_id', ".db_convert("'".TimeDate::getInstance()->nowDb()."'", 'datetime').")";
		$this->db->query($query,true,"Error setting product to product bundle relationship: "."<BR>$query");
		$GLOBALS['log']->debug("Setting product to product bundle relationship for $product_id and $bundle_id");
	}

    function set_product_bundle_note_relationship($note_index, $note_id, $bundle_id='')
    {
    	if(empty($bundle_id)){
    		$bundle_id = $this->id;
    	}

    	$query = "INSERT INTO $this->rel_notes (id,bundle_id,note_id,note_index, date_modified) VALUES ('".create_guid()."','".$bundle_id."','".$note_id."','".$note_index."', ".db_convert("'".TimeDate::getInstance()->nowDb()."'", 'datetime').")";

    	$this->db->query($query, true, "Error setting note to product to product bundle relationship: "."<BR>$query");
    	$GLOBALS['log']->debug("Setting note to product to product bundle relationship for bundle_id: $bundle_id, note_index: $note_index, and note_id: $note_id");
    }

    function clear_product_bundle_note_relationship($bundle_id='')
    {
    	$query = "DELETE FROM $this->rel_notes WHERE (bundle_id='$bundle_id') AND deleted=0";

    	$this->db->query($query, true, "Error clearing note to product to product bundle relationship");
    }
	function clear_productbundle_quote_relationship($bundle_id)
	{
		$query = "delete from $this->rel_quotes where (bundle_id='$bundle_id') and deleted=0";
		$this->db->query($query,true,"Error clearing product bundle to quote relationship: ");
	}

	function clear_quote_productbundle_relationship($quote_id)
	{
		$query = "delete from $this->rel_quotes where (quote_id='$quote_id') and deleted=0";
		$this->db->query($query,true,"Error clearing quote to product bundle relationship: ");
	}

    function set_productbundle_quote_relationship($quote_id, $bundle_id, $bundle_index = '0')
	{
		if(empty($bundle_id)){
			$bundle_id = $this->id;
		}
		$query = "insert into $this->rel_quotes (id,quote_id,bundle_id,bundle_index, date_modified) values (" . $this->db->quoted(create_guid()) . ", " . $this->db->quoted($quote_id) . ", " . $this->db->quoted($bundle_id) . ", " . $this->db->quoted($bundle_index) . ", " . $this->db->convert($this->db->quoted(TimeDate::getInstance()->nowDb()), 'datetime') . ")";
        $this->db->query($query,true,"Error setting quote to product bundle relationship: "."<BR>$query");
		$GLOBALS['log']->debug("Setting quote to product bundle relationship for $quote_id and $bundle_id");
	}



	function mark_relationships_deleted($id)
	{
		$this->clear_productbundle_product_relationship($id);
		$this->clear_productbundle_quote_relationship($id);
	}

	function fill_in_additional_list_fields()
	{
		$this->fill_in_additional_detail_fields();
	}

	function fill_in_additional_detail_fields()
	{
		
		$currency = BeanFactory::getBean('Currencies', $this->currency_id);
		if($currency->id != $this->currency_id || $currency->deleted == 1){
				$this->tax = $this->tax_usdollar;
				$this->shipping = $this->shipping_usdollar;
				$this->subtotal = $this->subtotal_usdollar;
				$this->total = $this->total_usdollar;
				$this->currency_id = $currency->id;
		}

	}


	/** Returns a list of the associated opportunities
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_list_view_data(){
		global $current_language, $app_strings, $app_list_strings;
//		global $support_expired, $support_coming_due, $support_coming_due_color, $support_expired_color;
		$product_mod_strings = return_module_language($current_language, "Products");
		include('modules/Products/config.php');

		$symbol = $currency->getDefaultCurrencySymbol();
		global $current_user;
		
		$currency = BeanFactory::getBean('Currencies');
		if($current_user->getPreference('currency') ){
			$currency->retrieve($current_user->getPreference('currency'));
			$symbol = $currency->symbol;
		}else{
			$currency->retrieve('-99');
			$symbol = $currency->symbol;
		}


		return  Array(
			'ID' => $this->id,
			'NAME' => (($this->name == "") ? "<em>blank</em>" : $this->name),
			'SHIPPING' =>  $symbol.'&nbsp;'. number_format(round($currency->convertFromDollar($this->shipping_usdollar),2),2,'.',''),
			'TAX' =>  $symbol.'&nbsp;'. number_format(round($currency->convertFromDollar($this->tax_usdollar),2),2,'.',''),
			'TOTAL' =>  $symbol.'&nbsp;'. number_format(round($currency->convertFromDollar($this->total_usdollar),2),2,'.',''),
			'SUBTOTAL' =>  $symbol.'&nbsp;'. number_format(round($currency->convertFromDollar($this->subtotal_usdollar),2),2,'.',''),
		);
	}
	/**
		builds a generic search based on the query string using or
		do not include any $this-> because this is called on without having the class instantiated
	*/
	function build_generic_where_clause ($the_query_string) {
	$where_clauses = Array();
	$the_query_string = $GLOBALS['db']->quote($the_query_string);
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
    $currency = BeanFactory::getBean('Currencies', $this->currency_id);
    $this->base_rate = $currency->conversion_rate;
    //US DOLLAR
    if (!empty($this->tax)) {
        $this->tax_usdollar = SugarCurrency::convertWithRate($this->tax, $this->base_rate);
    }
    if (isset($this->shipping) && !empty($this->shipping)) {
        $this->shipping_usdollar = SugarCurrency::convertWithRate($this->shipping, $this->base_rate);
    }
    if (isset($this->total) && !empty($this->total)) {
        $this->total_usdollar = SugarCurrency::convertWithRate($this->total, $this->base_rate);
    }
    if (isset($this->subtotal) && !empty($this->subtotal)) {
        $this->subtotal_usdollar = SugarCurrency::convertWithRate($this->subtotal, $this->base_rate);
    }
    if (isset($this->deal_tot) && !empty($this->deal_tot)) {
        $this->deal_tot_usdollar = SugarCurrency::convertWithRate($this->deal_tot, $this->base_rate);
    }
    if (isset($this->new_sub) && !empty($this->new_sub)) {
        $this->new_sub_usdollar = SugarCurrency::convertWithRate($this->new_sub, $this->base_rate);
    }
    $this->id = parent::save($check_notify);

    return $this->id;
}

    /**
     * Compare Product and(or) ProductBundleNote objects by {record}_index field
     * 
     * @param object $obj1
     * @param object $obj2
     * @return int
     */
    protected static function compareProductOrNoteIndexAsc($obj1, $obj2)
    {
        $firstValue = ($obj1 instanceof Product) ? $obj1->product_index : $obj1->note_index;
        $secondValue = ($obj2 instanceof Product) ? $obj2->product_index : $obj2->note_index;

        if ($firstValue == $secondValue) {
            return 0;
        } 
        return ($firstValue < $secondValue) ? -1 : 1;
    }

    /**
     * Compare Product Bundles by bundle index
     * 
     * @param object $pb1
     * @param object $pb2
     * @return int
     */
    public static function compareProductBundlesByIndex($pb1, $pb2)
    {
        if ($pb1->bundle_index == $pb2->bundle_index) {
            return 0;
        } 
        return ($pb1->bundle_index < $pb2->bundle_index) ? -1 : 1;
    }
}
?>
