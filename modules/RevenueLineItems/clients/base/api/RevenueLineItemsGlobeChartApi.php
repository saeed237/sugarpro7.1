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
class RevenueLineItemsGlobeChartApi extends SugarApi
{
    /**
     * {@inheritdoc}
     */
    public function registerApiRest()
    {
        return array(
            'sales_by_country' => array(
                'reqType' => 'GET',
                'path' => array('RevenueLineItems','by_country'),
                'pathVars' => array('module', '', ''),
                'method' => 'salesByCountry',
                'shortHelp' => 'Get opportunities won by country',
                'longHelp' => '',
            ),
        );
    }


    public function salesByCountry($api, $args)
    {
        // TODO: Fix information leakage if user cannot list or view records not
        // belonging to them. It's hard to tell if the user has access if we
        // never get the bean.

        // Check for permissions on both Revenue line times and accounts.
        $seed = BeanFactory::newBean('RevenueLineItems');
        if (!$seed->ACLAccess('view')) {
            return;
        }

        // Load up the relationship
        if (!$seed->load_relationship('account_link')) {
            // The relationship did not load, I'm guessing it doesn't exist
            return;
        }

        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $seed->account_link->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if (!$linkSeed->ACLAccess('view')) {
            return;
        }

        $query = new SugarQuery();
        $account_link = $query->join('account_link');
        $query->select(array("$account_link.billing_address_country", "$account_link.billing_address_state", 'likely_case', 'base_rate'));
        $query->from($seed);
        $query->where()->equals('sales_stage', 'Closed Won');

        // TODO: When we can sum on the database side through SugarQuery, we can
        // use the group by statement.

        $data = array();

        $results = $query->execute();
        foreach ($results as $row) {
            if (empty($data[$row['billing_address_country']])) {
                $data[$row['billing_address_country']] = array(
                    '_total' => 0
                );
            }
            if (empty($data[$row['billing_address_country']][$row['billing_address_state']])) {
                $data[$row['billing_address_country']][$row['billing_address_state']] = array(
                    '_total' => 0
                );
            }
            $data[$row['billing_address_country']]['_total'] += $row['likely_case']/$row['base_rate'];
            $data[$row['billing_address_country']][$row['billing_address_state']]['_total'] += $row['likely_case']/$row['base_rate'];
        }

        return $data;
    }
}
