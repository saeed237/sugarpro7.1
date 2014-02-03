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

$dictionary['accounts_bugs'] = array ( 'table' => 'accounts_bugs'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36',)
      , array('name' =>'account_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'bug_id', 'type' =>'varchar', 'len'=>'36')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'required'=>false, 'default'=>'0')
                                                      )                                  , 'indices' => array (
       array('name' =>'accounts_bugspk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_acc_bug_acc', 'type' =>'index', 'fields'=>array('account_id'))
      , array('name' =>'idx_acc_bug_bug', 'type' =>'index', 'fields'=>array('bug_id'))
      , array('name' => 'idx_account_bug', 'type'=>'alternate_key', 'fields'=>array('account_id','bug_id'))      
      )
      
 	  , 'relationships' => array ('accounts_bugs' => array('lhs_module'=> 'Accounts', 'lhs_table'=> 'accounts', 'lhs_key' => 'id',
							  'rhs_module'=> 'Bugs', 'rhs_table'=> 'bugs', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'accounts_bugs', 'join_key_lhs'=>'account_id', 'join_key_rhs'=>'bug_id'))
)
?>
