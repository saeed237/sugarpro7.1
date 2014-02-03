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


		// Create the indexes
$dictionary['vCal'] = array('table' => 'vcals'
                               ,'fields' => array (
  'id' => 
  array (
    'name' => 'id',
    'vname' => 'LBL_NAME',
    'type' => 'id',
    'required'=>true,
    'reportable'=>false,
  ),
     'deleted' => 
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'required' => false,
    'reportable'=>false,
  ),
  'date_entered' => 
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
  ),
  'date_modified' => 
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
  ),
    'user_id' => 
  array (
    'name' => 'user_id',
    'type' => 'id',
	'required'=>true,
	'reportable'=>false,
  ),
    'type' => 
  array (
    'name' => 'type',
    'type' => 'varchar',
    'len' => 100,
  ),
  'source' => 
  array (
    'name' => 'source',
    'type' => 'varchar',
    'len' => 100,
  ),
  'content' => 
  array (
    'name' => 'content',
    'type' => 'text',
  ),
  

)
                                                      , 'indices' => array (
       array('name' =>'vcalspk', 'type' =>'primary', 'fields'=>array('id')),
        array('name' =>'idx_vcal', 'type' =>'index', 'fields'=>array('type', 'user_id'))
                                                      )

                            );
?>