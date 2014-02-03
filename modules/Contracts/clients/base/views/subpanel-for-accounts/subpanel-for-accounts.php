<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (\“MSA\”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
$viewdefs['Contracts']['base']['view']['subpanel-for-accounts'] = array(
  'type' => 'subpanel-list',
  'panels' =>
  array(
    array(
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' =>
      array(
        array(
          'name' => 'name',
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        array(
          'name' => 'start_date',
          'label' => 'LBL_LIST_START_DATE',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'end_date',
          'label' => 'LBL_LIST_END_DATE',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'status',
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'total_contract_value',
          'label' => 'LBL_LIST_CONTRACT_VALUE',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
);
