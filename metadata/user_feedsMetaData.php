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

$dictionary['users_feeds'] = array ( 'table' => 'users_feeds'
                                  , 'fields' => array (
    
       array('name' =>'user_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'feed_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'rank', 'type' =>'int', 'required' => false)
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'', 'default'=>'0', 'required' => false)
                                                      ) 
                                 , 'indices' => array (
  
       array('name' =>'idx_ud_user_id', 'type' =>'index', 'fields'=>array('user_id', 'feed_id'))                                  
                                                      )
                                  )
?>
