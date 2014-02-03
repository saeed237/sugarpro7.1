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

$dictionary['tracker_sessions'] = array(
    'table' => 'tracker_sessions',
    'fields' => array(
        'id'=>array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'int',
            'len' => '11',
            'reportable' => true,            
            'isnull' => 'false',
            'auto_increment' => true,
        ),       
        'session_id'=>array(
            'name' => 'session_id',
            'vname' => 'LBL_SESSION_ID',
            'type' => 'varchar',
            'len' => '36',
            'isnull' => 'false',
        ),   
        'date_start'=>array(
            'name' => 'date_start',
            'vname' => 'LBL_DATE_START',
            'type' => 'datetime',
            'isnull' => 'false',
        ),
        'date_end'=>array(
            'name' => 'date_end',
            'vname' => 'LBL_DATE_LAST_ACTION',
            'type' => 'datetime',
            'isnull' => 'false',
        ),
        'seconds'=>array (
            'name' => 'seconds',
            'vname' => 'LBL_SECONDS',
            'type' => 'int',
            'len' => '9',
            'isnull' => 'false',
            'default' => '0',
        ) ,        
        'client_ip'=>array(
            'name' => 'client_ip',
            'vname' => 'LBL_CLIENT_IP',
            'type' => 'varchar',
            'len' => '45',
            'isnull' => 'false',
        ),
        'user_id'=>array(
            'name' => 'user_id',
            'vname' => 'LBL_USER_ID',
            'type' => 'varchar',
            'len' => '36',
            'isnull' => 'false',
        ),             
        'active'=>array (
            'name' => 'active',
            'vname' => 'LBL_ACTIVE',
            'type' => 'bool',
            'default' => '1',
        ),
        'round_trips'=>array(
            'name' => 'round_trips',
            'vname' => 'LBL_ROUNDTRIPS',
            'type' => 'int',
            'len' => '5',
            'isnull' => 'false',
        ),
	    'deleted' =>array (
		    'name' => 'deleted',
		    'vname' => 'LBL_DELETED',
		    'type' => 'bool',
		    'default' => '0',
		    'reportable'=>false,
		    'comment' => 'Record deletion indicator'
		),
		'assigned_user_link'=>array (
		    'name' => 'assigned_user_link',
		    'type' => 'link',
		    'relationship' => 'tracker_user_id',
		    'vname' => 'LBL_ASSIGNED_TO_USER',
		    'link_type' => 'one',
		    'module'=>'Users',
		    'bean_name'=>'User',
		    'source'=>'non-db',
		),		        
    ),
    //indices
    'indices' => array(
        array(
            'name' => 'tracker_sessions_pk',
            'type' => 'primary',
            'fields' => array(
                'id'
            )
        ),
        array(
            'name' => 'idx_tracker_sessions_s_id',
            'type' => 'index',
            'fields' => array(
                'session_id',
            ),
        ),
        array(
            'name' => 'idx_tracker_sessions_uas_id',
            'type' => 'index',
            'fields' => array(
                'user_id', 'active', 'session_id'
            ), 
        )    
    ),    
    //relationships
 	'relationships' => array (
	  'tracker_user_id' =>
		   array(
				'lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
		   		'rhs_module'=> 'TrackerSessions', 'rhs_table'=> 'tracker', 'rhs_key' => 'user_id',
		   		'relationship_type'=>'one-to-many'
		   )
   	),          
);