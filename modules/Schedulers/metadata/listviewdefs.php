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


$listViewDefs ['Schedulers'] =
array (
  'NAME' =>
  array (
    'width' => '35%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'sortable' => true,
    'default' => true,
  ),
  'JOB_INTERVAL' =>
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_JOB_INTERVAL',
    'default' => true,
  	'sortable' => false,
  ),
  'DATE_TIME_START' =>
  array (
    'width' => '25%',
    'label' => 'LBL_LIST_RANGE',
  	'customCode' => '{$DATE_TIME_START} - {$DATE_TIME_END}',
    'default' => true,
  	'related_fields' => array('date_time_end'),
  ),
  'STATUS' =>
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
  ),
);
