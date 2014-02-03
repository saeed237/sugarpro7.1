<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$dictionary['tracker_perf'] = array(
    'table' => 'tracker_perf',
    'fields' => array(
        'id'=>array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'int',
            'len' => '11',
            'isnull' => 'false',
            'auto_increment' => true,
            'reportable' => true,
        ),       
	    'monitor_id'=>array (
		    'name' => 'monitor_id',
		    'vname' => 'LBL_MONITOR_ID',
		    'type' => 'id',
		    'required'=>true,
		    'reportable'=>false,
	    ),        
        'server_response_time'=>array(
            'name' => 'server_response_time',
            'vname' => 'LBL_SERVER_RESPONSE_TIME',
            'type' => 'float',
            'dbType' => 'double',
            'isnull' => 'false',
        ),
        'db_round_trips'=>array(
            'name' => 'db_round_trips',
            'vname' => 'LBL_DB_ROUND_TRIPS',
            'type' => 'int',
            'len' => '6',
            'isnull' => 'false',
        ),
        'files_opened'=>array(
            'name' => 'files_opened',
            'vname' => 'LBL_FILES_OPENED',
            'type' => 'int',
            'len' => '6',
            'isnull' => 'false',     
        ),
        'memory_usage'=>array(
            'name' => 'memory_usage',
            'vname' => 'LBL_MEMORY_USAGE',
            'type' => 'int',
            'len' => '12',
            'isnull' => 'true',  
        ),
	    'deleted' =>array (
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'default' => '0',
			'reportable'=>false,
			'comment' => 'Record deletion indicator'
	    ),
        'date_modified'=>array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_LAST_ACTION',
            'type' => 'datetime',
            'isnull' => 'false',
        ),	            
    ),
    //indices
    'indices' => array(
        array(
            'name' => 'tracker_perf_pk',
            'type' => 'primary',
            'fields' => array(
                'id'
            )
        ),
        array(
            'name' => 'idx_tracker_perf_mon_id',
            'type' => 'index',
            'fields' => array(
                'monitor_id',
            ),
        )          
    ),
);