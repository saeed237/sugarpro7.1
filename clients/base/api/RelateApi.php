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


require_once 'clients/base/api/FilterApi.php';

class RelateApi extends FilterApi {
    public function registerApiRest() {
        return array(
            'filterRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('<module>', '?', 'link', '?', 'filter'),
                'pathVars' => array('module', 'record', '', 'link_name', ''),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related filtered records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
            'filterRelatedRecordsCount' => array(
                'reqType' => 'GET',
                'path' => array('<module>', '?', 'link', '?', 'filter', 'count'),
                'pathVars' => array('module', 'record', '', 'link_name', '', ''),
                'jsonParams' => array('filter'),
                'method' => 'filterRelatedCount',
                'shortHelp' => 'Lists related filtered records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',

            ),
            'listRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('<module>', '?', 'link', '?'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
        );
    }

    public function filterRelatedSetup(ServiceBase $api, array $args)
    {
        // Load the parent bean.
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

        // Load the relationship.
        $linkName = $args['link_name'];
        if (!$record->load_relationship($linkName)) {
            // The relationship did not load.
            throw new SugarApiExceptionNotFound('Could not find a relationship named: ' . $args['link_name']);
        }
        $linkModuleName = $record->$linkName->getRelatedModuleName();
        $linkSeed = BeanFactory::getBean($linkModuleName);
        if (!$linkSeed->ACLAccess('list')) {
            throw new SugarApiExceptionNotAuthorized('No access to list records for module: ' . $linkModuleName);
        }

        $options = $this->parseArguments($api, $args, $linkSeed);

        // If they don't have fields selected we need to include any link fields
        // for this relationship
        if (empty($args['fields']) && is_array($linkSeed->field_defs)) {
            $relatedLinkName = $record->$linkName->getRelatedModuleLinkName();
            $options['linkDataFields'] = array();
            foreach ($linkSeed->field_defs as $field => $def) {
                if (empty($def['rname_link']) || empty($def['link'])) {
                    continue;
                }
                if ($def['link'] != $relatedLinkName) {
                    continue;
                }
                // It's a match
                $options['linkDataFields'][] = $field;
                $options['select'][] = $field;
            }
        }

        $q = self::getQueryObject($linkSeed, $options);

        // Some relationships want the role column ignored
        if (!empty($args['ignore_role'])) {
            $ignoreRole = true;
        } else {
            $ignoreRole = false;
        }

        $q->joinSubpanel($record, $linkName, array('joinType' => 'INNER', 'ignoreRole' => $ignoreRole));

        if (!isset($args['filter']) || !is_array($args['filter'])) {
            $args['filter'] = array();
        }
        self::addFilters($args['filter'], $q->where(), $q);

        return array($args, $q, $options, $linkSeed);
    }

    public function filterRelated(ServiceBase $api, array $args)
    {

        $api->action = 'list';

        list($args, $q, $options, $linkSeed) = $this->filterRelatedSetup($api, $args);

        return $this->runQuery($api, $args, $q, $options, $linkSeed);
    }

    public function filterRelatedCount(ServiceBase $api, array $args)
    {

        $api->action = 'list';

        list($args, $q, $options, $linkSeed) = $this->filterRelatedSetup($api, $args);

        $q->select->selectReset()->setCountQuery();
        $q->limit = null;

        return reset($q->execute());
    }

}
