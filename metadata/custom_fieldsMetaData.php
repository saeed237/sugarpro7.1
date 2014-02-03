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

$dictionary['custom_fields'] = array ( 'table' => 'custom_fields'
                                  , 'fields' => array (
       array('name' =>'bean_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'set_num', 'type' =>'int', 'len'=>'11', 'default'=>'0')
      , array('name' =>'field0', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field1', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field2', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field3', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field4', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field5', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field6', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field7', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field8', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field9', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0')
                                                      )                                  , 'indices' => array (
       array('name' =>'idx_beanid_set_num', 'type' =>'index', 'fields'=>array('bean_id','set_num'))
                                                      )
                                  )
?>
