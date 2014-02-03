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
$viewdefs['Documents']['base']['view']['subpanel-for-contracttype'] = array(
  'type' => 'subpanel-list',
  'panels' =>
  array(
    array(
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' =>
      array(
        array(
          'name' => 'document_name',
          'label' => 'LBL_LIST_DOCUMENT_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        array(
          'name' => 'is_template',
          'label' => 'LBL_LIST_IS_TEMPLATE',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'template_type',
          'label' => 'LBL_LIST_TEMPLATE_TYPE',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'latest_revision',
          'label' => 'LBL_LATEST_REVISION',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
);
