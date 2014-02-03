<?php
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

$listViewDefs ['Meetings'] = 
array (
  'SET_COMPLETE' => 
  array (
    'width' => '1%',
    'label' => 'LBL_LIST_CLOSE',
    'link' => true,
    'sortable' => false,
    'default' => true,
    'related_fields' => 
    array (
      0 => 'status',
    ),
  ),
  'JOIN_MEETING' => 
  array (
    'width' => '1%',
    'label' => 'LBL_LIST_JOIN_MEETING',
    'link' => true,
    'sortable' => false,
    'default' => true,
    'related_fields' => 
    array('join_url', 'host_url'),
    'noHeader' => true,
  ),
  'NAME' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_SUBJECT',
    'link' => true,
    'default' => true,
  ),
  'CONTACT_NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_CONTACT',
    'link' => true,
    'id' => 'CONTACT_ID',
    'module' => 'Contacts',
    'default' => true,
    'ACLTag' => 'CONTACT',
  ),
  'PARENT_NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_RELATED_TO',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'link' => true,
    'default' => true,
    'sortable' => false,
    'ACLTag' => 'PARENT',
    'related_fields' => 
    array (
      0 => 'parent_id',
      1 => 'parent_type',
    ),
  ),
  'DATE_START' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_DATE',
    'link' => false,
    'default' => true,
    'related_fields' => 
    array (
      0 => 'time_start',
    ),
  ),
  'TEAM_NAME' => 
  array(
    'width' => '2', 
    'label' => 'LBL_LIST_TEAM',
    'default' => false
  ),        
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '2%',
    'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'DIRECTION' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_LIST_DIRECTION',
    'width' => '10%',
    'default' => false,
  ),
  'STATUS' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_STATUS',
    'link' => false,
    'default' => false,
  ),
  'DATE_ENTERED' => array (
	'width' => '10%',
	'label' => 'LBL_DATE_ENTERED',
	'default' => true
  ),  
);
?>
