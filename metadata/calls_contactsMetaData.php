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

$dictionary['calls_contacts'] = array ( 'table' => 'calls_contacts'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'call_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'contact_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'required', 'type' =>'varchar', 'len'=>'1', 'default'=>'1')
      , array('name' =>'accept_status', 'type' =>'varchar', 'len'=>'25', 'default'=>'none')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
                                                      )     
                                  , 'indices' => array (
       array('name' =>'calls_contactspk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_con_call_call', 'type' =>'index', 'fields'=>array('call_id'))
      , array('name' =>'idx_con_call_con', 'type' =>'index', 'fields'=>array('contact_id'))
      , array('name' => 'idx_call_contact', 'type'=>'alternate_key', 'fields'=>array('call_id','contact_id'))            
                                                      )

 	  , 'relationships' => array ('calls_contacts' => array('lhs_module'=> 'Calls', 'lhs_table'=> 'calls', 'lhs_key' => 'id',
							  'rhs_module'=> 'Contacts', 'rhs_table'=> 'contacts', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'calls_contacts', 'join_key_lhs'=>'call_id', 'join_key_rhs'=>'contact_id'))

)
?>
