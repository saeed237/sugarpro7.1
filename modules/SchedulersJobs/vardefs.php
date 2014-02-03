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
 * Copyright 2004-2013 SugarCRM Inc. All rights reserved.
 */


$dictionary['SchedulersJob'] = array('table' => 'job_queue',
    'comment' => 'Job queue keeps the list of the jobs executed by this instance',
    'fields' => array (
        'id' => array (
            'name' => 'id',
            'vname' => 'LBL_NAME',
            'type' => 'id',
            'len' => '36',
            'required' => true,
            'reportable'=>false,
        ),
       'name'=>
        array(
            'name'=>'name',
            'vname'=> 'LBL_NAME',
            'type'=>'name',
            'link' => true, // bug 39288
            'dbType' => 'varchar',
            'len'=>255,
            'required'=>true,
        ),
        'deleted' => array (
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => true,
            'default' => '0',
            'reportable'=>false,
        ),
        'date_entered' => array (
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'required' => true,
        ),
        'date_modified' => array (
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'required' => true,
        ),
        'scheduler_id' => array (
            'name' => 'scheduler_id',
            'vname' => 'LBL_SCHEDULER',
            'type' => 'id',
            'required' => false,
            'reportable' => false,
        ),
        'execute_time' => array (
            'name' => 'execute_time',
            'vname' => 'LBL_EXECUTE_TIME',
            'type' => 'datetime',
            'required' => true,
        ),
        'status' => array (
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'options'    => 'schedulers_times_dom',
            'len' => 20,
            'required' => true,
            'reportable' => true,
            'readonly' => true,
        ),
        'resolution' => array (
            'name' => 'resolution',
            'vname' => 'LBL_RESOLUTION',
            'type' => 'enum',
            'options'    => 'schedulers_resolution_dom',
            'len' => 20,
            'required' => true,
            'reportable' => true,
            'readonly' => true,
        ),
        'message' => array (
            'name' => 'message',
            'vname' => 'LBL_MESSAGE',
            'type' => 'text',
            'required' => false,
            'reportable' => false,
        ),
        'target' => array (
            'name' => 'target',
            'vname' => 'LBL_TARGET',
            'type' => 'varchar',
            'len' => 255,
            'required' => true,
            'reportable' => true,
        ),
        'data' => array (
            'name' => 'data',
            'vname' => 'LBL_DATA',
            'type' => 'longtext',
            'required' => false,
            'reportable' => true,
        ),
        'requeue' => array (
            'name' => 'requeue',
            'vname' => 'LBL_REQUEUE',
            'type' => 'bool',
            'default' => 0,
            'required' => false,
            'reportable' => true,
        ),
        'retry_count' => array (
            'name' => 'retry_count',
            'vname' => 'LBL_RETRY_COUNT',
            'type' => 'tinyint',
            'required' => false,
            'reportable' => true,
            'readonly' => true,
        ),
        'failure_count' => array (
            'name' => 'failure_count',
            'vname' => 'LBL_FAIL_COUNT',
            'type' => 'tinyint',
            'required' => false,
            'reportable' => true,
            'readonly' => true,
        ),
        'job_delay' => array (
            'name' => 'job_delay',
            'vname' => 'LBL_INTERVAL',
            'type' => 'int',
            'required' => false,
            'reportable' => false,
        ),
        'client' => array (
            'name' => 'client',
            'vname' => 'LBL_CLIENT',
            'type' => 'varchar',
            'len' => 255,
            'required' => true,
            'reportable' => true,
        ),
        'percent_complete' => array (
            'name' => 'percent_complete',
            'vname' => 'LBL_PERCENT',
            'type' => 'int',
            'required' => false,
            ),
        'job_group' => array (
            'name' => 'job_group',
            'vname' => 'LBL_JOB_GROUP',
            'type' => 'varchar',
            'len' => 255,
            'required' => false,
            'reportable' => true,
        ),
        'schedulers' => array (
            'name'            => 'schedulers',
            'vname'            => 'LBL_SCHEDULER_ID',
            'type'            => 'link',
            'relationship'    => 'schedulers_jobs_rel',
            'source'        => 'non-db',
            'link_type' => 'one',
       ),
        ),
    'acls' => array('SugarACLAdminOnly' => true),
    'indices' => array (
        array(
            'name' =>'job_queuepk',
            'type' =>'primary',
            'fields' => array(
                'id'
            )
        ),
        array(
            'name' =>'idx_status_scheduler',
            'type'=>'index',
            'fields' => array(
                'status',
                'scheduler_id',
               )
           ),
        array(
            'name' =>'idx_status_time',
            'type'=>'index',
            'fields' => array(
                'status',
                'execute_time',
                'date_entered',
               )
           ),
        array(
            'name' =>'idx_status_entered',
            'type'=>'index',
            'fields' => array(
                'status',
                'date_entered',
               )
           ),
        array(
            'name' =>'idx_status_modified',
            'type'=>'index',
            'fields' => array(
                'status',
                'date_modified',
               )
           ),
        array(
            'name' =>'idx_group_status',
            'type'=>'index',
            'fields' => array(
                'job_group',
                'status',
               )
           ),
    ),
);

VardefManager::createVardef('SchedulersJobs', 'SchedulersJob', array('assignable'));
