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

	

$mod_strings = array (
  'ERR_DELETE_RECORD' => 'A record number must be specified to delete the sale.',
  'LBL_ACCOUNT_ID' => 'Account ID',
  'LBL_ACCOUNT_NAME' => 'Account Name:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
  'LBL_AMOUNT' => 'Amount:',
  'LBL_AMOUNT_USDOLLAR' => 'Amount USD:',
  'LBL_ASSIGNED_TO_ID' => 'Assigned to ID',
  'LBL_ASSIGNED_TO_NAME' => 'User:',
  'LBL_CAMPAIGN' => 'Campaign:',
  'LBL_CLOSED_WON_SALES' => 'Closed Won Sales',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacts',
  'LBL_CREATED_ID' => 'Created by ID',
  'LBL_CURRENCY' => 'Currency:',
  'LBL_CURRENCY_ID' => 'Currency ID',
  'LBL_CURRENCY_NAME' => 'Currency Name',
  'LBL_CURRENCY_SYMBOL' => 'Currency Symbol',
  'LBL_DATE_CLOSED' => 'Expected Close Date:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Sale',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_DUPLICATE' => 'Possible Duplicate Sale',
  'LBL_EDIT_BUTTON' => 'Edit',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'History',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Lead Source:',
  'LBL_LIST_ACCOUNT_NAME' => 'Account Name',
  'LBL_LIST_AMOUNT' => 'Amount',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Assigned User',
  'LBL_LIST_DATE_CLOSED' => 'Close',
  'LBL_LIST_FORM_TITLE' => 'Sale List',
  'LBL_LIST_SALE_NAME' => 'Name',
  'LBL_LIST_SALE_STAGE' => 'Sales Stage',
  'LBL_MODIFIED_ID' => 'Modified by ID',
  'LBL_MODIFIED_NAME' => 'Modified by User Name',
  'LBL_MODULE_NAME' => 'Sale',
  'LBL_MODULE_TITLE' => 'Sale: Home',
  'LBL_MY_CLOSED_SALES' => 'My Closed Sales',
  'LBL_NAME' => 'Sale Name',
  'LBL_NEW_FORM_TITLE' => 'Create Sale',
  'LBL_NEXT_STEP' => 'Next Step:',
  'LBL_PROBABILITY' => 'Probability (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projects',
  'LBL_RAW_AMOUNT' => 'Raw Amount',
  'LBL_REMOVE' => 'Remove',
  'LBL_SALE' => 'Sale:',
  'LBL_SALES_STAGE' => 'Sales Stage:',
  'LBL_SALE_INFORMATION' => 'Sale Information',
  'LBL_SALE_NAME' => 'Sale Name:',
  'LBL_SEARCH_FORM_TITLE' => 'Sale Search',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TOP_SALES' => 'My Top Open Sale',
  'LBL_TOTAL_SALES' => 'Total Sales',
  'LBL_TYPE' => 'Type:',
  'LBL_VIEW_FORM_TITLE' => 'Sale View',
  'LNK_NEW_SALE' => 'Create Sale',
  'LNK_SALE_LIST' => 'Sale',
  'MSG_DUPLICATE' => 'The Sale record you are about to create might be a duplicate of a sale record that already exists. Sale records containing similar names are listed below.<br>Click Save to continue creating this new Sale, or click Cancel to return to the module without creating the sale.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Are you sure you want to remove this contact from the sale?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Are you sure you want to remove this sale from the project?',
  'UPDATE' => 'Sale - Currency Update',
  'UPDATE_BUGFOUND_COUNT' => 'Bugs Found:',
  'UPDATE_BUG_COUNT' => 'Bugs Found and Attempted to Resolve:',
  'UPDATE_COUNT' => 'Records Updated:',
  'UPDATE_CREATE_CURRENCY' => 'Creating New Currency:',
  'UPDATE_DOLLARAMOUNTS' => 'Update U.S. Dollar Amounts',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Update the U.S. Dollar amounts for sales based on the current set currency rates. This value is used to calculate Graphs and List View Currency Amounts.',
  'UPDATE_DONE' => 'Done',
  'UPDATE_FAIL' => 'Could not update -',
  'UPDATE_FIX' => 'Fix Amounts',
  'UPDATE_FIX_TXT' => 'Attempts to fix any invalid amounts by creating a valid decimal from the current amount. Any modified amount is backed up in the amount_backup database field. If you run this and notice bugs, do not rerun it without restoring from the backup as it may overwrite the backup with new invalid data.',
  'UPDATE_INCLUDE_CLOSE' => 'Include Closed Records',
  'UPDATE_MERGE' => 'Merge Currencies',
  'UPDATE_MERGE_TXT' => 'Merge multiple currencies into a single currency. If there are multiple currency records for the same currency, you merge them together. This will also merge the currencies for all other modules.',
  'UPDATE_NULL_VALUE' => 'Amount is NULL setting it to 0 -',
  'UPDATE_RESTORE' => 'Restore Amounts',
  'UPDATE_RESTORE_COUNT' => 'Record Amounts Restored:',
  'UPDATE_RESTORE_TXT' => 'Restores amount values from the backups created during fix.',
  'UPDATE_VERIFY' => 'Verify Amounts',
  'UPDATE_VERIFY_CURAMOUNT' => 'Current Amount:',
  'UPDATE_VERIFY_FAIL' => 'Record Failed Verification:',
  'UPDATE_VERIFY_FIX' => 'Running Fix would give',
  'UPDATE_VERIFY_NEWAMOUNT' => 'New Amount:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'New Currency:',
  'UPDATE_VERIFY_TXT' => 'Verifies that the amount values in sales are valid decimal numbers with only numeric characters(0-9) and decimals(.)',
);

