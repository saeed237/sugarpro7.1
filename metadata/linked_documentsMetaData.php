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

$dictionary['linked_documents'] = array ( 'table' => 'linked_documents'
   , 'fields' => array (
        array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'parent_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'parent_type', 'type' =>'varchar', 'len'=>'25')      
      , array('name' =>'document_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'document_revision_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
   )   
   , 'indices' => array (
        array('name' =>'linked_documentspk', 'type' =>'primary', 'fields'=>array('id')),
        array(	'name'			=> 'idx_parent_document', 
				'type'			=> 'alternate_key', 
				'fields'		=> array('parent_type','parent_id','document_id'),
		),
   )
   , 'relationships' => array (
			'contracts_documents' => array('lhs_module'=> 'Contracts', 'lhs_table'=> 'contracts', 'lhs_key' => 'id',
				   'rhs_module'=> 'Documents', 'rhs_table'=> 'documents', 'rhs_key' => 'id',
				   'relationship_type'=>'many-to-many',
				   'join_table'=> 'linked_documents', 'join_key_lhs'=>'parent_id', 'join_key_rhs'=>'document_id', 'relationship_role_column'=>'parent_type',
				   'relationship_role_column_value'=>'Contracts'),
			'leads_documents' => array('lhs_module'=> 'Leads', 'lhs_table'=> 'leads', 'lhs_key' => 'id',
				   'rhs_module'=> 'Documents', 'rhs_table'=> 'documents', 'rhs_key' => 'id',
				   'relationship_type'=>'many-to-many',
				   'join_table'=> 'linked_documents', 'join_key_lhs'=>'parent_id', 'join_key_rhs'=>'document_id', 'relationship_role_column'=>'parent_type',
				   'relationship_role_column_value'=>'Leads'),
			'contracttype_documents' => array('lhs_module'=> 'ContractTypes', 'lhs_table'=> 'contract_types', 'lhs_key' => 'id',
				   'rhs_module'=> 'Documents', 'rhs_table'=> 'documents', 'rhs_key' => 'id',
				   'relationship_type'=>'many-to-many',
				   'join_table'=> 'linked_documents', 'join_key_lhs'=>'parent_id', 'join_key_rhs'=>'document_id', 'relationship_role_column'=>'parent_type',
				   'relationship_role_column_value'=>'ContracTemplates'),
			),
   );
?>