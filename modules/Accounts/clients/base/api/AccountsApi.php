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


require_once 'clients/base/api/ListApi.php';
require_once 'data/BeanFactory.php';

class AccountsApi extends ListApi
{
    public function registerApiRest()
    {
        return array(
            'opportunity_stats' => array(
                'reqType' => 'GET',
                'path' => array('Accounts','?', 'opportunity_stats'),
                'pathVars' => array('module', 'record'),
                'method' => 'opportunityStats',
                'shortHelp' => 'Get opportunity statistics for current record',
                'longHelp' => '',
            ),
        );
    }

    public function opportunityStats($api, $args)
    {
        // TODO make all APIs wrapped on tries and catches
        // TODO: move this to own module (in this case accounts)

        // TODO: Fix information leakage if user cannot list or view records not
        // belonging to them. It's hard to tell if the user has access if we
        // never get the bean.

        // Check for permissions on both Accounts and opportunities.
        // Load up the bean
        $record = BeanFactory::getBean($args['module'], $args['record']);
        if (!$record->ACLAccess('view')) {
            return;
        }

        // Load up the relationship
        if (!$record->load_relationship('opportunities')) {
            // The relationship did not load, I'm guessing it doesn't exist
            return;
        }

        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $record->opportunities->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if (!$linkSeed->ACLAccess('view')) {
            return;
        }

        $query = new SugarQuery();
        $query->select(array('sales_status', 'amount_usdollar'));
        $query->from($linkSeed);
        // making this more generic so we can use this on contacts also as soon
        // as we move it to a proper module
        $query->join('accounts', array('alias' => 'record'));
        $query->where()->equals('record.id', $record->id);
        // FIXME add the security query here!!!
        // TODO: When we can sum on the database side through SugarQuery, we can
        // use the group by statement.

        $results = $query->execute();

        // TODO this can't be done this way since we can change the status on
        // studio and add more
        $data = array(
            'won' => array('amount_usdollar' => 0, 'count' => 0),
            'lost' => array('amount_usdollar' => 0, 'count' => 0),
            'active' => array('amount_usdollar' => 0, 'count' => 0)
        );

        foreach ($results as $row) {
            $map = array(
                'Closed Lost' => 'lost',
                'Closed Won' => 'won',
            );
            if (array_key_exists($row['sales_status'], $map)) {
                $status = $map[$row['sales_status']];
            } else {
                $status = 'active';
            }
            $data[$status]['amount_usdollar'] += $row['amount_usdollar'];
            $data[$status]['count']++;
        }
        return $data;
    }
}
