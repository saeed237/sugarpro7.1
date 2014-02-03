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
 * Stores Temporary Forecasts Information for a given user
 */
class Worksheet extends SugarBean {

    public $id;
    public $user_id;
    public $timeperiod_id;
    public $forecast_type;
    public $related_id;
    public $related_forecast_type;
    public $currency_id;
    public $base_rate;
    public $best_case;
    public $likely_case;
    public $worst_case;
    public $date_modified;
    public $modified_user_id;
    public $deleted;
    public $commit_stage;
    public $op_probability;
    public $quota;
    public $version;
    public $revision;

    public $table_name = "worksheet";

    public $object_name = "Worksheet";
    public $module_name = 'Worksheet';
    public $disable_custom_fields = true;

    // This is used to retrieve related fields from form posts.
    public $additional_column_fields = Array('');

    public $new_schema = true;
    public $module_dir = 'Forecasts';
    
    public function __construct() {
        parent::__construct();
        $this->disable_row_level_security = true;
    }

    /**
     * Save method
     * 
     * @param bool $check_notify
     * @return String|void
     */
    public function save($check_notify = false){
        if(empty($this->id) || $this->new_with_id == true) {
        	$currency = SugarCurrency::getBaseCurrency();
            $this->currency_id = $currency->id;
            $this->base_rate = $currency->conversion_rate;
        }
        $this->revision = microtime(true);
        
        return parent::save($check_notify);
    }

    /**
     * Get the Summary text For this bean.
     * 
     * @return string
     */
    public function get_summary_text() {
        return $this->id;
    }

    /**
     * Not sure what what method does as it's not used anywhere in the code.
     * 
     * @deprecated
     * @return mixed
     */
    public function is_authenticated()
    {
        return $this->authenticated;
    }

}
