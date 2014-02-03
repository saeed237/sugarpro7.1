<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


// Product is used to store customer information.
class Product extends SugarBean
{
    CONST STATUS_CONVERTED_TO_QUOTE = 'Converted to Quote';

    const STATUS_QUOTED = 'Quotes';

    // Stored fields
    public $id;
    public $deleted;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $created_by;
    public $created_by_name;
    public $modified_by_name;
    public $field_name_map;
    public $name;
    public $product_template_id;
    public $description;
    public $vendor_part_num;
    public $cost_price;
    public $discount_price;
    public $list_price;
    public $list_usdollar;
    public $discount_usdollar;
    public $cost_usdollar;
    public $deal_calc;
    public $deal_calc_usdollar;
    public $discount_amount_usdollar;
    public $currency_id;
    public $mft_part_num;
    public $status;
    public $date_purchased;
    public $weight;
    public $quantity;
    public $website;
    public $tax_class;
    public $support_name;
    public $support_description;
    public $support_contact;
    public $support_term;
    public $date_support_expires;
    public $date_support_starts;
    public $pricing_formula;
    public $pricing_factor;
    public $team_id;
    public $serial_number;
    public $asset_number;
    public $book_value;
    public $book_value_usdollar;
    public $book_value_date;
    public $currency_symbol;
    public $currency_name;
    public $default_currency_symbol;
    public $discount_amount;
    public $best_case = 0;
    public $likely_case = 0;
    public $worst_case = 0;
    public $base_rate;
    public $probability;
    public $date_closed;
    public $date_closed_timestamp;
    public $commit_stage;
    public $opportunity_id;
    public $product_type;

    // These are for related fields
    public $assigned_user_id;
    public $assigned_user_name;
    public $type_name;
    public $type_id;
    public $quote_id;
    public $quote_name;
    public $manufacturer_name;
    public $manufacturer_id;
    public $category_name;
    public $category_id;
    public $account_name;
    public $account_id;
    public $contact_name;
    public $contact_id;
    public $related_product_id;
    public $contracts;
    public $product_index;
    public $revenuelineitem_id;


    /**
     * Don't update the quote on save.
     *
     * @var bool
     */
    public $ignoreQuoteSave = false;

    public $table_name = "products";
    public $rel_manufacturers = "manufacturers";
    public $rel_types = "product_types";
    public $rel_products = "product_product";
    public $rel_categories = "product_categories";

    public $object_name = "Product";
    public $module_dir = 'Products';
    public $new_schema = true;
    public $importable = true;

    public $experts;

    // This is used to retrieve related fields from form posts.
    public $additional_column_fields = array('quote_id', 'quote_name', 'related_product_id');

    public $relationship_fields = array('account_id'=> 'account_link', 'related_product_id' => 'related_products');


    // This is the list of fields that are copied over from product template.
    public $template_fields = array(
        'mft_part_num',
        'vendor_part_num',
        'website',
        'tax_class',
        'manufacturer_id',
        'type_id',
        'category_id',
        'team_id',
        'weight',
        'support_name',
        'support_term',
        'support_description',
        'support_contact',
        'description',
        'cost_price',
        'discount_price',
        'list_price',
    );

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Product()
    {
        self::__construct();
    }

    public function __construct()
    {

        parent::__construct();

        $this->team_id = 1; // make the item globally accessible

        $currency = BeanFactory::getBean('Currencies');
        $this->default_currency_symbol = $currency->getDefaultCurrencySymbol();


    }


    public function get_summary_text()
    {
        return "$this->name";
    }


    public function fill_in_additional_list_fields()
    {
        $this->fill_in_additional_detail_fields();
    }

    /**
     * get_list_view_data
     * Returns a list view of the associated Products.  This view is used in the Subpanel
     * listings.
     *
     */
    public function get_list_view_data()
    {
        global $current_language, $app_strings, $app_list_strings, $current_user, $timedate, $locale;
        $product_mod_strings = return_module_language($current_language,"Products");
        require('modules/Products/config.php');
        //$this->format_all_fields();

        if ($this->date_purchased == '0000-00-00') {
            $the_date_purchased = '';
        } else {
            $the_date_purchased = $this->date_purchased;
            $db_date_purchased = $timedate->to_db_date($this->date_purchased, false);

        }
        $the_date_support_expires = $this->date_support_expires;
        $db_date_support_expires = $timedate->to_db_date($this->date_support_expires, false);

        $expired = $timedate->asDbDate($timedate->getNow()->get($support_expired));
        $coming_due = $timedate->asDbDate($timedate->getNow()->get($support_coming_due));

        /**
         * Convert price related data into users preferred currency
         * for display in subpanels
         */
        // See if a user has a preferred currency
        if ($current_user->getPreference('currency')) {
            // Retrieve the product currency
            $currency = BeanFactory::getBean('Currencies', $this->currency_id);
            // Retrieve the users currency
            $userCurrency = BeanFactory::getBean('Currencies', $current_user->getPreference('currency'));
            // If the product currency and the user default currency are different, convert to users currency
            if ($userCurrency->id != $currency->id) {
                $this->cost_price = $userCurrency->convertFromDollar($currency->convertToDollar($this->cost_price));
                $this->discount_price = $userCurrency->convertFromDollar(
                    $currency->convertToDollar($this->discount_price)
                );
                $this->list_price = $userCurrency->convertFromDollar($currency->convertToDollar($this->list_price));
                $this->deal_calc = $userCurrency->convertFromDollar($currency->convertToDollar($this->deal_calc));

                if (!(isset($this->discount_select) && $this->discount_select)) {
                    $this->discount_amount = $userCurrency->convertFromDollar(
                        $currency->convertToDollar($this->discount_amount)
                    );
                }

                $this->currency_symbol = $userCurrency->symbol;
                $this->currency_name = $userCurrency->name;
                $this->currency_id = $userCurrency->id;
            }
        }

        if (!empty($the_date_support_expires) && $db_date_support_expires < $expired) {
            $the_date_support_expires = "<strong><font color='$support_expired_color'>$the_date_support_expires</font></strong>";
        }
        if (!empty($the_date_support_expires) && $db_date_support_expires < $coming_due) {
            $the_date_support_expires = "<strong><font color='$support_coming_due_color'>$the_date_support_expires</font></strong>";
        }
        if ($this->date_support_expires == '0000-00-00') {
            $the_date_support_expires = '';
        }

        $temp_array = $this->get_list_view_array();
        $temp_array['NAME'] = (($this->name == "") ? "<em>blank</em>" : $this->name);
        if (!empty($this->status)) {
            $temp_array['STATUS'] = $app_list_strings['product_status_dom'][$this->status];
        }
        $temp_array['ENCODED_NAME'] = $this->name;
        $temp_array['DATE_SUPPORT_EXPIRES'] = $the_date_support_expires;
        $temp_array['DATE_PURCHASED'] = $the_date_purchased;


        $params['currency_id'] = $this->currency_id;
        $temp_array['LIST_PRICE'] = $this->list_price;
        $temp_array['DISCOUNT_PRICE'] = $this->discount_price;
        $temp_array['COST_PRICE'] = $this->cost_price;
        if (isset($this->discount_select) && $this->discount_select) {
            $temp_array['DISCOUNT_AMOUNT'] = $this->discount_amount . "%";
        } else {
            $temp_array['DISCOUNT_AMOUNT'] = $this->discount_amount;
        }

        $temp_array['ACCOUNT_NAME'] = empty($this->account_name) ? '' : $this->account_name;
        $temp_array['CONTACT_NAME'] = empty($this->contact_name) ? '' : $this->contact_name;
        return $temp_array;
    }

    /**
    builds a generic search based on the query string using or
    do not include any $this-> because this is called on without having the class instantiated
     */
    public function build_generic_where_clause($the_query_string)
    {
        $where_clauses = array();
        $the_query_string = $GLOBALS['db']->quote($the_query_string);
        array_push($where_clauses, "name like '$the_query_string%'");
        if (is_numeric($the_query_string)) {
            array_push($where_clauses, "mft_part_num like '%$the_query_string%'");
            array_push($where_clauses, "vendor_part_num like '%$the_query_string%'");
        }

        $the_where = "";
        foreach ($where_clauses as $clause) {
            if ($the_where != "") {
                $the_where .= " or ";
            }
            $the_where .= $clause;
        }


        return $the_where;
    }

    public function save($check_notify = false)
    {

        //If an opportunity_id value is provided, lookup the Account information (if available)
        if (!empty($this->opportunity_id)) {
            $this->setAccountIdForOpportunity($this->opportunity_id);
        }

        /* @var $currency Currency */
        $currency = BeanFactory::getBean('Currencies', $this->currency_id);

        $this->populateFromTemplate();

        // RPS - begin - decimals cant be null in sql server
        if ($this->cost_price == '') {
            $this->cost_price = 0;
        }
        if ($this->discount_price == '') {
            $this->discount_price = 0;
        }
        if ($this->list_price == '') {
            $this->list_price = 0;
        }
        if ($this->weight == '') {
            $this->weight = 0;
        }
        if ($this->book_value == '') {
            $this->book_value = 0;
        }
        if ($this->discount_amount == '') {
            $this->discount_amount = 0;
        }
        if ($this->deal_calc == '') {
            $this->deal_calc = 0;
        }

        if ($this->quantity == '') {
            $this->quantity = 1;
        }

        $this->calculateDiscountPrice();

        // always set the base rate to what the conversion_rate is in the currency
        $this->base_rate = $currency->conversion_rate;

        //US DOLLAR
        $varsToConvert = array(
            'discount_price' => 'discount_usdollar',
            'list_price' => 'list_usdollar',
            'cost_price' => 'cost_usdollar',
            'book_value' => 'book_value_usdollar',
            'deal_calc' => 'deal_calc_usdollar',
        );
        
        foreach ( $varsToConvert as $fromVar => $toVar ) {
            if (!empty($this->$fromVar)) {
                $this->$toVar = $currency->convertToDollar($this->$fromVar);
            } else {
                $this->$toVar = 0.00;
            }
        }
        if (isset($this->discount_amount) && (!empty($this->discount_amount) || $this->discount_amount == '0')) {
            if (isset($this->discount_select) && $this->discount_select) {
                $this->discount_amount_usdollar = $this->discount_amount;
            } else {
                $this->discount_amount_usdollar = $currency->convertToDollar($this->discount_amount);
            }
        }

        
        $this->convertDateClosedToTimestamp();
        $this->mapFieldsFromOpportunity();

        $id = parent::save($check_notify);

        // We need to update the associated product bundle and quote totals that might be impacted by this product.
        if (isset($id) && $this->ignoreQuoteSave === false) {
            $tax_rate = 0.00;
            $query = "select * from quotes INNER JOIN taxrates on quotes.taxrate_id=taxrates.id where quotes.id='" . $this->quote_id . "' and quotes.deleted=0 and taxrates.deleted=0";
            $result = $this->db->query($query);
            if ($row = $this->db->fetchByAssoc($result)) {
                $tax_rate = $row['value'] / 100;
                $shipping_usdollar = is_numeric($row['shipping_usdollar']) ? $row['shipping_usdollar'] : 0.00;
            }
            $query = "select product_bundles.id as bundle_id from product_bundle_product" .
                " INNER JOIN product_bundles on product_bundles.id=product_bundle_product.bundle_id" .
                " where product_bundle_product.deleted=0 AND product_bundle_product.product_id='" . $id . "' AND product_bundles.deleted=0";
            $result = $this->db->query($query);
            if ($row = $this->db->fetchByAssoc($result)) {
                $bundle_id = $row['bundle_id'];
                $query = "select shipping_usdollar from product_bundles where id='" . $bundle_id . "' and deleted=0";
                $result = $this->db->query($query);
                if ($row = $this->db->fetchByAssoc($result)) {
                    $shipping_usdollar = is_numeric($row['shipping_usdollar']) ? $row['shipping_usdollar'] : 0.00;
                }
                $query = "select * from product_bundle_product where bundle_id='" . $bundle_id . "' and deleted=0";
                $result = $this->db->query($query);
                $new_sub_usdollar = 0.00;
                $deal_tot_usdollar = 0.00;
                $deal_tot = 0.00;
                $new_sub = 0.00;
                $subtotal_usdollar = 0.00;
                $tax_usdollar = 0.00;
                $total_usdollar = 0.00;
                if ($row = $this->db->fetchByAssoc($result)) {
                    while ($row != null) {
                        $product = BeanFactory::getBean('Products');
                        $product->id = $row['product_id'];
                        $product->retrieve();
                        $subtotal_usdollar += $product->discount_usdollar * $product->quantity;

                        if (isset($this->discount_select) && $this->discount_select) {
                            $deal_tot_usdollar += ($product->discount_amount / 100) * $product->discount_usdollar * $product->quantity;
                        } else {
                            $deal_tot_usdollar += $product->discount_amount;
                        }
                        $new_sub_usdollar = $subtotal_usdollar - $deal_tot_usdollar;
                        if ($product->tax_class == 'Taxable') {
                            $tax_usdollar += ($product->discount_usdollar * $product->quantity) * $tax_rate;

                        }
                        $row = $this->db->fetchByAssoc($result);
                    }
                    $total_usdollar += $new_sub_usdollar + $tax_usdollar + $shipping_usdollar;
                    $total = $currency->convertFromDollar($total_usdollar);
                    $subtotal = $currency->convertFromDollar($subtotal_usdollar);
                    $new_sub = $currency->convertFromDollar($new_sub_usdollar);
                    $tax = $currency->convertFromDollar($tax_usdollar);
                    $deal_tot = $currency->convertFromDollar($deal_tot_usdollar);
                    $updateQuery = "update product_bundles set tax=" . $tax . ",tax_usdollar=" . $tax_usdollar . ",total=" . $total . ",deal_tot_usdollar=" . $deal_tot_usdollar . ",deal_tot=" . $deal_tot . ",total_usdollar=" . $total_usdollar .
                        ",new_sub=" . $new_sub . ",new_sub_usdollar=" . $new_sub_usdollar . ",subtotal=" . $subtotal .
                        ",subtotal_usdollar=" . $subtotal_usdollar . " where id='" . $bundle_id . "'";
                    $result = $this->db->query($updateQuery);
                    //Update the Grand Total for the Quote
                    $subtotal_usdollar = 0.00;
                    $tax_usdollar = 0.00;
                    $total_usdollar = 0.00;
                    $shipping_usdollar = 0.00;
                    $new_sub_usdollar = 0.00;
                    $query = "select sum(product_bundles.total_usdollar) as total_usdollar,sum(product_bundles.subtotal_usdollar) as subtotal_usdollar,sum(product_bundles.new_sub_usdollar) as new_sub_usdollar,sum(product_bundles.deal_tot_usdollar) as deal_tot_usdollar,sum(product_bundles.tax_usdollar) as tax_usdollar," .
                        "sum(product_bundles.shipping_usdollar) as shipping_usdollar from product_bundle_quote INNER JOIN product_bundles on " .
                        "product_bundles.id=product_bundle_quote.bundle_id where product_bundle_quote.quote_id='" . $this->quote_id . "' " .
                        "and product_bundle_quote.deleted=0 and product_bundles.deleted=0";
                    $result = $this->db->query($query);
                    if ($row = $this->db->fetchByAssoc($result)) {
                        /*
                        while ($row != null) {
                            $subtotal_usdollar += $row['subtotal_usdollar'];
                            $tax_usdollar += $row['tax_usdollar'];
                            $shipping_usdollar += $row['shipping_usdollar'];
                            $row =  $this->db->fetchByAssoc($result);
                        }*/
                        $shipping_usdollar = is_numeric($row['shipping_usdollar']) ? $row['shipping_usdollar'] : 0.00;
                        $subtotal_usdollar = is_numeric($row['subtotal_usdollar']) ? $row['subtotal_usdollar'] : 0.00;
                        $deal_tot_usdollar = is_numeric($row['deal_tot_usdollar']) ? $row['deal_tot_usdollar'] : 0.00;
                        $new_sub_usdollar = is_numeric($row['new_sub_usdollar']) ? $row['new_sub_usdollar'] : 0.00;
                        $tax_usdollar = is_numeric($row['tax_usdollar']) ? $row['tax_usdollar'] : 0.00;
                        $total_usdollar += $row['new_sub_usdollar'] + $row['tax_usdollar'] + $shipping_usdollar;
                        $total = $currency->convertFromDollar($total_usdollar);
                        $subtotal = $currency->convertFromDollar($subtotal_usdollar);
                        $deal_tot_usdollar = $deal_tot_usdollar;
                        $deal_tot = $currency->convertFromDollar($deal_tot_usdollar);
                        $new_sub = $currency->convertFromDollar($new_sub_usdollar);
                        $tax = $currency->convertFromDollar($tax_usdollar);
                        $updateQuery = "update quotes set tax=" . $tax . ",tax_usdollar=" . $tax_usdollar . ",total=" . $total . ",total_usdollar=" . $total_usdollar . ",deal_tot=" . $deal_tot . ",deal_tot_usdollar=" . $deal_tot_usdollar . ",new_sub=" . $new_sub . ",new_sub_usdollar=" . $new_sub_usdollar . ",subtotal=" . $subtotal .
                            ",subtotal_usdollar=" . $subtotal_usdollar . " where id='" . $this->quote_id . "'";
                        $result = $this->db->query($updateQuery);
                    }

                }
            }
        }
        return $id;
    }

    /*
     * map fields if opportunity id is set
     */
    protected function mapFieldsFromOpportunity()
    {
        if(!empty($this->opportunity_id) && empty($this->product_type)) {
            $opp = BeanFactory::getBean('Opportunities', $this->opportunity_id);
            $this->product_type = $opp->opportunity_type;
        }
    }

    /**
     * Handle Converting DateClosed to a Timestamp
     */
    protected function convertDateClosedToTimestamp()
    {
        $timedate = TimeDate::getInstance();
        if ($timedate->check_matching_format($this->date_closed, TimeDate::DB_DATE_FORMAT)) {
            $date_close_db = $this->date_closed;
        } else {
            $date_close_db = $timedate->to_db_date($this->date_closed);
        }

        if (!empty($date_close_db)) {
            $date_close_datetime = $timedate->fromDbDate($date_close_db);
            $this->date_closed_timestamp = $date_close_datetime->getTimestamp();
        }
    }

    /**
     * Sets the account_id value for instance given an opportunityId argument of the Opportunity id
     *
     * @param $opportunityId String value of the Opportunity id
     * @return bool true if account_id was set; false otherwise
     */
    protected function setAccountIdForOpportunity($opportunityId)
    {
        $opp = BeanFactory::getBean('Opportunities', $opportunityId);
        if ($opp->load_relationship('accounts')) {
            $accounts = $opp->accounts->query(array('where' => 'accounts.deleted=0'));
            foreach ($accounts['rows'] as $accountId => $value) {
                $this->account_id = $accountId;
                return true;
            }
        }
        return false;
    }

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }

    public function listviewACLHelper()
    {
        $array_assign = parent::listviewACLHelper();

        $is_owner = false;
        if (!empty($this->contact_name)) {

            if (!empty($this->contact_name_owner)) {
                global $current_user;
                $is_owner = $current_user->id == $this->contact_name_owner;
            }
        }
        if (ACLController::checkAccess('Contacts', 'view', $is_owner)) {
            $array_assign['CONTACT'] = 'a';
        } else {
            $array_assign['CONTACT'] = 'span';
        }
        $is_owner = false;
        if (!empty($this->account_name)) {

            if (!empty($this->account_name_owner)) {
                global $current_user;
                $is_owner = $current_user->id == $this->account_name_owner;
            }
        }
        if (ACLController::checkAccess('Accounts', 'view', $is_owner)) {
            $array_assign['ACCOUNT'] = 'a';
        } else {
            $array_assign['ACCOUNT'] = 'span';
        }
        $is_owner = false;
        if (!empty($this->quote_name)) {

            if (!empty($this->quote_name_owner)) {
                global $current_user;
                $is_owner = $current_user->id == $this->quote_name_owner;
            }
        }
        if (ACLController::checkAccess('Quotes', 'view', $is_owner)) {
            $array_assign['QUOTE'] = 'a';
        } else {
            $array_assign['QUOTE'] = 'span';
        }

        return $array_assign;
    }

    /**
     * Converts (copies) a Products (QuotedLineItem) to a Revenue Line Item
     * @return RevenueLineItem
     */
    public function convertToRevenueLineItem()
    {
        /* @var $rli RevenueLineItem */
        $rli = BeanFactory::getBean('RevenueLineItems');
        $rli->id = create_guid();
        $rli->new_with_id = true;
        $rli->fetched_row = array();

        foreach ($this->getFieldDefinitions() as $field) {
            if ($field['name'] != 'id') {
                $rli->$field['name'] = $this->$field['name'];
                // set the fetched row, so we prevent the product_template from fetching again
                // when the re-save happens because of the relationships
                $rli->fetched_row[$field['name']] = $this->$field['name'];
            }
        }

        if (!empty($this->discount_select)) {
            // we have a percentage discount, use the deal_calc field to calculated the discount_amount field
            $rli->discount_amount = SugarMath::init($this->deal_calc)->mul($rli->quantity)->result();
        } else {
            // no percentage, so just calculate it
            $rli->discount_amount = SugarMath::init($rli->discount_amount)->mul($rli->quantity)->result();
        }

        
        // since we don't have a likely_case on products,
        if ($rli->likely_case == '0.00') {
            //undo bad math from quotes.
            $rli->likely_case = SugarMath::init()
                                ->exp(
                                    '(?+?)-?',
                                    array(
                                        $this->total_amount,
                                        $this->discount_amount,
                                        $rli->discount_amount
                                    )
                                )
                                ->result();
        }

        $this->revenuelineitem_id = $rli->id;
        $this->ignoreQuoteSave = true;
        $this->save();

        return $rli;
    }

    /**
     * This function loads in values from the product's template
     */
    protected function populateFromTemplate()
    {
        if (!isset($this->product_template_id)) {
            // No template to choose from
            return;
        }
        if (isset($this->fetched_row['product_template_id'])
            && $this->product_template_id == $this->fetched_row['product_template_id']) {
            // Templates are the same, don't do anything
            return;
        }

        $template = BeanFactory::getBean('ProductTemplates', $this->product_template_id);
        
        foreach ($this->template_fields as $template_field) {
            // Empty isn't good enough here, if they set a total to 0.00 we need to not
            // copy that from the template
            if (!empty($this->$template_field)
                || (isset($this->$template_field)
                    && ($this->$template_field === 0 || $this->$template_field === 0.0))) {
                continue;
            }
            if (isset($template->$template_field)) {
                $this->$template_field = $template->$template_field;
            }
        }
    }

    /**
     * This function calculates any requested discount from the various formulas
     */
    protected function calculateDiscountPrice()
    {
        if (!empty($this->discount_select)) {
            $this->deal_calc = $this->discount_amount/100*$this->discount_price;
        } else {
            $this->deal_calc = $this->discount_amount;
        }
        
        if (!empty($this->pricing_formula)
            || !empty($this->cost_price)
            || !empty($this->list_price)
            || !empty($this->discount_price)
            || !empty($this->pricing_factor)
            || !empty($this->discount_amount)
            || !empty($this->discount_select)) {
            require_once('modules/ProductTemplates/Formulas.php');
            refresh_price_formulas();
            global $price_formulas;
            if (isset($price_formulas[$this->pricing_formula])) {
                include_once ($price_formulas[$this->pricing_formula]);
                $formula = new $this->pricing_formula;
                $this->discount_price = $formula->calculate_price($this->cost_price,$this->list_price,$this->discount_price,$this->pricing_factor);
            }
        }
        

    }
}
