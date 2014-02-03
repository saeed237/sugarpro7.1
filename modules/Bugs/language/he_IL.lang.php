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
  'ERR_DELETE_RECORD' => 'You must specify a record number in order to delete the bug.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'חשבונות',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'פעילויות',
  'LBL_ASSIGNED_TO_NAME' => 'הוקצה עבור',
  'LBL_BUG' => 'באג:',
  'LBL_BUG_INFORMATION' => 'סקירת באגים',
  'LBL_BUG_NUMBER' => 'באג מספר:',
  'LBL_BUG_SUBJECT' => 'באג בנושא:',
  'LBL_CASES_SUBPANEL_TITLE' => 'אירועים',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'אנשי קשר',
  'LBL_CONTACT_BUG_TITLE' => 'איש קשר-באג:',
  'LBL_CONTACT_NAME' => 'שם איש קשר:',
  'LBL_CONTACT_ROLE' => 'תפקיד:',
  'LBL_CREATED_BY' => 'נוצר על ידי:',
  'LBL_DATE_CREATED' => 'נוצר בתאריך:',
  'LBL_DATE_LAST_MODIFIED' => 'שונה בתאריך:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'מעקב אחר באגים',
  'LBL_DESCRIPTION' => 'תיאור:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'מסמכים',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'הוקצה למשתמש ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'הוקצה למשתמש ששמו',
  'LBL_EXPORT_CREATED_BY' => 'נוצר על ידי ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Fixed in Release Name',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'שונה על ידי ID',
  'LBL_FIXED_IN_RELEASE' => 'תוקן בגרסה:',
  'LBL_FOUND_IN_RELEASE' => 'נמצא בגרסה:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'נמצא בשחשור ששמו',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'הסטוריה',
  'LBL_INVITEE' => 'אנשי קשר',
  'LBL_LIST_ACCOUNT_NAME' => 'שם חשבון',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'משתמשים שהוקצו',
  'LBL_LIST_CONTACT_NAME' => 'שם איש קשר',
  'LBL_LIST_EMAIL_ADDRESS' => 'כתובת דואר אלקטרוני',
  'LBL_LIST_FIXED_IN_RELEASE' => 'תוקן בגרסה',
  'LBL_LIST_FORM_TITLE' => 'רשימת באגים',
  'LBL_LIST_LAST_MODIFIED' => 'שונה לאחרונה',
  'LBL_LIST_MY_BUGS' => 'הבאגים שמוקצים אלי',
  'LBL_LIST_NUMBER' => 'מס.',
  'LBL_LIST_PHONE' => 'טלפון',
  'LBL_LIST_PRIORITY' => 'עדיפות',
  'LBL_LIST_RELEASE' => 'גרסה',
  'LBL_LIST_RESOLUTION' => 'החלטה',
  'LBL_LIST_STATUS' => 'סטאטוס',
  'LBL_LIST_SUBJECT' => 'נושא',
  'LBL_LIST_TYPE' => 'סוג',
  'LBL_MODIFIED_BY' => 'שונה לאחרונה על ידי:',
  'LBL_MODULE_ID' => 'באגים',
  'LBL_MODULE_NAME' => 'באגים',
  'LBL_MODULE_TITLE' => 'מעקב אחר באגים: דף ראשי',
  'LBL_NEW_FORM_TITLE' => 'באג חדש',
  'LBL_NUMBER' => 'מספר:',
  'LBL_PORTAL_VIEWABLE' => 'נצפה בפורטל',
  'LBL_PRIORITY' => 'עדיפות:',
  'LBL_PRODUCT_CATEGORY' => 'קטגוריה:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'פרויקטים',
  'LBL_RELEASE' => 'גרסה:',
  'LBL_RESOLUTION' => 'החלטה:',
  'LBL_SEARCH_FORM_TITLE' => 'חיפוש באג',
  'LBL_SHOW_IN_PORTAL' => 'הצג בפורטל',
  'LBL_SOURCE' => 'מקור:',
  'LBL_STATUS' => 'סטאטוס:',
  'LBL_SUBJECT' => 'נושא:',
  'LBL_SYSTEM_ID' => 'זהוי מערכת',
  'LBL_TYPE' => 'סוג:',
  'LBL_WORK_LOG' => 'יומן עבודה:',
  'LNK_BUG_LIST' => 'צפייה בבאגים',
  'LNK_BUG_REPORTS' => 'צפה בדוח על באגים',
  'LNK_IMPORT_BUGS' => 'ייבוא באגים',
  'LNK_NEW_BUG' => 'דוח על באג',
  'NTC_DELETE_CONFIRMATION' => 'האם אתה בטוח שברצונך להסיר איש הקשר מבאג זה?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'האם אתה בטוח שברצונך להסיר באג זה מהחשבון?',
  'NTC_REMOVE_INVITEE' => 'האם אתה בטוח שברצונך להסיר איש הקשר מבאג זה?',
);

