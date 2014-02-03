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
  'ERR_DELETE_RECORD' => 'Trebuie sa specifici un numar de inregistrare pentru a sterge produsul',
  'LBL_ACCOUNT_NAME' => 'Numele Contului',
  'LBL_ASSIGNED_TO' => 'Atribuit Lui:',
  'LBL_ASSIGNED_TO_ID' => 'Atribuit ID Utilizator',
  'LBL_CATEGORY' => 'Categorie',
  'LBL_CATEGORY_ID' => 'Identitate categorie:',
  'LBL_CATEGORY_NAME' => 'Nume categorie:',
  'LBL_CONTACT_NAME' => 'Nume Contact:',
  'LBL_COST_PRICE' => 'Cost:',
  'LBL_COST_USDOLLAR' => 'Cost USD:',
  'LBL_CURRENCY' => 'Moneda',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Simbol Moneda',
  'LBL_DATE_AVAILABLE' => 'Data disponibila:',
  'LBL_DATE_COST_PRICE' => 'Data-Cost-Pret:',
  'LBL_DESCRIPTION' => 'Descriere',
  'LBL_DISCOUNT_PRICE' => 'Pret Unitate:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Data discount pretz',
  'LBL_DISCOUNT_USDOLLAR' => 'Discount Pret USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Alocat utilizatorului ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Alocat utilizatorului',
  'LBL_EXPORT_COST_PRICE' => 'Pret',
  'LBL_EXPORT_CREATED_BY' => 'Creat de ID',
  'LBL_EXPORT_CURRENCY' => 'Moneda',
  'LBL_EXPORT_CURRENCY_ID' => 'Moneda Id',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificat de ID-ul',
  'LBL_LIST_CATEGORY' => 'Categorie',
  'LBL_LIST_CATEGORY_ID' => 'Identitate categorie:',
  'LBL_LIST_COST_PRICE' => 'Cost',
  'LBL_LIST_DISCOUNT_PRICE' => 'Pret Unitar',
  'LBL_LIST_FORM_TITLE' => 'Lista catalog produse',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Mft Num',
  'LBL_LIST_LIST_PRICE' => 'Lista',
  'LBL_LIST_MANUFACTURER' => 'Producator',
  'LBL_LIST_MANUFACTURER_ID' => 'Indentitate producator',
  'LBL_LIST_NAME' => 'Nume',
  'LBL_LIST_PRICE' => 'Lista preturi:',
  'LBL_LIST_QTY_IN_STOCK' => 'Cantitate',
  'LBL_LIST_STATUS' => 'Disponibilitate',
  'LBL_LIST_TYPE' => 'Tip',
  'LBL_LIST_TYPE_ID' => 'Tip:',
  'LBL_LIST_USDOLLAR' => 'Lista USD:',
  'LBL_MANUFACTURER' => 'Producator',
  'LBL_MANUFACTURERS' => 'Producatori',
  'LBL_MANUFACTURER_ID' => 'Indentitate producator',
  'LBL_MANUFACTURER_NAME' => 'Nume producator:',
  'LBL_MFT_PART_NUM' => 'Numarul parte al producatorului:',
  'LBL_MODULE_ID' => 'Sabloane produse',
  'LBL_MODULE_NAME' => 'Catalog de produse',
  'LBL_MODULE_NAME_SINGULAR' => 'Catalog de produse',
  'LBL_MODULE_TITLE' => 'Catalog Produse: Acasa',
  'LBL_NAME' => 'Nume produs:',
  'LBL_NEW_FORM_TITLE' => 'Creeaza item',
  'LBL_PERCENTAGE' => 'Procentaj(%):',
  'LBL_POINTS' => 'Puncte',
  'LBL_PRICING_FACTOR' => 'Factor de pret:',
  'LBL_PRICING_FORMULA' => 'Formula preturilor implicita',
  'LBL_PRODUCT' => 'Produs',
  'LBL_PRODUCT_CATEGORIES' => 'Categorii de Produse',
  'LBL_PRODUCT_ID' => 'Identitate produs:',
  'LBL_PRODUCT_TYPES' => 'Tipuri Produse',
  'LBL_QTY_IN_STOCK' => 'Stoc',
  'LBL_QUANTITY' => 'Cantitate in stoc:',
  'LBL_RELATED_PRODUCTS' => 'Produs inrudit',
  'LBL_SEARCH_FORM_TITLE' => 'Cautare Catalog Produse',
  'LBL_STATUS' => 'Disponibilitate',
  'LBL_SUPPORT_CONTACT' => 'Suport contact:',
  'LBL_SUPPORT_DESCRIPTION' => 'Suport desc:',
  'LBL_SUPPORT_NAME' => 'Nume suport:',
  'LBL_SUPPORT_TERM' => 'Suport term:',
  'LBL_TAX_CLASS' => 'Clasa de taxe:',
  'LBL_TYPE' => 'Tip',
  'LBL_TYPE_ID' => 'Tip ID',
  'LBL_TYPE_NAME' => 'Tastati numele',
  'LBL_URL' => 'URL',
  'LBL_VENDOR_PART_NUM' => 'Nume parte furnizor:',
  'LBL_WEBSITE' => 'Site Web',
  'LBL_WEIGHT' => 'Greutate:',
  'LNK_IMPORT_PRODUCTS' => 'Importa produse',
  'LNK_NEW_MANUFACTURER' => 'Producatori',
  'LNK_NEW_PRODUCT' => 'Creeaza produs pentru catalog',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Categorii de Produse',
  'LNK_NEW_PRODUCT_TYPE' => 'Tipuri Produse',
  'LNK_NEW_SHIPPER' => 'Furnizori Transport',
  'LNK_PRODUCT_LIST' => 'Vezi catalog produse',
  'NTC_DELETE_CONFIRMATION' => 'Esti sigur ca vrei sa stergi aceasta inregistrare?',
);

