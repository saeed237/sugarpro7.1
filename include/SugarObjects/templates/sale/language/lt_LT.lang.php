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
  'ERR_DELETE_RECORD' => 'Jūs turite nurodyti įrašo numerį, kad galėtumėte ištrinti pardavimus.',
  'LBL_ACCOUNT_ID' => 'Kliento ID',
  'LBL_ACCOUNT_NAME' => 'Kliento pavadinimas:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Priminimai',
  'LBL_AMOUNT' => 'Suma:',
  'LBL_AMOUNT_USDOLLAR' => 'Suma Lt:',
  'LBL_ASSIGNED_TO_ID' => 'Atsakingo ID',
  'LBL_ASSIGNED_TO_NAME' => 'Atsakingas:',
  'LBL_CAMPAIGN' => 'Kampanija:',
  'LBL_CLOSED_WON_SALES' => 'Sėkmingi pardavimai',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktai',
  'LBL_CREATED_ID' => 'Kūrėjo ID',
  'LBL_CURRENCY' => 'Valiuta',
  'LBL_CURRENCY_ID' => 'Valiutos ID',
  'LBL_CURRENCY_NAME' => 'Valiutos pavadinimas',
  'LBL_CURRENCY_SYMBOL' => 'Valiutos simbolis',
  'LBL_DATE_CLOSED' => 'Pardavimo data:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Pardavimas',
  'LBL_DESCRIPTION' => 'Aprašymas:',
  'LBL_DUPLICATE' => 'Galimas pardavimų dubliavimasis',
  'LBL_EDIT_BUTTON' => 'Redaguoti',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Istorija',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Potencialūs kontaktai',
  'LBL_LEAD_SOURCE' => 'Pritraukimo metodas:',
  'LBL_LIST_ACCOUNT_NAME' => 'Kliento pavadinimas',
  'LBL_LIST_AMOUNT' => 'Suma',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Atsakingas',
  'LBL_LIST_DATE_CLOSED' => 'Sandorio data',
  'LBL_LIST_FORM_TITLE' => 'Pardavimų sąrašas',
  'LBL_LIST_SALE_NAME' => 'Pavadinimas',
  'LBL_LIST_SALE_STAGE' => 'Pardavimo etapas',
  'LBL_MODIFIED_ID' => 'Redaguotojo ID',
  'LBL_MODIFIED_NAME' => 'Redaguotojo vardas',
  'LBL_MODULE_NAME' => 'Pardavimas',
  'LBL_MODULE_TITLE' => 'Pardavimas: Pradžia',
  'LBL_MY_CLOSED_SALES' => 'Mano užbaigti pardavimai',
  'LBL_NAME' => 'Pardavimo pavadinimas',
  'LBL_NEW_FORM_TITLE' => 'Naujas pardavimas',
  'LBL_NEXT_STEP' => 'Kitas žingsnis:',
  'LBL_PROBABILITY' => 'Tikimybė (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektai',
  'LBL_RAW_AMOUNT' => 'Pradinė suma',
  'LBL_REMOVE' => 'Išimti',
  'LBL_SALE' => 'Pardavimas:',
  'LBL_SALES_STAGE' => 'Pardavimo etapas:',
  'LBL_SALE_INFORMATION' => 'Pardavimo informacija',
  'LBL_SALE_NAME' => 'Pardavimo pavadinimas:',
  'LBL_SEARCH_FORM_TITLE' => 'Pardavimo paieška',
  'LBL_TEAM_ID' => 'Komandos ID',
  'LBL_TOP_SALES' => 'Mano stambiausi potencialūs pardavimai',
  'LBL_TOTAL_SALES' => 'Viso pardavimų',
  'LBL_TYPE' => 'Tipas:',
  'LBL_VIEW_FORM_TITLE' => 'Pardavimo informacija',
  'LNK_NEW_SALE' => 'Sukurti pardavimą',
  'LNK_SALE_LIST' => 'Pardavimas',
  'MSG_DUPLICATE' => 'Jūs dubliuojate pardavimą. Jei norite dubliuoti paspauskite Saugoti ir sukurti, kitu atveju spauskite Atšaukti ir sugrįšite į modulį nesukūrę pardavimo.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Ar tikrai norite išimti šį kontaktą iš pardavimų?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Ar tikrai norite išimti šį pardavimų iš projekto?',
  'UPDATE' => 'Pardavimas - Valiutos atnaujinimas',
  'UPDATE_BUGFOUND_COUNT' => 'Rastos klaidos:',
  'UPDATE_BUG_COUNT' => 'Rastos klaidos ir bandyta ištaisyti',
  'UPDATE_COUNT' => 'Įrašai atnaujinti:',
  'UPDATE_CREATE_CURRENCY' => 'Kuria naują valiutą:',
  'UPDATE_DOLLARAMOUNTS' => 'Atnaujinti U.S. Dollar sumas',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Atnaujinti pardavimų sumas litais, pagal įvestus valiutų kursus.',
  'UPDATE_DONE' => 'Užbaigta',
  'UPDATE_FAIL' => 'Nepavyko atnaujinti -',
  'UPDATE_FIX' => 'Pataisyti sumas',
  'UPDATE_FIX_TXT' => 'Bando pataisyti neteisingai įvestas sumas.',
  'UPDATE_INCLUDE_CLOSE' => 'Įtraukti užbaigtus įrašus',
  'UPDATE_MERGE' => 'Apjungti valiutas',
  'UPDATE_MERGE_TXT' => 'Apjungti keletą valiutų į vieną valiutą.',
  'UPDATE_NULL_VALUE' => 'Suma yra NULL, tad priskiriamas jai 0 -',
  'UPDATE_RESTORE' => 'Atstatyti sumas',
  'UPDATE_RESTORE_COUNT' => 'Įrašų sumos atstatytos:',
  'UPDATE_RESTORE_TXT' => 'Atstato sumą į pradinę būseną',
  'UPDATE_VERIFY' => 'Patikrinti sumas',
  'UPDATE_VERIFY_CURAMOUNT' => 'Esama suma',
  'UPDATE_VERIFY_FAIL' => 'Rasti neteisingi įrašai:',
  'UPDATE_VERIFY_FIX' => 'Pataisius būtų',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nauja suma:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nauja valiuta:',
  'UPDATE_VERIFY_TXT' => 'Patikrina ar pardavimų sumos yra skaitinės reikšmės susidedančios iš (0-9) ir dešimtainės skirtuko (,)',
);

