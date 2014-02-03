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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε την πώληση.',
  'LBL_ACCOUNT_ID' => 'Ταυτότητα Λογαριασμού',
  'LBL_ACCOUNT_NAME' => 'Όνομα Λογαριασμού:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Δραστηριότητες',
  'LBL_AMOUNT' => 'Ποσό:',
  'LBL_AMOUNT_USDOLLAR' => 'Ποσό USD:',
  'LBL_ASSIGNED_TO_ID' => 'Ανατέθηκε σε Ταυτότητα',
  'LBL_ASSIGNED_TO_NAME' => 'Χειριστής:',
  'LBL_CAMPAIGN' => 'Εκστρατεία:',
  'LBL_CLOSED_WON_SALES' => 'Κλειστές Κερδισμένες Πωλήσεις',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Επαφές',
  'LBL_CREATED_ID' => 'Δημιουργήθηκε από Ταυτότητα',
  'LBL_CURRENCY' => 'Νόμισμα:',
  'LBL_CURRENCY_ID' => 'Ταυτότητα Νομίσματος',
  'LBL_CURRENCY_NAME' => 'Όνομα Νομίσματος',
  'LBL_CURRENCY_SYMBOL' => 'Σύμβολο Νομίσματος',
  'LBL_DATE_CLOSED' => 'Αναμενόμενη Ημερομηνία Κλεισίματος:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Πώληση',
  'LBL_DESCRIPTION' => 'Περιγραφή',
  'LBL_DUPLICATE' => 'Πιθανά Αντίγραφο Καταχώρησης Πώλησης',
  'LBL_EDIT_BUTTON' => 'Επεξεργασία',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Ιστορικό',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Δυνητικοί Πελάτες',
  'LBL_LEAD_SOURCE' => 'Πηγή Προέλευσης:',
  'LBL_LIST_ACCOUNT_NAME' => 'Όνομα Λογαριασμού',
  'LBL_LIST_AMOUNT' => 'Ποσό',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ανατεθειμένος Χειριστής',
  'LBL_LIST_DATE_CLOSED' => 'Έκλεισε',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Πωλήσεων',
  'LBL_LIST_SALE_NAME' => 'Όνομα',
  'LBL_LIST_SALE_STAGE' => 'Στάδιο Πώλησης',
  'LBL_MODIFIED_ID' => 'Τροποποιήθηκε από Ταυτότητα',
  'LBL_MODIFIED_NAME' => 'Τροποποιήθηκε Από Χειριστή',
  'LBL_MODULE_NAME' => 'Πώληση',
  'LBL_MODULE_TITLE' => 'Πώληση: Αρχή',
  'LBL_MY_CLOSED_SALES' => 'Κλειστές Πωλήσεις Μου',
  'LBL_NAME' => 'Όνομα Πώλησης',
  'LBL_NEW_FORM_TITLE' => 'Δημιουργία Πώλησης',
  'LBL_NEXT_STEP' => 'Επόμενο Βήμα:',
  'LBL_PROBABILITY' => 'Πιθανότητα (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Έργα',
  'LBL_RAW_AMOUNT' => 'Ακαθάριστο Ποσό',
  'LBL_REMOVE' => 'Αφαίρεση',
  'LBL_SALE' => 'Πώληση:',
  'LBL_SALES_STAGE' => 'Στάδιο Πώλησης:',
  'LBL_SALE_INFORMATION' => 'Πληροφορία Πώλησης',
  'LBL_SALE_NAME' => 'Όνομα Πώλησης:',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Πώλησης',
  'LBL_TEAM_ID' => 'Ταυτότητα Ομάδας',
  'LBL_TOP_SALES' => 'Κορυφαίες Ανοικτές Πωλήσεις Μου',
  'LBL_TOTAL_SALES' => 'Συνολικές Πωλήσεις',
  'LBL_TYPE' => 'Τύπος:',
  'LBL_VIEW_FORM_TITLE' => 'Προβολή Πωλήσεων',
  'LNK_NEW_SALE' => 'Δημιουργία Πώλησης',
  'LNK_SALE_LIST' => 'Πώληση',
  'MSG_DUPLICATE' => 'Η εγγραφή Πώλησης που πρόκειται να δημιουργηθεί θα μπορούσε να είναι αντίγραφο μίας πώλησης που ήδη υπάρχει.Οι εγγραφές Πωλήσεων περιέχουν παρόμοια ονόματα παυ αναφέρονται παρακάτω.<br>Πατήστε το κουμπί Αποθήκευση για να συνεχίσετε τη δημιουργία αυτής της νέας Πώλησης, ή πατήστε το κουμπί Άκυρο για να επιστρέψετε στην ενότητα χωρίς να δημιουργήσετε την πώληση.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτή την επαφή από την πώληση;',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Είστε βέβαιοι ότι θέλετε να αφαιρέσετε αυτή την πώληση από το έργο;',
  'UPDATE' => 'Ευκαιρία - Ενημέρωση Νομίσματος',
  'UPDATE_BUGFOUND_COUNT' => 'Βρέθηκαν Σφάλματα:',
  'UPDATE_BUG_COUNT' => 'Βρέθηκαν Σφάλματα και έγινε Προσπάθεια να Διορθωθούν:',
  'UPDATE_COUNT' => 'Οι Εγγραφές Ενημερώθηκαν:',
  'UPDATE_CREATE_CURRENCY' => 'Δημιουργία Νέου Νομίσματος:',
  'UPDATE_DOLLARAMOUNTS' => 'Ενημέρωση των ποσών σε Δολλάρια U.S',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Η ενημέρωση των ποσών των ευκαιριών σε δολλάρια U.S, βασίζεται στις τρέχουσες επιλογές νομίσματος. Αυτή η τιμή χρησιμοποιείται για τον υπολογισμό των Γραφημάτων και την Προβολή Λίστας Ποσών Νομίσματος.',
  'UPDATE_DONE' => 'Ολοκληρώθηκε',
  'UPDATE_FAIL' => 'Δεν έγινε ενημέρωση -',
  'UPDATE_FIX' => 'Διόρθωση Ποσών',
  'UPDATE_FIX_TXT' => 'Επιχειρεί να διορθώσει οποιοδήποτε άκυρο ποσό, δημιουργώντας τις δεκαδικές τιμές από τα υφιστάμενα ποσά. Οποιοδήποτε τροποποιημένο ποσό, υποστηρίζεται στο πεδίο ποσό_αντίγραφο ασφαλείας της βάσης δεδομένων. Εάν εκτελείται αυτό και παρατηρήσετε σφάλματα, δεν θα επαναληφθεί χωρίς επαναφορά από το αντίγραφο ασφαλείας, καθώς μπορεί να αντικαταστήσει το αντίγραφο ασφαλείας με νέα άκυρα δεδομένα.',
  'UPDATE_INCLUDE_CLOSE' => 'Συμπεριλαμβάνει τις Κλειστές Εγγραφές',
  'UPDATE_MERGE' => 'Συγχώνευση Νομισμάτων',
  'UPDATE_MERGE_TXT' => 'Συγχώνευση πολλαπλών νομισμάτων σε ένα νόμισμα. Εάν υπάρχουν πολλαπλές εγγραφές νομισμάτων, να επιλεγεί η συγχώνευσή τους. Αυτό θα συγχωνεύσει και τα νομίσματα που υπάρχουν στις άλλες ενότητες της εφαρμογής.',
  'UPDATE_NULL_VALUE' => 'Δεν υπάρχει Ποσό, καθορίστε μία τιμή από 0 -',
  'UPDATE_RESTORE' => 'Επαναφορά Ποσών',
  'UPDATE_RESTORE_COUNT' => 'Επαναφορά Αποκαταστημένων Ποσών:',
  'UPDATE_RESTORE_TXT' => 'Επαναφορά αριθμητικών τιμών από τα αντίγραφα ασφαλείας (backups) που δημιουργήθηκαν κατά τη διαδικασία Διόρθωσης.',
  'UPDATE_VERIFY' => 'Επιβεβαίωση Ποσών',
  'UPDATE_VERIFY_CURAMOUNT' => 'Τρέχων Ποσό:',
  'UPDATE_VERIFY_FAIL' => 'Η Επιβεβαίωση της Εγγραφής Απέτυχε:',
  'UPDATE_VERIFY_FIX' => 'Εκτελώντας τη διόρθωση θα δώσει',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Νέο Ποσό:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Νέο Νόμισμα:',
  'UPDATE_VERIFY_TXT' => 'Επιβεβαιώνει ότι τα ποσά στις πωλήσεις είναι έγκυροι δεκαδικοί αριθμοί με μόνο τους αριθμητικούς χαρακτήρες (0-9) και τα δεκαδικά (.)',
);

