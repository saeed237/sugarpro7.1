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
  'LBL_ACTION_ERROR' => 'Αυτή η ενέργεια περιέχει τα λάθη και δεν μπορεί να εκτελεστεί. Επεξεργαστείτε τη δράση, έτσι ώστε όλα τα πεδία και οι τιμές των πεδίων να είναι έγκυρα.',
  'LBL_ACTION_ERRORS' => 'Ειδοποίηση: Μια ή περισσότερες παρακάτω ενέργειες περιέχουν λάθη.',
  'LBL_ALERT_ERROR' => 'Αυτή η ειδοποίηση δεν μπορεί να εκτελεσθεί. Εκδώστε την ειδοποίηση έτσι ώστε οι όλες ρυθμίσεις να ισχύουν.',
  'LBL_ALERT_ERRORS' => 'Σημείωση: Μία ή περισσότερες ειδοποιήσεις που ακολουθούν περιέχουν λάθη.',
  'LBL_ALERT_SUBJECT' => 'ΕΙΔΟΠΟΙΗΣΕΙΣ ΡΟΗΣ ΕΡΓΑΣΙΑΣ',
  'LBL_ALERT_TEMPLATES' => 'Πρότυπο Ειδοποίησης',
  'LBL_ANY_FIELD' => 'οποιοδήποτε πεδίο',
  'LBL_AS' => 'ως',
  'LBL_BASE_MODULE' => 'Ενότητα Στόχου:',
  'LBL_BODY' => 'Σώμα:',
  'LBL_CREATE_ALERT_TEMPLATE' => 'Δημιουργία προτύπου ειδοποίησης:',
  'LBL_DESCRIPTION' => 'Περιγραφή:',
  'LBL_DOWN' => 'Κάτω',
  'LBL_EDITLAYOUT' => 'Επεξεργασία Διάταξης',
  'LBL_EDIT_ALT_TEXT' => 'Όλα τα Κείμενα',
  'LBL_EMAILTEMPLATES_TYPE' => 'Τύπος',
  'LBL_EMAILTEMPLATES_TYPE_LIST_WORKFLOW' => 
  array (
    'workflow' => 'Ροή Εργασίας',
  ),
  'LBL_FIRE_ORDER' => 'Σειρά Διαδικασίας:',
  'LBL_FROM_ADDRESS' => 'Μορφή Διεύθυνσης:',
  'LBL_FROM_NAME' => 'Από Όνομα:',
  'LBL_HIDE' => 'Απόκρυψη',
  'LBL_INSERT' => 'Εισαγωγή',
  'LBL_INVITEES' => 'Προσκεκλημένοι',
  'LBL_INVITEE_NOTICE' => 'Προσοχή, θα πρέπει να επιλέξετε τουλάχιστον έναν προσκεκλημένο προκειμένου να δημιουργηθεί αυτό.',
  'LBL_INVITE_LINK' => 'Συνάντηση/Σύνδεσμος Κλήσης Πρόσκλησης',
  'LBL_LACK_OF_NOTIFICATIONS_ON' => 'Σημείωση: Για να στείλετε ειδοποιήσεις, παρέχετε πληροφορίες του SMTP Διακομιστή στον Διαχειριστή > Ρυθμίσεις Email.',
  'LBL_LACK_OF_TRIGGER_ALERT' => 'Ειδοποίηση: Πρέπει να δημιουργήσετε ένα trigger για αυτήν την ροή εργασίας αντικειμένου στη λειτουργία',
  'LBL_LINK_RECORD' => 'Σύνδεση σε Εγγραφή',
  'LBL_LIST_BASE_MODULE' => 'Ενότητα Στόχου:',
  'LBL_LIST_DN' => 'κάτω',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Ροής Εργασίας',
  'LBL_LIST_NAME' => 'Όνομα',
  'LBL_LIST_ORDER' => 'Σειρά Διαδικασίας:',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_TYPE' => 'Εμφάνιση Εκτέλεσης:',
  'LBL_LIST_UP' => 'πάνω',
  'LBL_MODULE_ID' => 'Ροή Εργασίας',
  'LBL_MODULE_NAME' => 'Ορισμοί Ροή Εργασίας',
  'LBL_MODULE_NAME_SINGULAR' => 'Ορισμός Ροής Εργασίας',
  'LBL_MODULE_TITLE' => 'Ροή Εργασίας: Αρχή',
  'LBL_NAME' => 'Όνομα:',
  'LBL_NEW_FORM_TITLE' => 'Ορισμός Δημιουργίας Ροής Εργασίας',
  'LBL_PLEASE_SELECT' => 'Παρακαλώ Eπιλέξτε',
  'LBL_PROCESS_LIST' => 'Εκτέλεση Εντολών Ροής Εργασίας',
  'LBL_PROCESS_SELECT' => 'Παρακαλώ επιλέξτε ενότητα:',
  'LBL_RECIPIENTS' => 'Παραλήπτες',
  'LBL_RECORD_TYPE' => 'Ισχύει για:',
  'LBL_RELATED_MODULE' => 'Σχετική Ενότητα:',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Ροής Εργασίας',
  'LBL_SELECT_FILTER' => 'Πρέπει να επιλέξετε ένα πεδίο με το οποίο θα φιλτράρει την σχετική ενότητα.',
  'LBL_SELECT_MODULE' => 'Παρακαλώ επιλέξτε μία σχετική ενότητα.',
  'LBL_SELECT_OPTION' => 'Παρακαλώ επιλέξτε μία επιλογή.',
  'LBL_SELECT_VALUE' => 'Πρέπει να επιλέξετε τιμή.',
  'LBL_SET' => 'Καθορισμός',
  'LBL_SHOW' => 'Εμφάνιση',
  'LBL_SPECIFIC_FIELD' => 'συγκεκριμένο πεδίο',
  'LBL_STATUS' => 'Κατάσταση:',
  'LBL_SUBJECT' => 'Θέμα:',
  'LBL_TRIGGER_ERROR' => 'Σημείωση: Ο trigger περιέχει μη έγκυρες τιμές και δεν θα βάλει φωτιά.',
  'LBL_TRIGGER_ERRORS' => 'Σημείωση: Ένας ή περισσότεροι triggers παρακάτω περιέχουν λάθη.',
  'LBL_TYPE' => 'Εμφάνιση Εκτέλεσης:',
  'LBL_UP' => 'Επάνω',
  'LBL__S' => '&#39;ς',
  'LNK_ALERT_TEMPLATES' => 'Πρότυπο Email Ειδοποίησης',
  'LNK_NEW_WORKFLOW' => 'Δημιουργία Ορισμού Ροής Εργασίας',
  'LNK_PROCESS_VIEW' => 'Εκτέλεση Εντολών Ροής Εργασίας',
  'LNK_WORKFLOW' => 'Ορισμός Λίστας Ροής Εργασίας',
  'NTC_REMOVE_ALERT' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτή την ροή εργασίας;',
);

