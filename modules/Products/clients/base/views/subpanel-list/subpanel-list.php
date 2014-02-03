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
$viewdefs['Products']['base']['view']['subpanel-list'] = array(
  'panels' => array(
    array(
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => array(
        array(
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => 'true',
        ),
        array(
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
          'name' => 'status',
        ),
        array(
          'target_record_key' => 'account_id',
          'target_module' => 'Accounts',
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'account_name',
          'sortable' => false,
        ),
        array(
          'target_record_key' => 'contact_id',
          'target_module' => 'Contacts',
          'label' => 'LBL_LIST_CONTACT_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'contact_name',
          'sortable' => false,
        ),
        array(
          'label' => 'LBL_LIST_DATE_PURCHASED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_purchased',
        ),
        array(
          'label' => 'LBL_LIST_DISCOUNT_PRICE',
          'enabled' => true,
          'default' => true,
          'name' => 'discount_price',
        ),
        array(
          'label' => 'LBL_LIST_SUPPORT_EXPIRES',
          'enabled' => true,
          'default' => true,
          'name' => 'date_support_expires',
        ),
      ),
    ),
  ),
);
