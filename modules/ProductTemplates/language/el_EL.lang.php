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
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε το προϊόν.',
  'LBL_ACCOUNT_NAME' => 'Όνομα Λογαριασμού:',
  'LBL_ASSIGNED_TO' => 'Ανατέθηκε Σε:',
  'LBL_ASSIGNED_TO_ID' => 'Ανατέθηκε Σε Ταυτότητα:',
  'LBL_CATEGORY' => 'Κατηγορία:',
  'LBL_CATEGORY_ID' => 'Ταυτότητα Κατηγορίας',
  'LBL_CATEGORY_NAME' => 'Όνομα Κατηγορίας:',
  'LBL_CONTACT_NAME' => 'Όνομα Επαφής:',
  'LBL_COST_PRICE' => 'Κόστος:',
  'LBL_COST_USDOLLAR' => 'Κόστος Δολλαρίου',
  'LBL_CURRENCY' => 'Νόμισμα:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Σύμβολο Νομίσματος',
  'LBL_DATE_AVAILABLE' => 'Διαθέσιμη Ημερομηνία:',
  'LBL_DATE_COST_PRICE' => 'Ημερομηνία-Τιμή-Κόστος:',
  'LBL_DESCRIPTION' => 'Περιγραφή:',
  'LBL_DISCOUNT_PRICE' => 'Τιμή Μονάδας:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Ημερομηνία Τιμής Έκπτωσης:',
  'LBL_DISCOUNT_USDOLLAR' => 'Τιμή Έκπτωσης USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Ταυτότητα Ανατεθειμένου Χειριστή',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Ανατεθειμένο Όνομα Χειριστή',
  'LBL_EXPORT_COST_PRICE' => 'Τιμή Κόστους',
  'LBL_EXPORT_CREATED_BY' => 'Δημιουργήθηκε Από Ταυτότητα',
  'LBL_EXPORT_CURRENCY' => 'Νόμισμα',
  'LBL_EXPORT_CURRENCY_ID' => 'Ταυτότητα Νομίσματος',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Τροποποιήθηκε από Ταυτότητα',
  'LBL_LIST_CATEGORY' => 'Κατηγορία:',
  'LBL_LIST_CATEGORY_ID' => 'Ταυτότητα Κατηγορίας:',
  'LBL_LIST_COST_PRICE' => 'Κόστος:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Τιμή:',
  'LBL_LIST_FORM_TITLE' => 'Λίστα Κατηγορίας Προϊόντος',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Αριθμός Κατασκευαστή',
  'LBL_LIST_LIST_PRICE' => 'Λίστα',
  'LBL_LIST_MANUFACTURER' => 'Κατασκευαστής',
  'LBL_LIST_MANUFACTURER_ID' => 'Ταυτότητα Κατασκευαστή:',
  'LBL_LIST_NAME' => 'Όνομα',
  'LBL_LIST_PRICE' => 'Τιμοκατάλογος:',
  'LBL_LIST_QTY_IN_STOCK' => 'Ποσότητα',
  'LBL_LIST_STATUS' => 'Διαθεσιμότητα',
  'LBL_LIST_TYPE' => 'Τύπος:',
  'LBL_LIST_TYPE_ID' => 'Τύπος:',
  'LBL_LIST_USDOLLAR' => 'Λίστα USD',
  'LBL_MANUFACTURER' => 'Κατασκευαστής:',
  'LBL_MANUFACTURERS' => 'Κατασκευαστές',
  'LBL_MANUFACTURER_ID' => 'Ταυτότητα Κατασκευαστή',
  'LBL_MANUFACTURER_NAME' => 'Όνομα Κατασκευαστή:',
  'LBL_MFT_PART_NUM' => 'Αριθμός Παρτίδας Κατασκευαστή:',
  'LBL_MODULE_ID' => 'Πρότυπα Προϊόντων',
  'LBL_MODULE_NAME' => 'Κατάλογος Προϊόντος',
  'LBL_MODULE_NAME_SINGULAR' => 'Κατάλογος Προϊόντος',
  'LBL_MODULE_TITLE' => 'Κατάλογος Προϊόντος: Αρχή',
  'LBL_NAME' => 'Όνομα Προϊόντος:',
  'LBL_NEW_FORM_TITLE' => 'Δημιουργία Είδους',
  'LBL_PERCENTAGE' => 'Ποσοστό(%)',
  'LBL_POINTS' => 'Σημεία',
  'LBL_PRICING_FACTOR' => 'Παράγοντας Τιμολόγησης:',
  'LBL_PRICING_FORMULA' => 'Προεπιλογή Τύπου Τιμολόγησης:',
  'LBL_PRODUCT' => 'Προϊόν:',
  'LBL_PRODUCT_CATEGORIES' => 'Κατηγορίες Προϊόντων',
  'LBL_PRODUCT_ID' => 'Ταυτότητα Προϊόντος:',
  'LBL_PRODUCT_TYPES' => 'Τύποι Προϊόντων',
  'LBL_QTY_IN_STOCK' => 'Ποσότητα Αποθεμάτων',
  'LBL_QUANTITY' => 'Ποσότητα στο Απόθεμα:',
  'LBL_RELATED_PRODUCTS' => 'Σχετικό Προϊόν',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Καταλόγου Προϊόντος',
  'LBL_STATUS' => 'Διαθεσιμότητα:',
  'LBL_SUPPORT_CONTACT' => 'Επαφή Υποστήριξης:',
  'LBL_SUPPORT_DESCRIPTION' => 'Περιγραφή Υποστήριξης:',
  'LBL_SUPPORT_NAME' => 'Όνομα Υποστήριξης:',
  'LBL_SUPPORT_TERM' => 'Περίοδος Υποστήριξης:',
  'LBL_TAX_CLASS' => 'Κατηγορία Φόρου:',
  'LBL_TYPE' => 'Τύπος',
  'LBL_TYPE_ID' => 'Ταυτότητα Τύπου',
  'LBL_TYPE_NAME' => 'Όνομα Τύπου',
  'LBL_URL' => 'Προϊόν URL:',
  'LBL_VENDOR_PART_NUM' => 'Αριθμός Παρτίδας Πωλητή:',
  'LBL_WEBSITE' => 'Ιστοσελίδα',
  'LBL_WEIGHT' => 'Βάρος:',
  'LNK_IMPORT_PRODUCTS' => 'Εισαγωγή Προϊόντων',
  'LNK_NEW_MANUFACTURER' => 'Κατασκευαστές',
  'LNK_NEW_PRODUCT' => 'Δημιουργία Προϊόντος για Κατάλογο',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Κατηγορίες Προϊόντων',
  'LNK_NEW_PRODUCT_TYPE' => 'Τύποι Προϊόντων',
  'LNK_NEW_SHIPPER' => 'Πάροχοι Αποστολής',
  'LNK_PRODUCT_LIST' => 'Προβολή Καταλόγων Προϊόντων',
  'NTC_DELETE_CONFIRMATION' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτή την εγγραφή;',
);

