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
  'ERR_DELETE_RECORD' => 'Um das Produkt zu löschen, muss eine Datensatznummer angegeben werden.',
  'LBL_ACCOUNT_NAME' => 'Firmenname:',
  'LBL_ASSIGNED_TO' => 'Zugewiesen an:',
  'LBL_ASSIGNED_TO_ID' => 'Bearbeiter:',
  'LBL_CATEGORY' => 'Kategorie',
  'LBL_CATEGORY_ID' => 'Kategorie ID:',
  'LBL_CATEGORY_NAME' => 'Kategorie Name:',
  'LBL_CONTACT_NAME' => 'Name:',
  'LBL_COST_PRICE' => 'Einstandspreis:',
  'LBL_COST_USDOLLAR' => 'Einstandspreis USD:',
  'LBL_CURRENCY' => 'Währung',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Währungssymbol:',
  'LBL_DATE_AVAILABLE' => 'Verfügbarkeitsdatum:',
  'LBL_DATE_COST_PRICE' => 'Datum-Einstandspreis:',
  'LBL_DESCRIPTION' => 'Beschreibung:',
  'LBL_DISCOUNT_PRICE' => 'Rabattierter Preis:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Rabatt Preis Datum:',
  'LBL_DISCOUNT_USDOLLAR' => 'Rabatt Preis USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Zugewiesen an',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Zugewiesen an',
  'LBL_EXPORT_COST_PRICE' => 'Herstellkosten',
  'LBL_EXPORT_CREATED_BY' => 'Ersteller',
  'LBL_EXPORT_CURRENCY' => 'Währung',
  'LBL_EXPORT_CURRENCY_ID' => 'Währungs ID:',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Bearbeiter:',
  'LBL_LIST_CATEGORY' => 'Kategorie',
  'LBL_LIST_CATEGORY_ID' => 'Kategorie ID:',
  'LBL_LIST_COST_PRICE' => 'Einstandspreis:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Preis:',
  'LBL_LIST_FORM_TITLE' => 'Produktkatalog Liste',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Herst. Teilenr.',
  'LBL_LIST_LIST_PRICE' => 'Liste',
  'LBL_LIST_MANUFACTURER' => 'Hersteller',
  'LBL_LIST_MANUFACTURER_ID' => 'Hersteller ID:',
  'LBL_LIST_NAME' => 'Name',
  'LBL_LIST_PRICE' => 'Listpreis',
  'LBL_LIST_QTY_IN_STOCK' => 'Mng',
  'LBL_LIST_STATUS' => 'Verfügbarkeit',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_LIST_TYPE_ID' => 'Typ ID:',
  'LBL_LIST_USDOLLAR' => 'Liste USD:',
  'LBL_MANUFACTURER' => 'Hersteller:',
  'LBL_MANUFACTURERS' => 'Hersteller',
  'LBL_MANUFACTURER_ID' => 'Hersteller ID:',
  'LBL_MANUFACTURER_NAME' => 'Herstellername:',
  'LBL_MFT_PART_NUM' => 'Herst. Artikelnummer:',
  'LBL_MODULE_ID' => 'Produktvorlagen',
  'LBL_MODULE_NAME' => 'Produktkatalog',
  'LBL_MODULE_NAME_SINGULAR' => 'Produktkatalog',
  'LBL_MODULE_TITLE' => 'Produktkatalog: Home',
  'LBL_NAME' => 'Produkt Name:',
  'LBL_NEW_FORM_TITLE' => 'Neuer Artikel',
  'LBL_PERCENTAGE' => 'Prozentsatz(%)',
  'LBL_POINTS' => 'Punkte',
  'LBL_PRICING_FACTOR' => 'Preisfaktor:',
  'LBL_PRICING_FORMULA' => 'Standard Preisformel:',
  'LBL_PRODUCT' => 'Produkt:',
  'LBL_PRODUCT_CATEGORIES' => 'Produktkategorien',
  'LBL_PRODUCT_ID' => 'Produkt ID:',
  'LBL_PRODUCT_TYPES' => 'Produktarten',
  'LBL_QTY_IN_STOCK' => 'Menge auf Lager',
  'LBL_QUANTITY' => 'Menge auf Lager:',
  'LBL_RELATED_PRODUCTS' => 'Verknüpftes Produkt',
  'LBL_SEARCH_FORM_TITLE' => 'Produktkatalog Suche',
  'LBL_STATUS' => 'Verfügbarkeit:',
  'LBL_SUPPORT_CONTACT' => 'Support Kontakt:',
  'LBL_SUPPORT_DESCRIPTION' => 'Support Besch:',
  'LBL_SUPPORT_NAME' => 'Support Name:',
  'LBL_SUPPORT_TERM' => 'Support Bedingung:',
  'LBL_TAX_CLASS' => 'Steuerklasse:',
  'LBL_TYPE' => 'Typ:',
  'LBL_TYPE_ID' => 'Typ-ID',
  'LBL_TYPE_NAME' => 'Typ Name',
  'LBL_URL' => 'Produkt URL:',
  'LBL_VENDOR_PART_NUM' => 'Verkäufer Artikelnummer:',
  'LBL_WEBSITE' => 'Webseite:',
  'LBL_WEIGHT' => 'Gewicht:',
  'LNK_IMPORT_PRODUCTS' => 'Produkte importieren',
  'LNK_NEW_MANUFACTURER' => 'Hersteller',
  'LNK_NEW_PRODUCT' => 'Produkt für Katalog erstellen',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Produktkategorien',
  'LNK_NEW_PRODUCT_TYPE' => 'Produktarten',
  'LNK_NEW_SHIPPER' => 'Versender',
  'LNK_PRODUCT_LIST' => 'Produktkatalog',
  'NTC_DELETE_CONFIRMATION' => 'Sind Sie sicher, dass Sie diesen Eintrag löschen wollen?',
);

