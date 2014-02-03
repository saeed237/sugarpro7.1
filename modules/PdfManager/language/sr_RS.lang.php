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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivnosti',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'UPOZORENJE: Ako promenite primarni modul, sva polja koja su već dodata u šablon biće uklonjena',
  'LBL_ASSIGNED_TO_ID' => 'ID broj dodeljenog korisnika',
  'LBL_ASSIGNED_TO_NAME' => 'Dodeljeno',
  'LBL_AUTHOR' => 'Autor:',
  'LBL_BASE_MODULE' => 'Modul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Odaberi modul za koji će ovaj šablon biti dostupan.',
  'LBL_BODY_HTML' => 'Šablon',
  'LBL_BODY_HTML_POPUP_HELP' => 'Kreirajte šablom korišćenjem HTML uređivača. Nakon čuvanja šablona, bićete u mogućnosti da pregledate PDG verziju šablona.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Kreirajte šablon korišćenjem HTML uređivača. Nakon čuvanja šablona, moći ćete da pregledate PDF verziju šablona. <br /><br />Da uredite proces koji se koristi pri kreiranju linija proizvoda, kliknite na dugme "HTML" u uređivaču kako biste pristupili kodu. Kod je sadržan u okviru sledećih tagova: <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP--> and <!--END_BUNDLE_LOOP-->.',
  'LBL_BTN_INSERT' => 'Unesi',
  'LBL_CREATED' => 'Autor',
  'LBL_CREATED_ID' => 'ID broj korisnika koji je kreirao',
  'LBL_CREATED_USER' => 'Kreirao korisnik',
  'LBL_DATE_ENTERED' => 'Datum kreiranja',
  'LBL_DATE_MODIFIED' => 'Datum izmene',
  'LBL_DELETED' => 'Obrisan',
  'LBL_DESCRIPTION' => 'Opis',
  'LBL_EDITVIEW_PANEL1' => 'Svojstva PDF dokumenta',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Ovo je fajl koji ste tražili (ovaj tekst možete kasnije promeniti)',
  'LBL_FIELD' => 'Polje:',
  'LBL_FIELDS_LIST' => 'Polja',
  'LBL_FIELD_POPUP_HELP' => 'Odaberite polje u koje je potrebno ubaciti varijabu za vrednost polja. Kako bi odabrali polja modula roditelja, prvo odaberite modul u odeljku za lnikove na dnu liste polja u prvom padajućem meniju, a onda odaberite polje u drugom.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Pregled istorije',
  'LBL_HOMEPAGE_TITLE' => 'Moji PDF šabloni',
  'LBL_ID' => 'ID broj',
  'LBL_KEYWORDS' => 'Ključne reči',
  'LBL_KEYWORDS_POPUP_HELP' => 'Veži ključne reči sa dokumentom, obično u formatu "klljučna reč1 klljučna reč2..."',
  'LBL_LINK_LIST' => 'Linkovi',
  'LBL_LIST_FORM_TITLE' => 'Lista izdanja',
  'LBL_LIST_NAME' => 'Naziv',
  'LBL_MODIFIED' => 'Promenio',
  'LBL_MODIFIED_ID' => 'ID broj korisnika koji je promenio',
  'LBL_MODIFIED_NAME' => 'Ime korisnika koji je promenio',
  'LBL_MODIFIED_USER' => 'Promenio korisnik',
  'LBL_MODULE_NAME' => 'PDF Menadžer',
  'LBL_MODULE_NAME_SINGULAR' => 'PDF Menadžer',
  'LBL_MODULE_TITLE' => 'PDF Menadžer',
  'LBL_NAME' => 'Naziv',
  'LBL_NEW_FORM_TITLE' => 'Novi PDF šablon',
  'LBL_PAYMENT_TERMS' => 'Uslovi plaćanja:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PDF Menadžer',
  'LBL_PREVIEW' => 'Pregled',
  'LBL_PUBLISHED' => 'Objavljen',
  'LBL_PUBLISHED_POPUP_HELP' => 'Objavi šablon kako bi bio dostupan korisnicima',
  'LBL_PURCHASE_ORDER_NUM' => 'RB kupovine:',
  'LBL_SEARCH_FORM_TITLE' => 'Pretraga PDF menadžera',
  'LBL_SUBJECT' => 'Tema',
  'LBL_TEAM' => 'Timovi',
  'LBL_TEAMS' => 'Timovi',
  'LBL_TEAM_ID' => 'ID broj tima',
  'LBL_TITLE' => 'Naslov',
  'LBL_TPL_BILL_TO' => 'Naplata',
  'LBL_TPL_CURRENCY' => 'Valuta:',
  'LBL_TPL_DISCOUNT' => 'Popust:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Međuzbir sa popustom:',
  'LBL_TPL_EXT_PRICE' => 'Procenjena cena',
  'LBL_TPL_GRAND_TOTAL' => 'Sveukupni zbir',
  'LBL_TPL_INVOICE' => 'Faktura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Ovaj šablon se koristi za štampanje predračuna u PDF varijanti',
  'LBL_TPL_INVOICE_NAME' => 'Faktura',
  'LBL_TPL_INVOICE_NUMBER' => 'Broj predračuna:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'predračun',
  'LBL_TPL_LIST_PRICE' => 'Cena:',
  'LBL_TPL_PART_NUMBER' => 'Broj dela:',
  'LBL_TPL_PRODUCT' => 'Proizvod:',
  'LBL_TPL_QUANTITY' => 'Količina',
  'LBL_TPL_QUOTE' => 'Ponuda',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Ovaj šablon se koristi za štampanje Ponude u PDF varijanti',
  'LBL_TPL_QUOTE_NAME' => 'Ponuda',
  'LBL_TPL_QUOTE_NUMBER' => 'Broj ponude:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'ponuda',
  'LBL_TPL_SALES_PERSON' => 'Osoba iz prodaje:',
  'LBL_TPL_SHIPPING' => 'Slanje:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Pošiljaoc:',
  'LBL_TPL_SHIP_TO' => 'Dostaviti na',
  'LBL_TPL_SUBTOTAL' => 'Međuzbir:',
  'LBL_TPL_TAX' => 'Porez:',
  'LBL_TPL_TAX_RATE' => 'Stopa poreza:',
  'LBL_TPL_TOTAL' => 'Ukupno',
  'LBL_TPL_UNIT_PRICE' => 'Jedinična cena:',
  'LBL_TPL_VALID_UNTIL' => 'Važi do:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Uredi PDF šablon',
  'LNK_IMPORT_PDFMANAGER' => 'Uvezi PDF šablone',
  'LNK_LIST' => 'Pregledaj PDF šablone',
  'LNK_NEW_RECORD' => 'Kreiraj PDF šablon',
);

