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
  'ERR_DELETE_RECORD' => 'Duhet përcaktuar numrin e regjistrimit për të fshirë produktin',
  'LBL_ACCOUNT_NAME' => 'Emri i llogarisë:',
  'LBL_ASSIGNED_TO' => 'drejtuar',
  'LBL_ASSIGNED_TO_ID' => 'caktuar për ID',
  'LBL_CATEGORY' => 'Kategoria',
  'LBL_CATEGORY_ID' => 'ID e kategorisë',
  'LBL_CATEGORY_NAME' => 'Emri i kategorisë',
  'LBL_CONTACT_NAME' => 'Emri i kontaktit',
  'LBL_COST_PRICE' => 'Shpenzimi',
  'LBL_COST_USDOLLAR' => 'shpenzimi (dollar amerikan)',
  'LBL_CURRENCY' => 'monedha',
  'LBL_CURRENCY_SYMBOL_NAME' => 'simboli i monedhës',
  'LBL_DATE_AVAILABLE' => 'Të dhënat e disponueshme',
  'LBL_DATE_COST_PRICE' => 'të dhënat-shpenzimi-çmimi',
  'LBL_DESCRIPTION' => 'Përshkrim',
  'LBL_DISCOUNT_PRICE' => 'Çmimi për njësi',
  'LBL_DISCOUNT_PRICE_DATE' => 'data e çmimit në lirim',
  'LBL_DISCOUNT_USDOLLAR' => 'Çmimi i zbritur dollar amerikan',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID e përdoruesit të caktuar',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Emri i përdoruesit të caktuar',
  'LBL_EXPORT_COST_PRICE' => 'çmimi kushtues',
  'LBL_EXPORT_CREATED_BY' => 'Krijuar Nga ID',
  'LBL_EXPORT_CURRENCY' => 'monedha',
  'LBL_EXPORT_CURRENCY_ID' => 'ID e Monedhës',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modifikuar nga ID',
  'LBL_LIST_CATEGORY' => 'Kategoria',
  'LBL_LIST_CATEGORY_ID' => 'ID  e kategroisë',
  'LBL_LIST_COST_PRICE' => 'shpenzimi',
  'LBL_LIST_DISCOUNT_PRICE' => 'çmimi',
  'LBL_LIST_FORM_TITLE' => 'Lista e katalogut të produktit',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'MFT numri',
  'LBL_LIST_LIST_PRICE' => 'lista',
  'LBL_LIST_MANUFACTURER' => 'Prodhuesi',
  'LBL_LIST_MANUFACTURER_ID' => 'ID e prodhuesit',
  'LBL_LIST_NAME' => 'Emri',
  'LBL_LIST_PRICE' => 'Lista e çmimeve',
  'LBL_LIST_QTY_IN_STOCK' => 'Qty',
  'LBL_LIST_STATUS' => 'Disponueshmëria',
  'LBL_LIST_TYPE' => 'Lloji',
  'LBL_LIST_TYPE_ID' => 'Lloji',
  'LBL_LIST_USDOLLAR' => 'Lista dollar amerikan',
  'LBL_MANUFACTURER' => 'prodhuesi',
  'LBL_MANUFACTURERS' => 'Prodhuesit',
  'LBL_MANUFACTURER_ID' => 'ID e prodhuesit',
  'LBL_MANUFACTURER_NAME' => 'Emri i prodhuesit',
  'LBL_MFT_PART_NUM' => 'Numri i pjesës së MFT',
  'LBL_MODULE_ID' => 'Shabllonet e produkteve',
  'LBL_MODULE_NAME' => 'Katalogu i produkteve',
  'LBL_MODULE_NAME_SINGULAR' => 'Katalogu i produkteve',
  'LBL_MODULE_TITLE' => 'Katalogu i produkteve: Ballina',
  'LBL_NAME' => 'Emri i produktit',
  'LBL_NEW_FORM_TITLE' => 'Krijo artikull',
  'LBL_PERCENTAGE' => 'Përqindja %',
  'LBL_POINTS' => 'Pikët',
  'LBL_PRICING_FACTOR' => 'faktorët e çmimit',
  'LBL_PRICING_FORMULA' => 'formula e gabuar e çmimit',
  'LBL_PRODUCT' => 'Produkti',
  'LBL_PRODUCT_CATEGORIES' => 'Kategoritë e Produkteve',
  'LBL_PRODUCT_ID' => 'ID e produktit',
  'LBL_PRODUCT_TYPES' => 'Llojet e Produkteve',
  'LBL_QTY_IN_STOCK' => 'sasia rezervë',
  'LBL_QUANTITY' => 'sasia e rezervave',
  'LBL_RELATED_PRODUCTS' => 'Produktet e lidhura',
  'LBL_SEARCH_FORM_TITLE' => 'Kërkim i katalogut të produkteve',
  'LBL_STATUS' => 'Disponueshmëria',
  'LBL_SUPPORT_CONTACT' => 'kontakti mbështetës',
  'LBL_SUPPORT_DESCRIPTION' => 'Përshkrimi mbështetës',
  'LBL_SUPPORT_NAME' => 'Emri i mbështetësit',
  'LBL_SUPPORT_TERM' => 'termi mbështetës',
  'LBL_TAX_CLASS' => 'Klasa e taksës',
  'LBL_TYPE' => 'Lloji',
  'LBL_TYPE_ID' => 'ID e llojit',
  'LBL_TYPE_NAME' => 'Emri i llojit',
  'LBL_URL' => 'URL e produktit',
  'LBL_VENDOR_PART_NUM' => 'Numri i pjesës së shitësit',
  'LBL_WEBSITE' => 'ueb faqja',
  'LBL_WEIGHT' => 'pesha',
  'LNK_IMPORT_PRODUCTS' => 'Produkte të importuara',
  'LNK_NEW_MANUFACTURER' => 'Prodhuesit',
  'LNK_NEW_PRODUCT' => 'Krijo produkt për katalog',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Kategoritë e produkteve',
  'LNK_NEW_PRODUCT_TYPE' => 'Llojet e Produkteve',
  'LNK_NEW_SHIPPER' => 'Ofruesit e transportit',
  'LNK_PRODUCT_LIST' => 'Shiko katalogun i produkteve',
  'NTC_DELETE_CONFIRMATION' => 'A jeni të sigurtë që dëshironi të fshini këtë regjistrim?',
);

