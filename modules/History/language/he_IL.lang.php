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
 * Hebrew vertion by:
 * Menahem Lurie Consultancy and IT Management,SugarCRM partner - Israel
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * *******************************************************************************/

 


$mod_strings = array (
  'LBL_MODULE_NAME' => 'הסטוריה',
  'LBL_MODULE_TITLE' => 'הסטוריה: דף הבית',
  'LBL_SEARCH_FORM_TITLE' => 'חפש בהסטוריה',
  'LBL_LIST_FORM_TITLE' => 'הסטוריה',
  'LBL_LIST_SUBJECT' => 'נושא',
  'LBL_LIST_CONTACT' => 'איש קשר',
  'LBL_LIST_RELATED_TO' => 'קשור אל',
  'LBL_LIST_DATE' => 'תאריך',
  'LBL_LIST_TIME' => 'זמן התחלה',
  'LBL_LIST_CLOSE' => 'סגור',
  'LBL_SUBJECT' => 'נושא:',
  'LBL_STATUS' => 'סטאטוס:',
  'LBL_LOCATION' => 'מיקום:',
  'LBL_DATE_TIME' => 'תאריך ושעת התחלה:',
  'LBL_DATE' => 'תאריך התחלה:',
  'LBL_TIME' => 'זמן התחלה:',
  'LBL_DURATION' => 'משך:',
  'LBL_HOURS_MINS' => '(שעות/דקות)',
  'LBL_CONTACT_NAME' => 'שם איש קשר: ',
  'LBL_MEETING' => 'פגישה:',
  'LBL_DESCRIPTION_INFORMATION' => 'תיאור המידע',
  'LBL_DESCRIPTION' => 'תיאר:',
  'LBL_COLON' => ':',
  'LBL_DEFAULT_STATUS' => 'מתוכנן',
  'LNK_NEW_CALL' => 'יומן שיחה',
  'LNK_NEW_MEETING' => 'שיחה מתוכננת',
  'LNK_NEW_TASK' => 'צור משימה',
  'LNK_NEW_NOTE' => 'צור פתק או צרופה',
  'LNK_NEW_EMAIL' => 'ארכיב דואר אלקטרוני',
  'LNK_CALL_LIST' => 'שיחות טלפון',
  'LNK_MEETING_LIST' => 'פגישות',
  'LNK_TASK_LIST' => 'משימות',
  'LNK_NOTE_LIST' => 'פתקים',
  'LNK_EMAIL_LIST' => 'דואר אלקטרוני',
  'ERR_DELETE_RECORD' => 'למחיקת החשבון עליך לספק מספר רשומה.',
  'NTC_REMOVE_INVITEE' => 'אתה בטוח שברצונך להסיר מוזמנים אלה מהישיבה?',
  'LBL_INVITEE' => 'מוזמנים',
  'LBL_LIST_DIRECTION' => 'משך',
  'LBL_DIRECTION' => 'הדרכה',
  'LNK_NEW_APPOINTMENT' => 'פגישה חדשה',
  'LNK_VIEW_CALENDAR' => 'היום',
  'LBL_OPEN_ACTIVITIES' => 'פתח פעילויות',
  'LBL_HISTORY' => 'הסטוריה',
  'LBL_UPCOMING' => 'הפגישות הבאות שלי',
  'LBL_TODAY' => 'גמור ',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'צור משימה [Alt+N]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'צור משימה',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'תזמן פגישה [Alt+M]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'תזמן פגישה',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'יומן שיחה [Alt+C]',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'יומן שיחה',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'צור פתק או צרופה [Alt+T]',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'צור פתק או צרופה',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'ארכיב דואר אלקטרוני [Alt+K]',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'ארכיב דואר אלקטרוני',
  'LBL_LIST_STATUS' => 'סטאטוס',
  'LBL_LIST_DUE_DATE' => 'תאריך תפוגה',
  'LBL_LIST_LAST_MODIFIED' => 'שונה לאחרונה',
  'NTC_NONE_SCHEDULED' => 'לא מתוזמן.',
  'appointment_filter_dom' => array(
  	 'today' => 'היום'
  	,'tomorrow' => 'מחר'
  	,'this Saturday' => 'השבוע'
  	,'next Saturday' => 'בשבוע הבא'
  	,'last this_month' => 'החודש'
  	,'last next_month' => 'בחודש הבא'
  ),
  'LNK_IMPORT_NOTES'=>'ייבא פתקים',
  'NTC_NONE'=>'כלום',
	'LBL_ACCEPT_THIS'=>'לקבל?',
	'LBL_DEFAULT_SUBPANEL_TITLE' => 'הסטוריה',
);



