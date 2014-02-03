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
$module_name = '<module_name>';
$viewdefs[$module_name]['base']['view']['subpanel-list'] = array(
  'panels' => 
  array(
    array(
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array(
        array(
          'name' => 'name',
          'label' => 'LBL_LIST_SALE_NAME',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'sales_stage',
          'label' => 'LBL_LIST_SALE_STAGE',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'date_closed',
          'label' => 'LBL_LIST_DATE_CLOSED',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'label' => 'LBL_LIST_AMOUNT',
          'enabled' => true,
          'default' => true,
          'name' => 'amount',
          'related_fields' => array(
              'currency_id',
              'base_rate'
          ),
        ),
        array(
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
);
