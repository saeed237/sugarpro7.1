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
require_once('include/api/SugarApi.php');
class RevenueLineItemToQuoteConvertApi extends SugarApi
{
    /**
     * {@inheritdoc}
     */
    public function registerApiRest()
    {
        return array(
            'convert' => array(
                'reqType' => 'POST',
                'path' => array('RevenueLineItems', '?', 'quote'),
                'pathVars' => array('module', 'record', 'action'),
                'method' => 'convertToQuote',
                'shortHelp' => 'Convert a Revenue Line Item Into A Quote Record',
                'longHelp' => 'modules/RevenueLineItems/clients/base/api/help/convert_to_quote.html',
            ),
            'multiconvert' => array(
                'reqType' => 'POST',
                'path' => array('RevenueLineItems', 'multi-quote'),
                'pathVars' => array('module', 'action'),
                'method' => 'multiConvertToQuote',
                'shortHelp' => 'Convert a Revenue Line Item Into A Quote Record',
                'longHelp' => 'modules/RevenueLineItems/clients/base/api/help/multi_convert_to_quote.html',
            )
        );
    }

    /**
     * Converts multiple Revenue Line Items into a single Quote.
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionNotFound
     */
    public function multiConvertToQuote(ServiceBase $api, array $args)
    {
        if (empty($args['records'])) {
            // no products passed in
            throw new SugarApiExceptionNotFound();
        }

        /* @var $opp Opportunity */
        $opp = BeanFactory::getBean('Opportunities', $args['opportunity_id']);

        // now that we have the product bundle, lets create the quote
        /* @var $quote Quote */
        $quote = BeanFactory::getBean('Quotes');
        $quote->id = create_guid();
        $quote->new_with_id = true;
        $quote->name = $opp->name;

        // lets create a new bundle
        $product_bundle = $this->createProductBundleFromRLIList($args['records'], $quote->id);

        $quote->total = $product_bundle->total;
        $quote->total_usdollar = $product_bundle->total_base;
        $quote->subtotal = $product_bundle->total;
        $quote->subtotal_usdollar = $product_bundle->total_base;
        $quote->deal_tot = $product_bundle->total;
        $quote->deal_tot_usdollar = $product_bundle->total_base;
        $quote->new_sub = $product_bundle->total;
        $quote->new_sub_usdollar = $product_bundle->total_base;
        $quote->tax = 0.00;
        $quote->tax_usdollar = 0.00;
        $quote->currency_id = $opp->currency_id;
        $quote->opportunity_id = $opp->id;
        $quote->quote_stage = "Draft";
        $quote->assigned_user_id = $GLOBALS['current_user']->id;

        $this->setQuoteAccountInfo($opp->account_id, $quote);

        $quote->save();

        $quote->set_relationship(
            'product_bundle_quote',
            array('quote_id' => $quote->id, 'bundle_id' => $product_bundle->id, 'bundle_index' => 0)
        );

        return array('id' => $quote->id, 'name' => $quote->name);
    }

    /**
     * Converts RLI to a quote
     * 
     * @param ServiceBase api
     * @param array args
     * 
     * @returns array Quote ID and name of new quote
     */
    public function convertToQuote(ServiceBase $api, array $args)
    {
        // load up the Product
        /* @var $rli RevenueLineItem */
        $rli = BeanFactory::getBean('RevenueLineItems', $args['record']);

        if (empty($rli->id)) {
            // throw a 404 (Not Found) if the rli is not found
            throw new SugarApiExceptionNotFound();
        }

        /* @var $opp Opportunity */
        $opp = BeanFactory::getBean('Opportunities', $rli->opportunity_id);

        // now that we have the product bundle, lets create the quote
        /* @var $quote Quote */
        $quote = BeanFactory::getBean('Quotes');
        $quote->id = create_guid();
        $quote->new_with_id = true;
        $quote->name = $opp->name;

        // lets create a new bundle
        $product_bundle = $this->createProductBundleFromRLIList(array($args['record']), $quote->id);

        $quote->set_relationship(
            'product_bundle_quote',
            array('quote_id' => $quote->id, 'bundle_id' => $product_bundle->id, 'bundle_index' => 0)
        );

        $quote->total = $product_bundle->total;
        $quote->total_usdollar = $product_bundle->total_base;
        $quote->subtotal = $product_bundle->total;
        $quote->subtotal_usdollar = $product_bundle->total_base;
        $quote->deal_tot = $product_bundle->total;
        $quote->deal_tot_usdollar = $product_bundle->total_base;
        $quote->new_sub = $product_bundle->total;
        $quote->new_sub_usdollar = $product_bundle->total_base;
        $quote->tax = 0.00;
        $quote->tax_usdollar = 0.00;
        // quote should default to same currency as RLI
        $quote->currency_id = $rli->currency_id;
        $quote->base_rate = $rli->base_rate;
        $quote->opportunity_id = $opp->id;
        $quote->quote_stage = "Draft";
        $quote->assigned_user_id = $GLOBALS['current_user']->id;

        $this->setQuoteAccountInfo($opp->account_id, $quote);

        $quote->save();

        return array('id' => $quote->id, 'name' => $quote->name);
    }

    /**
     * Take a list of RLI's and make them into a new Product Bundle
     *
     * @param array $rlis
     * @param string $quote_id      The id for the quote we are creating
     * @return ProductBundle
     */
    protected function createProductBundleFromRLIList(array $rlis, $quote_id = null)
    {
        /* @var $product_bundle ProductBundle */
        $product_bundle = BeanFactory::getBean('ProductBundles');
        $product_bundle->id = create_guid();
        $product_bundle->new_with_id = true;
        $total = 0;
        $total_base = 0;

        foreach ($rlis as $key => $rli_id) {

            /* @var $rli RevenueLineItem */
            $rli = BeanFactory::getBean('RevenueLineItems', $rli_id);

            /* @var $product Product */
            $product = $rli->convertToQuotedLineItem();

            $product_total = SugarMath::init()->exp(
                "?*?",
                array($product->quantity, $product->likely_case)
            )->result();

            $total = SugarMath::init($total)->add($product_total)->result();
            $total_base = SugarMath::init($total_base)->add(
                SugarCurrency::convertWithRate($product_total, $product->base_rate)
            )->result();

            $product_bundle->set_relationship(
                'product_bundle_product',
                array('bundle_id' => $product_bundle->id, 'product_id' => $product->id, 'product_index' => ($key + 1))
            );

            if (!is_null($quote_id)) {
                $product->quote_id = $quote_id;
                $product->status = Product::STATUS_QUOTED;

                # Set the quote_id on the product so we know it's linked
                $rli->quote_id = $quote_id;
                $rli->status = RevenueLineItem::STATUS_QUOTED;
                $rli->save();
            }
            $product->save();
        }
        $product_bundle->bundle_stage = 'Draft';
        $product_bundle->total = $total;
        $product_bundle->total_usdollar = $total_base;
        $product_bundle->subtotal = $total;
        $product_bundle->subtotal_usdollar = $total_base;
        $product_bundle->deal_tot = $total;
        $product_bundle->deal_tot_usdollar = $total_base;
        $product_bundle->new_sub = $total;
        $product_bundle->new_sub_usdollar = $total_base;
        $product_bundle->tax = 0.00;
        $product_bundle->tax_usdollar = 0.00;
        $product_bundle->currency_id = $product->currency_id;
        $product_bundle->save();

        return $product_bundle;
    }

    /**
     * Set the Account Billing and Shipping Info if the account is loaded.
     *
     * @param $account_id
     * @param $quote
     */
    protected function setQuoteAccountInfo($account_id, &$quote)
    {
        // get the account from the product
        /* @var $account Account */
        $account = BeanFactory::getBean('Accounts', $account_id);
        if (isset($account->id)) {
            $quote->billing_address_street = $account->billing_address_street;
            $quote->billing_address_city = $account->billing_address_city;
            $quote->billing_address_country = $account->billing_address_country;
            $quote->billing_address_state = $account->billing_address_state;
            $quote->billing_address_postalcode = $account->billing_address_postalcode;

            $quote->shipping_address_street = $account->shipping_address_street;
            $quote->shipping_address_city = $account->shipping_address_city;
            $quote->shipping_address_country = $account->shipping_address_country;
            $quote->shipping_address_state = $account->shipping_address_state;
            $quote->shipping_address_postalcode = $account->shipping_address_postalcode;

            $quote->set_relationship(
                'quotes_accounts',
                array('quote_id' => $quote->id, 'account_id' => $account->id, 'account_role' => 'Bill To'),
                false
            );

            $quote->set_relationship(
                'quotes_accounts',
                array('quote_id' => $quote->id, 'account_id' => $account->id, 'account_role' => 'Ship To'),
                false
            );
        }
    }
}
