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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivity',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'UPOZORNĚNÍ: Pokud změníte primární modul, všechna pole již přidány do šablony budou muset být odstraněny.',
  'LBL_ASSIGNED_TO_ID' => 'Přidělené ID uživatele',
  'LBL_ASSIGNED_TO_NAME' => 'Přiřazeno:',
  'LBL_AUTHOR' => 'Autor:',
  'LBL_BASE_MODULE' => 'Modul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Výběr modulů kde bude šablona dostupná',
  'LBL_BODY_HTML' => 'Šablona',
  'LBL_BODY_HTML_POPUP_HELP' => 'Vytvořte šablonu pomocí HTML editoru. Po uložení šablony, budete moci zobrazit náhled PDF verze šablony.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Vytvořit šablonu pomocí HTML editoru. After saving the template, you will be able to view a preview of the PDF version of the template.<br /><br />To edit the loop used to create the Product line items, click the "HTML" button in the editor to access the code.  The code is contained within &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => 'Vložit',
  'LBL_CREATED' => 'Vytvořil',
  'LBL_CREATED_ID' => 'Vytvořeno uživatelem ID',
  'LBL_CREATED_USER' => 'Vytvořeno uživatelem',
  'LBL_DATE_ENTERED' => 'Datum vytvoření',
  'LBL_DATE_MODIFIED' => 'Datum poslední úpravy',
  'LBL_DELETED' => 'Smazáno',
  'LBL_DESCRIPTION' => 'Popis',
  'LBL_EDITVIEW_PANEL1' => 'Vlastnosti PDF',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Zde je soubor o který jste požádal (můžete změnit text)',
  'LBL_FIELD' => 'Pole:',
  'LBL_FIELDS_LIST' => 'Pole',
  'LBL_FIELD_POPUP_HELP' => 'Vyberte pole pro vložení proměnné pro hodnoty pole. Chcete-li vybrat pole nadřazeného modulu, nejprve vyberte modul v oblasti Odkazy v dolní části seznamu Pole v první rozevírací, vyberte pole ve druhé rozevírací.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Zobrazit historii',
  'LBL_HOMEPAGE_TITLE' => 'Moje PDF šablony',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Klíčová slova',
  'LBL_KEYWORDS_POPUP_HELP' => 'Klíčová slova obvykle vkládat takto: "slovo1, slovo2,..."',
  'LBL_LINK_LIST' => 'Linky',
  'LBL_LIST_FORM_TITLE' => 'Seznam PDF šablon',
  'LBL_LIST_NAME' => 'Název',
  'LBL_MODIFIED' => 'Upravil',
  'LBL_MODIFIED_ID' => 'Změněno uživatelem ID',
  'LBL_MODIFIED_NAME' => 'Upravil',
  'LBL_MODIFIED_USER' => 'Upraveno uživatelem',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Název',
  'LBL_NEW_FORM_TITLE' => 'Nová PDF šablona',
  'LBL_PAYMENT_TERMS' => 'Platební podmínky:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Náhled',
  'LBL_PUBLISHED' => 'Publikovaná',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publikovat šablonu',
  'LBL_PURCHASE_ORDER_NUM' => 'Číslo objednávky:',
  'LBL_SEARCH_FORM_TITLE' => 'Hledat PDF',
  'LBL_SUBJECT' => 'Předmět',
  'LBL_TEAM' => 'Týmy',
  'LBL_TEAMS' => 'Týmy',
  'LBL_TEAM_ID' => 'ID týmu',
  'LBL_TITLE' => 'Nadpis:',
  'LBL_TPL_BILL_TO' => 'Fakturovat',
  'LBL_TPL_CURRENCY' => 'Měna',
  'LBL_TPL_DISCOUNT' => 'Sleva',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Ponížený mezisoučet',
  'LBL_TPL_EXT_PRICE' => 'Rozšířená cena',
  'LBL_TPL_GRAND_TOTAL' => 'Celkový součet',
  'LBL_TPL_INVOICE' => 'Faktura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Tato šablona se používá pro tisk faktury ve formátu PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Faktura',
  'LBL_TPL_INVOICE_NUMBER' => 'Číslo faktury',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'Faktura',
  'LBL_TPL_LIST_PRICE' => 'Tabulková cena:',
  'LBL_TPL_PART_NUMBER' => 'Číslo dílu:',
  'LBL_TPL_PRODUCT' => 'Produkt:',
  'LBL_TPL_QUANTITY' => 'Množství',
  'LBL_TPL_QUOTE' => 'Nabídka',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Tato šablona se používá pro tisk nabídky ve formátu PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Nabídka',
  'LBL_TPL_QUOTE_NUMBER' => 'Číslo faktury',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'Nabídka',
  'LBL_TPL_SALES_PERSON' => 'Prodejce:',
  'LBL_TPL_SHIPPING' => 'Dopravné',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Dopravce',
  'LBL_TPL_SHIP_TO' => 'Dodat na',
  'LBL_TPL_SUBTOTAL' => 'Mezisoučet',
  'LBL_TPL_TAX' => 'Daň',
  'LBL_TPL_TAX_RATE' => 'Daň%',
  'LBL_TPL_TOTAL' => 'Celkem',
  'LBL_TPL_UNIT_PRICE' => 'Cena za jednotku:',
  'LBL_TPL_VALID_UNTIL' => 'Platné do:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Upravit PDF šablonu',
  'LNK_IMPORT_PDFMANAGER' => 'Importovat PDF šablonu',
  'LNK_LIST' => 'Zobrazit PDF šablonu',
  'LNK_NEW_RECORD' => 'Vytvořit PDF šablonu',
);

