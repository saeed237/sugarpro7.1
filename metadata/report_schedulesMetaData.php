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


$dictionary['report_schedules'] = array ( 'table' => 'report_schedules'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'dbType' => 'id', 'len'=>'36', )
      , array('name' =>'user_id', 'type' =>'varchar',  'dbType' => 'id', 'len'=>'36', 'required'=>true)
      , array('name' =>'report_id', 'type' =>'varchar',  'dbType' => 'id', 'len'=>'36', 'required'=>true)
      , array ('name' => 'date_start','type' => 'datetime')
      , array('name' =>'next_run', 'type' =>'datetime', 'len'=>'', 'required'=>true)
      , array('name' =>'active', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>true)
      , array('name' =>'time_interval', 'type' =>'int', 'len'=>'11')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'schedule_type', 'type' =>'varchar', 'len'=>'3')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
                                                      )                                  , 'indices' => array (
       array('name' =>'report_schedulespk', 'type' =>'primary', 'fields'=>array('id'))
                                                      ),
       array('name' => 'idx_report_schedule_user_id', 'type' => 'index', 'fields' => array ('user_id')),
      )
?>
