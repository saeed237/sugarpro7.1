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

$dictionary['quotes_contacts'] = array ( 'table' => 'quotes_contacts'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'contact_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'quote_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'contact_role', 'type' =>'varchar', 'len'=>'20', )
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
		)                                  
		
  , 'indices' => array (
       array('name' =>'quotes_contactspk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_con_qte_con', 'type' =>'index', 'fields'=>array('contact_id'))
      , array('name' =>'idx_con_qte_opp', 'type' =>'index', 'fields'=>array('quote_id'))
      , array('name' => 'idx_quote_contact_role', 'type'=>'alternate_key', 'fields'=>array('quote_id','contact_role'))
                                                      )
                                                      
  , 'relationships' => array ('quotes_contacts_shipto' => 
   								array('rhs_module'=> 'Quotes', 'rhs_table'=> 'quotes', 
								'rhs_key' => 'id','lhs_module'=> 'Contacts', 'lhs_table'=> 'contacts', 
								'lhs_key' => 'id','relationship_type'=>'many-to-many','true_relationship_type' => 'one-to-many',
						  		'join_table'=> 'quotes_contacts', 'join_key_rhs'=>'quote_id', 'join_key_lhs'=>'contact_id',
							    'relationship_role_column'=>'contact_role', 'relationship_role_column_value'=>'Ship To'
						  		),
					   			'quotes_contacts_billto' => 
   								array('rhs_module'=> 'Quotes', 'rhs_table'=> 'quotes', 
								'rhs_key' => 'id','lhs_module'=> 'Contacts', 'lhs_table'=> 'contacts', 
								'lhs_key' => 'id','relationship_type'=>'many-to-many','true_relationship_type' => 'one-to-many',
						  		'join_table'=> 'quotes_contacts', 'join_key_rhs'=>'quote_id', 'join_key_lhs'=>'contact_id',
							    'relationship_role_column'=>'contact_role', 'relationship_role_column_value'=>'Bill To'
						  		)						  		
							)
)
?>
