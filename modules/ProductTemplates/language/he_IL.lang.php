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
  'ERR_DELETE_RECORD' => 'A record number must be specified to delete the product.',
  'LBL_ACCOUNT_NAME' => 'שם חשבון:',
  'LBL_ASSIGNED_TO' => 'הוקצה עבור:',
  'LBL_ASSIGNED_TO_ID' => 'הוקצה עבור זהות:',
  'LBL_CATEGORY' => 'קטגוריה:',
  'LBL_CATEGORY_ID' => 'קטגוריה זהות:',
  'LBL_CATEGORY_NAME' => 'שם קטגוריה:',
  'LBL_CONTACT_NAME' => 'שם איש קשר:',
  'LBL_COST_PRICE' => 'עלות:',
  'LBL_COST_USDOLLAR' => 'עלות בשקלים:',
  'LBL_CURRENCY' => 'מטבע:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'סימול מטבע:',
  'LBL_DATE_AVAILABLE' => 'זמין מתאריך:',
  'LBL_DATE_COST_PRICE' => 'תאריך-עלות-מחיר:',
  'LBL_DESCRIPTION' => 'תיאור:',
  'LBL_DISCOUNT_PRICE' => 'מחיר ליחידה:',
  'LBL_DISCOUNT_PRICE_DATE' => 'תאריך מחיר בהנחה:',
  'LBL_DISCOUNT_USDOLLAR' => 'מחיר בהנחה בשקלים:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'הוקצה למשתמש ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'הוקצה למשתמש ששמו',
  'LBL_EXPORT_COST_PRICE' => 'מחיר עלות',
  'LBL_EXPORT_CREATED_BY' => 'נוצר על ידי ID',
  'LBL_EXPORT_CURRENCY' => 'מטבע:',
  'LBL_EXPORT_CURRENCY_ID' => 'מטבע זהות',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'שונה על ידי ID',
  'LBL_LIST_CATEGORY' => 'קטגוריה:',
  'LBL_LIST_CATEGORY_ID' => 'קטגוריה זהות:',
  'LBL_LIST_COST_PRICE' => 'עלות:',
  'LBL_LIST_DISCOUNT_PRICE' => 'מחיר:',
  'LBL_LIST_FORM_TITLE' => 'רשימת קטלוג מוצרים',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'יצרן מספר',
  'LBL_LIST_LIST_PRICE' => 'רשימה',
  'LBL_LIST_MANUFACTURER' => 'יצרן',
  'LBL_LIST_MANUFACTURER_ID' => 'יצרן זהות:',
  'LBL_LIST_NAME' => 'שם',
  'LBL_LIST_PRICE' => 'מחיר מחירון:',
  'LBL_LIST_QTY_IN_STOCK' => 'יחידות',
  'LBL_LIST_STATUS' => 'זמינות',
  'LBL_LIST_TYPE' => 'סוג:',
  'LBL_LIST_TYPE_ID' => 'סוג זהות:',
  'LBL_LIST_USDOLLAR' => 'מחירון בשקלים:',
  'LBL_MANUFACTURER' => 'יצרן:',
  'LBL_MANUFACTURER_ID' => 'יצרן זהות:',
  'LBL_MANUFACTURER_NAME' => 'שם יצרן:',
  'LBL_MFT_PART_NUM' => 'מספר חלק אצל היצרן:',
  'LBL_MODULE_ID' => 'תבנית מוצרים',
  'LBL_MODULE_NAME' => 'קטלוג מוצרים',
  'LBL_MODULE_TITLE' => 'קטלוג מוצרים: דף בית',
  'LBL_NAME' => 'שם מוצר:',
  'LBL_NEW_FORM_TITLE' => 'צור צוות',
  'LBL_PERCENTAGE' => 'אחוזים(%)',
  'LBL_POINTS' => 'נקודות',
  'LBL_PRICING_FACTOR' => 'פקטור תימחור:',
  'LBL_PRICING_FORMULA' => 'נוסחת תמחור בררת מחדל :',
  'LBL_PRODUCT' => 'מוצר:',
  'LBL_PRODUCT_ID' => 'מוצר זהות:',
  'LBL_QTY_IN_STOCK' => 'כמות במלאי',
  'LBL_QUANTITY' => 'כמות במלאי:',
  'LBL_RELATED_PRODUCTS' => 'מוצרים קשורים',
  'LBL_SEARCH_FORM_TITLE' => 'חיפוש קטלוג מוצר',
  'LBL_STATUS' => 'זמינות:',
  'LBL_SUPPORT_CONTACT' => 'איש תמיכה:',
  'LBL_SUPPORT_DESCRIPTION' => 'תיאור התמיכה:',
  'LBL_SUPPORT_NAME' => 'שם איש התמיכה:',
  'LBL_SUPPORT_TERM' => 'תנאי התמיכה:',
  'LBL_TAX_CLASS' => 'סוגי מיסים:',
  'LBL_TYPE' => 'סוג:',
  'LBL_TYPE_ID' => 'זהות סוג',
  'LBL_TYPE_NAME' => 'שם סוג',
  'LBL_URL' => 'לינק למוצר:',
  'LBL_VENDOR_PART_NUM' => 'מספר חלק אצל ספק:',
  'LBL_WEBSITE' => 'אתר אינטרנט',
  'LBL_WEIGHT' => 'משקל:',
  'LNK_IMPORT_PRODUCTS' => 'ייבוא מוצרים',
  'LNK_NEW_MANUFACTURER' => 'יצרנים',
  'LNK_NEW_PRODUCT' => 'צור מוצר עבור קטלוג',
  'LNK_NEW_PRODUCT_CATEGORY' => 'קטגוריות מוצרים',
  'LNK_NEW_PRODUCT_TYPE' => 'סוגי מוצרים',
  'LNK_NEW_SHIPPER' => 'ספקי שילוח',
  'LNK_PRODUCT_LIST' => 'צפייה בקטלוג מוצרים',
  'NTC_DELETE_CONFIRMATION' => 'Are you sure you want to delete this record?',
);

