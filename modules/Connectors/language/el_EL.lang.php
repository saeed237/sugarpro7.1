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
  'ERROR_EMPTY_RECORD_ID' => 'Λάθος: Η Ταυτότητα Εγγραφής δεν είναι καθορισμένη ή άδεια.',
  'ERROR_EMPTY_SOURCE_ID' => 'Λάθος: Η Ταυτότητα Πηγής δεν είναι καθορισμένη ή άδεια.',
  'ERROR_EMPTY_WRAPPER' => 'Λάθος: Δεν είναι δυνατή η περίπτωση ανάκτησης περιτυλίγματος για την πηγή [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Λάθος: Δεν βρέθηκαν πρόσθετες λεπτομέρεις για την εγγραφή.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Λάθος: Δεν υπάρχουν συνδέσεις που να αντιστοιχίζονται σε αυτή την ενότητα.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Λάθος: Δεν υπάρχουν πεδία ενότητας που να έχουν χαρτογραφηθεί για εμφάνιση στα αποτελέσματα. Παρακαλούμε επικοινωνήστε με το διαχειριστή του συστήματος.',
  'ERROR_NO_FIELDS_MAPPED' => 'Λάθος: Θα πρέπει να χαρτογραφήσετε τουλάχιστον ένα πεδίο Σύνδεσης σε ένα πεδίο ενότητας για κάθε ενότητα εισόδου.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Καμία ενότητα δεν έχει ενεργοποιηθεί για αυτή την σύνδεση . Επιλέξτε μια ενότητα για αυτή την σύνδεση στη σελίδα Ενεργοποίηση Συνδέσεων.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Λάθος: Δεν υπάρχουν συνδέσεις που έχουν ενεργοποιηθεί στα πεδία αναζήτησης που ορίζονται.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Λάθος: Δεν υπάρχουν πεδία αναζήτησης που ορίζονται για την ενότητα και την σύνδεση. Παρακαλούμε επικοινωνήστε με το διαχειριστή του συστήματος.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Λάθος: Κανένα αρχείο sourcedefs.php δεν βρέθηκε.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Λάθος: Δεν έχουν καθοριστεί πηγές από όπου μπορείτε να ανακτήσετε δεδομένα.',
  'ERROR_RECORD_NOT_SELECTED' => 'Λάθος: Παρακαλώ επιλέξτε μία εγγραφή από τη λίστα πριν προχωρήσετε.',
  'LBL_ADDRCITY' => 'Πόλη',
  'LBL_ADDRCOUNTRY' => 'Χώρα',
  'LBL_ADDRCOUNTRY_ID' => 'Ταυτότητα Χώρας',
  'LBL_ADDRSTATEPROV' => 'Περιοχή',
  'LBL_ADD_MODULE' => 'Προσθήκη',
  'LBL_ADMINISTRATION' => 'Διαχείριση Σύνδεσης',
  'LBL_ADMINISTRATION_MAIN' => 'Ρυθμίσεις Σύνδεσης',
  'LBL_AVAILABLE' => 'Διαθέσιμο',
  'LBL_BACK' => '< Πίσω',
  'LBL_CLOSE' => 'Κλείσιμο',
  'LBL_COMPANY_ID' => 'Ταυτότητα Εταιρείας',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Μερικά υποχρεωτικά πεδία έχουν μείνει κενά. Να προχωρήσει να αποθηκεύσει τις αλλαγές;',
  'LBL_CONNECTOR' => 'Σύνδεση',
  'LBL_CONNECTOR_FIELDS' => 'Πεδία Σύνδεσης',
  'LBL_DATA' => 'Δεδομένα',
  'LBL_DEFAULT' => 'Προεπιλογή',
  'LBL_DELETE_MAPPING_ENTRY' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτή την είσοδο;',
  'LBL_DISABLED' => 'Απενεργοποιημενη',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Καμία αντιστοιχία δεν βρέθηκε για τα κριτήρια αναζήτησης σας.',
  'LBL_ENABLED' => 'Ενεργοποιημένη',
  'LBL_EXTERNAL' => 'Επιτρέπεται στους χειριστές να δημιουργήσουν εξωτερικό λογαριασμό αρχείων σε αυτή την σύνδεση.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Προκειμένου να χρησιμοποιήσετε αυτή την σύνδεση, οι ιδιότητες θα πρέπει επίσης να Καθοριστούν στις Ιδιότητες Σύνδεσης στις ρυθμίσεις σελίδας.',
  'LBL_FINSALES' => 'Ετήσιες Πωλήσεις',
  'LBL_INFO_INLINE' => 'Πληροφορίες',
  'LBL_MARKET_CAP' => 'Κεφαλαιοποίηση',
  'LBL_MERGE' => 'Συγχώνευση',
  'LBL_MODIFY_DISPLAY_DESC' => 'Επιλέξτε ποιά ενότητα είναι ενεργοποιημένη για κάθε σύνδεση.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Ρυθμίσεις Σύνδεσης: ΕνεργοποίησηΣυνδέσεων',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Ενεργοποίηση Συνδέσεων',
  'LBL_MODIFY_MAPPING_DESC' => 'Χάρτης πεδίων σύνδεσης σε ενότητα πεδίων προκειμένου να διαπιστωθούν ποια δεδομένα σύνδεσης μπορούν να προβληθούν και να συγχωνευθούν στις εγγραφές ενότητας',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Ρυθμίσεις Σύνδεσης: Χάρτης Πεδίων Σύνδεσης',
  'LBL_MODIFY_MAPPING_TITLE' => 'Χάρτης Πεδίων Σύνδεσης',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Ρυθμίστε τις ιδιότητες για κάθε σύνδεση, συμπεριλαμβανομένων των URLs και των κλειδιών API.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Ρυθμίσεις Σύνδεσης: Καθορισμός Ιδιοτήτων Σύνδεσης',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Καθορισμός Ιδιοτήτων Σύνδεσης',
  'LBL_MODIFY_SEARCH' => 'Αναζήτηση',
  'LBL_MODIFY_SEARCH_DESC' => 'Επιλέξτε τα πεδία σύνδεσης να χρησιμοποιήσετε να αναζητήσετε δεδομένα για κάθε ενότητα.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Ρυθμίσεις Σύνδεσης: Αναζήτηση Διαχείριση Σύνδεσης',
  'LBL_MODIFY_SEARCH_TITLE' => 'Αναζήτηση Διαχείριση Σύνδεσης',
  'LBL_MODULE_FIELDS' => 'Πεδία Ενότητας',
  'LBL_MODULE_NAME' => 'Συνδέσεις',
  'LBL_MODULE_NAME_SINGULAR' => 'Σύνδεση',
  'LBL_NO_PROPERTIES' => 'Δεν υπάρχουν διαμορφώσιμες ιδιότητες για αυτή την σύνδεση.',
  'LBL_PARENT_DUNS' => 'Γονικό DUNS',
  'LBL_PREVIOUS' => '< Πίσω',
  'LBL_QUOTE' => 'Προσφορά',
  'LBL_RECNAME' => 'Όνομα Εταιρείας',
  'LBL_RESET_BUTTON_TITLE' => 'Επαναφορά',
  'LBL_RESET_TO_DEFAULT' => 'Επαναφορά στην Προεπιλογή',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Είστε βέβαιοι ότι θέλετε να επαναφέρετε την προεπιλεγμένη ρύθμιση;',
  'LBL_RESULT_LIST' => 'Λίστα Δεδομένων',
  'LBL_RUN_WIZARD' => 'Εκτέλεση Οδηγού',
  'LBL_SAVE' => 'Αποθήκευση',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Εύρεση...',
  'LBL_SHOW_IN_LISTVIEW' => 'Εμφάνιση στην Προβολή Λίστας Συγχώνευσης',
  'LBL_SMART_COPY' => 'Έξυπνη Αντιγραφή',
  'LBL_STEP1' => 'Αναζήτηση και Προβολή Δεδομένων',
  'LBL_STEP2' => 'Συγχώνευση Εγγραφών με',
  'LBL_SUMMARY' => 'Περίληψη',
  'LBL_TEST_SOURCE' => 'Δοκιμή Σύνδεσης',
  'LBL_TEST_SOURCE_FAILED' => 'Αποτυχημένη Δοκιμή',
  'LBL_TEST_SOURCE_RUNNING' => 'Εκτέλεση δοκιμής...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Επιτυχημένη Δοκιμή',
  'LBL_TITLE' => 'Συγχώνευση Δεδομένων',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Απόλυτο Γονικό DUNS',
);

