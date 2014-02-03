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
  'ERR_DELETE_RECORD' => 'You must specify a record number to delete the account.',
  'LBL_ACCEPT' => 'Accept',
  'LBL_ACCEPT_THIS' => 'לקבל?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'שם איש קשר:',
  'LBL_DATE' => 'תאריך התחלה:',
  'LBL_DATE_TIME' => 'תאריך התחלה ושעה:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'פתח פעילויות',
  'LBL_DESCRIPTION' => 'תיאור:',
  'LBL_DESCRIPTION_INFORMATION' => 'תיאור המידע',
  'LBL_DIRECTION' => 'כיוון',
  'LBL_DURATION' => 'משך:',
  'LBL_DURATION_MINUTES' => 'משך בדקות:',
  'LBL_HISTORY' => 'הסטוריה',
  'LBL_HOURS_MINS' => '(שעות/דקות)',
  'LBL_INVITEE' => 'מוזמנים',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'משתמש שהוקצה',
  'LBL_LIST_CLOSE' => 'סגור',
  'LBL_LIST_CONTACT' => 'איש קשר',
  'LBL_LIST_DATE' => 'תאריך',
  'LBL_LIST_DIRECTION' => 'כיוון',
  'LBL_LIST_DUE_DATE' => 'תאריך סיום',
  'LBL_LIST_FORM_TITLE' => 'רשימת פעילויות',
  'LBL_LIST_LAST_MODIFIED' => 'שונה לאחרונה',
  'LBL_LIST_RELATED_TO' => 'קשור ב',
  'LBL_LIST_STATUS' => 'סטאטוס',
  'LBL_LIST_SUBJECT' => 'נושא',
  'LBL_LIST_TIME' => 'זמן התחלה',
  'LBL_LOCATION' => 'מיקום:',
  'LBL_MEETING' => 'פגישה:',
  'LBL_MODULE_NAME' => 'פעיליות',
  'LBL_MODULE_TITLE' => 'פעילויות: דף ראשי',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'צור פתק או צרופה',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'צור פתק או צרופה [Alt+T]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'צור משימה',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'צור משימה [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'פעילויות פתוחות',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'יומן שיחה',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'יומן שיחה [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'תזמן משימה',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'תזמן משימה [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'חיפוש פעילויות',
  'LBL_STATUS' => 'סטאטוס:',
  'LBL_SUBJECT' => 'נושא:',
  'LBL_TIME' => 'זמן התחלה:',
  'LBL_TODAY' => 'הושלם',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'ארכב דואר אלקטרוני',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'ארכב דואר אלקטרוני [Alt+K]',
  'LBL_UPCOMING' => 'הפגישות הקרובות שלי',
  'LNK_CALL_LIST' => 'צפה בתאים',
  'LNK_EMAIL_LIST' => 'צפייה בדואר אלקטרוני',
  'LNK_IMPORT_CALLS' => 'ייבא שיחות',
  'LNK_IMPORT_MEETINGS' => 'ייבא פגישות',
  'LNK_IMPORT_NOTES' => 'ייבא פתקים',
  'LNK_IMPORT_TASKS' => 'ייבא משימות',
  'LNK_MEETING_LIST' => 'צפה בפגישות',
  'LNK_NEW_APPOINTMENT' => 'פגישה חדשה',
  'LNK_NEW_CALL' => 'יומן שיחה',
  'LNK_NEW_EMAIL' => 'צור דואר אלקטרוני מאורכב',
  'LNK_NEW_MEETING' => 'תזמן שיחה',
  'LNK_NEW_NOTE' => 'צור פתק או צרופה',
  'LNK_NEW_TASK' => 'צור משימה',
  'LNK_NOTE_LIST' => 'צפה בפתקים',
  'LNK_TASK_LIST' => 'צפה במשימות',
  'LNK_VIEW_CALENDAR' => 'צפיה ביומן',
  'NTC_NONE' => 'כלום',
  'NTC_NONE_SCHEDULED' => 'לא מתוזמן.',
  'NTC_REMOVE_INVITEE' => 'Are you sure you want to remove this invitee from the meeting?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'בחודש הבא',
    'last this_month' => 'החודש',
    'next Saturday' => 'בשבוע הבא',
    'this Saturday' => 'השבוע',
    'today' => 'היום',
    'tomorrow' => 'מחר',
  ),
);

