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

$dictionary['email_marketing_prospect_lists'] = array ( 

	'table' => 'email_marketing_prospect_lists',

	'fields' => array (
		array (
			'name' => 'id',
			'type' => 'varchar',
			'len' => '36',
		),
		array (
			'name' => 'prospect_list_id',
			'type' => 'varchar',
			'len' => '36',
		),
		array (
			'name' => 'email_marketing_id',
			'type' => 'varchar',
			'len' => '36',
		),
        array (
			'name' => 'date_modified',
			'type' => 'datetime'
		),
		array (
			'name' => 'deleted',
			'type' => 'bool',
			'len' => '1',
			'default' => '0'
		),
	),
	'indices' => array (
		array (
			'name' => 'email_mp_listspk',
			'type' => 'primary',
			'fields' => array ( 'id' )
		),
		array (
			'name' => 'email_mp_prospects',
			'type' => 'alternate_key',
			'fields' => array (	'email_marketing_id',
								'prospect_list_id'
						)
		),
	),
	
 	'relationships' => array (
		'email_marketing_prospect_lists' => array(
											'lhs_module'=> 'EmailMarketing', 
											'lhs_table'=> 'email_marketing', 
											'lhs_key' => 'id',
											'rhs_module'=> 'ProspectLists', 
											'rhs_table'=> 'prospect_lists', 
											'rhs_key' => 'id',
											'relationship_type'=>'many-to-many',
											'join_table'=> 'email_marketing_prospect_lists', 
											'join_key_lhs'=>'email_marketing_id',
											'join_key_rhs'=>'prospect_list_id', 
		),
	)
)
?>