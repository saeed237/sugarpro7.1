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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Tevékenységek',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'FIGYELEM: ha megváltoztatja az elsődleges modult, a sablonhoz korábban hozzáadott mezőket el kell távolítani!',
  'LBL_ASSIGNED_TO_ID' => 'Felelős azonosítója:',
  'LBL_ASSIGNED_TO_NAME' => 'Felelős:',
  'LBL_AUTHOR' => 'Szerző',
  'LBL_BASE_MODULE' => 'Modul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Válassza ki azt a modult, amely számára ez a sablon elérhető lesz.',
  'LBL_BODY_HTML' => 'Sablon',
  'LBL_BODY_HTML_POPUP_HELP' => 'Hozza létre a sablont HTML szerkesztő segítségével! Mentés után megtekintheti a sablon PDF előnézetét.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Hozza létre a sablont HTML szerkesztő segítségével! Mentés után megtekintheti a sablon PDF előnézetét.<br /><br />A termékskála loopjának szerkesztéséhez kattintson a HTML gombra, hogy hozzáférjen a kódhoz. A kód itt található: <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP--> és <!--END_BUNDLE_LOOP-->.',
  'LBL_BTN_INSERT' => 'Beszúr',
  'LBL_CREATED' => 'Létrehozta:',
  'LBL_CREATED_ID' => 'Létrehozó azonosítója',
  'LBL_CREATED_USER' => 'Felhasználó által létrehozva',
  'LBL_DATE_ENTERED' => 'Létrehozás dátuma',
  'LBL_DATE_MODIFIED' => 'Módosítás dátuma',
  'LBL_DELETED' => 'Törölve',
  'LBL_DESCRIPTION' => 'Leírás',
  'LBL_EDITVIEW_PANEL1' => 'PDF dokumentum tulajdonságai',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Itt van a bekért fájl (a szöveg megváltoztatható)',
  'LBL_FIELD' => 'Mező',
  'LBL_FIELDS_LIST' => 'Mezők',
  'LBL_FIELD_POPUP_HELP' => 'Válasszon ki egy mezőt, hogy hozzáadjon egy változót a mező értékéhez! Szülő modul mezőinek kiválasztásához előbb adja meg a modul nevét a Mezők lista végén, majd válassza ki a kívánt mezőt a második legördülőből!',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Előzmények megtekintése',
  'LBL_HOMEPAGE_TITLE' => 'PDF sablonjaim',
  'LBL_ID' => 'Azonosító',
  'LBL_KEYWORDS' => 'Kulcsszavak',
  'LBL_KEYWORDS_POPUP_HELP' => 'Adjon meg kulcsszavakat a dokumentumhoz az alábbi formában: "kulcsszó1 kulcsszó2..."',
  'LBL_LINK_LIST' => 'Linkek',
  'LBL_LIST_FORM_TITLE' => 'PDF sablon lista',
  'LBL_LIST_NAME' => 'Név',
  'LBL_MODIFIED' => 'Módosította:',
  'LBL_MODIFIED_ID' => 'Módosító azonosítója',
  'LBL_MODIFIED_NAME' => 'Módosító neve',
  'LBL_MODIFIED_USER' => 'Felhasználó által módosítva',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Név',
  'LBL_NEW_FORM_TITLE' => 'Új PDF sablon',
  'LBL_PAYMENT_TERMS' => 'Fizetési feltételek:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Előnézet',
  'LBL_PUBLISHED' => 'Közzétéve',
  'LBL_PUBLISHED_POPUP_HELP' => 'Tegye közzé a sablont, hogy a többi felhasználó számára is elérhető legyen!',
  'LBL_PURCHASE_ORDER_NUM' => 'Megrendelési szám:',
  'LBL_SEARCH_FORM_TITLE' => 'Keresés a PdfManagerben',
  'LBL_SUBJECT' => 'Tárgy',
  'LBL_TEAM' => 'Csoportok',
  'LBL_TEAMS' => 'Csoportok',
  'LBL_TEAM_ID' => 'Csoport azonosító',
  'LBL_TITLE' => 'Cím',
  'LBL_TPL_BILL_TO' => 'Számlázási cím',
  'LBL_TPL_CURRENCY' => 'Pénznem:',
  'LBL_TPL_DISCOUNT' => 'Kedvezmény',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Kedvezményes végösszeg:',
  'LBL_TPL_EXT_PRICE' => 'Kibővített ár',
  'LBL_TPL_GRAND_TOTAL' => 'Végösszeg',
  'LBL_TPL_INVOICE' => 'Számla',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'A sablon PDF számla nyomtatásához használható.',
  'LBL_TPL_INVOICE_NAME' => 'Számla',
  'LBL_TPL_INVOICE_NUMBER' => 'Számla száma:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'számla',
  'LBL_TPL_LIST_PRICE' => 'Listaár',
  'LBL_TPL_PART_NUMBER' => 'Cikkszám',
  'LBL_TPL_PRODUCT' => 'Termék',
  'LBL_TPL_QUANTITY' => 'Mennyiség',
  'LBL_TPL_QUOTE' => 'Árajánlat',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'A sablon PDF árajánlat nyomtatásához használható.',
  'LBL_TPL_QUOTE_NAME' => 'Árajánlat',
  'LBL_TPL_QUOTE_NUMBER' => 'Árajánlat száma:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'árajánlat',
  'LBL_TPL_SALES_PERSON' => 'Értékesítő:',
  'LBL_TPL_SHIPPING' => 'Szállítás:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Szállító:',
  'LBL_TPL_SHIP_TO' => 'Szállítási cím',
  'LBL_TPL_SUBTOTAL' => 'Végösszeg:',
  'LBL_TPL_TAX' => 'Adó:',
  'LBL_TPL_TAX_RATE' => 'Adó mérték:',
  'LBL_TPL_TOTAL' => 'Összesen',
  'LBL_TPL_UNIT_PRICE' => 'Egységár',
  'LBL_TPL_VALID_UNTIL' => 'Érvényesség lejárta:',
  'LNK_EDIT_PDF_TEMPLATE' => 'PDF sablon szerkesztése',
  'LNK_IMPORT_PDFMANAGER' => 'PDF sablonok importálása',
  'LNK_LIST' => 'PDF sablonok megtekintése',
  'LNK_NEW_RECORD' => 'PDF sablon létrehozása',
);

