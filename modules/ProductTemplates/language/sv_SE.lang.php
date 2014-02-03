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
  'ERR_DELETE_RECORD' => 'Ett objektnummer måste specificeras för att radera produkten.',
  'LBL_ACCOUNT_NAME' => 'Organisationsnamn:',
  'LBL_ASSIGNED_TO' => 'Tilldelad till:',
  'LBL_ASSIGNED_TO_ID' => 'Tilldelad till ID:',
  'LBL_CATEGORY' => 'Kategori',
  'LBL_CATEGORY_ID' => 'Kategori ID',
  'LBL_CATEGORY_NAME' => 'Kategorinamn:',
  'LBL_CONTACT_NAME' => 'Kontaktnamn:',
  'LBL_COST_PRICE' => 'Kostnad:',
  'LBL_COST_USDOLLAR' => 'Kostnad:',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Valutasymbol:',
  'LBL_DATE_AVAILABLE' => 'Tillgängligt datum:',
  'LBL_DATE_COST_PRICE' => 'Datum-Kostnad-Pris',
  'LBL_DESCRIPTION' => 'Beskrivning:',
  'LBL_DISCOUNT_PRICE' => 'Rabatterat pris',
  'LBL_DISCOUNT_PRICE_DATE' => 'Datum för rabatterat pris:',
  'LBL_DISCOUNT_USDOLLAR' => 'Rabbaterat pris:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Tilldelad Användar ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Tilldelat Användarnamn',
  'LBL_EXPORT_COST_PRICE' => 'Inköpspris',
  'LBL_EXPORT_CREATED_BY' => 'Skapad av ID',
  'LBL_EXPORT_CURRENCY' => 'Valuta',
  'LBL_EXPORT_CURRENCY_ID' => 'Valuta ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Ändrad av ID',
  'LBL_LIST_CATEGORY' => 'Kategori:',
  'LBL_LIST_CATEGORY_ID' => 'Kategori ID:',
  'LBL_LIST_COST_PRICE' => 'Kostnad:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Pris:',
  'LBL_LIST_FORM_TITLE' => 'Lista produktkatalogen',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Tillverknings nummer',
  'LBL_LIST_LIST_PRICE' => 'Lista',
  'LBL_LIST_MANUFACTURER' => 'Tillverkare',
  'LBL_LIST_MANUFACTURER_ID' => 'Tillverkare ID:',
  'LBL_LIST_NAME' => 'Namn',
  'LBL_LIST_PRICE' => 'Listpris',
  'LBL_LIST_QTY_IN_STOCK' => 'Kvantitet',
  'LBL_LIST_STATUS' => 'Tillgång',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_LIST_TYPE_ID' => 'Typ ID:',
  'LBL_LIST_USDOLLAR' => 'List:',
  'LBL_MANUFACTURER' => 'Tillverkare:',
  'LBL_MANUFACTURERS' => 'Tillverkare',
  'LBL_MANUFACTURER_ID' => 'Tillverkare ID',
  'LBL_MANUFACTURER_NAME' => 'Tillverkarens namn:',
  'LBL_MFT_PART_NUM' => 'Tillverkarens artikelnummer:',
  'LBL_MODULE_ID' => 'ProduktMall',
  'LBL_MODULE_NAME' => 'Produktkatalog',
  'LBL_MODULE_TITLE' => 'Produktkatalog: Hem',
  'LBL_NAME' => 'Produktnamn:',
  'LBL_NEW_FORM_TITLE' => 'Skapa post',
  'LBL_PERCENTAGE' => 'Procent (%)',
  'LBL_POINTS' => 'Poäng',
  'LBL_PRICING_FACTOR' => 'Prisfaktor',
  'LBL_PRICING_FORMULA' => 'Prisberäkningsformel:',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCT_CATEGORIES' => 'Produktkategorier',
  'LBL_PRODUCT_ID' => 'Produkt ID:',
  'LBL_PRODUCT_TYPES' => 'Produkttyper',
  'LBL_QTY_IN_STOCK' => 'Aktie Antal',
  'LBL_QUANTITY' => 'Kvantitet i lager:',
  'LBL_RELATED_PRODUCTS' => 'Relaterad produkt',
  'LBL_SEARCH_FORM_TITLE' => 'Sök produktkatalog',
  'LBL_STATUS' => 'Tillgång:',
  'LBL_SUPPORT_CONTACT' => 'Supportkontakt:',
  'LBL_SUPPORT_DESCRIPTION' => 'Supportbeskrivning:',
  'LBL_SUPPORT_NAME' => 'Supportnamn:',
  'LBL_SUPPORT_TERM' => 'Supportteam:',
  'LBL_TAX_CLASS' => 'Skatteklass:',
  'LBL_TYPE' => 'Typ:',
  'LBL_TYPE_ID' => 'ID Typ',
  'LBL_TYPE_NAME' => 'Typnamn:',
  'LBL_URL' => 'Produkt URL:',
  'LBL_VENDOR_PART_NUM' => 'Leverantörens artikelnummer:',
  'LBL_WEBSITE' => 'Hemsida',
  'LBL_WEIGHT' => 'Vikt:',
  'LNK_IMPORT_PRODUCTS' => 'Importera produkter',
  'LNK_NEW_MANUFACTURER' => 'Tillverkare',
  'LNK_NEW_PRODUCT' => 'Skapa produkt för katalogen',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Produktkategorier',
  'LNK_NEW_PRODUCT_TYPE' => 'Produtkttyper',
  'LNK_NEW_SHIPPER' => 'Leverantörer',
  'LNK_PRODUCT_LIST' => 'Produktkatalog',
  'NTC_DELETE_CONFIRMATION' => 'Är du säker på att du vill radera posten?',
);

