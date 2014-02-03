<?php
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

$vardefs = array (
	'fields' => array (
        $_object_name . '_number' => array (
			'name' => $_object_name . '_number',
			'vname' => 'LBL_NUMBER',
			'type' => 'int',
            'readonly' => true,
			'len' => 11,
			'required' => true,
			'auto_increment' => true,
			'unified_search' => true,
			'full_text_search' => array('boost' => 3),
			'comment' => 'Visual unique identifier',
			'duplicate_merge' => 'disabled',
			'disable_num_format' => true,
			'studio' => array('quickcreate' => false),
            'duplicate_on_record_copy' => 'no',
		),

        'name' => array (
			'name' => 'name',
			'vname' => 'LBL_SUBJECT',
			'type' => 'name',
			'link' => true, // bug 39288 
			'dbType' => 'varchar',
			'len' => 255,
			'audited' => true,
			'unified_search' => true,
			'full_text_search' => array('boost' => 3),
			'comment' => 'The short description of the bug',
			'merge_filter' => 'selected',
			'required'=>true,
            'importable' => 'required',
            'duplicate_on_record_copy' => 'always',
			
		),
        'type' => array (
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'type' => 'enum',
            'options' => strtolower($object_name) . '_type_dom',
            'len'=>255,
            'comment' => 'The type of issue (ex: issue, feature)',
            'merge_filter' => 'enabled',
            'sortable' => true,
            'duplicate_on_record_copy' => 'always',
        ),

		'status' => array (
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'options' => strtolower($object_name) . '_status_dom',
            'len' => 100,
            'audited' => true,
            'comment' => 'The status of the issue',
            'merge_filter' => 'enabled',
            'sortable' => true,
            'duplicate_on_record_copy' => 'always',
		),

        'priority' => array (
			'name' => 'priority',
			'vname' => 'LBL_PRIORITY',
			'type' => 'enum',
			'options' => strtolower($object_name) . '_priority_dom',
			'len' => 100,
			'audited' => true,
			'comment' => 'An indication of the priorty of the issue',
			'merge_filter' => 'enabled',
            'sortable' => true,
            'duplicate_on_record_copy' => 'always',
		),

        'resolution' => array (
			'name' => 'resolution',
			'vname' => 'LBL_RESOLUTION',
			'type' => 'enum',
			'options' => strtolower($object_name) . '_resolution_dom',
			'len' => 255,
			'audited' => true,
			'comment' => 'An indication of how the issue was resolved',
			'merge_filter' => 'enabled',
            'sortable' => true,
            'duplicate_on_record_copy' => 'always',
			
		),

	    'system_id' => array (
			'name' => 'system_id',
			'vname' => 'LBL_SYSTEM_ID',
			'type' => 'int',
            'duplicate_on_record_copy' => 'always',
			'comment' => 'The offline client device that created the bug'
		),


			//not in cases.
	    'work_log' => array (
			'name' => 'work_log',
			'vname' => 'LBL_WORK_LOG',
			'type' => 'text',
            'duplicate_on_record_copy' => 'always',
			'comment' => 'Free-form text used to denote activities of interest'
		),

		
	),
	'indices'=>array(
		 'number'=>array('name' =>strtolower($module).'numk', 'type' =>'unique', 'fields'=>array($_object_name . '_number'))
	),
	
);
