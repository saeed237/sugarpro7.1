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
  'ERR_DELETE_RECORD' => 'Et registernummer må oppgis for å slette dette produktet.',
  'LBL_ACCOUNT_NAME' => 'Kontonavn:',
  'LBL_ASSIGNED_TO' => 'Tildelt:',
  'LBL_ASSIGNED_TO_ID' => 'Tildelt ID:',
  'LBL_CATEGORY' => 'Kategori:',
  'LBL_CATEGORY_ID' => 'Kategori-ID:',
  'LBL_CATEGORY_NAME' => 'Kategorinavn:',
  'LBL_CONTACT_NAME' => 'Kontaktnavn:',
  'LBL_COST_PRICE' => 'Kostnad:',
  'LBL_COST_USDOLLAR' => 'Kostnad USD:',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Valutasymbol:',
  'LBL_DATE_AVAILABLE' => 'Tilgjengelighetsdato:',
  'LBL_DATE_COST_PRICE' => 'Dato-Kostnad-Pris:',
  'LBL_DESCRIPTION' => 'Beskrivelse:',
  'LBL_DISCOUNT_PRICE' => 'Rabattert pris:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Dato for prisrabatt:',
  'LBL_DISCOUNT_USDOLLAR' => 'Rabattert pris USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Tildelt Bruker-ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Tildelt Brukernavn',
  'LBL_EXPORT_COST_PRICE' => 'Kostpris',
  'LBL_EXPORT_CREATED_BY' => 'Opprettet Av ID',
  'LBL_EXPORT_CURRENCY' => 'Valuta',
  'LBL_EXPORT_CURRENCY_ID' => 'Valuta-ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Endret av ID',
  'LBL_LIST_CATEGORY' => 'Kategori:',
  'LBL_LIST_CATEGORY_ID' => 'Kategori-ID:',
  'LBL_LIST_COST_PRICE' => 'Kostnad:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Pris:',
  'LBL_LIST_FORM_TITLE' => 'Produktkatalogliste',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Prod. num.',
  'LBL_LIST_LIST_PRICE' => 'Liste',
  'LBL_LIST_MANUFACTURER' => 'Produsent',
  'LBL_LIST_MANUFACTURER_ID' => 'Produsent-ID:',
  'LBL_LIST_NAME' => 'Navn',
  'LBL_LIST_PRICE' => 'Listepris:',
  'LBL_LIST_QTY_IN_STOCK' => 'Kvantitet',
  'LBL_LIST_STATUS' => 'Tilgjenglighet',
  'LBL_LIST_TYPE' => 'Type:',
  'LBL_LIST_TYPE_ID' => 'Type-ID:',
  'LBL_LIST_USDOLLAR' => 'Liste USD:',
  'LBL_MANUFACTURER' => 'Produsent:',
  'LBL_MANUFACTURERS' => 'Produsenter',
  'LBL_MANUFACTURER_ID' => 'Produsent-ID:',
  'LBL_MANUFACTURER_NAME' => 'Produsentens navn:',
  'LBL_MFT_PART_NUM' => 'Prod. del av nummer:',
  'LBL_MODULE_ID' => 'Produktmaler',
  'LBL_MODULE_NAME' => 'Produktkatalog',
  'LBL_MODULE_TITLE' => 'Produktkatalog: Hjem',
  'LBL_NAME' => 'Produktnavn:',
  'LBL_NEW_FORM_TITLE' => 'Opprett postering',
  'LBL_PERCENTAGE' => 'Prosent(%)',
  'LBL_POINTS' => 'Poeng',
  'LBL_PRICING_FACTOR' => 'Prisfaktor:',
  'LBL_PRICING_FORMULA' => 'Forhåndsinntilt prisformel:',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCT_CATEGORIES' => 'Produktkategorier',
  'LBL_PRODUCT_ID' => 'Produkt-ID:',
  'LBL_PRODUCT_TYPES' => 'Produkttyper',
  'LBL_QTY_IN_STOCK' => 'Lagerbeholdning',
  'LBL_QUANTITY' => 'Mengde på lager:',
  'LBL_RELATED_PRODUCTS' => 'Relatert produkt',
  'LBL_SEARCH_FORM_TITLE' => 'Søk i produktkatalog',
  'LBL_STATUS' => 'Tilgjengelighet:',
  'LBL_SUPPORT_CONTACT' => 'Supportkontakt:',
  'LBL_SUPPORT_DESCRIPTION' => 'Supportdesc:',
  'LBL_SUPPORT_NAME' => 'Supportnavn:',
  'LBL_SUPPORT_TERM' => 'Supporttid:',
  'LBL_TAX_CLASS' => 'Skatteklasse:',
  'LBL_TYPE' => 'Type',
  'LBL_TYPE_ID' => 'Type-ID',
  'LBL_TYPE_NAME' => 'Typenavn',
  'LBL_URL' => 'Produkt-URL:',
  'LBL_VENDOR_PART_NUM' => 'Delenummer på automat:',
  'LBL_WEBSITE' => 'Nettsted',
  'LBL_WEIGHT' => 'Vekt:',
  'LNK_IMPORT_PRODUCTS' => 'Importér produkter',
  'LNK_NEW_MANUFACTURER' => 'Produsenter',
  'LNK_NEW_PRODUCT' => 'Opprett postering for katalog',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Produktkategorier',
  'LNK_NEW_PRODUCT_TYPE' => 'Produkttyper',
  'LNK_NEW_SHIPPER' => 'Avsenderleverandør',
  'LNK_PRODUCT_LIST' => 'Produktkatalog',
  'NTC_DELETE_CONFIRMATION' => 'Er du sikker på at du vil slette denne oppføringen?',
);

