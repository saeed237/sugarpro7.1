<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

// Product is used to store customer information.
class RevenueLineItem extends SugarBean
{
    const STATUS_CONVERTED_TO_QUOTE = 'Converted to Quote';

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
    public $product_type;

    /**
     * @public String      The Current Sales Stage
     */
    public $sales_stage;

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
    public $opportunity_id;
    public $opportunity_name;
    public $contact_name;
    public $contact_id;
    public $related_product_id;
    public $contracts;
    public $product_index;

    public $table_name = "revenue_line_items";
    public $rel_manufacturers = "manufacturers";
    public $rel_types = "product_types";
    public $rel_products = "product_product";
    public $rel_categories = "product_categories";

    public $object_name = "RevenueLineItem";
    public $module_dir = 'RevenueLineItems';
    public $new_schema = true;
    public $importable = true;

    public $experts;

    // This is used to retrieve related fields from form posts.
    public $additional_column_fields = array('quote_id', 'quote_name', 'related_product_id');
    

    /**
     * Default Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->team_id = 1; // make the item globally accessible

        $currency = BeanFactory::getBean('Currencies');
        $this->default_currency_symbol = $currency->getDefaultCurrencySymbol();
    }

    /**
     * Get summary text
     */
    public function get_summary_text()
    {
        return "$this->name";
    }

    /**
     * To check whether currency_id field is changed during save.
     * @return bool true if currency_id is changed, false otherwise
     */
    protected function isCurrencyIdChanged() {
        // if both are defined, compare
        if (isset($this->currency_id) && isset($this->fetched_row['currency_id'])) {
            if ($this->currency_id != $this->fetched_row['currency_id']) {
                return true;
            }
        }
        // one is not defined, the other one is not empty, means changed
        if (!isset($this->currency_id) && !empty($this->fetched_row['currency_id'])) {
            return true;
        }
        if (!isset($this->fetched_row['currency_id']) && !empty($this->currency_id)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function save($check_notify = false)
    {
        //If an opportunity_id value is provided, lookup the Account information (if available)
        if (!empty($this->opportunity_id)) {
            $this->setAccountIdForOpportunity($this->opportunity_id);
        }

        /* @var $currency Currency */
        $currency = BeanFactory::getBean('Currencies', $this->currency_id);
        // RPS - begin - decimals cant be null in sql server

        if (empty($this->best_case)) {
            $this->best_case = $this->likely_case;
        }
        if (empty($this->worst_case)) {
            $this->worst_case = $this->likely_case;
        }
        
        if ($this->quantity == '') {
            $this->quantity = 1;
        }

        // if stage is not closed won/lost, update base_rate with currency rate
        if (!in_array($this->sales_stage, $this->getClosedStages()) || !isset($this->base_rate) || $this->isCurrencyIdChanged()) {
            $currency = SugarCurrency::getCurrencyByID($this->currency_id);
            $this->base_rate = $currency->conversion_rate;
        }

        //US DOLLAR
        if (isset($this->discount_price) && (!empty($this->discount_price) || $this->discount_price == '0')) {
            $this->discount_usdollar = $currency->convertToDollar($this->discount_price);
        }
        if (isset($this->list_price) && (!empty($this->list_price) || $this->list_price == '0')) {
            $this->list_usdollar = $currency->convertToDollar($this->list_price);
        }
        if (isset($this->cost_price) && (!empty($this->cost_price) || $this->cost_price == '0')) {
            $this->cost_usdollar = $currency->convertToDollar($this->cost_price);
        }
        if (isset($this->book_value) && (!empty($this->book_value) || $this->book_value == '0')) {
            $this->book_value_usdollar = $currency->convertToDollar($this->book_value);
        }
        if (isset($this->deal_calc) && (!empty($this->deal_calc) || $this->deal_calc == '0')) {
            $this->deal_calc_usdollar = $currency->convertToDollar($this->deal_calc);
        }
        if (isset($this->discount_amount) && (!empty($this->discount_amount) || $this->discount_amount == '0')) {
            if (isset($this->discount_select) && $this->discount_select) {
                $this->discount_amount_usdollar = $this->discount_amount;
            } else {
                $this->discount_amount_usdollar = $currency->convertToDollar($this->discount_amount);
            }
        }

        if ($this->probability === '') {
            $this->mapProbabilityFromSalesStage();
        }
        
        $this->mapFieldsFromProductTemplate();
        $this->mapFieldsFromOpportunity();

        $id = parent::save($check_notify);

        return $id;
    }
    
    /**
     * Override the current SugarBean functionality to make sure that when this method is called that it will also
     * take care of any draft worksheets by rolling-up the data
     *
     * @param string $id            The ID of the record we want to delete
     */
    public function mark_deleted($id)
    {
        parent::mark_deleted($id);
           
    }


    /**
     * map fields if opportunity id is set
     */
    protected function mapFieldsFromOpportunity()
    {
        if (!empty($this->opportunity_id) && empty($this->product_type)) {
            $opp = BeanFactory::getBean('Opportunities', $this->opportunity_id);
            $this->product_type = $opp->opportunity_type;
        }
    }

    /**
     * Handling mapping the probability from the sales stage.
     */
    protected function mapProbabilityFromSalesStage()
    {
        global $app_list_strings;
        if (!empty($this->sales_stage)) {
            $prob_arr = $app_list_strings['sales_probability_dom'];
            if (isset($prob_arr[$this->sales_stage])) {
                $this->probability = $prob_arr[$this->sales_stage];
            }
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

    /**
     * Handle the mapping of the fields from the product template to the product
     */
    protected function mapFieldsFromProductTemplate()
    {
        if (!empty($this->product_template_id)
            && $this->fetched_row['product_template_id'] != $this->product_template_id
        ) {
            /* @var $pt ProductTemplate */
            $pt = BeanFactory::getBean('ProductTemplates', $this->product_template_id);

            $this->category_id = $pt->category_id;
            $this->mft_part_num = $pt->mft_part_num;
            $this->list_price = SugarCurrency::convertAmount($pt->list_price, $pt->currency_id, $this->currency_id);
            $this->cost_price = SugarCurrency::convertAmount($pt->cost_price, $pt->currency_id, $this->currency_id);
            $this->discount_price = SugarCurrency::convertAmount($pt->discount_price, $pt->currency_id, $this->currency_id); // discount_price = unit price on the front end...
            $this->list_usdollar = $pt->list_usdollar;
            $this->cost_usdollar = $pt->cost_usdollar;
            $this->discount_usdollar = $pt->discount_usdollar;
            $this->tax_class = $pt->tax_class;
            $this->weight = $pt->weight;
        }
    }

    /**
     * {@inheritdoc}
     */
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
     * Converts (copies) RLI to Products (QuotedLineItem)
     * @return Product
     */
    public function convertToQuotedLineItem()
    {
        /* @var $product Product */
        $product = BeanFactory::getBean('Products');
        $product->id = create_guid();
        $product->new_with_id = true;
        foreach ($this->getFieldDefinitions() as $field) {
            if ($field['name'] == 'id') {
                // if it's the ID field, associate it back to the product on the relationship field
                $product->revenuelineitem_id = $this->$field['name'];
            } else {
                $product->$field['name'] = $this->$field['name'];
            }
        }
        // use product name if available
        if (!empty($this->product_template_id)) {
            $pt = BeanFactory::getBean('ProductTemplates', $this->product_template_id);
            if (!empty($pt) && !empty($pt->name)) {
                $product->name = $pt->name;
            }
        }
        // if discount_price (unit_price) is not set, use likely_case
        if (strlen($this->discount_price) == 0) {
            $product->discount_price = $this->likely_case;
        }
        return $product;
    }

    /**
     * getClosedStages
     *
     * Return an array of closed stage names from the admin bean.
     *
     * @access protected
     * @return array array of closed stage values
     */
    public function getClosedStages()
    {
        $admin = BeanFactory::getBean('Administration');
        $settings = $admin->getConfigForModule('Forecasts');

        // get all possible closed stages
        $stages = array_merge(
            (array)$settings['sales_stage_won'],
            (array)$settings['sales_stage_lost']
        );
        // db quote values
        foreach($stages as $stage_key => $stage_value) {
            $stages[$stage_key] = $this->db->quote($stage_value);
        }
        return $stages;
    }

}
