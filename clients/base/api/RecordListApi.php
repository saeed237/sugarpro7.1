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



require_once('include/api/SugarApi.php');

/*
 * Record List API implementation
 */
class RecordListApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'recordListCreate' => array(
                'reqType' => 'POST',
                'path' => array('<module>','record_list'),
                'pathVars' => array('module',''),
                'jsonParams' => array('filter'),
                'method' => 'recordListCreate',
                'shortHelp' => 'An API to create and save lists of records',
                'longHelp' => 'include/api/help/module_recordlist_post.html',
            ),
            'recordListDelete' => array(
                'reqType' => 'DELETE',
                'path' => array('<module>','record_list','?'),
                'pathVars' => array('module','','record_list_id'),
                'method' => 'recordListDelete',
                'shortHelp' => 'An API to delete an old record list',
                'longHelp' => 'include/api/help/module_recordlist_delete.html',
            ),
            'recordListGet' => array(
                'reqType' => 'GET',
                'path' => array('<module>','record_list','?'),
                'pathVars' => array('module','','record_list_id'),
                'method' => 'recordListGet',
                'shortHelp' => 'An API to fetch a previously created record list',
                'longHelp' => 'include/api/help/module_recordlist_get.html',
            ),
        );
    }

    public static function loadRecordList($id, $user = null) {
        $db = DBManagerFactory::getInstance();
        
        if ($user == null) {
            $user = $GLOBALS['current_user'];
        }
        
        $ret = $db->query("SELECT * FROM record_list WHERE id = '".$db->quote($id)."' AND assigned_user_id = '".$db->quote($user->id)."'",true);

        $row = $db->fetchByAssoc($ret);

        if (!empty($row['records'])) {
            $data = $row;
            $data['records'] = json_decode($data['records']);
            return $data;
        } else {
            return null;
        }

    }

    public static function saveRecordList($recordList, $module, $id = null, $user = null) {
        $db = DBManagerFactory::getInstance();
        
        if ($user == null) {
            $user = $GLOBALS['current_user'];
        }

        $currentTime = $GLOBALS['timedate']->nowDb();
        
        if (empty($id)) {
            $id = create_guid();
            $query = "INSERT INTO record_list (id, assigned_user_id, module_name, records, date_modified) VALUES ('".$db->quote($id)."','".$db->quote($user->id)."', '".$db->quote($module)."','".$db->quote(json_encode($recordList))."', '".$currentTime."')"; 
        } else {
            $query = "UPDATE record_list SET records = '".$db->quote(json_encode($recordList))."', date_modified = '".$currentTime."'";
        }

        $ret = $db->query($query,true);

        return $id;
    }


    /**
     * To create a record list
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API containing the module and the records
     * @return array id, module, records
     */
    public function recordListCreate($api, $args)
    {
        $seed = BeanFactory::newBean($args['module']);

        if (!$seed->ACLAccess('access')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        if (!is_array($args['records'])) {
            throw new SugarApiExceptionMissingParameter();
        }
        
        $id = self::saveRecordList($args['records'], $args['module']);

        $loadedRecordList = self::loadRecordList($id);
        
        return $loadedRecordList;
    }

    /**
     * To delete a record list
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API containing the module
     * @return bool Did the delete succeed
     */
    public function recordListDelete($api, $args)
    {
        $seed = BeanFactory::newBean($args['module']);
        if (!$seed->ACLAccess('access')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        if (empty($args['record_list_id'])) {
            throw new SugarApiExceptionMissingParameter();
        }
        if (!$api->user->isAdmin()) {
            $recordList = self::loadRecordList($args['record_list_id']);
            if ($recordList['assigned_user_id'] != $api->user->id) {
                throw new SugarApiExceptionNotAuthorized();
            }
        }

        $db = DBManagerFactory::getInstance();
        $db->query("DELETE FROM record_list WHERE id = '".$db->quote($args['record_list_id'])."'",true);

        return true;
    }

    /**
     * To retrieve a record list
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API containing the module and id of the record list
     * @return array The record list
     */
    public function recordListGet($api, $args)
    {
        $seed = BeanFactory::newBean($args['module']);
        if (!$seed->ACLAccess('access')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $recordList = $this->loadRecordList($args['record_list_id']);
        if ($recordList == null) {
            throw new SugarApiExceptionNotFound();
        }
        if ($recordList['module'] != $args['module']) {
            throw new SugarApiExceptionNotAuthorized();
        }
        if (!$api->user->isAdmin()) {
            if ($recordList['assigned_user_id'] != $api->user->id) {
                throw new SugarApiExceptionNotAuthorized();
            }            
        }

        return $recordList;
    }
    
}
