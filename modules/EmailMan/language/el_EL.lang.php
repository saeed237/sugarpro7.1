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
  'ERR_INT_ONLY_EMAIL_PER_RUN' => 'Χρησιμοποιείστε μόνο ακέραιες αξίες για να προσδιορίσετε τον αριθμό των emails που στέλνονται ανά παρτίδα',
  'LBL_ALLOW_DEFAULT_SELECTION' => 'Επιτρέπει στους χειριστές να χρησιμοποιούν αυτόν τον λογαριασμό για τα εξερχόμενα email:',
  'LBL_ALLOW_DEFAULT_SELECTION_HELP' => 'Όταν αυτή η επιλογή επιλέγεται, όλοι οι χειριστές θα είναι σε θέση να στείλουν τα ηλεκτρονικά ταχυδρομεία χρησιμοποιώντας τον ίδιο εξερχόμενο πάροχο ταχυδρομείου που χρησιμοποιείται για να στείλει τις ανακοινώσεις και τις ειδοποιήσεις των συστημάτων. Εάν η επιλογή δεν επιλέγεται, οι χειριστές μπορούν ακόμα να χρησιμοποιήσουν τον εξερχόμενο κεντρικό υπολογιστή ταχυδρομείου,  από να παράσχουν τις πληροφορίες του λογαριασμού τους.',
  'LBL_ATTACHMENT_AUDIT' => 'στάλθηκε. Δεν αναπαρήχθη τοπικά για να συντηρήσει τη χρήση δίσκων.',
  'LBL_CAMP_MESSAGE_COPY' => 'Κρατήστε τα αντίγραφα των μηνυμάτων εκστρατείας:',
  'LBL_CAMP_MESSAGE_COPY_DESC' => 'Θα επιθυμούσατε να αποθηκεύσετε τα πλήρη αντίγραφα ΚΑΘΕ μηνύματος email που στέλνεται κατά τη διάρκεια όλων των εκστρατειών; Σας συνιστούμε και καμία προεπιλογή. Επιλέγοντας "καμία" θα αποθηκεύσει μόνο το πρότυπο που αποστέλλεται και τις μεταβλητές που απαιτούνται για να αναδημιουργήσει το μεμονωμένο μήνυμα.',
  'LBL_CHOOSE_EMAIL_PROVIDER' => 'Επιλέξτε τον πάροχο του Email σας',
  'LBL_CONFIGURE_CAMPAIGN_EMAIL_SETTINGS' => 'Διαμόρφωση Ρυθμίσεων Email Εκστρατείας',
  'LBL_CONFIGURE_SETTINGS' => 'Διαμόρφωση Ρυθμίσεων Email',
  'LBL_CUSTOM_LOCATION' => 'Ορίζεται από το χειριστή',
  'LBL_DEFAULT_LOCATION' => 'Προεπιλογή',
  'LBL_DISCLOSURE_TEXT_SAMPLE' => 'ΣΗΜΕΙΩΣΗ: Αυτό το μήνυμα email είναι για την αποκλειστική χρήση του παραλήπτη(ων) και μπορεί να περιέχει εμπιστευτικές και προσωπικές πληροφορίες. Απαγορεύεται οποιαδήποτε μη εξουσιοδοτημένη αναθεώρηση, χρήση, αποκάλυψη, ή διανομή. Εάν δεν είστε ο προοριζόμενος παραλήπτης, παρακαλώ καταστρέψτε όλα τα αντίγραφα του αρχικού μηνύματος και ειδοποιήστε τον αποστολέα, προκειμένου η εγγραφή της διεύθυνσης μας να διορθωθεί.',
  'LBL_DISCLOSURE_TEXT_TITLE' => 'Περιεχόμενο Κοινοποίησης',
  'LBL_DISCLOSURE_TITLE' => 'Επισύναψη Μήνυμα Κοινοποίησης σε Κάθε Email',
  'LBL_EMAILS_PER_RUN' => 'Ο Αριθμός των emails στέλνονται ανά στίβα:',
  'LBL_EMAIL_DEFAULT_CHARSET' => 'Σύνθεση μηνυμάτων email με αυτό το σύνολο χαρακτήρων',
  'LBL_EMAIL_DEFAULT_DELETE_ATTACHMENTS' => 'Διαγραφή σχετικών σημειώσεων και συνημμένων με διαγραμμένα Emails',
  'LBL_EMAIL_DEFAULT_EDITOR' => 'Σύνθεση email χρησιμοποιώντας αυτόν τον client',
  'LBL_EMAIL_GMAIL_DEFAULTS' => 'Προπληρωμή Προεπιλογών Gmail™',
  'LBL_EMAIL_LINK_TYPE' => 'Email Client',
  'LBL_EMAIL_LINK_TYPE_HELP' => '<b>Sugar Mail Client:</b> Αποστολή emails χρησιμοποιώντας το email client στην εφαρμογή του Sugar.<br><b>Εξωτερικό Ταχυδρομείο Client:</b> Αποστολή email, χρησιμοποιώντας ένα email client έξω από την εφαρμογή του Sugar, όπως το Microsoft Outlook.',
  'LBL_EMAIL_OUTBOUND_CONFIGURATION' => 'Διαμόρφωση Εξερχόμενου Ταχυδρομείου',
  'LBL_EMAIL_PER_RUN_REQ' => 'Αριθμός των emails που στέλνονται ανά στίβα:',
  'LBL_EMAIL_SMTP_SSL' => 'Ενεργοποίηση SMTP επί SSL',
  'LBL_EMAIL_USER_TITLE' => 'Προεπιλογών Email Χειριστή',
  'LBL_EXCHANGE_LOGO' => 'Exchange',
  'LBL_EXCHANGE_SMTPPASS' => 'Κωδικός Πρόσβασης Exchange',
  'LBL_EXCHANGE_SMTPPORT' => 'Θύρα Διακομιστή Exchange',
  'LBL_EXCHANGE_SMTPSERVER' => 'Διακομιστής Exchange',
  'LBL_EXCHANGE_SMTPUSER' => 'Όνομα Χειριστή Exchange',
  'LBL_FROM_ADDRESS_HELP' => 'Όταν ενεργοποιηθεί, το ανατειθειμένο όνομα χειριστή / και η διεύθυνση email θα πρέπει να περιλαμβάνονται στη Φόρμα πεδίου του email. Αυτή η δυνατότητα μπορεί να μην λειτουργήσει με διακομιστές SMTP που δεν επιτρέπουν την αποστολή από διαφορετικό λογαριασμό email από τον λογαριασμό του διακομιστή.',
  'LBL_GMAIL_LOGO' => 'Gmail',
  'LBL_GMAIL_SMTPPASS' => 'Κωδικός Πρόσβασης Gmail:',
  'LBL_GMAIL_SMTPUSER' => 'Gmail  Διεύθυνση Email:',
  'LBL_HELP' => 'Βοήθεια',
  'LBL_ID' => 'Ταυτότητα',
  'LBL_INVALID_ENTRY_POINT' => 'Δεν είναι έγκυρο το σημείο εισόδου',
  'LBL_IN_QUEUE' => 'Σε Εξέλιξη',
  'LBL_IN_QUEUE_DATE' => 'Σε αναμονή Ημερομηνία',
  'LBL_LIST_CAMPAIGN' => 'Εκστρατεία',
  'LBL_LIST_FORM_PROCESSED_TITLE' => 'Επεξεργασμένα',
  'LBL_LIST_FORM_TITLE' => 'Σειρά Προτεραιότητας',
  'LBL_LIST_FROM_EMAIL' => 'Email Από',
  'LBL_LIST_FROM_NAME' => 'Όνομα Από',
  'LBL_LIST_IN_QUEUE' => 'Σε Επεξεργασία',
  'LBL_LIST_MESSAGE_NAME' => 'Μήνυμα Μάρκετινγκ',
  'LBL_LIST_RECIPIENT_EMAIL' => 'Email Παραλήπτη',
  'LBL_LIST_RECIPIENT_NAME' => 'Όνομα Παραλήπτη',
  'LBL_LIST_SEND_ATTEMPTS' => 'Προσπάθειες Αποστολής',
  'LBL_LIST_SEND_DATE_TIME' => 'Ημερομηνία Αποστολής',
  'LBL_LIST_USER_NAME' => 'Όνομα Χειριστή',
  'LBL_LOCATION_ONLY' => 'Τοποθεσία',
  'LBL_LOCATION_TRACK' => 'Τοποθεσία των αρχείων παρακολούθησης εκστρατείας (όπως campaign_tracker.php)',
  'LBL_MAIL_SENDTYPE' => 'Πράκτορας Μεταφοράς Ταχυδρομείου',
  'LBL_MAIL_SMTPAUTH_REQ' => 'Χρήση SMTP Πιστοποίησης:',
  'LBL_MAIL_SMTPPASS' => 'Κωδικός Πρόσβασης:',
  'LBL_MAIL_SMTPPORT' => 'Θύρα SMTP:',
  'LBL_MAIL_SMTPSERVER' => 'Διακομιστής SMTP Ταχυδρομείου:',
  'LBL_MAIL_SMTPUSER' => 'Όνομα Χειριστή:',
  'LBL_MARKETING_ID' => 'Ταυτότητα Μάρκετινγκ',
  'LBL_MODULE_ID' => 'Διαχειριστής Email',
  'LBL_MODULE_NAME' => 'Ρυθμίσεις Email',
  'LBL_MODULE_NAME_SINGULAR' => 'Επιλογές Email',
  'LBL_MODULE_TITLE' => 'Διαχείριση Μαζικής Αποστολής',
  'LBL_NO' => 'Όχι',
  'LBL_NOTIFICATION_ON_DESC' => 'Όταν είναι ενεργοποιημένο, τα μηνύματα αποστέλλονται στους χειριστές, όταν τα αρχεία τους έχουν ανατεθεί.',
  'LBL_NOTIFY_FROMADDRESS' => '"Από¨ Διεύθυνση:',
  'LBL_NOTIFY_FROMNAME' => '"Από" Όνομα:',
  'LBL_NOTIFY_ON' => 'Ανατεθειμένες Ειδοποιήσεις',
  'LBL_NOTIFY_SEND_BY_DEFAULT' => 'Αποστολή ειδοποιήσεων στους νέους χειριστές',
  'LBL_NOTIFY_SEND_FROM_ASSIGNING_USER' => 'Αποστολή ανακοίνωσης από την διεύθυνση email του ανατεθειμένου χειριστή',
  'LBL_NOTIFY_TITLE' => 'Επιλογές Email',
  'LBL_OLD_ID' => 'Παλαιά Ταυτότητα',
  'LBL_OUTBOUND_EMAIL_TITLE' => 'Επιλογές Εξερχομένων Email',
  'LBL_OUTGOING_SECTION_HELP' => 'Διαμόρφωση του προεπιλεγμένου διακομιστή εξερχόμενου ταχυδρομείου για την αποστολή email ειδοποιήσεων, συμπεριλαμβανομένων των ειδοποιήσεων ροής εργασίας.',
  'LBL_PREPEND_TEST' => '[Δοκιμή]:',
  'LBL_RELATED_ID' => 'Σχετική Ταυτότητα',
  'LBL_RELATED_TYPE' => 'Σχετικός Τύπος',
  'LBL_SAVE_OUTBOUND_RAW' => 'Αποθήκευση Εξερχομένων Emails',
  'LBL_SEARCH_FORM_PROCESSED_TITLE' => 'Πρόοδος Αναζήτησης',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Σειράς',
  'LBL_SECURITY_APPLET' => 'Ετικέτα Applet',
  'LBL_SECURITY_BASE' => 'Ετικέτα Βάσης',
  'LBL_SECURITY_DESC' => 'Ελέγξτε τα παρακάτω που ΔΕΝ πρέπει να επιτρέπονται μέσω εισερχομένων email ή να εμφανίζονται στην ενότητα email.',
  'LBL_SECURITY_EMBED' => 'Ενσωματωμένη ετικέτα',
  'LBL_SECURITY_FORM' => 'Ετικέτα Φόρμας',
  'LBL_SECURITY_FRAME' => 'Ετικέτα Πλαισίου',
  'LBL_SECURITY_FRAMESET' => 'Ετικέτα Frameset',
  'LBL_SECURITY_IFRAME' => 'Ετικέτα iFrame',
  'LBL_SECURITY_IMPORT' => 'εισαγωγή ετικέτας',
  'LBL_SECURITY_LAYER' => 'Ετικέτα Στρώματος',
  'LBL_SECURITY_LINK' => 'Ετικέτα Συνδέσεων',
  'LBL_SECURITY_OBJECT' => 'Ετικέτα Αντικειμένου',
  'LBL_SECURITY_OUTLOOK_DEFAULTS' => 'Επιλέξτε στο Outlook προεπιλογή ελάχιστων ρυθμίσεων ασφαλείας (σφάλλει στην πλευρά της σωστής εμφάνισης).',
  'LBL_SECURITY_SCRIPT' => 'Ετικέτα Σεναρίου',
  'LBL_SECURITY_STYLE' => 'Ετικέτα Ύφους',
  'LBL_SECURITY_TITLE' => 'Ρυθμίσεις Ασφαλείας Email',
  'LBL_SECURITY_TOGGLE_ALL' => 'Εναλλαγή Όλων των Επιλογών',
  'LBL_SECURITY_XMP' => 'Ετικέτα Xmp',
  'LBL_SEND_ATTEMPTS' => 'Προσπάθειες Αποστολής',
  'LBL_SEND_DATE_TIME' => 'Ημερομηνιία Αποστολής',
  'LBL_UNAUTH_ACCESS' => 'Μη εξουσιοδοτημένη πρόσβαση στη διαχείριση.',
  'LBL_VIEW_PROCESSED_EMAILS' => 'Προβολή Προόδου Εmails',
  'LBL_VIEW_QUEUED_EMAILS' => 'Προβολή των Emails στη Σειρά',
  'LBL_YAHOOMAIL_SMTPPASS' => 'Yahoo! Κωδικός Πρόσβασης Ταχυδρομείου',
  'LBL_YAHOOMAIL_SMTPUSER' => 'Yahoo! Ταυτότητα Ταχυδρομείου',
  'LBL_YAHOO_MAIL_LOGO' => 'Yahoo Mail',
  'LBL_YES' => 'Ναι',
  'TRACKING_ENTRIES_LOCATION_DEFAULT_VALUE' => 'Αξία από Config.php setting site_url',
  'TXT_REMOVE_ME' => 'Για να αφαιρέσετε τον ευατό σας από αυτή την λίτσα email',
  'TXT_REMOVE_ME_ALT' => 'Για να αφαιρέσετε τον ευατό σας από αυτή την λίτσα email πηγαίνετε στο',
  'TXT_REMOVE_ME_CLICK' => 'πατήστε εδώ',
);

