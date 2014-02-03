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
class Subscription extends Basic
{
    public $table_name = 'subscriptions';
    public $object_name = 'Subscription';
    public $module_name = 'Subscriptions';
    public $module_dir = 'ActivityStream/Subscriptions';

    public $id;
    public $name = '';
    public $parent_type;
    public $parent_id;
    public $deleted;
    public $active;
    public $date_entered;
    public $date_modified;
    public $created_by;
    public $created_by_name;

    /**
     * Disable Custom Field lookup since Activity Streams don't support them
     *
     * @var bool
     */
    public $disable_custom_fields = true;

    /**
     * Gets the subscribed users for the record specified.
     * @param  SugarBean $record
     * @param  string    $type   Return type for data
     * @param Array $params
     *        disable_row_level_security
     * @return mixed
     */
    public static function getSubscribedUsers(SugarBean $record, $type = 'array', $params = array())
    {
        $query = self::getQueryObject($params);
        $query->select(array('created_by'));
        $query->where()->equals('parent_id', $record->id);
        $query->where()->equals('parent_type', $record->module_name);

        return $query->execute($type);
    }

    /**
     * Gets the subscribed records for the user specified.
     * @param  User   $user
     * @param  string $type Return type for data
     * @param Array $params
     *        disable_row_level_security
     * @return mixed
     */
    public static function getSubscribedRecords(User $user, $type = 'array', $params = array())
    {
        $query = self::getQueryObject($params);
        $query->select(array('parent_id'));
        $query->where()->equals('created_by', $user->id);

        return $query->execute($type);
    }

    /**
     * Checks whether the specified user is subscribed to the given record.
     * @param  User      $user
     * @param  SugarBean $record
     * @param Array $params
     *        disable_row_level_security
     * @return string|null       GUID of subscription or null
     */
    public static function checkSubscription(User $user, SugarBean $record, $params = array())
    {
        $query = self::getQueryObject($params);
        $query->select(array('id'));
        $query->where()->equals('parent_id', $record->id);
        $query->where()->equals('created_by', $user->id);
        $result = $query->execute();
        if (count($result)) {
            return $result[0]['id'];
        }
        return null;
    }

    /**
     * Checks which of the given records the specified user is subscribed to.
     * @param  User  $user
     * @param  array $records An array of associative arrays (not SugarBeans).
     * @param Array $params
     *        disable_row_level_security
     * @return array Associative array where keys are IDs of the record a user
     * is subscribed to.
     */
    public static function checkSubscriptionList(User $user, array $records, $params = array())
    {
        $return = array();
        // Plucks IDs of records passed in.
        $ids = array_map(
            function ($record) {
                return $record['id'];
            },
            $records
        );

        if (!empty($ids)) {
            $query = self::getQueryObject($params);
            $query->select(array('parent_id'));
            $query->where()->in('parent_id', $ids);
            $query->where()->equals('created_by', $user->id);
            $result = $query->execute();
            foreach ($result as $row) {
                $return[$row['parent_id']] = true;
            }
        }

        return $return;
    }

    /**
     * Retrieve the subscription bean for a user-record relationship.
     * @param  User      $user
     * @param  SugarBean $record
     * @param Array $params
     *        disable_row_level_security
     * @return Subscription|null
     */
    public static function getSubscription(User $user, SugarBean $record, $params = array())
    {
        $guid = self::checkSubscription($user, $record, $params);
        if (!empty($guid)) {
            return BeanFactory::retrieveBean('Subscriptions', $guid);
        }
        return null;
    }

    /**
     * Adds a user subscription to a record if one doesn't already exist.
     * @param  User      $user
     * @param  SugarBean $record
     * @param Array $params
     *        disable_row_level_security
     * @return string|bool       GUID of the subscription or false.
     */
    public static function subscribeUserToRecord(User $user, SugarBean $record, $params = array())
    {
        if (!self::checkSubscription($user, $record, $params)) {
            $seed = BeanFactory::getBean('Subscriptions');
            $seed->parent_type = $record->module_name;
            $seed->parent_id = $record->id;
            $seed->set_created_by = false;
            $seed->created_by = $user->id;
            return $seed->save();
        }
        return false;
    }

    /**
     * Removes a user subscription to a record.
     * @param  User      $user
     * @param  SugarBean $record
     * @return bool
     */
    public static function unsubscribeUserFromRecord(User $user, SugarBean $record)
    {
        $sub = self::getSubscription($user, $record);
        if ($sub) {
            $sub->mark_deleted();
            return true;
        }
        return false;
    }

    /**
     * Returns a query object for subscription queries.
     * @param Array $params
     *        disable_row_level_security
     * @return SugarQuery
     */
    protected static function getQueryObject($params = array())
    {
        $subscription = BeanFactory::getBean('Subscriptions');
        // Pro+ versions able to override visibility on subscriptions (Portal)
        // to allow Contact change activity messages to be linked to subscribers
        if (!empty($params['disable_row_level_security'])) {
            $subscription->disable_row_level_security = true;
        }
        $query = new SugarQuery();
        $query->from($subscription);
        $query->where()->equals('deleted', '0');
        return $query;
    }

    /**
     * Override mark_deleted().
     */
    public function mark_deleted()
    {
        $this->deleted = 1;
        $this->save();
    }

    /**
     * Adds an activities_users relationship between the activity and all users specified in the data array
     * @param array $data
     */
    public static function addActivitySubscriptions(array $data)
    {
        $activity = BeanFactory::retrieveBean('Activities', $data['act_id']);
        $userIds = array();
        foreach ($data['user_partials'] as $userPartial) {
            $userIds[] = $userPartial['created_by'];
        }
        $activity->processUserRelationships($userIds);
    }

    /**
     * Helper for processing subscriptions on a bean-related activity.
     *
     * @param  SugarBean $bean
     * @param  Activity  $act
     * @param  array     $args
     * @param  array     $params
     */
    public static function processSubscriptions(SugarBean $bean, Activity $act, array $args, $params = array())
    {
        $userPartials          = self::getSubscribedUsers($bean, 'array', $params);
        $data                  = array(
            'act_id'        => $act->id,
            'args'          => $args,
            'user_partials' => $userPartials,
        );
        if (count($userPartials) < 5) {
            self::addActivitySubscriptions($data);
        } else {
            $job                   = BeanFactory::getBean('SchedulersJobs');
            $job->requeue          = 1;
            $job->name             = "ActivityStream add";
            $job->data             = serialize($data);
            $job->target           = "class::SugarJobAddActivitySubscriptions";
            $job->assigned_user_id = $GLOBALS['current_user']->id;
            $queue                 = new SugarJobQueue();
            $queue->submitJob($job);
        }
    }
}
