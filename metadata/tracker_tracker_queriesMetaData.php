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

$dictionary['tracker_tracker_queries'] = array ( 
'table' => 'tracker_tracker_queries', 
'fields' => array (
      'id'=>array('name' => 'id', 'vname' => 'LBL_ID', 'type' => 'int', 'len' => '11', 'isnull' => 'false', 'auto_increment' => true, 'reportable'=>false),      
      'monitor_id'=>array('name' =>'monitor_id', 'type' =>'varchar', 'len'=>'36'),
      'query_id'=>array('name' =>'query_id', 'type' =>'varchar', 'len'=>'36'),
      'date_modified'=>array ('name' => 'date_modified','type' => 'datetime')
),
'indices' => array (
      array('name' =>'tracker_tracker_queriespk', 'type' =>'primary', 'fields'=>array('id')),
      array('name' =>'idx_tracker_tq_monitor', 'type' =>'index', 'fields'=>array('monitor_id')),
      array('name' =>'idx_tracker_tq_query', 'type' =>'index', 'fields'=>array('query_id')),
), 
'relationships' => array (
	'tracker_tracker_queries' => array(
	    'lhs_module'=> 'Trackers', 'lhs_table'=> 'tracker', 'lhs_key' => 'monitor_id',
		'rhs_module'=> 'TrackerQueries', 'rhs_table'=> 'tracker_queries', 'rhs_key' => 'query_id',
		'relationship_type'=>'many-to-many',
		'join_table'=> 'tracker_tracker_queries', 'join_key_lhs'=>'monitor_id', 'join_key_rhs'=>'query_id'
	 )
)
);                              

?>