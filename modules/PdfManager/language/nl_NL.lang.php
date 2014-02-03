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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activiteiten',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'WAARSCHUWING: Als u de hoofd module aanpast, zullen alle reeds aangemaakte velden in het sjabloon moeten worden verwijderd.',
  'LBL_ASSIGNED_TO_ID' => 'Toegewezen Gebruikers ID',
  'LBL_ASSIGNED_TO_NAME' => 'Toegewezen aan',
  'LBL_AUTHOR' => 'Auteur',
  'LBL_BASE_MODULE' => 'Module',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Selecteer een Module waarvoor dit sjabloon beschikbaar zal zijn',
  'LBL_BODY_HTML' => 'Sjabloon',
  'LBL_BODY_HTML_POPUP_HELP' => 'Maak het sjabloon met behulp van de HTML editor. Nadat het sjabloon opgeslagen is, kunt u een voorbeeld bekijken van de PDF variant van het sjabloon.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Maak het sjabloon met behulp van de HTML editor. Nadat het sjabloon opgeslagen is, kunt u een voorbeeld bekijken van de PDF variant van het sjabloon.<br /><br />Om de &#39;loop&#39; aan te passen om de &#39;Product line items&#39; te maken: Klik op de "HTML" knop in de editor om toegang te krijgen tot de code. De code is ingesloten tussen <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP--> and <!--END_BUNDLE_LOOP-->. <br /><br />//// English:<br />To edit the loop used to create the Product line items, click the "HTML" button in the editor to access the code. The code is contained within <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP--> and <!--END_BUNDLE_LOOP-->.',
  'LBL_BTN_INSERT' => 'Invoegen',
  'LBL_CREATED' => 'Aangemaakt door',
  'LBL_CREATED_ID' => 'Aangemaakt door ID',
  'LBL_CREATED_USER' => 'Aangemaakt door Gebruiker',
  'LBL_DATE_ENTERED' => 'Datum aangemaakt',
  'LBL_DATE_MODIFIED' => 'Datum Gewijzigd',
  'LBL_DELETED' => 'Verwijderd',
  'LBL_DESCRIPTION' => 'Beschrijving',
  'LBL_EDITVIEW_PANEL1' => 'Eigenschappen van PDF Document',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Hier is het bestand dat u aangevraagd heeft (Deze tekst is aanpasbaar)',
  'LBL_FIELD' => 'Veld',
  'LBL_FIELDS_LIST' => 'Velden',
  'LBL_FIELD_POPUP_HELP' => 'Selecteer een Veld om de Variabele voor de Veldwaarde in te voeren. Om velden van de &#39;Parent Module&#39; te selecteren, selecteer eerst de module bij de snelkoppelingen onderaan de lijst met Velden in de eerste &#39;dropdown&#39;. Selecteer vervolgens vervolgens het Veld in de tweede dropdown.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Bekijk historie',
  'LBL_HOMEPAGE_TITLE' => 'Mijn PDF Sjablonen',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Sleutelwoord(en)',
  'LBL_KEYWORDS_POPUP_HELP' => 'Associeer Zoekwoorden met het document, meestal in de vorm "keyword1 keyword2 ..."',
  'LBL_LINK_LIST' => 'Koppelingen',
  'LBL_LIST_FORM_TITLE' => 'PDF sjabloon lijst',
  'LBL_LIST_NAME' => 'Naam',
  'LBL_MODIFIED' => 'Gewijzigd door',
  'LBL_MODIFIED_ID' => 'Gewijzigd door ID',
  'LBL_MODIFIED_NAME' => 'Gewijzigd door Naam',
  'LBL_MODIFIED_USER' => 'Gewijzigd door Gebruiker',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Naam',
  'LBL_NEW_FORM_TITLE' => 'Nieuw PDF Sjabloon',
  'LBL_PAYMENT_TERMS' => 'Betalingsvoorwaarden:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Voorvertoning',
  'LBL_PUBLISHED' => 'Gepubliceerd',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publiceer een sjabloon om het beschikbaar te maken voor Gebruikers',
  'LBL_PURCHASE_ORDER_NUM' => 'Inkoopopdracht:',
  'LBL_SEARCH_FORM_TITLE' => 'Zoek PDF Manager',
  'LBL_SUBJECT' => 'Onderwerp',
  'LBL_TEAM' => 'Teams',
  'LBL_TEAMS' => 'Teams',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TITLE' => 'Titel',
  'LBL_TPL_BILL_TO' => 'Factuur:',
  'LBL_TPL_CURRENCY' => 'Valuta:',
  'LBL_TPL_DISCOUNT' => 'Korting:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Subtotaal (incl. korting):',
  'LBL_TPL_EXT_PRICE' => 'Ext. Prijs',
  'LBL_TPL_GRAND_TOTAL' => 'Eindtotaal',
  'LBL_TPL_INVOICE' => 'Factuur',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Dit Sjabloon wordt gebruikt om een Factuur te printen als PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Factuur',
  'LBL_TPL_INVOICE_NUMBER' => 'Factuur nummer:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'Factuur',
  'LBL_TPL_LIST_PRICE' => 'Bruto verkoopprijs:',
  'LBL_TPL_PART_NUMBER' => 'Artikelnummer:',
  'LBL_TPL_PRODUCT' => 'Product:',
  'LBL_TPL_QUANTITY' => 'Hoeveelheid:',
  'LBL_TPL_QUOTE' => 'Quote',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Dit Sjabloon wordt gebruikt om een Offerte te printen als PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Quote',
  'LBL_TPL_QUOTE_NUMBER' => 'Offerte nummer',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'Offerte',
  'LBL_TPL_SALES_PERSON' => 'Verkoopmedewerker:',
  'LBL_TPL_SHIPPING' => 'Verzendkosten:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Verzendmethode:',
  'LBL_TPL_SHIP_TO' => 'Levering:',
  'LBL_TPL_SUBTOTAL' => 'Subtotaal:',
  'LBL_TPL_TAX' => 'BTW:',
  'LBL_TPL_TAX_RATE' => 'BTW percentage:',
  'LBL_TPL_TOTAL' => 'Totaal',
  'LBL_TPL_UNIT_PRICE' => 'Eenheidsprijs:',
  'LBL_TPL_VALID_UNTIL' => 'Geldig tot:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Pas PDF Sjablonen aan',
  'LNK_IMPORT_PDFMANAGER' => 'Importeer PDF Sjablonen',
  'LNK_LIST' => 'Bekijk PDF Sjablonen',
  'LNK_NEW_RECORD' => 'Maak nieuw PDF Sjabloon',
);

