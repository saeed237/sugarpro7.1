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
  'ERR_DELETE_RECORD' => 'Der skal angives et postnummer for at slette produktet.',
  'LBL_ACCOUNT_NAME' => 'Virksomhednavn:',
  'LBL_ASSIGNED_TO' => 'Tildelt til:',
  'LBL_ASSIGNED_TO_ID' => 'Tildelt til id:',
  'LBL_CATEGORY' => 'Kategori:',
  'LBL_CATEGORY_ID' => 'Kategori id:',
  'LBL_CATEGORY_NAME' => 'Kategorinavn:',
  'LBL_CONTACT_NAME' => 'Kontaktnavn:',
  'LBL_COST_PRICE' => 'Omkostninger:',
  'LBL_COST_USDOLLAR' => 'Omkostninger i USD:',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Valutasymbol:',
  'LBL_DATE_AVAILABLE' => 'Tilgængelig dato:',
  'LBL_DATE_COST_PRICE' => 'Dato-omkostninger-pris:',
  'LBL_DESCRIPTION' => 'Beskrivelse:',
  'LBL_DISCOUNT_PRICE' => 'Enhedspris:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Rabatpris, dato:',
  'LBL_DISCOUNT_USDOLLAR' => 'Rabatpris i USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Tildelt bruger-id',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Tildelt brugernavn',
  'LBL_EXPORT_COST_PRICE' => 'Kostpris',
  'LBL_EXPORT_CREATED_BY' => 'Oprettet af id',
  'LBL_EXPORT_CURRENCY' => 'Valuta',
  'LBL_EXPORT_CURRENCY_ID' => 'Valuta id',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Ændret af id',
  'LBL_LIST_CATEGORY' => 'Kategori:',
  'LBL_LIST_CATEGORY_ID' => 'Kategori-id:',
  'LBL_LIST_COST_PRICE' => 'Omkostninger:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Pris:',
  'LBL_LIST_FORM_TITLE' => 'Produktkatalogliste',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Prod.nr.',
  'LBL_LIST_LIST_PRICE' => 'Liste',
  'LBL_LIST_MANUFACTURER' => 'Producent',
  'LBL_LIST_MANUFACTURER_ID' => 'Producent-id:',
  'LBL_LIST_NAME' => 'Navn',
  'LBL_LIST_PRICE' => 'Listepris:',
  'LBL_LIST_QTY_IN_STOCK' => 'Mængde',
  'LBL_LIST_STATUS' => 'Tilgængelighed',
  'LBL_LIST_TYPE' => 'Type:',
  'LBL_LIST_TYPE_ID' => 'Type-id:',
  'LBL_LIST_USDOLLAR' => 'Vis USD:',
  'LBL_MANUFACTURER' => 'Producent:',
  'LBL_MANUFACTURERS' => 'Producenter',
  'LBL_MANUFACTURER_ID' => 'Producent id:',
  'LBL_MANUFACTURER_NAME' => 'Producentnavn:',
  'LBL_MFT_PART_NUM' => 'Prod. artikelnummer:',
  'LBL_MODULE_ID' => 'Produktskabeloner',
  'LBL_MODULE_NAME' => 'Produktkatalog',
  'LBL_MODULE_TITLE' => 'Produktkatalog: Startside',
  'LBL_NAME' => 'Produktnavn:',
  'LBL_NEW_FORM_TITLE' => 'Opret post',
  'LBL_PERCENTAGE' => 'Procent "%"',
  'LBL_POINTS' => 'Punkter',
  'LBL_PRICING_FACTOR' => 'Prisfaktor:',
  'LBL_PRICING_FORMULA' => 'Standardprisformel:',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCT_CATEGORIES' => 'Produktkategorier',
  'LBL_PRODUCT_ID' => 'Produkt-id:',
  'LBL_PRODUCT_TYPES' => 'Produkttyper',
  'LBL_QTY_IN_STOCK' => 'Antal på lager',
  'LBL_QUANTITY' => 'Beholdningsmængde:',
  'LBL_RELATED_PRODUCTS' => 'Relateret produkt',
  'LBL_SEARCH_FORM_TITLE' => 'Søg efter produktkatalog',
  'LBL_STATUS' => 'Tilgængelighed:',
  'LBL_SUPPORT_CONTACT' => 'Supportkontakt:',
  'LBL_SUPPORT_DESCRIPTION' => 'Supportbeskr.:',
  'LBL_SUPPORT_NAME' => 'Supportnavn:',
  'LBL_SUPPORT_TERM' => 'Supportvarighed:',
  'LBL_TAX_CLASS' => 'Momsklasse:',
  'LBL_TYPE' => 'Type:',
  'LBL_TYPE_ID' => 'Type id',
  'LBL_TYPE_NAME' => 'Typenavn',
  'LBL_URL' => 'Produkt-URL:',
  'LBL_VENDOR_PART_NUM' => 'Leverandørs artikelnummer:',
  'LBL_WEBSITE' => 'Websted',
  'LBL_WEIGHT' => 'Vægt:',
  'LNK_IMPORT_PRODUCTS' => 'Importér produkter',
  'LNK_NEW_MANUFACTURER' => 'Producenter',
  'LNK_NEW_PRODUCT' => 'Opret produkt til katalog',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Produktkategorier',
  'LNK_NEW_PRODUCT_TYPE' => 'Produkttyper',
  'LNK_NEW_SHIPPER' => 'Speditører',
  'LNK_PRODUCT_LIST' => 'Produktkatalog',
  'NTC_DELETE_CONFIRMATION' => 'Er du sikker på, at du vil slette denne post?',
);

