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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteter',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'VARNING: Om du ändrar primärmodulen, kommer alla fält som redan adderats till templaten att raderas.',
  'LBL_ASSIGNED_TO_ID' => 'Tilldelat användarid',
  'LBL_ASSIGNED_TO_NAME' => 'Tilldelad till',
  'LBL_AUTHOR' => 'Författare',
  'LBL_BASE_MODULE' => 'Modul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Välj en modul för vilken den här templaten ska vara möjlig.',
  'LBL_BODY_HTML' => 'Template',
  'LBL_BODY_HTML_POPUP_HELP' => 'Skapa en template genom att använda HTML editorn. Efter du sparat templaten, kommer du ha möjlighet att visa en förhandsgranskning av PDF versionen av templaten.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Skapa en template genom att använda HTML editorn. Efter du sparat templaten, kommer du ha möjlighet att visa en förhandsgranskning av PDF versionen av templaten.<br /><br />För att redigera loopen som används för att skapa Product line items, klicka "HTML" knappen i editorn för att få tillgång till koden. Koden finns innanför &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => 'Infoga',
  'LBL_CREATED' => 'Skapad av',
  'LBL_CREATED_ID' => 'Skapat av ID',
  'LBL_CREATED_USER' => 'Skapad av användare',
  'LBL_DATE_ENTERED' => 'Skapat datum',
  'LBL_DATE_MODIFIED' => 'Senast ändrad',
  'LBL_DELETED' => 'Raderad',
  'LBL_DESCRIPTION' => 'Beskrivning',
  'LBL_EDITVIEW_PANEL1' => 'PDF Dokument Egenskaper',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Här är filen du begärde (Du kan ändra den här texten)',
  'LBL_FIELD' => 'Fält',
  'LBL_FIELDS_LIST' => 'Fält',
  'LBL_FIELD_POPUP_HELP' => 'Välj ett fält att sätta in variabel för fältets värde. För att välja fält av föräldramodulen, välj först modulen i Länkområdet i botten på Fältlistan i den första dropdownen, Välj sedan välj fältet i den andra dropdownen.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Visa historik',
  'LBL_HOMEPAGE_TITLE' => 'Mina PDF Templates',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Nyckelord',
  'LBL_KEYWORDS_POPUP_HELP' => 'Associera nyckelord med dokumentet, vanligtvis i formen "nyckelord1 nyckelord2 ..."',
  'LBL_LINK_LIST' => 'Länkar',
  'LBL_LIST_FORM_TITLE' => 'PDF Template Lista',
  'LBL_LIST_NAME' => 'Namn',
  'LBL_MODIFIED' => 'Ändrad av',
  'LBL_MODIFIED_ID' => 'Ändrat av ID',
  'LBL_MODIFIED_NAME' => 'Ändrad av namn',
  'LBL_MODIFIED_USER' => 'Ändrad av användare',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Namn',
  'LBL_NEW_FORM_TITLE' => 'Ny PDF Template',
  'LBL_PAYMENT_TERMS' => 'Betalningsvillkor:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Förhandsgranska',
  'LBL_PUBLISHED' => 'Publicerad',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publicera en template för att göra den tillgänglig till andra användare',
  'LBL_PURCHASE_ORDER_NUM' => 'Inköpsordernummer:',
  'LBL_SEARCH_FORM_TITLE' => 'Sök PDF Manager',
  'LBL_SUBJECT' => 'Ämne',
  'LBL_TEAM' => 'Teams',
  'LBL_TEAMS' => 'Teams',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TITLE' => 'Titel',
  'LBL_TPL_BILL_TO' => 'Fakturera till',
  'LBL_TPL_CURRENCY' => 'Valuta:',
  'LBL_TPL_DISCOUNT' => 'Avdrag:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Avdrag Delsumma:',
  'LBL_TPL_EXT_PRICE' => 'Externt pris',
  'LBL_TPL_GRAND_TOTAL' => 'Totalsumma',
  'LBL_TPL_INVOICE' => 'Faktura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Den här templaten används för att skriva Faktura i PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Faktura',
  'LBL_TPL_INVOICE_NUMBER' => 'Fakturanummer:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'faktura',
  'LBL_TPL_LIST_PRICE' => 'Listpris',
  'LBL_TPL_PART_NUMBER' => 'Delnummer:',
  'LBL_TPL_PRODUCT' => 'Produkt',
  'LBL_TPL_QUANTITY' => 'Kvantitet',
  'LBL_TPL_QUOTE' => 'Offert',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Den här templaten används för att skriva Offert i PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Offert',
  'LBL_TPL_QUOTE_NUMBER' => 'Offert nummer:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'offert',
  'LBL_TPL_SALES_PERSON' => 'Säljare:',
  'LBL_TPL_SHIPPING' => 'Levererans:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Transportföretag:',
  'LBL_TPL_SHIP_TO' => 'Leverera till',
  'LBL_TPL_SUBTOTAL' => 'Delsumma:',
  'LBL_TPL_TAX' => 'Skatt:',
  'LBL_TPL_TAX_RATE' => 'Skattesats:',
  'LBL_TPL_TOTAL' => 'Totalt',
  'LBL_TPL_UNIT_PRICE' => 'Enhetspris',
  'LBL_TPL_VALID_UNTIL' => 'Giltig till:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Redigera PDF Template',
  'LNK_IMPORT_PDFMANAGER' => 'Importera PDF Templates',
  'LNK_LIST' => 'Visa PDF Templates',
  'LNK_NEW_RECORD' => 'Skapa PDF Template',
);

