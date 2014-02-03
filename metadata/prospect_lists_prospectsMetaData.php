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

$dictionary['prospect_lists_prospects'] = array ( 

	'table' => 'prospect_lists_prospects',

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
			'name' => 'related_id',
			'type' => 'varchar',
			'len' => '36',
		),
		array (
			'name' => 'related_type',
			'type' => 'varchar',
			'len' => '25',  //valid values are Prospect, Contact, Lead, User
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
			'name' => 'prospect_lists_prospectspk',
			'type' => 'primary',
			'fields' => array ( 'id' )
		),
		array (
			'name' => 'idx_plp_pro_id',
			'type' => 'index',
			'fields' => array ('prospect_list_id')
		),
		array (
			'name' => 'idx_plp_rel_id',
			'type' => 'alternate_key',
			'fields' => array (	'related_id',
								'related_type',
								'prospect_list_id'
						)
		),
	),
	
 	'relationships' => array (
		'prospect_list_contacts' => array(	'lhs_module'=> 'ProspectLists', 
											'lhs_table'=> 'prospect_lists', 
											'lhs_key' => 'id',
											'rhs_module'=> 'Contacts', 
											'rhs_table'=> 'contacts', 
											'rhs_key' => 'id',
											'relationship_type'=>'many-to-many',
											'join_table'=> 'prospect_lists_prospects', 
											'join_key_lhs'=>'prospect_list_id', 
											'join_key_rhs'=>'related_id',
											'relationship_role_column'=>'related_type',
											'relationship_role_column_value'=>'Contacts'
									),

		'prospect_list_prospects' =>array(	'lhs_module'=> 'ProspectLists', 
											'lhs_table'=> 'prospect_lists', 
											'lhs_key' => 'id',
											'rhs_module'=> 'Prospects', 
											'rhs_table'=> 'prospects', 
											'rhs_key' => 'id',
											'relationship_type'=>'many-to-many',
											'join_table'=> 'prospect_lists_prospects', 
											'join_key_lhs'=>'prospect_list_id', 
											'join_key_rhs'=>'related_id',
											'relationship_role_column'=>'related_type',
											'relationship_role_column_value'=>'Prospects'
									),

		'prospect_list_leads' =>array(	'lhs_module'=> 'ProspectLists', 
										'lhs_table'=> 'prospect_lists', 
										'lhs_key' => 'id',
										'rhs_module'=> 'Leads', 
										'rhs_table'=> 'leads', 
										'rhs_key' => 'id',
										'relationship_type'=>'many-to-many',
										'join_table'=> 'prospect_lists_prospects', 
										'join_key_lhs'=>'prospect_list_id', 
										'join_key_rhs'=>'related_id',
										'relationship_role_column'=>'related_type',
										'relationship_role_column_value'=>'Leads',
								),

		'prospect_list_users' =>array(	'lhs_module'=> 'ProspectLists', 
										'lhs_table'=> 'prospect_lists', 
										'lhs_key' => 'id',
										'rhs_module'=> 'Users', 
										'rhs_table'=> 'users', 
										'rhs_key' => 'id',
										'relationship_type'=>'many-to-many',
										'join_table'=> 'prospect_lists_prospects', 
										'join_key_lhs'=>'prospect_list_id', 
										'join_key_rhs'=>'related_id',
										'relationship_role_column'=>'related_type',
										'relationship_role_column_value'=>'Users',
								),

		'prospect_list_accounts' =>array(	'lhs_module'=> 'ProspectLists', 
											'lhs_table'=> 'prospect_lists', 
											'lhs_key' => 'id',
											'rhs_module'=> 'Accounts', 
											'rhs_table'=> 'accounts', 
											'rhs_key' => 'id',
											'relationship_type'=>'many-to-many',
											'join_table'=> 'prospect_lists_prospects', 
											'join_key_lhs'=>'prospect_list_id', 
											'join_key_rhs'=>'related_id',
											'relationship_role_column'=>'related_type',
											'relationship_role_column_value'=>'Accounts',
								)
	)
	
)
?>