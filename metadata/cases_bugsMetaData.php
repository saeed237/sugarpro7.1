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

$dictionary['cases_bugs'] = array ( 'table' => 'cases_bugs'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'case_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'bug_id', 'type' =>'varchar', 'len'=>'36')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
                                                      )                                  , 'indices' => array (
       array('name' =>'cases_bugspk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_cas_bug_cas', 'type' =>'index', 'fields'=>array('case_id'))
      , array('name' =>'idx_cas_bug_bug', 'type' =>'index', 'fields'=>array('bug_id'))
      , array('name' => 'idx_case_bug', 'type'=>'alternate_key', 'fields'=>array('case_id','bug_id'))            
      
                                                      )
 	  , 'relationships' => array ('cases_bugs' => array('lhs_module'=> 'Cases', 'lhs_table'=> 'cases', 'lhs_key' => 'id',
							  'rhs_module'=> 'Bugs', 'rhs_table'=> 'bugs', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'cases_bugs', 'join_key_lhs'=>'case_id', 'join_key_rhs'=>'bug_id'))
                                                      
                                  )
?>
