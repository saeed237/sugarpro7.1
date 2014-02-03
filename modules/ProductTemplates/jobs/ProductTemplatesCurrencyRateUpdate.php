<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once('include/SugarCurrency/CurrencyRateUpdateAbstract.php');

/**
 * OpportunitiesCurrencyRateUpdate
 *
 * A class for updating currency rates on specified database table columns
 * when a currency conversion rate is updated by the administrator.
 *
 */
class ProductTemplatesCurrencyRateUpdate extends CurrencyRateUpdateAbstract
{
    /**
     * constructor
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        // set rate field definitions
        $this->addRateColumnDefinition('product_templates', 'base_rate');
        // set usdollar field definitions
        $this->addUsDollarColumnDefinition('product_templates', 'list_price', 'list_usdollar');
        $this->addUsDollarColumnDefinition('product_templates', 'cost_price', 'cost_usdollar');
        $this->addUsDollarColumnDefinition('product_templates', 'discount_price', 'discount_usdollar');
    }

}
