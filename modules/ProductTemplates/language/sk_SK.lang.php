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
  'ERR_DELETE_RECORD' => 'K odstráneniu produktu musíte zadať číslo záznamu.',
  'LBL_ACCOUNT_NAME' => 'Názov účtu:',
  'LBL_ASSIGNED_TO' => 'Pridelený k:',
  'LBL_ASSIGNED_TO_ID' => 'Pridelené k ID',
  'LBL_CATEGORY' => 'Kategória',
  'LBL_CATEGORY_ID' => 'ID kategórie',
  'LBL_CATEGORY_NAME' => 'Názov kategórie',
  'LBL_CONTACT_NAME' => 'Meno kontaktu:',
  'LBL_COST_PRICE' => 'Výdavky:',
  'LBL_COST_USDOLLAR' => 'Výdavky USD:',
  'LBL_CURRENCY' => 'Mena:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Symbol meny:',
  'LBL_DATE_AVAILABLE' => 'Dátum dostupnosti:',
  'LBL_DATE_COST_PRICE' => 'Dátum-Výdavok-Cena:',
  'LBL_DESCRIPTION' => 'Popis:',
  'LBL_DISCOUNT_PRICE' => 'Jednotková cena',
  'LBL_DISCOUNT_PRICE_DATE' => 'Dátum zľavy:',
  'LBL_DISCOUNT_USDOLLAR' => 'Zľava USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Pridelené užívateľské ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Pridelené meno užívateľa',
  'LBL_EXPORT_COST_PRICE' => 'Obstarávacia cena',
  'LBL_EXPORT_CREATED_BY' => 'Vytvoril ID',
  'LBL_EXPORT_CURRENCY' => 'Mena',
  'LBL_EXPORT_CURRENCY_ID' => 'ID meny',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Upravil ID',
  'LBL_LIST_CATEGORY' => 'Kategória:',
  'LBL_LIST_CATEGORY_ID' => 'Kategória ID:',
  'LBL_LIST_COST_PRICE' => 'Výdavky:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Cena:',
  'LBL_LIST_FORM_TITLE' => 'Katalóg produktov',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Číslo výrobcu',
  'LBL_LIST_LIST_PRICE' => 'Zoznam',
  'LBL_LIST_MANUFACTURER' => 'Výrobca',
  'LBL_LIST_MANUFACTURER_ID' => 'ID Výrobcu:',
  'LBL_LIST_NAME' => 'Názov',
  'LBL_LIST_PRICE' => 'Cenník:',
  'LBL_LIST_QTY_IN_STOCK' => 'Mn.',
  'LBL_LIST_STATUS' => 'Dostupnosť',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_LIST_TYPE_ID' => 'Typ:',
  'LBL_LIST_USDOLLAR' => 'Zoznam USD',
  'LBL_MANUFACTURER' => 'Výrobca:',
  'LBL_MANUFACTURERS' => 'Výrobcovia',
  'LBL_MANUFACTURER_ID' => 'ID Výrobcu:',
  'LBL_MANUFACTURER_NAME' => 'Názov výrobcu',
  'LBL_MFT_PART_NUM' => 'Číslo dielu výrobcu:',
  'LBL_MODULE_ID' => 'Šablóny produktov',
  'LBL_MODULE_NAME' => 'Katalóg produktov',
  'LBL_MODULE_NAME_SINGULAR' => 'Katalóg produktov',
  'LBL_MODULE_TITLE' => 'Katalóg produktov: Domov',
  'LBL_NAME' => 'Názov produktu:',
  'LBL_NEW_FORM_TITLE' => 'Vytvoriť položku',
  'LBL_PERCENTAGE' => 'Percento(%)',
  'LBL_POINTS' => 'Body',
  'LBL_PRICING_FACTOR' => 'Faktor cenotvorby:',
  'LBL_PRICING_FORMULA' => 'Vzorec prednastavenej cenotvorby',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCT_CATEGORIES' => 'Kategórie produktov',
  'LBL_PRODUCT_ID' => 'Produkt ID',
  'LBL_PRODUCT_TYPES' => 'Typy produktov',
  'LBL_QTY_IN_STOCK' => 'Množstvo na sklade',
  'LBL_QUANTITY' => 'Množstvo na sklade',
  'LBL_RELATED_PRODUCTS' => 'Príbuzný produkt',
  'LBL_SEARCH_FORM_TITLE' => 'Prehľadávanie katalógu produktov',
  'LBL_STATUS' => 'Dostupnosť:',
  'LBL_SUPPORT_CONTACT' => 'Kontakt podpory:',
  'LBL_SUPPORT_DESCRIPTION' => 'Podpora popis:',
  'LBL_SUPPORT_NAME' => 'Podpora Názov:',
  'LBL_SUPPORT_TERM' => 'Podpora Podmienky:',
  'LBL_TAX_CLASS' => 'Daňova trieda',
  'LBL_TYPE' => 'Typ',
  'LBL_TYPE_ID' => 'ID typu',
  'LBL_TYPE_NAME' => 'Názov typu',
  'LBL_URL' => 'URL produktu:',
  'LBL_VENDOR_PART_NUM' => 'Číslo dielu predajcu:',
  'LBL_WEBSITE' => 'Web stránka',
  'LBL_WEIGHT' => 'Váha:',
  'LNK_IMPORT_PRODUCTS' => 'Import produktov',
  'LNK_NEW_MANUFACTURER' => 'Výrobcovia',
  'LNK_NEW_PRODUCT' => 'Vytvoriť produkt pre katalóg',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Kategórie produktov',
  'LNK_NEW_PRODUCT_TYPE' => 'Typy produktov',
  'LNK_NEW_SHIPPER' => 'Prepravcovia',
  'LNK_PRODUCT_LIST' => 'Zobrazenie katalógu produktov',
  'NTC_DELETE_CONFIRMATION' => 'Skutočne, chcete vymazať tento záznam?',
);

