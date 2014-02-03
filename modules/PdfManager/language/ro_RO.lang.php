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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitati',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'AVERTISMENT: Dacă schimbați modulul primar, toate câmpurile deja adăugat la șablon vor trebui să fie eliminate.',
  'LBL_ASSIGNED_TO_ID' => 'Atribuit ID Utilizator',
  'LBL_ASSIGNED_TO_NAME' => 'Atrbuit lui',
  'LBL_AUTHOR' => 'Autor:',
  'LBL_BASE_MODULE' => 'Modul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Selectați un modul pentru care acest șablon va fi disponibil.',
  'LBL_BODY_HTML' => 'Template',
  'LBL_BODY_HTML_POPUP_HELP' => 'Creați șablonul folosind editorul HTML. După salvare șablonul, va fi capabil de a vedea o previzualizare a versiunii PDF de șablon.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Creați șablonul folosind editorul HTML. După salvarea șablonul, va fi capabil de a vedea o previzualizare a versiunii PDF de șablon.<br /><br />Pentru a edita bucla folosite pentru a crea elementele de linia de produse, faceți clic pe "HTML" buton pe editorul pentru a accesa codul.Codul este conținută în cadrul <- START_BUNDLE_LOOP ->, <-! START_PRODUCT_LOOP ->, <-! END_PRODUCT_LOOP -> si <-! END_BUNDLE_LOOP ->.',
  'LBL_BTN_INSERT' => 'Introdu',
  'LBL_CREATED' => 'Creeata de',
  'LBL_CREATED_ID' => 'Creata de ID',
  'LBL_CREATED_USER' => 'Creeata de Utilizator',
  'LBL_DATE_ENTERED' => 'Data crearii:',
  'LBL_DATE_MODIFIED' => 'Data Modificarii',
  'LBL_DELETED' => 'Sters',
  'LBL_DESCRIPTION' => 'Descriere',
  'LBL_EDITVIEW_PANEL1' => 'PDF Document Properties',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Aici este fișierul solicitat-(Aveți posibilitatea să modificați acest text)',
  'LBL_FIELD' => 'Camp:',
  'LBL_FIELDS_LIST' => 'Campuri',
  'LBL_FIELD_POPUP_HELP' => 'Selectați un câmp pentru a introduce variabila pentru valoarea câmpului. Pentru a selecta câmpurile de un modul de părinte, selectați mai întâi modulul în zona Legături de la partea de jos a listei Câmpuri în primul vertical, apoi selectați câmpul din lista verticală a doua.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Vizualizare Istoric',
  'LBL_HOMEPAGE_TITLE' => 'Sugar Feed-ul meu',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Cuvinte cheie:',
  'LBL_KEYWORDS_POPUP_HELP' => 'Cuvintele cheie asociat cu documentul, în general, sub forma "descriptor1 descriptor2 ..."',
  'LBL_LINK_LIST' => 'Linkuri',
  'LBL_LIST_FORM_TITLE' => 'Lista lansari',
  'LBL_LIST_NAME' => 'Nume',
  'LBL_MODIFIED' => 'Modificata de',
  'LBL_MODIFIED_ID' => 'Modificata de ID',
  'LBL_MODIFIED_NAME' => 'Modificata de Nume',
  'LBL_MODIFIED_USER' => 'Modificata de Utilizator',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Nume',
  'LBL_NEW_FORM_TITLE' => 'Lansare Noua',
  'LBL_PAYMENT_TERMS' => 'Termeni de Plata:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Previzualizare',
  'LBL_PUBLISHED' => 'Publicat',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publicarea unui șablon pentru a le pune la dispoziția utilizatorilor.',
  'LBL_PURCHASE_ORDER_NUM' => 'Numar Ordin de Plata',
  'LBL_SEARCH_FORM_TITLE' => 'Lanseaza cautari',
  'LBL_SUBJECT' => 'subiect',
  'LBL_TEAM' => 'Echipe',
  'LBL_TEAMS' => 'Echipe',
  'LBL_TEAM_ID' => 'ID Echipa:',
  'LBL_TITLE' => 'Titlu',
  'LBL_TPL_BILL_TO' => 'Facturabil la:',
  'LBL_TPL_CURRENCY' => 'Moneda',
  'LBL_TPL_DISCOUNT' => 'Discount:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Discount Subtotal:',
  'LBL_TPL_EXT_PRICE' => 'Pret Extins',
  'LBL_TPL_GRAND_TOTAL' => 'Total General',
  'LBL_TPL_INVOICE' => 'Factura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Acest șablon este utilizat pentru a imprima factura în format PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Factura',
  'LBL_TPL_INVOICE_NUMBER' => 'Numarul Facturii',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'factura',
  'LBL_TPL_LIST_PRICE' => 'Lista preturi:',
  'LBL_TPL_PART_NUMBER' => 'Numar Piesa:',
  'LBL_TPL_PRODUCT' => 'Produs',
  'LBL_TPL_QUANTITY' => 'Cantitate',
  'LBL_TPL_QUOTE' => 'Cota',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Acest șablon este utilizat pentru a imprima Cotatia in PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Cotatie',
  'LBL_TPL_QUOTE_NUMBER' => 'numar cotat',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'cotatie',
  'LBL_TPL_SALES_PERSON' => 'Agent de vânzări:',
  'LBL_TPL_SHIPPING' => 'Transport',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Transport Furnizor:',
  'LBL_TPL_SHIP_TO' => 'Transportat la',
  'LBL_TPL_SUBTOTAL' => 'Subtotal:',
  'LBL_TPL_TAX' => 'taxa',
  'LBL_TPL_TAX_RATE' => 'Rata Taxa',
  'LBL_TPL_TOTAL' => 'Total',
  'LBL_TPL_UNIT_PRICE' => 'Pret Unitate:',
  'LBL_TPL_VALID_UNTIL' => 'Valabil pana la:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Editeza PDF Template',
  'LNK_IMPORT_PDFMANAGER' => 'Import PDF Templates',
  'LNK_LIST' => 'Sugar Feed',
  'LNK_NEW_RECORD' => 'Creeaza Sugar Feed',
);

