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
  'ERR_DELETE_RECORD' => 'Jméno záznamu musí být specifikované pro odstranění produktu.',
  'LBL_ACCOUNT_NAME' => 'Jméno společnosti:',
  'LBL_ASSIGNED_TO' => 'Přiděleno:',
  'LBL_ASSIGNED_TO_ID' => 'Přiděleno ID:',
  'LBL_CATEGORY' => 'Kategorie:',
  'LBL_CATEGORY_ID' => 'ID kategorie:',
  'LBL_CATEGORY_NAME' => 'Jméno kategorie:',
  'LBL_CONTACT_NAME' => 'Jméno kontaktu:',
  'LBL_COST_PRICE' => 'Náklady:',
  'LBL_COST_USDOLLAR' => 'Cena USD:',
  'LBL_CURRENCY' => 'Měna:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Symbol měny:',
  'LBL_DATE_AVAILABLE' => 'Dostupné:',
  'LBL_DATE_COST_PRICE' => 'Datum-Náklady-Cena',
  'LBL_DESCRIPTION' => 'Popis:',
  'LBL_DISCOUNT_PRICE' => 'Cena za jednotku:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Datum slevy:',
  'LBL_DISCOUNT_USDOLLAR' => 'Sleva USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Přiřazený uživatel ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Přiřazený uživatel',
  'LBL_EXPORT_COST_PRICE' => 'Pořizovací cena',
  'LBL_EXPORT_CREATED_BY' => 'Vytvořeno od ID:',
  'LBL_EXPORT_CURRENCY' => 'Měna:',
  'LBL_EXPORT_CURRENCY_ID' => 'ID měny',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'ID modifikátora',
  'LBL_LIST_CATEGORY' => 'Kategorie:',
  'LBL_LIST_CATEGORY_ID' => 'ID kategorie:',
  'LBL_LIST_COST_PRICE' => 'Náklady:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Cena:',
  'LBL_LIST_FORM_TITLE' => 'Seznam katalog výrobků',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Číslo výrobce',
  'LBL_LIST_LIST_PRICE' => 'Seznam',
  'LBL_LIST_MANUFACTURER' => 'Výrobce',
  'LBL_LIST_MANUFACTURER_ID' => 'ID výrobce:',
  'LBL_LIST_NAME' => 'Jméno',
  'LBL_LIST_PRICE' => 'Ceníková cena:',
  'LBL_LIST_QTY_IN_STOCK' => 'Množství',
  'LBL_LIST_STATUS' => 'Dostupnost',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_LIST_TYPE_ID' => 'Type ID:',
  'LBL_LIST_USDOLLAR' => 'Seznam USD:',
  'LBL_MANUFACTURER' => 'Výrobce:',
  'LBL_MANUFACTURERS' => 'Výrobci',
  'LBL_MANUFACTURER_ID' => 'ID výrobce:',
  'LBL_MANUFACTURER_NAME' => 'Jméno výrobce:',
  'LBL_MFT_PART_NUM' => 'Číslo dílu výrobce',
  'LBL_MODULE_ID' => 'Šablony produktů',
  'LBL_MODULE_NAME' => 'Katalog produktů',
  'LBL_MODULE_TITLE' => 'Katalog produktů: Hlavní stránka',
  'LBL_NAME' => 'Jméno produktu:',
  'LBL_NEW_FORM_TITLE' => 'Vytvořit položku',
  'LBL_PERCENTAGE' => 'Procentuální (%)',
  'LBL_POINTS' => 'Body',
  'LBL_PRICING_FACTOR' => 'Cenový faktor:',
  'LBL_PRICING_FORMULA' => 'Výchozí cenový vzorec:',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCT_CATEGORIES' => 'Kategorie produktů',
  'LBL_PRODUCT_ID' => 'ID produktu:',
  'LBL_PRODUCT_TYPES' => 'Typy produktu',
  'LBL_QTY_IN_STOCK' => 'Množství skladem',
  'LBL_QUANTITY' => 'Množství na skladě:',
  'LBL_RELATED_PRODUCTS' => 'Související produkt',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledávání v katalogu výrobků',
  'LBL_STATUS' => 'Dostupnost:',
  'LBL_SUPPORT_CONTACT' => 'Kontakt na podporu:',
  'LBL_SUPPORT_DESCRIPTION' => 'Popis podpory:',
  'LBL_SUPPORT_NAME' => 'Jméno podpory:',
  'LBL_SUPPORT_TERM' => 'Termín podpory:',
  'LBL_TAX_CLASS' => 'Daňová třída:',
  'LBL_TYPE' => 'Type:',
  'LBL_TYPE_ID' => 'ID Typu',
  'LBL_TYPE_NAME' => 'Jméno typu',
  'LBL_URL' => 'URL produktu:',
  'LBL_VENDOR_PART_NUM' => 'Číslo dílu prodávajícího:',
  'LBL_WEBSITE' => 'WWW stránky:',
  'LBL_WEIGHT' => 'Váha:',
  'LNK_IMPORT_PRODUCTS' => 'Importovat produkty',
  'LNK_NEW_MANUFACTURER' => 'Výrobci',
  'LNK_NEW_PRODUCT' => 'Vytvořit produkt pro katalog',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Kategorie produktů',
  'LNK_NEW_PRODUCT_TYPE' => 'Typy produktů',
  'LNK_NEW_SHIPPER' => 'Přepravní poskytovatelé',
  'LNK_PRODUCT_LIST' => 'Zobrazit katalog výrobků',
  'NTC_DELETE_CONFIRMATION' => 'Jste si jisti, že chcete smazat tento záznam?',
);

