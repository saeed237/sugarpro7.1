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
  'ERR_DELETE_RECORD' => 'Musisz podać numer rekordu, aby usunąć ten produkt.',
  'LBL_ACCOUNT_NAME' => 'Nazwa kontrahenta:',
  'LBL_ASSIGNED_TO' => 'Przydzielono do:',
  'LBL_ASSIGNED_TO_ID' => 'ID przydzielone do:',
  'LBL_CATEGORY' => 'Kategoria:',
  'LBL_CATEGORY_ID' => 'ID kategorii',
  'LBL_CATEGORY_NAME' => 'Nazwa kategorii:',
  'LBL_CONTACT_NAME' => 'Nazwa kontaktu:',
  'LBL_COST_PRICE' => 'Koszt:',
  'LBL_COST_USDOLLAR' => 'Koszt (PLN):',
  'LBL_CURRENCY' => 'Waluta:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Symbol waluty:',
  'LBL_DATE_AVAILABLE' => 'Data dostępności:',
  'LBL_DATE_COST_PRICE' => 'Data-koszt-cena:',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DISCOUNT_PRICE' => 'Cena rabatowa:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Data obniżki ceny:',
  'LBL_DISCOUNT_USDOLLAR' => 'Cena rabatowa (PLN):',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Przydzielono do',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Przydzielono do',
  'LBL_EXPORT_COST_PRICE' => 'Cena kosztów własnych',
  'LBL_EXPORT_CREATED_BY' => 'Utworzone przez (ID)',
  'LBL_EXPORT_CURRENCY' => 'Waluta',
  'LBL_EXPORT_CURRENCY_ID' => 'ID waluty',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Zmodyfikowane przez (ID)',
  'LBL_LIST_CATEGORY' => 'Kategoria:',
  'LBL_LIST_CATEGORY_ID' => 'ID kategorii:',
  'LBL_LIST_COST_PRICE' => 'Koszt:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Cena:',
  'LBL_LIST_FORM_TITLE' => 'Lista Katalogu produktów',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Symbol producenta',
  'LBL_LIST_LIST_PRICE' => 'Cena katalogowa',
  'LBL_LIST_MANUFACTURER' => 'Producent',
  'LBL_LIST_MANUFACTURER_ID' => 'ID producenta:',
  'LBL_LIST_NAME' => 'Nazwa',
  'LBL_LIST_PRICE' => 'Cena katalogowa:',
  'LBL_LIST_QTY_IN_STOCK' => 'Ilość',
  'LBL_LIST_STATUS' => 'Dostępność',
  'LBL_LIST_TYPE' => 'Typ produktu:',
  'LBL_LIST_TYPE_ID' => 'ID typu:',
  'LBL_LIST_USDOLLAR' => 'Cena katalogowa (PLN):',
  'LBL_MANUFACTURER' => 'Producent:',
  'LBL_MANUFACTURERS' => 'Producenci',
  'LBL_MANUFACTURER_ID' => 'ID producenta',
  'LBL_MANUFACTURER_NAME' => 'Nazwa producenta:',
  'LBL_MFT_PART_NUM' => 'Nr kat. wg producenta:',
  'LBL_MODULE_ID' => 'Wzór produktu',
  'LBL_MODULE_NAME' => 'Katalog produktów',
  'LBL_MODULE_NAME_SINGULAR' => 'Katalog produktów',
  'LBL_MODULE_TITLE' => 'Katalog produktów: Strona główna',
  'LBL_NAME' => 'Nazwa produktu:',
  'LBL_NEW_FORM_TITLE' => 'Utwórz przedmiot',
  'LBL_PERCENTAGE' => 'Procent (%)',
  'LBL_POINTS' => 'Punktów',
  'LBL_PRICING_FACTOR' => 'Współczynnik ceny:',
  'LBL_PRICING_FORMULA' => 'Domyślna formuła ustalania ceny:',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCT_CATEGORIES' => 'Kategorie produktów',
  'LBL_PRODUCT_ID' => 'ID produktu:',
  'LBL_PRODUCT_TYPES' => 'Typy produktów',
  'LBL_QTY_IN_STOCK' => 'Ilość w magazynie',
  'LBL_QUANTITY' => 'Ilość na magazynie:',
  'LBL_RELATED_PRODUCTS' => 'Powiązane produkty',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie w katalogu produktów',
  'LBL_STATUS' => 'Dostępność:',
  'LBL_SUPPORT_CONTACT' => 'Kontakt do gwaranta:',
  'LBL_SUPPORT_DESCRIPTION' => 'Typ gwarancji:',
  'LBL_SUPPORT_NAME' => 'Gwarant:',
  'LBL_SUPPORT_TERM' => 'Okres gwarancji:',
  'LBL_TAX_CLASS' => 'Obowiązek podatkowy:',
  'LBL_TYPE' => 'Typ produktu:',
  'LBL_TYPE_ID' => 'ID typu',
  'LBL_TYPE_NAME' => 'Nazwa typu',
  'LBL_URL' => 'URL do produktu:',
  'LBL_VENDOR_PART_NUM' => 'Nr kat. wg sprzedawcy:',
  'LBL_WEBSITE' => 'Strona www',
  'LBL_WEIGHT' => 'Waga:',
  'LNK_IMPORT_PRODUCTS' => 'Importuj produkty',
  'LNK_NEW_MANUFACTURER' => 'Producenci',
  'LNK_NEW_PRODUCT' => 'Uwórz produkt',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Kategorie produktów',
  'LNK_NEW_PRODUCT_TYPE' => 'Typy produktów',
  'LNK_NEW_SHIPPER' => 'Dostawcy',
  'LNK_PRODUCT_LIST' => 'Katalog produktów',
  'NTC_DELETE_CONFIRMATION' => 'Czy na pewno chcesz usunąć ten rekord?',
);

