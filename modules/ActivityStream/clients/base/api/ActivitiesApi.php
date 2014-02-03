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

class ActivitiesApi extends FilterApi
{
    protected static $beanList = array();
    protected static $previewCheckResults = array();

    public function registerApiRest()
    {
        return array(
            // TODO: Look into removing this method. We shouldn't need this, but
            // it's here to prevent breaking stuff before SugarCon 2013.
            'record_activities' => array(
                'reqType' => 'GET',
                'path' => array('<module>','?', 'link', 'activities'),
                'pathVars' => array('module','record', ''),
                'method' => 'getRecordActivities',
                'shortHelp' => 'This method retrieves a record\'s activities',
                'longHelp' => 'modules/ActivityStream/clients/base/api/help/recordActivities.html',
            ),
            'module_activities' => array(
                'reqType' => 'GET',
                'path' => array('<module>', 'Activities'),
                'pathVars' => array('module', ''),
                'method' => 'getModuleActivities',
                'shortHelp' => 'This method retrieves a module\'s activities',
                'longHelp' => 'modules/ActivityStream/clients/base/api/help/moduleActivities.html',
            ),
            'home_activities' => array(
                'reqType' => 'GET',
                'path' => array('Activities'),
                'pathVars' => array(''),
                'method' => 'getHomeActivities',
                'shortHelp' => 'This method gets homepage activities for a user',
                'longHelp' => 'modules/ActivityStream/clients/base/api/help/homeActivities.html',
            ),
            'record_activities_filter' => array(
                'reqType' => 'GET',
                'path' => array('<module>','?', 'link', 'activities', 'filter'),
                'pathVars' => array('module','record', ''),
                'method' => 'getRecordActivities',
                'shortHelp' => 'This method retrieves a filtered list of a record\'s activities',
                'longHelp' => 'modules/ActivityStream/clients/base/api/help/recordActivities.html',
            ),
            'module_activities_filter' => array(
                'reqType' => 'GET',
                'path' => array('<module>', 'Activities', 'filter'),
                'pathVars' => array('module', ''),
                'method' => 'getModuleActivities',
                'shortHelp' => 'This method retrieves a filtered list of a module\'s activities',
                'longHelp' => 'modules/ActivityStream/clients/base/api/help/moduleActivities.html',
            ),
            'home_activities_filter' => array(
                'reqType' => 'GET',
                'path' => array('Activities', 'filter'),
                'pathVars' => array(''),
                'method' => 'getHomeActivities',
                'shortHelp' => 'This method gets a filtered list of homepage activities for a user',
                'longHelp' => 'modules/ActivityStream/clients/base/api/help/homeActivities.html',
            ),
        );
    }

    public function getRecordActivities(ServiceBase $api, array $args)
    {
        $params = $this->parseArguments($api, $args);
        $record = BeanFactory::retrieveBean($args['module'], $args['record']);

        if (empty($record)) {
            throw new SugarApiExceptionNotFound('Could not find parent record '.$args['record'].' in module '.$args['module']);
        }
        if (!$record->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }

        $query = self::getQueryObject($api, $params, $record);
        return $this->formatResult($api, $args, $query, $record);
    }

    public function getModuleActivities(ServiceBase $api, array $args)
    {
        $params = $this->parseArguments($api, $args);
        $record = BeanFactory::getBean($args['module']);
        if (!$record->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }

        $query = self::getQueryObject($api, $params, $record);
        return $this->formatResult($api, $args, $query, $record);
    }

    public function getHomeActivities(ServiceBase $api, array $args)
    {
        $params = $this->parseArguments($api, $args);
        $query = self::getQueryObject($api, $params);
        return $this->formatResult($api, $args, $query);
    }

    public function parseArguments(ServiceBase $api, array $args)
    {
        $params = parent::parseArguments($api, $args);
        if (isset($args['filter'])) {
            $params['filter'] = $args['filter'];
        }
        return $params;
    }

    protected function formatResult(ServiceBase $api, array $args, SugarQuery $query, SugarBean $bean = null)
    {
        $response = array();
        $response['records'] = $query->execute('array', false);
        // We add one to it when setting it, so we subtract one now for the true
        // limit.
        $limit = $query->limit - 1;
        $count = count($response['records']);
        if ($count > $limit) {
            $nextOffset = $query->offset + $limit;
            array_pop($response['records']);
        } else {
            $nextOffset = -1;
        }
        $timedate = TimeDate::getInstance();

        // Emulate going through SugarBean, without the extra DB hits.
        foreach ($response['records'] as &$record) {
            $record['comment_count'] = (int)$record['comment_count'];
            $record['data'] = json_decode($record['data'], true);
            $record['last_comment'] = json_decode($record['last_comment'], true);
            $date_modified = $timedate->fromDbType($record['date_modified'], 'datetime');
            $record['date_modified'] = $timedate->asIso($date_modified);
            $date_entered = $timedate->fromDbType($record['date_entered'], 'datetime');
            $record['date_entered'] = $timedate->asIso($date_entered);

            if ($record['activity_type'] == 'update') {
                if (is_null($bean) || empty($bean->id)) {
                    $record['fields'] = json_decode($record['fields'], true);
                    $changedData      = array();
                    if (!empty($record['fields'])) {
                        $aclBean = null;
                        if (!is_null($bean)) {
                            $aclBean = $bean;
                        } elseif (!empty($record['data']['object']['module'])) {
                            $aclModule = $record['data']['object']['module'];
                            $aclBean = $this->getEmptyBean($aclModule);
                        }
                        if (!is_null($aclBean)) {
                            $context = array('user' => $api->user);
                            $aclBean->ACLFilterFieldList($record['data']['changes'], $context);
                        }
                        foreach ($record['data']['changes'] as &$change) {
                            if (in_array($change['field_name'], $record['fields'])) {
                                $changedData[$change['field_name']] = $record['data']['changes'][$change['field_name']];
                            }
                        }
                        unset($record['fields']);
                    }
                    $record['data']['changes'] = $changedData;
                } else {
                    $context = array('user' => $api->user);
                    $bean->ACLFilterFieldList($record['data']['changes'], $context);
                }
            }

            // Do module flipping if necessary.
            $displayFields = $this->getDisplayModule($record, $bean);
            $record['display_parent_type'] = $displayFields['module'];
            $record['display_parent_id'] = $displayFields['id'];

            //check if parent record preview should be enabled
            if (!empty($record['parent_type']) && !empty($record['parent_id'])) {
                $previewCheckResult = $this->checkParentPreviewEnabled($api->user, $record['display_parent_type'], $record['display_parent_id']);
                $record['preview_enabled'] = $previewCheckResult['preview_enabled'];
                $record['preview_disabled_reason'] = $previewCheckResult['preview_disabled_reason'];
            }

            // Format the name of the user.
            $name = array($record['first_name'], $record['last_name']);
            if ($api->user->showLastNameFirst()) {
                $name = array_reverse($name);
            }
            $record['created_by_name'] = implode(' ', $name);

            if (!isset($record['created_by_name']) && isset($record['data']['created_by_name'])) {
                $record['created_by_name'] = $record['data']['created_by_name'];
            }
        }
        $response['next_offset'] = $nextOffset;
        $response['args'] = $args;
        return $response;
    }

    protected function checkParentPreviewEnabled($user, $module, $id)
    {
        $previewCheckKey = $module . '.' . $id;
        $previewCheckResult = array();
        if (array_key_exists($previewCheckKey, self::$previewCheckResults)) {
            $previewCheckResult = self::$previewCheckResults[$previewCheckKey];
        } else {
            $previewCheckBean = $this->getEmptyBean($module);
            $previewCheckBean->id = $id;
            //check if user has access - also checks if record is deleted
            $previewCheckResult['preview_enabled'] = $previewCheckBean->checkUserAccess($user);
            //currently only one error reason, but may be others in the future
            $previewCheckResult['preview_disabled_reason'] = $previewCheckResult['preview_enabled'] ? '' : 'LBL_PREVIEW_DISABLED_DELETED_OR_NO_ACCESS';
        }
        self::$previewCheckResults[$previewCheckKey] = $previewCheckResult;
        return $previewCheckResult;
    }

    /**
     * For non-homepage requests and link/unlink activities, flip the parent
     * record that's displayed so that the event is noticeable.
     * @param  array     $record The individual activity, as an array.
     * @param  SugarBean $bean   The request's context's bean.
     * @return array     Associative array with two keys, 'module' and 'id'.
     */
    protected function getDisplayModule(array $record, SugarBean $bean = null)
    {
        $array = array(
            'module' => isset($record['parent_type']) ? $record['parent_type'] : '',
            'id' => isset($record['parent_id']) ? $record['parent_id'] : '',
        );

        if (!is_null($bean) && ($record['activity_type'] === 'link' || $record['activity_type'] === 'unlink')) {
            // Verify that the context matches record's parent module.
            if ($bean->module_name === $record['parent_type']) {
                $array['module'] = $record['data']['subject']['module'];
                $array['id'] = $record['data']['subject']['id'];
            }
        }

        return $array;
    }

    protected function getEmptyBean($module)
    {
        if (isset(self::$beanList[$module])) {
            $bean = self::$beanList[$module];
        } else {
            $bean = BeanFactory::getBean($module);
            if (!is_null($bean)) {
                self::$beanList[$module] = $bean;
            }
        }
        return $bean;
    }

    public static function getQueryObject(ServiceBase $api, array $params, SugarBean $record = null)
    {
        $seed = BeanFactory::getBean('Activities');
        $query = new SugarQuery();
        $query->from($seed);

        // Always order the activity stream by date modified DESC.
        $query->orderBy('date_modified', 'DESC');

        // +1 used to determine if we have more records to show.
        $query->limit($params['limit'] + 1)->offset($params['offset']);

        $columns = array('activities.*', 'users.first_name', 'users.last_name', 'users.picture');


        // Join with user names.
        $query->joinTable('users', array('joinType' => 'INNER'))
            ->on()->equalsField('activities.created_by', 'users.id');

        $join = $query->joinTable('activities_users', array('joinType' => 'INNER', 'linkName' => 'activities_users'))
            ->on()->equalsField("activities_users.activity_id", 'activities.id')
            ->equals("activities_users.deleted", 0);

        if (!$record || !$record->id) {
            // Join with cached list of activities to show.
            $columns[] = 'activities_users.fields';
            $join = $join->queryOr();
            // TODO: Change this to include all teams a user is a member of
            // for more granular activity stream control.
            $join->queryAnd()->equals('activities_users.parent_type', 'Teams')
                ->equals('activities_users.parent_id', 1);
            $join->queryAnd()->equals('activities_users.parent_type', 'Users')
                ->equals('activities_users.parent_id', $api->user->id);
            if ($record) {
                $query->where()->equals('activities.parent_type', $record->module_name);
            } else {
                $homeActivityFilter = $query->where()->queryOr();
                $homeActivityFilter->isNull('activities.parent_type');
                $homeActivityFilter->equals('activities_users.parent_type', 'Users');
            }
        } else {
            // If we have a relevant bean, we add our where condition.
            $query->where()->equals('activities_users.parent_type', $record->module_name);
            if ($record->id) {
                $query->where()->equals('activities_users.parent_id', $record->id);
            }
        }

        // We only support filtering on activity_type.
        if (!empty($params['filter'])) {
            self::addFilters($params['filter'], $query->where(), $query);
        }

        $query->where()->equals('deleted', 0);
        $query->select($columns);

        return $query;
    }
}
