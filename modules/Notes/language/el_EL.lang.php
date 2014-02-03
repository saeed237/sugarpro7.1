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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε τον λογαριασμό.',
  'ERR_REMOVING_ATTACHMENT' => 'Αποτυχία στην αφαίρεση επισύναψης...',
  'LBL_ACCOUNT_ID' => 'Ταυτότητα Λογαριασμού:',
  'LBL_ACTIVITIES_REPORTS' => 'Αναφορές Δραστηριοτήτων',
  'LBL_CASE_ID' => 'Ταυτότητα Υπόθεσης:',
  'LBL_CLOSE' => 'Κλείσιμο:',
  'LBL_COLON' => ':',
  'LBL_CONTACT_ID' => 'Ταυτότητα Επαφής:',
  'LBL_CONTACT_NAME' => 'Επαφή:',
  'LBL_CREATED_BY' => 'Δημιουργήθηκε Από',
  'LBL_DATE_ENTERED' => 'Ημερομηνία Δημιουργίας',
  'LBL_DATE_MODIFIED' => 'Ημερομηνία Τροποποίησης',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Σημειώσεις',
  'LBL_DELETED' => 'Διαγράφηκε',
  'LBL_DESCRIPTION' => 'Σημείωση',
  'LBL_EDITLAYOUT' => 'Επεξεργασία Διάταξης',
  'LBL_EMAIL_ADDRESS' => 'Διεύθυνση Email:',
  'LBL_EMAIL_ATTACHMENT' => 'Επισύναψη Email',
  'LBL_EMBED_FLAG' => 'Ενσωμάτωση στο email;',
  'LBL_EXPORT_PARENT_ID' => 'Σχετίζεται Με Ταυτότητα',
  'LBL_EXPORT_PARENT_TYPE' => 'Σχετίζεται Με Ενότητα',
  'LBL_FILENAME' => 'Επισύναψη:',
  'LBL_FILE_MIME_TYPE' => 'Τύπος Mime',
  'LBL_FILE_URL' => 'Αρχείο URL',
  'LBL_FIRST_NAME' => 'Όνομα',
  'LBL_LAST_NAME' => 'Επώνυμο',
  'LBL_LEAD_ID' => 'Ταυτότητα Δυνητικού Πελάτη:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ανατεθειμένος Χειριστής',
  'LBL_LIST_CONTACT' => 'Επαφή',
  'LBL_LIST_CONTACT_NAME' => 'Επαφή',
  'LBL_LIST_DATE_MODIFIED' => 'Τελευταία Τροποποίηση',
  'LBL_LIST_EDIT_BUTTON' => 'Επεξεργασία',
  'LBL_LIST_FILENAME' => 'Επισύναψη',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Σημειώσεων',
  'LBL_LIST_RELATED_TO' => 'Σχετιίζεται Με',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_SUBJECT' => 'Θέμα',
  'LBL_MEMBER_OF' => 'Μέλος του:',
  'LBL_MODIFIED_BY' => 'Τροποποιήθηκε Από',
  'LBL_MODULE_NAME' => 'Σημειώσεις',
  'LBL_MODULE_NAME_SINGULAR' => 'Σημείωση',
  'LBL_MODULE_TITLE' => 'Σημειώσεις: Αρχή',
  'LBL_MY_NOTES_DASHLETNAME' => 'Σημειώσεις Μου',
  'LBL_NEW_FORM_BTN' => 'Προσθήκη μιας Σημείωσης',
  'LBL_NEW_FORM_TITLE' => 'Δημιουργία Σημείωσης ή Προσθήκη Επισύναψης',
  'LBL_NOTE' => 'Σημείωση:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Επισυνάψεις',
  'LBL_NOTE_INFORMATION' => 'Επισκόπηση',
  'LBL_NOTE_STATUS' => 'Σημείωση',
  'LBL_NOTE_SUBJECT' => 'Θέμα:',
  'LBL_OC_FILE_NOTICE' => 'Παρακαλώ συνδεθείτε στον server για να δείτε το αρχείο',
  'LBL_OPPORTUNITY_ID' => 'Ταυτότητα Ευκαιρίας:',
  'LBL_PANEL_DETAILS' => 'Λεπτομέρειες',
  'LBL_PARENT_ID' => 'Γονική Ταυτότητα:',
  'LBL_PARENT_TYPE' => 'Γονική Ταυτότητα',
  'LBL_PHONE' => 'Τηλέφωνο:',
  'LBL_PORTAL_FLAG' => 'Εμφάνιση στο Portal;',
  'LBL_PRODUCT_ID' => 'Ταυτότητα Προϊόντος:',
  'LBL_QUOTE_ID' => 'Ταυτότητα Προσφοράς:',
  'LBL_RELATED_TO' => 'Σχετίζεται Με:',
  'LBL_REMOVING_ATTACHMENT' => 'Αφαίρεση επισύναψης...',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Σημειώσεων',
  'LBL_SEND_ANYWAYS' => 'Το email δεν έχει θέμα. Αποστολή/αποθήκευση σε κάθε περίπτωση;',
  'LBL_STATUS' => 'Κατάσταση',
  'LBL_SUBJECT' => 'Θέμα:',
  'LNK_IMPORT_NOTES' => 'Εισαγωγή Σημειώσεων',
  'LNK_NEW_NOTE' => 'Δημιουργία Σημείωσης ή Επισύναψης',
  'LNK_NOTE_LIST' => 'Προβολή Σημειώσεων',
);

