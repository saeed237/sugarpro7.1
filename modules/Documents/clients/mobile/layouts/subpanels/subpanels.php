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

$viewdefs['Documents']['mobile']['layout']['subpanels'] = array (
  'components' => array (
      array (
          'layout' => 'subpanel',
          'label' => 'LBL_ACCOUNTS_SUBPANEL_TITLE',
          'context' => array (
              'link' => 'accounts',
          ),
      ),
      array (
          'layout' => 'subpanel',
          'label' => 'LBL_CONTACTS_SUBPANEL_TITLE',
          'context' => array (
              'link' => 'contacts',
          ),
      ),
      array (
          'layout' => 'subpanel',
          'label' => 'LBL_OPPORTUNITIES_SUBPANEL_TITLE',
          'context' => array (
              'link' => 'opportunities',
          ),
      ),
      array (
          'layout' => 'subpanel',
          'label' => 'LBL_CASES_SUBPANEL_TITLE',
          'context' => array (
              'link' => 'cases',
          ),
      ),
      array(
          'layout' => 'subpanel',
          'label' => 'LBL_RLI_SUBPANEL_TITLE',
          'creatable' => false,
          'context' => array(
              'link' => 'revenuelineitems',
          ),
      ),
      array (
          'layout' => 'subpanel',
          'label' => 'LBL_QUOTES_SUBPANEL_TITLE',
          'context' => array (
              'link' => 'quotes',
          ),
      ),
  ),
);
