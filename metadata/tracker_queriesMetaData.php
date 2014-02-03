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

$dictionary['tracker_queries'] = array(
    'table' => 'tracker_queries',
    'fields' => array(
        'id'=>array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'int',
            'len' => '11',
            'reportable' => true,
            'isnull' => 'false',
            'auto_increment' => true
        ),
	    'query_id'=>array (
		    'name' => 'query_id',
		    'vname' => 'LBL_QUERY_ID',
		    'type' => 'id',
		    'required'=>true,
		    'reportable'=>false,
	    ),
        'text'=>array(
            'name' => 'text',
            'vname' => 'LBL_SQL_TEXT',
            'type' => 'text',
            'isnull' => 'false',
        ),
        'query_hash'=>array(
            'name' => 'query_hash',
            'vname' => 'LBL_QUERY_HASH',
            'type' => 'varchar',
            'len' => '36',
            'reportable' => false,
            'isnull' => 'false',
        ),
        'sec_total'=>array(
            'name' => 'sec_total',
            'vname' => 'LBL_SEC_TOTAL',
            'type' => 'float',
            'dbType' => 'double',
            'isnull' => 'false',
        ),
        'sec_avg'=>array(
            'name' => 'sec_avg',
            'vname' => 'LBL_SEC_AVG',
            'type' => 'float',
            'dbType' => 'double',
            'isnull' => 'false',
        ),
        'run_count'=>array(
            'name' => 'run_count',
            'vname' => 'LBL_RUN_COUNT',
            'type' => 'int',
            'len' => '6',
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
        'date_modified'=>array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'isnull' => 'false',
        ),
    ) ,
    'indices' => array(
        array(
            'name' => 'tracker_queries_pk',
            'type' => 'primary',
            'fields' => array(
                'id'
            )
        ),

        array(
            'name' =>'idx_tracker_queries_query_hash',
            'type' =>'index',
            'fields'=>array(
                'query_hash'
       	    )
        ),
          array(
            'name' =>'idx_tracker_queries_query_id',
            'type' =>'index',
            'fields'=>array(
                'query_id'
       	    )
        )

    )
);