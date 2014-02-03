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

$dictionary['contacts_cases'] = array ( 'table' => 'contacts_cases'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'contact_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'case_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'contact_role', 'type' =>'varchar', 'len'=>'50')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0','required'=>false)
                                                      )                                  , 'indices' => array (
       array('name' =>'contacts_casespk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_con_case_con', 'type' =>'index', 'fields'=>array('contact_id'))
      , array('name' =>'idx_con_case_case', 'type' =>'index', 'fields'=>array('case_id'))
      , array('name' => 'idx_contacts_cases', 'type'=>'alternate_key', 'fields'=>array('contact_id','case_id'))                  
                                                      )
 	  , 'relationships' => array ('contacts_cases' => array('lhs_module'=> 'Contacts', 'lhs_table'=> 'contacts', 'lhs_key' => 'id',
							  'rhs_module'=> 'Cases', 'rhs_table'=> 'cases', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'contacts_cases', 'join_key_lhs'=>'contact_id', 'join_key_rhs'=>'case_id'))
                                  
)
?>
