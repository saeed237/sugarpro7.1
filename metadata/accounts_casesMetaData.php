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

$dictionary['accounts_cases'] = array ( 'table' => 'accounts_cases'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'account_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'case_id', 'type' =>'varchar', 'len'=>'36')
      , array ('name' => 'date_modified','type' => 'datetime')
  	,array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'required'=>false, 'default'=>'0')
                                                      )                                  , 'indices' => array (
       array('name' =>'accounts_casespk', 'type' =>'primary', 'fields'=>array('id'))
       , array('name' =>'idx_acc_case_acc', 'type' =>'index', 'fields'=>array('account_id'))
      , array('name' =>'idx_acc_acc_case', 'type' =>'index', 'fields'=>array('case_id'))
                                                      )
                                  )
?>
