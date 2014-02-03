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
  'ERR_DELETE_RECORD' => 'Morate navesti broj zapisa da bi obrisali proizvod.',
  'LBL_ACCOUNT_NAME' => 'Naziv kompanije:',
  'LBL_ASSIGNED_TO' => 'Dodeljeno:',
  'LBL_ASSIGNED_TO_ID' => 'ID broj dodeljenog korisnika',
  'LBL_CATEGORY' => 'Kategorija:',
  'LBL_CATEGORY_ID' => 'ID broj kategorije',
  'LBL_CATEGORY_NAME' => 'Naziv kategorije:',
  'LBL_CONTACT_NAME' => 'Ime kontakta:',
  'LBL_COST_PRICE' => 'Trošak:',
  'LBL_COST_USDOLLAR' => 'Trošak (Američki dolar):',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Simbol valute:',
  'LBL_DATE_AVAILABLE' => 'Dostupno od:',
  'LBL_DATE_COST_PRICE' => 'Datum-Trošak-Cena:',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DISCOUNT_PRICE' => 'Jedinična cena:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Datum cene sa popustom:',
  'LBL_DISCOUNT_USDOLLAR' => 'Cena sa popustom (Američki dolar):',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID broj dodeljenog korisnika',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Ime dodeljenog korisnika',
  'LBL_EXPORT_COST_PRICE' => 'Cena koštanja',
  'LBL_EXPORT_CREATED_BY' => 'ID broj osobe koja je kreirala',
  'LBL_EXPORT_CURRENCY' => 'Valuta',
  'LBL_EXPORT_CURRENCY_ID' => 'ID broj valute',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'ID korisnika koji je promenio',
  'LBL_LIST_CATEGORY' => 'Kategorija:',
  'LBL_LIST_CATEGORY_ID' => 'ID broj kategorije:',
  'LBL_LIST_COST_PRICE' => 'Trošak:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Cena:',
  'LBL_LIST_FORM_TITLE' => 'Lista kataloga proizvoda',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Broj dela proizvođača',
  'LBL_LIST_LIST_PRICE' => 'Lista',
  'LBL_LIST_MANUFACTURER' => 'Proizvođač',
  'LBL_LIST_MANUFACTURER_ID' => 'ID broj proizvođača:',
  'LBL_LIST_NAME' => 'Naziv',
  'LBL_LIST_PRICE' => 'Cena:',
  'LBL_LIST_QTY_IN_STOCK' => 'Kom',
  'LBL_LIST_STATUS' => 'Dostupnost',
  'LBL_LIST_TYPE' => 'Tip:',
  'LBL_LIST_TYPE_ID' => 'Tip:',
  'LBL_LIST_USDOLLAR' => 'Cena (Američki dolar):',
  'LBL_MANUFACTURER' => 'Proizvođač:',
  'LBL_MANUFACTURERS' => 'Proizvođači',
  'LBL_MANUFACTURER_ID' => 'ID broj proizvođača:',
  'LBL_MANUFACTURER_NAME' => 'Naziv proizvođača:',
  'LBL_MFT_PART_NUM' => 'Broj dela proizvođača:',
  'LBL_MODULE_ID' => 'Šabloni proizvoda',
  'LBL_MODULE_NAME' => 'Katalog proizvoda',
  'LBL_MODULE_NAME_SINGULAR' => 'Katalog proizvoda:',
  'LBL_MODULE_TITLE' => 'Katalog proizvoda: Početna strana',
  'LBL_NAME' => 'Naziv proizvoda:',
  'LBL_NEW_FORM_TITLE' => 'Kreiraj atikal',
  'LBL_PERCENTAGE' => 'Procenat(%):',
  'LBL_POINTS' => 'Bodovi',
  'LBL_PRICING_FACTOR' => 'Cenovni faktor',
  'LBL_PRICING_FORMULA' => 'Podrazumevana cenovna formula:',
  'LBL_PRODUCT' => 'Proizvod:',
  'LBL_PRODUCT_CATEGORIES' => 'Kategorije proizvoda',
  'LBL_PRODUCT_ID' => 'ID broj proizvoda:',
  'LBL_PRODUCT_TYPES' => 'Tipovi proizvoda',
  'LBL_QTY_IN_STOCK' => 'Količina zaliha',
  'LBL_QUANTITY' => 'Raspoloživa količina:',
  'LBL_RELATED_PRODUCTS' => 'Povezani proizvod',
  'LBL_SEARCH_FORM_TITLE' => 'Pretraga kataloga proizvoda',
  'LBL_STATUS' => 'Dostupnost:',
  'LBL_SUPPORT_CONTACT' => 'Kontakt za podršku:',
  'LBL_SUPPORT_DESCRIPTION' => 'Opis podrške:',
  'LBL_SUPPORT_NAME' => 'Naziv podrške:',
  'LBL_SUPPORT_TERM' => 'Uslovi podrške:',
  'LBL_TAX_CLASS' => 'Poreska stopa:',
  'LBL_TYPE' => 'Tip',
  'LBL_TYPE_ID' => 'ID tipa',
  'LBL_TYPE_NAME' => 'Naziv tipa',
  'LBL_URL' => 'URL proizvoda:',
  'LBL_VENDOR_PART_NUM' => 'Broj dela prodavca:',
  'LBL_WEBSITE' => 'Web stranica',
  'LBL_WEIGHT' => 'Težina:',
  'LNK_IMPORT_PRODUCTS' => 'Uvezi proizvode',
  'LNK_NEW_MANUFACTURER' => 'Proizvođači',
  'LNK_NEW_PRODUCT' => 'Kreiraj prozvod za Katalog',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Kategorije proizvoda',
  'LNK_NEW_PRODUCT_TYPE' => 'Tipovi proizvoda',
  'LNK_NEW_SHIPPER' => 'Dostavljači',
  'LNK_PRODUCT_LIST' => 'Prikaži katalog proizvoda',
  'NTC_DELETE_CONFIRMATION' => 'Da li ste sigurni da želite da obrišete ovaj zapis?',
);

