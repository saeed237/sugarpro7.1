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

/* this table should never get created, it should only be used as a template for the acutal audit tables
 * for each moudule.
 */
$dictionary['audit'] = 
		array ( 'table' => 'audit',
              	'fields' => array (
              	      'id'=> array('name' =>'id', 'type' =>'id', 'len'=>'36','required'=>true), 
              	      'parent_id'=>array('name' =>'parent_id', 'type' =>'id', 'len'=>'36','required'=>true),               	                   	
				      'date_created'=>array('name' =>'date_created','type' => 'datetime'),
				      'created_by'=>array('name' =>'created_by','type' => 'varchar','len' => 36),				
					  'field_name'=>array('name' =>'field_name','type' => 'varchar','len' => 100),
					  'data_type'=>array('name' =>'data_type','type' => 'varchar','len' => 100),
					  'before_value_string'=>array('name' =>'before_value_string','type' => 'varchar'),
					  'after_value_string'=>array('name' =>'after_value_string','type' => 'varchar'),
					  'before_value_text'=>array('name' =>'before_value_text','type' => 'text'),
					  'after_value_text'=>array('name' =>'after_value_text','type' => 'text'),
				),
				'indices' => array (
				      //name will be re-constructed adding idx_ and table name as the prefix like 'idx_accounts_'
				      array ('name' => 'pk', 'type' => 'primary', 'fields' => array('id')),
				      array ('name' => 'parent_id', 'type' => 'index', 'fields' => array('parent_id'))
				)
		)
?>