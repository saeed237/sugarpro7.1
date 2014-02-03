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
$viewdefs['Accounts']['base']['view']['subpanel-list'] = array(
  'panels' =>
  array(
    array(
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' =>
      array(
        array(
          'default' => true,
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'name' => 'name',
          'link' => true,
        ),
        array(
          'default' => true,
          'label' => 'LBL_LIST_CITY',
          'enabled' => true,
          'name' => 'billing_address_city',
        ),
        array(
          'type' => 'varchar',
          'default' => true,
          'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
          'enabled' => true,
          'name' => 'billing_address_country',
        ),
        array(
          'default' => true,
          'label' => 'LBL_LIST_PHONE',
          'enabled' => true,
          'name' => 'phone_office',
        ),
      ),
    ),
  ),
);
