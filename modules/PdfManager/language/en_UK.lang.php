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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'WARNING: If you change the primary module, all fields already added to template will need to be removed.',
  'LBL_ASSIGNED_TO_ID' => 'Assigned User Id',
  'LBL_ASSIGNED_TO_NAME' => 'Assigned to',
  'LBL_AUTHOR' => 'Author',
  'LBL_BASE_MODULE' => 'Module',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Select a module for which this template will be available.',
  'LBL_BODY_HTML' => 'Template',
  'LBL_BODY_HTML_POPUP_HELP' => 'Create the template using the HTML editor. After saving the template, you will be able to view a preview of the PDF version of the template.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Create the template using the HTML editor. After saving the template, you will be able to view a preview of the PDF version of the template.<br /><br />To edit the loop used to create the Product line items, click the "HTML" button in the editor to access the code.  The code is contained within &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => 'Insert',
  'LBL_CREATED' => 'Created By',
  'LBL_CREATED_ID' => 'Created By Id',
  'LBL_CREATED_USER' => 'Created by User',
  'LBL_DATE_ENTERED' => 'Date Created',
  'LBL_DATE_MODIFIED' => 'Date Modified',
  'LBL_DELETED' => 'Deleted',
  'LBL_DESCRIPTION' => 'Description',
  'LBL_EDITVIEW_PANEL1' => 'PDF Document Properties',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Here is the file you requested (You can change this text)',
  'LBL_FIELD' => 'Field',
  'LBL_FIELDS_LIST' => 'Fields',
  'LBL_FIELD_POPUP_HELP' => 'Select a field to insert the variable for the field value. To select fields of a parent module, first select the module in the Links area at the bottom of the Fields list in the first dropdown, then select the field in the second dropdown.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'View History',
  'LBL_HOMEPAGE_TITLE' => 'My PDF Templates',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Keyword(s)',
  'LBL_KEYWORDS_POPUP_HELP' => 'Associate Keywords with the document, generally in the form "keyword1 keyword2..."',
  'LBL_LINK_LIST' => 'Links',
  'LBL_LIST_FORM_TITLE' => 'PDF Template List',
  'LBL_LIST_NAME' => 'Name',
  'LBL_MODIFIED' => 'Modified By',
  'LBL_MODIFIED_ID' => 'Modified By Id',
  'LBL_MODIFIED_NAME' => 'Modified By Name',
  'LBL_MODIFIED_USER' => 'Modified by User',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Name',
  'LBL_NEW_FORM_TITLE' => 'New PDF Template',
  'LBL_PAYMENT_TERMS' => 'Payment Terms:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Preview',
  'LBL_PUBLISHED' => 'Published',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publish a template to make it available to users.',
  'LBL_PURCHASE_ORDER_NUM' => 'Purchase Order Num:',
  'LBL_SEARCH_FORM_TITLE' => 'Search PDF Manager',
  'LBL_SUBJECT' => 'Subject',
  'LBL_TEAM' => 'Teams',
  'LBL_TEAMS' => 'Teams',
  'LBL_TEAM_ID' => 'Team Id',
  'LBL_TITLE' => 'Title',
  'LBL_TPL_BILL_TO' => 'Bill To',
  'LBL_TPL_CURRENCY' => 'Currency:',
  'LBL_TPL_DISCOUNT' => 'Discount:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Discounted Subtotal:',
  'LBL_TPL_EXT_PRICE' => 'Ext. Price',
  'LBL_TPL_GRAND_TOTAL' => 'Grand Total',
  'LBL_TPL_INVOICE' => 'Invoice',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'This template is used to print Invoice in PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Invoice',
  'LBL_TPL_INVOICE_NUMBER' => 'Invoice number:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'invoice',
  'LBL_TPL_LIST_PRICE' => 'List Price',
  'LBL_TPL_PART_NUMBER' => 'Part Number',
  'LBL_TPL_PRODUCT' => 'Product',
  'LBL_TPL_QUANTITY' => 'Quantity',
  'LBL_TPL_QUOTE' => 'Quote',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'This template is used to print Quote in PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Quote',
  'LBL_TPL_QUOTE_NUMBER' => 'Quote number:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'quote',
  'LBL_TPL_SALES_PERSON' => 'Sales Person:',
  'LBL_TPL_SHIPPING' => 'Shipping:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Shipping Provider:',
  'LBL_TPL_SHIP_TO' => 'Ship To',
  'LBL_TPL_SUBTOTAL' => 'Subtotal:',
  'LBL_TPL_TAX' => 'Tax:',
  'LBL_TPL_TAX_RATE' => 'Tax Rate:',
  'LBL_TPL_TOTAL' => 'Total',
  'LBL_TPL_UNIT_PRICE' => 'Unit Price',
  'LBL_TPL_VALID_UNTIL' => 'Valid until:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Edit PDF Template',
  'LNK_IMPORT_PDFMANAGER' => 'Import PDF Templates',
  'LNK_LIST' => 'View PDF Templates',
  'LNK_NEW_RECORD' => 'Create PDF Template',
);

