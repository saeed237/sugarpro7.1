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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε ένα αριθμό εγγραφής για να διαγράψετε τον λογαριασμό.',
  'LBL_ACCEPT' => 'Αποδοχή',
  'LBL_ACCEPT_THIS' => 'Αποδοχή;',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Όνομα Επαφής:',
  'LBL_DATE' => 'Ημερομηνία Έναρξης:',
  'LBL_DATE_TIME' => 'Ημερομηνία Έναρξης & Ώρα:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Ανοικτές Δραστηριότητες',
  'LBL_DELETE_ACTIVITY' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτήν την δραστηριότητα;',
  'LBL_DESCRIPTION' => 'Περιγραφή:',
  'LBL_DESCRIPTION_INFORMATION' => 'Πληροφορίες Περιγραφής',
  'LBL_DIRECTION' => 'Κατεύθυνση',
  'LBL_DURATION' => 'Διάρκεια:',
  'LBL_DURATION_MINUTES' => 'Διάρκεια σε λεπτά:',
  'LBL_HISTORY' => 'Ιστορικό',
  'LBL_HOURS_MINS' => '(ώρα/λεπτά)',
  'LBL_INVITEE' => 'Καλεσμένοι',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ανατεθειμένος Χειριστής',
  'LBL_LIST_CLOSE' => 'Κλείσιμο',
  'LBL_LIST_CONTACT' => 'Επαφή',
  'LBL_LIST_DATE' => 'Ημερομηνία',
  'LBL_LIST_DIRECTION' => 'Κατεύθυνση',
  'LBL_LIST_DUE_DATE' => 'Έως Ημερομηνία',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Δραστηριοτήτων',
  'LBL_LIST_LAST_MODIFIED' => 'Τελευταία Τροποποίηση',
  'LBL_LIST_RELATED_TO' => 'Σχετίζεται με',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_SUBJECT' => 'Θέμα',
  'LBL_LIST_TIME' => 'Ώρα Έναρξης',
  'LBL_LOCATION' => 'Τοποθεσία:',
  'LBL_MEETING' => 'Συνάντηση:',
  'LBL_MODULE_NAME' => 'Δραστηριότητες',
  'LBL_MODULE_NAME_SINGULAR' => 'Δραστηριότητα',
  'LBL_MODULE_TITLE' => 'Δραστηριότητες: Αρχή',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Δημιουργία Εργασίας',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Δημιουργία Εργασίας [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'Ανοικτές Δραστηριότητες',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Σύνδεση Κλήσης',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Κλήση [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Προγραμματισμός Συνάντησης',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Προγραμματισμός Συνάντησης [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Δραστηριοτήτων',
  'LBL_STATUS' => 'Κατάσταση:',
  'LBL_SUBJECT' => 'Θέμα:',
  'LBL_TIME' => 'Ώρα Έναρξης:',
  'LBL_TODAY' => 'μέσω',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Αρχειοθέτηση Email',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Αρχειοθέτηση Email',
  'LBL_UPCOMING' => 'Προσεχείς Συναντήσεις Μου',
  'LNK_CALL_LIST' => 'Προβολή Κλήσεων',
  'LNK_EMAIL_LIST' => 'Emails',
  'LNK_IMPORT_CALLS' => 'Εισαγωγή Κλήσεων',
  'LNK_IMPORT_MEETINGS' => 'Εισαγωγή Συναντήσεων',
  'LNK_IMPORT_NOTES' => 'Εισαγωγή Σημειώσεων',
  'LNK_IMPORT_TASKS' => 'Εισαγωγή Εργασιών',
  'LNK_MEETING_LIST' => 'Προβολή Συναντήσεων',
  'LNK_NEW_APPOINTMENT' => 'Νέο Ραντεβού',
  'LNK_NEW_CALL' => 'Κλήση',
  'LNK_NEW_EMAIL' => 'Αρχειοθέτηση Email',
  'LNK_NEW_MEETING' => 'Προγραμματισμός Συνάντησης',
  'LNK_NEW_NOTE' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LNK_NEW_TASK' => 'Δημιουργία Εργασίας',
  'LNK_NOTE_LIST' => 'Προβολή Σημειώσεων',
  'LNK_TASK_LIST' => 'Προβολή Εργασιών',
  'LNK_VIEW_CALENDAR' => 'Ημερολόγιο',
  'NTC_NONE' => 'Κανένα',
  'NTC_NONE_SCHEDULED' => 'Κανένας Προγραμματισμός.',
  'NTC_REMOVE_INVITEE' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτόν τον καλεσμένο από την συνάντηση;',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'επόμενο μήνα',
    'last this_month' => 'αυτό το μήνα',
    'next Saturday' => 'επόμενη εβδομάδα',
    'this Saturday' => 'αυτή την εβδομάδα',
    'today' => 'σήμερα',
    'tomorrow' => 'αύριο',
  ),
);

