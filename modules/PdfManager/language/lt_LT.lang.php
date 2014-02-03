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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Priminimai',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'PERSPĖJIMAS: Jeigu Jūs pakeisite pagrindinį modulį, Jūsų šablone esančius laukus reikės išimti.',
  'LBL_ASSIGNED_TO_ID' => 'Atsakingo Id',
  'LBL_ASSIGNED_TO_NAME' => 'Atsakingas',
  'LBL_AUTHOR' => 'Autorius',
  'LBL_BASE_MODULE' => 'Modulis',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Pasirinkti modulį, kuriam galios šis šablonas.',
  'LBL_BODY_HTML' => 'Šablonas',
  'LBL_BODY_HTML_POPUP_HELP' => 'Sukirkite šabloną pasinaudodami HTML redaktoriumi. Kai išsaugosite šabloną, Jūs galėsite peržiūrėti šablono PDF versiją.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Jeigu norite paredaguoti produktų linijas, prašome paspausti ant "HTML" mygtuko. Kodą redagavimui rasite šiuose vietose:  <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP--> ir <!--END_BUNDLE_LOOP-->.',
  'LBL_BTN_INSERT' => 'Įdėti',
  'LBL_CREATED' => 'Sukūrė',
  'LBL_CREATED_ID' => 'Sukūrėjo Id',
  'LBL_CREATED_USER' => 'Sukūrė vartotojas',
  'LBL_DATE_ENTERED' => 'Sukurta',
  'LBL_DATE_MODIFIED' => 'Redaguota',
  'LBL_DELETED' => 'Ištrintas',
  'LBL_DESCRIPTION' => 'Aprašymas',
  'LBL_EDITVIEW_PANEL1' => 'PDF dokumento nustatymai',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Štai failas kurio Jūs prašėte (Jūs galėsite pakeisti šį tekstą)',
  'LBL_FIELD' => 'Laukas',
  'LBL_FIELDS_LIST' => 'Laukai',
  'LBL_FIELD_POPUP_HELP' => 'Pasirinkite lauką, kurį norėtume įkelti. Jeigu norite įkelti įrašus iš tėvinio modulio, pirmiausia pasirinkite modulį nuorodų skiltyje, tada pasirinkite ir patį lauką.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Rodyti istoriją',
  'LBL_HOMEPAGE_TITLE' => 'Mano PDF šablonai',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Raktažodžiai',
  'LBL_KEYWORDS_POPUP_HELP' => 'Susieti raktažodžius su dokumentu (pvz.: raktas1 raktas2)',
  'LBL_LINK_LIST' => 'Nuorodos',
  'LBL_LIST_FORM_TITLE' => 'PDF šablonų sąrašas',
  'LBL_LIST_NAME' => 'Pavadinimas',
  'LBL_MODIFIED' => 'Redagavo',
  'LBL_MODIFIED_ID' => 'Redaguotojo Id',
  'LBL_MODIFIED_NAME' => 'Redagavo',
  'LBL_MODIFIED_USER' => 'Redagavo vartotojas',
  'LBL_MODULE_NAME' => 'PDF valdymas',
  'LBL_MODULE_NAME_SINGULAR' => 'PDF valdymas',
  'LBL_MODULE_TITLE' => 'PDF valdymas',
  'LBL_NAME' => 'Pavadinimas',
  'LBL_NEW_FORM_TITLE' => 'Naujas PDF šablonas',
  'LBL_PAYMENT_TERMS' => 'Apmokėjimo sąlygos:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PDF valdymas',
  'LBL_PREVIEW' => 'Peržiūra',
  'LBL_PUBLISHED' => 'Naudojamas',
  'LBL_PUBLISHED_POPUP_HELP' => 'Padaryti šabloną prieinamą visiems vartotojams.',
  'LBL_PURCHASE_ORDER_NUM' => 'Pirkimo užsakymo Nr:',
  'LBL_SEARCH_FORM_TITLE' => 'PDF valdymo paieška',
  'LBL_SUBJECT' => 'Tema',
  'LBL_TEAM' => 'Komandos',
  'LBL_TEAMS' => 'Komandos',
  'LBL_TEAM_ID' => 'Komandos Id',
  'LBL_TITLE' => 'Pavadinimas',
  'LBL_TPL_BILL_TO' => 'Mokėtojas',
  'LBL_TPL_CURRENCY' => 'Valiuta:',
  'LBL_TPL_DISCOUNT' => 'Nuolaida:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Tarpinė suma su nuolaida:',
  'LBL_TPL_EXT_PRICE' => 'Ext. kaina',
  'LBL_TPL_GRAND_TOTAL' => 'Bendra suma',
  'LBL_TPL_INVOICE' => 'Sąskaita',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Šis šablonas yra naudojamas sąskaitų generavimui PDF formate.',
  'LBL_TPL_INVOICE_NAME' => 'Sąskaita',
  'LBL_TPL_INVOICE_NUMBER' => 'Sąskaitos Nr.:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'sąskaita',
  'LBL_TPL_LIST_PRICE' => 'Standartinė kaina',
  'LBL_TPL_PART_NUMBER' => 'Tiekėjo prekės Nr',
  'LBL_TPL_PRODUCT' => 'Prekė',
  'LBL_TPL_QUANTITY' => 'Kiekis',
  'LBL_TPL_QUOTE' => 'Pasiūlymas',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Šis šablonas yra naudojamas pasiūlymų generavimui PDF formate.',
  'LBL_TPL_QUOTE_NAME' => 'Pasiūlymas',
  'LBL_TPL_QUOTE_NUMBER' => 'Pasiūlymo Nr.:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'pasiūlymas',
  'LBL_TPL_SALES_PERSON' => 'Vadybininkas:',
  'LBL_TPL_SHIPPING' => 'Pristatymas:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Pristatymo teikėjas:',
  'LBL_TPL_SHIP_TO' => 'Siųsti',
  'LBL_TPL_SUBTOTAL' => 'Tarpinė suma:',
  'LBL_TPL_TAX' => 'Mokesčiai:',
  'LBL_TPL_TAX_RATE' => 'Mokesčiai (%)',
  'LBL_TPL_TOTAL' => 'Viso',
  'LBL_TPL_UNIT_PRICE' => 'Vieneto kaina',
  'LBL_TPL_VALID_UNTIL' => 'Galioja iki:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Redaguoti PDF šablonus',
  'LNK_IMPORT_PDFMANAGER' => 'Importuoti PDF šablonus',
  'LNK_LIST' => 'PDF šablonai',
  'LNK_NEW_RECORD' => 'Sukurti naują PDF šabloną',
);

