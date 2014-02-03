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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Attività',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'ATTENZIONE: Se si cambia il modulo primario, tutti i campi già aggiunti al modello dovranno essere rimossi.',
  'LBL_ASSIGNED_TO_ID' => 'Id Utente Assegnato',
  'LBL_ASSIGNED_TO_NAME' => 'Assegnato a',
  'LBL_AUTHOR' => 'Autore',
  'LBL_BASE_MODULE' => 'Modulo',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Seleziona un modulo per cui questo modello sarà disponibile.',
  'LBL_BODY_HTML' => 'Modello',
  'LBL_BODY_HTML_POPUP_HELP' => 'Crea il modello usando l´editor HTML. Dopo aver salvato il modello potrai visualizzare in anteprima la versione PDF del modello.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Crea il modello usando l´editor HTML. Dopo aver salvato il modello potrai visualizzare in anteprima la versione PDF del modello. Per modificare il loop utilizzato per creare gli elementi della linea di prodotto, accedere al codice cliccando sul pulsante "HTML" nell´editor. Il codice è contenuto all´interno di <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP--> e <!--END_BUNDLE_LOOP-->.',
  'LBL_BTN_INSERT' => 'Inserisci',
  'LBL_CREATED' => 'Creato Da',
  'LBL_CREATED_ID' => 'Creato Da Id',
  'LBL_CREATED_USER' => 'Creato da Utente',
  'LBL_DATE_ENTERED' => 'Data di Inserimento',
  'LBL_DATE_MODIFIED' => 'Data di Modifica',
  'LBL_DELETED' => 'Cancellato',
  'LBL_DESCRIPTION' => 'Descrizione',
  'LBL_EDITVIEW_PANEL1' => 'Proprietà Documento PDF',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Questo è il file che hai richiesto (E´ possibile modificare questo testo)',
  'LBL_FIELD' => 'Campo',
  'LBL_FIELDS_LIST' => 'Campi',
  'LBL_FIELD_POPUP_HELP' => 'Seleziona un campo per inserire la variabile per il valore del campo. Per selezionare campi di un modulo relazionato, prima seleziona il modulo nell´area Links in fondo alla lista dei Campi nel menu a tendina, poi seleziona il campo nel secondo menu a tendina.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Visualizza Storico',
  'LBL_HOMEPAGE_TITLE' => 'I miei Modelli PDF',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Parole Chiave',
  'LBL_KEYWORDS_POPUP_HELP' => 'Associa Parolechiave al documento, generalmente con la formula "parolachiave1 parolachiave2..."',
  'LBL_LINK_LIST' => 'Collegamenti',
  'LBL_LIST_FORM_TITLE' => 'Elenco Template PDF',
  'LBL_LIST_NAME' => 'Nome',
  'LBL_MODIFIED' => 'Modificato Da',
  'LBL_MODIFIED_ID' => 'Modificato Da Id',
  'LBL_MODIFIED_NAME' => 'Modificato Da Nome',
  'LBL_MODIFIED_USER' => 'Modificato da Utente',
  'LBL_MODULE_NAME' => 'GestionePdf',
  'LBL_MODULE_NAME_SINGULAR' => 'GestionePdf',
  'LBL_MODULE_TITLE' => 'GestionePdf',
  'LBL_NAME' => 'Nome',
  'LBL_NEW_FORM_TITLE' => 'Nuovo Modello PDF',
  'LBL_PAYMENT_TERMS' => 'Termini di Pagamento:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'GestionePdf',
  'LBL_PREVIEW' => 'Anteprima',
  'LBL_PUBLISHED' => 'Pubblicato',
  'LBL_PUBLISHED_POPUP_HELP' => 'Pubblica un modello per renderlo disponibile agli utenti.',
  'LBL_PURCHASE_ORDER_NUM' => 'Numero Ordine di Acquisto:',
  'LBL_SEARCH_FORM_TITLE' => 'Cerca Gestione PDF',
  'LBL_SUBJECT' => 'Soggetto',
  'LBL_TEAM' => 'Gruppi',
  'LBL_TEAMS' => 'Gruppi',
  'LBL_TEAM_ID' => 'Id Gruppo',
  'LBL_TITLE' => 'Titolo',
  'LBL_TPL_BILL_TO' => 'Fatturare A',
  'LBL_TPL_CURRENCY' => 'Valuta:',
  'LBL_TPL_DISCOUNT' => 'Sconto:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Subtotale Scontato:',
  'LBL_TPL_EXT_PRICE' => 'Prezzo Totale',
  'LBL_TPL_GRAND_TOTAL' => 'Importo Totale',
  'LBL_TPL_INVOICE' => 'Fattura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Questo modello è utilizzato per stampare la Fattura in PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Fattura',
  'LBL_TPL_INVOICE_NUMBER' => 'Numero Fattura',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'Fattura',
  'LBL_TPL_LIST_PRICE' => 'Prezzo di Listino',
  'LBL_TPL_PART_NUMBER' => 'Codice Prodotto',
  'LBL_TPL_PRODUCT' => 'Prodotto',
  'LBL_TPL_QUANTITY' => 'Quantità',
  'LBL_TPL_QUOTE' => 'Offerta',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Questo modello è utilizzato per stampare l´Offerta in PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Offerta',
  'LBL_TPL_QUOTE_NUMBER' => 'Numero di Offerta:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'offerta',
  'LBL_TPL_SALES_PERSON' => 'Commerciale:',
  'LBL_TPL_SHIPPING' => 'Spedizione:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Spedizioniere',
  'LBL_TPL_SHIP_TO' => 'Spedire A',
  'LBL_TPL_SUBTOTAL' => 'Subtotale:',
  'LBL_TPL_TAX' => 'Imposte:',
  'LBL_TPL_TAX_RATE' => 'Tasso di Imposta:',
  'LBL_TPL_TOTAL' => 'Totale',
  'LBL_TPL_UNIT_PRICE' => 'Prezzo Unitario',
  'LBL_TPL_VALID_UNTIL' => 'Valido fino a:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Modifica Modello PDF',
  'LNK_IMPORT_PDFMANAGER' => 'Importa Modelli PDF',
  'LNK_LIST' => 'Visualizza Modelli PDF',
  'LNK_NEW_RECORD' => 'Crea Modello PDF',
);

