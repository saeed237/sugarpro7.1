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

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array (
  'LBL_MODULE_NAME' => 'Currencies',
  'LBL_MODULE_NAME_SINGULAR' => 'Currency',
  'LBL_LIST_FORM_TITLE' => 'Currencies',
  'LBL_CURRENCY' => 'Currency',
  'LBL_ADD' => 'Add',
  'LBL_MERGE' => 'Merge',
  'LBL_MERGE_TXT' => 'Please select the currencies you would like to map to the selected currency. This will delete all the currencies with a checkmark and reassign any value associated with them to the selected currency.',
  'LBL_US_DOLLAR' => 'U.S. Dollar',
  'LBL_DELETE' => 'Delete',
  'LBL_LIST_SYMBOL' => 'Currency Symbol',
  'LBL_LIST_NAME' => 'Currency Name',
  'LBL_LIST_ISO4217' => 'ISO 4217 Code',
  'LBL_LIST_ISO4217_HELP' => 'Enter a three-letter ISO 4217 code that defines the currency name and currency symbol.',
  'LBL_UPDATE' => 'Update',
  'LBL_LIST_RATE' => 'Conversion Rate',
  'LBL_LIST_RATE_HELP' => 'A Conversion Rate of 0.5 for Euro means that 10 USD = 5 Euro.',
  'LBL_LIST_STATUS' => 'Status',
  'LNK_NEW_CONTACT' => 'New Contact',
  'LNK_NEW_ACCOUNT' => 'New Account',
  'LNK_NEW_OPPORTUNITY' => 'New Opportunity',
  'LNK_NEW_CASE' => 'New Case',
  'LNK_NEW_NOTE' => 'Create Note or Attachment',
  'LNK_NEW_CALL' => 'New Call',
  'LNK_NEW_EMAIL' => 'New Email',
  'LNK_NEW_MEETING' => 'New Meeting',
  'LNK_NEW_TASK' => 'Create Task',
  'NTC_DELETE_CONFIRMATION' => 'Are you sure you want to delete this record? Any record using this currency will be converted to the system default currency when they are accessed. It may be better to set the status to inactive.',
  'LBL_BELOW_MIN' => 'Conversion rate has to be above 0',
  'currency_status_dom' => 
  array (
    'Active' => 'Active',
    'Inactive' => 'Inactive',
  ),
  'LBL_CREATED_BY' => 'Created By',
  'LBL_EDIT_LAYOUT' => 'Edit Layout' /*for 508 compliance fix*/,
  'LBL_ADMIN_ONLY' => 'Administrators Only',
);
?>
