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


require_once 'clients/base/api/RelateApi.php';

class AccountsRelateApi extends RelateApi
{
    public function registerApiRest() {
        return array(
            'filterRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('Accounts', '?', 'link', '?', 'filter'),
                'pathVars' => array('module', 'record', '', 'link_name', ''),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related filtered records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            )
        );
    }

    public function filterRelated(ServiceBase $api, array $args)
    {
        if ($args['module'] !== 'Accounts' || !in_array($args['link_name'], array('calls', 'meetings')) || empty($args['include_child_items'])) {
            return parent::filterRelated($api, $args);
        }

        $api->action = 'list';

        $record = BeanFactory::retrieveBean($args['module'], $args['record']);

        if (empty($record)) {
            throw new SugarApiExceptionNotFound(
                sprintf(
                    'Could not find parent record %s in module: %s',
                    $args['record'],
                    $args['module']
                )
            );
        }

        if (!$record->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: ' . $args['module']);
        }

        $linkName = $args['link_name'];
        if (!$record->load_relationship($linkName)) {
            throw new SugarApiExceptionNotFound('Could not find a relationship named: ' . $args['link_name']);
        }
        $linkModuleName = $record->$linkName->getRelatedModuleName();
        $linkSeed = BeanFactory::getBean($linkModuleName);
        if (!$linkSeed->ACLAccess('list')) {
            throw new SugarApiExceptionNotAuthorized('No access to list records for module: ' . $linkModuleName);
        }

        $options = $this->parseArguments($api, $args, $linkSeed);
        $q = self::getQueryObject($linkSeed, $options);
        if (!isset($args['filter']) || !is_array($args['filter'])) {
            $args['filter'] = array();
        }

        self::addFilters($args['filter'], $q->where(), $q);

        $q->joinTable('accounts')
            ->on()
            ->equals('accounts.id', $record->id)
            ->equals('accounts.deleted', 0);

        // FIXME: there should be the ability to specify from which related module
        // the child items should be loaded
        $q->joinTable('accounts_contacts', array('alias' => 'ac', 'joinType' => 'LEFT'))
            ->on()
            ->equalsField('ac.account_id', 'accounts.id')
            ->equals('ac.deleted', 0);

        // FIXME: this informations should be dynamically retrieved
        if ($linkModuleName === 'Meetings') {
            $childModuleTable = 'meetings';
            $childRelationshipTable = 'meetings_contacts';
            $childRelationshipAlias = 'mc';
            $childLhsColumn = $childModuleTable . '.id';
            $childRhsColumn = $childRelationshipAlias . '.meeting_id';

        } else {
            $childModuleTable = 'calls';
            $childRelationshipTable = 'calls_contacts';
            $childRelationshipAlias = 'cc';
            $childLhsColumn = $childModuleTable . '.id';
            $childRhsColumn = $childRelationshipAlias . '.call_id';
        }

        $q->joinTable($childRelationshipTable, array('alias' => $childRelationshipAlias, 'joinType' => 'LEFT'))
            ->on()
            ->equalsField($childRhsColumn, $childLhsColumn)
            ->equals($childRelationshipAlias . '.deleted', 0);

        $where = $q->where()->queryOr();
        $where->queryAnd()->equals($childModuleTable . '.parent_type', 'Contacts')->equalsField($childModuleTable . '.parent_id', 'ac.contact_id');
        $where->queryAnd()->equals($childModuleTable . '.parent_type', 'Contacts')->equalsField($childModuleTable . '.parent_id', $childRelationshipAlias . '.contact_id');
        $where->queryAnd()->equals($childModuleTable . '.parent_type', 'Accounts')->equalsField($childModuleTable . '.parent_id', 'accounts.id');

        return $this->runQuery($api, $args, $q, $options, $linkSeed);
    }
}
