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

// created: 2005-11-03 19:18:13
$acldefs['Quotes'] = array (
  'forms' => 
  array (
    'by_name' => 
    array (
      'Billing_account_button' => 
      array (
        'display_option' => 'disabled',
        'action_option' => 'list',
        'app_action' => 'EditView',
        'module' => 'Accounts',
      ),
      'Shipping_account_button' => 
      array (
        'display_option' => 'disabled',
        'action_option' => 'list',
        'app_action' => 'EditView',
        'module' => 'Accounts',
      ),
      'Billing_contact_button' => 
      array (
        'display_option' => 'disabled',
        'action_option' => 'list',
        'app_action' => 'EditView',
        'module' => 'Contacts',
      ),
      'Shipping_contact_button' => 
      array (
        'display_option' => 'disabled',
        'action_option' => 'list',
        'app_action' => 'EditView',
        'module' => 'Contacts',
      ),
      'Opportunity_button' => 
      array (
        'display_option' => 'disabled',
        'action_option' => 'list',
        'app_action' => 'EditView',
        'module' => 'Opportunities',
      ),
      'opp_to_quote_button' => 
      array (
        'display_option' => 'disabled',
        'action_option' => 'edit',
        'app_action' => 'DetailView',
        'module' => 'Opportunities',
      ),
    ),
  ),
  'form_names' => 
  array (
    'by_id' => 'by_id',
    'by_name' => 'by_name',
    'DetailView' => 'DetailView',
    'EditView' => 'EditView',
  ),
);
?>
