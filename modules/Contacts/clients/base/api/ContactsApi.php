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

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'clients/base/api/ListApi.php';
require_once 'data/BeanFactory.php';

class ContactsApi extends ListApi
{
    public function registerApiRest()
    {
        return array(
            'opportunity_stats' => array(
                'reqType' => 'GET',
                'path' => array('Contacts','?', 'opportunity_stats'),
                'pathVars' => array('module', 'record'),
                'method' => 'opportunityStats',
                'shortHelp' => 'Get opportunity statistics for current record',
                'longHelp' => '',
            ),
            'influencers' => array(
                'reqType' => 'GET',
                'path' => array('Contacts','?', 'influencers'),
                'pathVars' => array('module', 'record'),
                'method' => 'influencers',
                'shortHelp' => '',
                'longHelp' => '',
            ),
        );
    }

    public function influencers($api, $args)
    {
        $account = $this->getAccountBean($api, $args);
        $relationships = array('calls' => 0, 'meetings' => 0);
        $data = array();
        foreach($relationships as $relationship => $ignore) {
            // Load up the relationship
            if (!$account->load_relationship($relationship)) {
                // The relationship did not load, I'm guessing it doesn't exist
                throw new SugarApiExceptionNotFound('Could not find a relationship name ' . $relationship);
            }
            // Figure out what is on the other side of this relationship, check permissions
            $linkModuleName = $account->$relationship->getRelatedModuleName();
            $linkSeed = BeanFactory::newBean($linkModuleName);
            if (!$linkSeed->ACLAccess('view')) {
                throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$linkModuleName);
            }

            $relationshipData = $account->$relationship->query(array());

            foreach ($relationshipData['rows'] as $id => $value) {
                $bean = BeanFactory::getBean(ucfirst($relationship), $id);
                $bean->load_relationship('users');
                $userModuleName = $bean->users->getRelatedModuleName();
                $userSeed = BeanFactory::newBean($userModuleName);
                $userData = $bean->users->query(array());

                foreach($userData['rows'] as $userId => $user) {
                    if(empty($data[$userId])) {
                        $userBean = BeanFactory::getBean('Users', $userId);
                        _ppl($userId);
                        if($userBean) {
                            $data[$userId] = array_merge($this->formatBean($api, $args, $userBean), $relationships);
                            $data[$userId][$relationship]++;
                        }
                    } else {
                        $data[$userId][$relationship]++;
                    }
                }
            }
        }
        return array_values($data);
    }

    public function opportunityStats($api, $args)
    {
        $account = $this->getAccountBean($api, $args);
        $data = $this->getAccountRelationship($api, $args, $account, 'opportunities', null);
        $return = array(
            'won' => array('amount_usdollar' => 0, 'count' => 0),
            'lost' => array('amount_usdollar' => 0, 'count' => 0),
            'active' => array('amount_usdollar' => 0, 'count' => 0)
        );
        foreach ($data as $record) {
            switch($record['sales_stage']) {
                case "Closed Lost":
                    $status = 'lost';
                    break;
                case "Closed Won":
                    $status = 'won';
                    break;
                default:
                    $status = 'active';
                    break;
            }
            $return[$status]['amount_usdollar'] += $record['amount_usdollar'];
            $return[$status]['count']++;
        }
        return $return;
    }


    protected function getBean($api, $args)
    {
        // Load up the bean
        $record = BeanFactory::getBean($args['module'], $args['record']);

        if (empty($record)) {
            throw new SugarApiExceptionNotFound('Could not find parent record '.$args['record'].' in module '.$args['module']);
        }
        if (!$record->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }
        return $record;
    }

    protected function getAccountBean($api, $args)
    {
        $record = $this->getBean($api, $args);
        // Load up the relationship
        if (!$record->load_relationship('accounts')) {
            throw new SugarApiExceptionNotFound('Could not find a relationship name accounts');
        }

        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $record->accounts->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if (!$linkSeed->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$linkModuleName);
        }

        $accounts = $record->accounts->query(array());
        foreach ($accounts['rows'] as $accountId => $value) {
            $account = BeanFactory::getBean('Accounts', $accountId);
            if (empty($account)) {
                throw new SugarApiExceptionNotFound('Could not find parent record '.$accountId.' in module Accounts');
            }
            if (!$account->ACLAccess('view')) {
                throw new SugarApiExceptionNotAuthorized('No access to view records for module: Accounts');
            }

            // Only one account, so we can return inside the loop.
            return $account;
        }
    }

    protected function getAccountRelationship($api, $args, $account, $relationship, $limit = 5, $query = array())
    {
        // Load up the relationship
        if (!$account->load_relationship($relationship)) {
            // The relationship did not load, I'm guessing it doesn't exist
            throw new SugarApiExceptionNotFound('Could not find a relationship name ' . $relationship);
        }
        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $account->$relationship->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if (!$linkSeed->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$linkModuleName);
        }

        $relationshipData = $account->$relationship->query($query);
        $rowCount = 1;

        $data = array();
        foreach ($relationshipData['rows'] as $id => $value) {
            $rowCount++;
            $bean = BeanFactory::getBean(ucfirst($relationship), $id);
            $data[] = $this->formatBean($api, $args, $bean);
            if (!is_null($limit) && $rowCount == $limit) {
                // We have hit our limit.
                break;
            }
        }
        return $data;
    }


}
