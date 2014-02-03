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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivitäten',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'WARNUNG: Wenn Sie das Primarmodul ändern, müssen Sie alle hinzugefügten Felder entfernen.',
  'LBL_ASSIGNED_TO_ID' => 'Zugewiesene BenutzerID',
  'LBL_ASSIGNED_TO_NAME' => 'Zugewiesen an',
  'LBL_AUTHOR' => 'Autor',
  'LBL_BASE_MODULE' => 'Modul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Wählen Sie ein Modul für das diese Vorlage verfügbar sein soll.',
  'LBL_BODY_HTML' => 'Vorlage',
  'LBL_BODY_HTML_POPUP_HELP' => 'Erstellen Sie eine Vorlage mit dem HTML Editor. Nach dem Speichern sehen Sie eine Vorschau der PDF Version der Vorlage.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Create the template using the HTML editor. After saving the template, you will be able to view a preview of the PDF version of the template.<br /><br />To edit the loop used to create the Product line items, click the "HTML" button in the editor to access the code.  The code is contained within &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => 'Einfügen',
  'LBL_CREATED' => 'Erstellt von:',
  'LBL_CREATED_ID' => 'Erstellt von ID:',
  'LBL_CREATED_USER' => 'Erstellt von Benutzer:',
  'LBL_DATE_ENTERED' => 'Erstellt am:',
  'LBL_DATE_MODIFIED' => 'Geändert am:',
  'LBL_DELETED' => 'Gelöscht',
  'LBL_DESCRIPTION' => 'Beschreibung',
  'LBL_EDITVIEW_PANEL1' => 'PDF Dokument Eigenschaften',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Hier ist die Datei, die sie angefordert haben (Dieser Text kann geändert werden)',
  'LBL_FIELD' => 'Feld',
  'LBL_FIELDS_LIST' => 'Felder',
  'LBL_FIELD_POPUP_HELP' => 'Wählen Sie ein Feld, um die Variable für den Feldwert einzufügen. To select fields of a parent module, first select the module in the Links area at the bottom of the Fields list in the first dropdown, then select the field in the second dropdown.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Verlauf ansehen',
  'LBL_HOMEPAGE_TITLE' => 'Meine PDF Vorlagen',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Schlüsselwörter:',
  'LBL_KEYWORDS_POPUP_HELP' => 'Schlüsselwörter mit einem Dokument in Verbindung bringen normaler Weise in der Form: "Schlüsselwort1 Schlüsselwort2...."',
  'LBL_LINK_LIST' => 'Links',
  'LBL_LIST_FORM_TITLE' => 'PDF Vorlagen Liste',
  'LBL_LIST_NAME' => 'Name',
  'LBL_MODIFIED' => 'Geändert von',
  'LBL_MODIFIED_ID' => 'Geändert von ID',
  'LBL_MODIFIED_NAME' => 'Geändert von',
  'LBL_MODIFIED_USER' => 'Geändert von Benutzer',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Name',
  'LBL_NEW_FORM_TITLE' => 'Neue PDF Vorlage',
  'LBL_PAYMENT_TERMS' => 'Zahlungskonditionen:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Vorschau',
  'LBL_PUBLISHED' => 'Veröffentlicht',
  'LBL_PUBLISHED_POPUP_HELP' => 'Veröffentlichen Sie eine Vorlage um sie für andere Benutzer sichtbar zu machen.',
  'LBL_PURCHASE_ORDER_NUM' => 'Bestellnummer:',
  'LBL_SEARCH_FORM_TITLE' => 'Suche PDF Manager',
  'LBL_SUBJECT' => 'Betreff',
  'LBL_TEAM' => 'Teams',
  'LBL_TEAMS' => 'Teams',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TITLE' => 'Titel',
  'LBL_TPL_BILL_TO' => 'Rech. an',
  'LBL_TPL_CURRENCY' => 'Währung:',
  'LBL_TPL_DISCOUNT' => 'Rabatt:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Rabatt Zwischensumme:',
  'LBL_TPL_EXT_PRICE' => 'Ext. Preis',
  'LBL_TPL_GRAND_TOTAL' => 'Gesamtbetrag',
  'LBL_TPL_INVOICE' => 'Rechnung',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Diese Vorlage wird zum Drucken von Rechnungen zu PDF verwendet.',
  'LBL_TPL_INVOICE_NAME' => 'Rechnung',
  'LBL_TPL_INVOICE_NUMBER' => 'Rechnungsnummer:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'Rechnung',
  'LBL_TPL_LIST_PRICE' => 'Listpreis',
  'LBL_TPL_PART_NUMBER' => 'Teilenummer',
  'LBL_TPL_PRODUCT' => 'Produkt',
  'LBL_TPL_QUANTITY' => 'Menge',
  'LBL_TPL_QUOTE' => 'Vertrag',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Diese Vorlage wird zum Drucken von Angeboten zu PDF verwendet.',
  'LBL_TPL_QUOTE_NAME' => 'Angebot',
  'LBL_TPL_QUOTE_NUMBER' => 'Angebotnummer:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'Angebot',
  'LBL_TPL_SALES_PERSON' => 'Verkäufer/in:',
  'LBL_TPL_SHIPPING' => 'Versand:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Lieferant:',
  'LBL_TPL_SHIP_TO' => 'Lief. an:',
  'LBL_TPL_SUBTOTAL' => 'Zwischensumme:',
  'LBL_TPL_TAX' => 'Steuer:',
  'LBL_TPL_TAX_RATE' => 'Steuersatz:',
  'LBL_TPL_TOTAL' => 'Gesamt',
  'LBL_TPL_UNIT_PRICE' => 'Stück Preis',
  'LBL_TPL_VALID_UNTIL' => 'Gültig bis:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Bericht PDF Vorlage bearbeiten',
  'LNK_IMPORT_PDFMANAGER' => 'PDF Vorlagen importieren',
  'LNK_LIST' => 'PDF Vorlagen anzeigen',
  'LNK_NEW_RECORD' => 'PDF Vorlage erstellen',
);

