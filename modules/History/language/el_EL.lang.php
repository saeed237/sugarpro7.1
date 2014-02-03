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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε αυτόν τον λογαριασμό',
  'LBL_ACCEPT_THIS' => 'Αποδοχή;',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Όνομα Επαφής:',
  'LBL_DATE' => 'Ημερομηνία Έναρξης:',
  'LBL_DATE_TIME' => 'Ημερομηνία & Ώρα Έναρξης:',
  'LBL_DEFAULT_STATUS' => 'Προγραμματισμένη',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Ιστορικό',
  'LBL_DESCRIPTION' => 'Περιγραφή:',
  'LBL_DESCRIPTION_INFORMATION' => 'Περιγραφή Πληροφορίας',
  'LBL_DIRECTION' => 'Κατεύθυνση',
  'LBL_DURATION' => 'Διάρκεια:',
  'LBL_HISTORY' => 'Ιστορικό',
  'LBL_HOURS_MINS' => '(ώρες/λεπτά)',
  'LBL_INVITEE' => 'Προσκεκλημένοι',
  'LBL_LIST_CLOSE' => 'Κλείσιμο',
  'LBL_LIST_CONTACT' => 'Επαφή',
  'LBL_LIST_DATE' => 'Ημερομηνία',
  'LBL_LIST_DIRECTION' => 'Κατεύθυνση',
  'LBL_LIST_DUE_DATE' => 'Έως Ημερομηνία',
  'LBL_LIST_FORM_TITLE' => 'Ιστορικό',
  'LBL_LIST_LAST_MODIFIED' => 'Τελευταία Τροποποίηση',
  'LBL_LIST_RELATED_TO' => 'Σχετίζεται με',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_SUBJECT' => 'Θέμα',
  'LBL_LIST_TIME' => 'Ώρα Έναρξης',
  'LBL_LOCATION' => 'Τοποθεσία:',
  'LBL_MEETING' => 'Συνάντηση:',
  'LBL_MODULE_NAME' => 'Ιστορικό',
  'LBL_MODULE_NAME_SINGULAR' => 'Ιστορικό',
  'LBL_MODULE_TITLE' => 'Ιστορικό: Αρχή',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Δημιουργία Εργασίας',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Δημιουργία Εργασίας [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'Ανοιχτές Δραστηριότητες',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Καταγραφή Κλήσης',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Καταγραφή Κλήσης [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Προγραμματισμός Συνάντησης',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Προγραμματισμός Συνάντησης [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Ιστορικού',
  'LBL_STATUS' => 'Κατάσταση:',
  'LBL_SUBJECT' => 'Θέμα:',
  'LBL_TIME' => 'Ώρα Έναρξης:',
  'LBL_TODAY' => 'μέσω',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Αρχειοθέτηση Email',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Αρχειοθέτηση Email [Alt+K]',
  'LBL_UPCOMING' => 'Επερχόμενες Συναντήσεις Μου',
  'LNK_CALL_LIST' => 'Κλήσεις',
  'LNK_EMAIL_LIST' => 'Emails',
  'LNK_IMPORT_NOTES' => 'Εισαγωγή Σημειώσεων',
  'LNK_MEETING_LIST' => 'Συναντήσεις',
  'LNK_NEW_APPOINTMENT' => 'Νέο Ραντεβού',
  'LNK_NEW_CALL' => 'Νέα Κλήση',
  'LNK_NEW_EMAIL' => 'Αρχειοθέτηση Email',
  'LNK_NEW_MEETING' => 'Προγραμματισμός Συνάντησης',
  'LNK_NEW_NOTE' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LNK_NEW_TASK' => 'Δημιουργία Εργασίας',
  'LNK_NOTE_LIST' => 'Σημειώσεις',
  'LNK_TASK_LIST' => 'Εργασίες',
  'LNK_VIEW_CALENDAR' => 'Σήμερα',
  'NTC_NONE' => 'Κανένα',
  'NTC_NONE_SCHEDULED' => 'Κανένας Προγραμματισμός.',
  'NTC_REMOVE_INVITEE' => 'Να αφαιρεθει αυτός ο προσκεκλημένος από αυτή τη συνάντηση;',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'τον επόμενο μήνα',
    'last this_month' => 'αυτόν τον μήνα',
    'next Saturday' => 'την επόμενη εβδομάδα',
    'this Saturday' => 'αυτή την εβδομάδα',
    'today' => 'σήμερα',
    'tomorrow' => 'αύριο',
  ),
);

