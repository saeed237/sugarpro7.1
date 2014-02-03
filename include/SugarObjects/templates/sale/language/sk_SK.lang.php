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
  'ERR_DELETE_RECORD' => 'K odstráneniu verzie musíte zadať číslo záznamu.',
  'LBL_ACCOUNT_ID' => 'ID účtu',
  'LBL_ACCOUNT_NAME' => 'Názov účtu:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivity',
  'LBL_AMOUNT' => 'Čiastka:',
  'LBL_AMOUNT_USDOLLAR' => 'Čiastka USD:',
  'LBL_ASSIGNED_TO_ID' => 'Pridelené užívateľské ID',
  'LBL_ASSIGNED_TO_NAME' => 'Používateľ:',
  'LBL_CAMPAIGN' => 'Kampaň:',
  'LBL_CLOSED_WON_SALES' => 'Uzatvorený víťazný predaj',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CREATED_ID' => 'Vytvoril podľa ID',
  'LBL_CURRENCY' => 'Mena:',
  'LBL_CURRENCY_ID' => 'ID meny',
  'LBL_CURRENCY_NAME' => 'Názov meny',
  'LBL_CURRENCY_SYMBOL' => 'Symbol meny',
  'LBL_DATE_CLOSED' => 'Očakávaný dátum uzávierky:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Predaj',
  'LBL_DESCRIPTION' => 'Popis:',
  'LBL_DUPLICATE' => 'Možná duplicita predajov',
  'LBL_EDIT_BUTTON' => 'Upraviť',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'História',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Smerovanie',
  'LBL_LEAD_SOURCE' => 'Hlavný zdroj:',
  'LBL_LIST_ACCOUNT_NAME' => 'Názov účtu',
  'LBL_LIST_AMOUNT' => 'Čiastka',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Pridelený použivateľ',
  'LBL_LIST_DATE_CLOSED' => 'Zavrieť',
  'LBL_LIST_FORM_TITLE' => 'Zoznam predajov',
  'LBL_LIST_SALE_NAME' => 'Názov',
  'LBL_LIST_SALE_STAGE' => 'Fáza predaja',
  'LBL_MODIFIED_ID' => 'Zmenil podľa ID',
  'LBL_MODIFIED_NAME' => 'Zmenené podľa používateľského meno',
  'LBL_MODULE_NAME' => 'Predaj',
  'LBL_MODULE_TITLE' => 'Predaj: Domov',
  'LBL_MY_CLOSED_SALES' => 'Moje uzatvorené predaje',
  'LBL_NAME' => 'Názov predaja',
  'LBL_NEW_FORM_TITLE' => 'Vytvoriť predaj',
  'LBL_NEXT_STEP' => 'Ďalší krok:',
  'LBL_PROBABILITY' => 'Pravdepodobnosť (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_RAW_AMOUNT' => 'Hrubá čiastka',
  'LBL_REMOVE' => 'Odstrániť',
  'LBL_SALE' => 'Predaj:',
  'LBL_SALES_STAGE' => 'Fáza predaja:',
  'LBL_SALE_INFORMATION' => 'Informácie o predaji',
  'LBL_SALE_NAME' => 'Názov predaja:',
  'LBL_SEARCH_FORM_TITLE' => 'Hľadaj predaj',
  'LBL_TEAM_ID' => 'ID tímu',
  'LBL_TOP_SALES' => 'Moje TOP otvorené ponuky',
  'LBL_TOTAL_SALES' => 'Všetky predaje',
  'LBL_TYPE' => 'Typ:',
  'LBL_VIEW_FORM_TITLE' => 'Zobraziť predaj',
  'LNK_NEW_SALE' => 'Vytvoriť predaj',
  'LNK_SALE_LIST' => 'Predaj',
  'MSG_DUPLICATE' => 'Je pravdepodobné, že vytvárate duplicitnú ponuku. Záznamy predaov obsahujúce podobné názvy sú uvedené nižšie.<br />Kliknutím na tlačidlo Uložiť pokračujete vo vytváraní tejto ponuky, alebo kliknite na tlačidlo Zrušiť a vrátite sa na modul bez vytvorenia ponuky.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Ste si istí, že chcete odstrániť tento kontakt z predaja?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Ste si istí, že chcete odstrániť tento predaj z projektu?',
  'UPDATE' => 'Obchodná príležitosť - aktualizácia meny',
  'UPDATE_BUGFOUND_COUNT' => 'Nájdené chyby:',
  'UPDATE_BUG_COUNT' => 'Nájdené chyby a pokus o vyriešenie:',
  'UPDATE_COUNT' => 'Aktualizované záznamy:',
  'UPDATE_CREATE_CURRENCY' => 'Vytvorenie novej meny:',
  'UPDATE_DOLLARAMOUNTS' => 'Aktualizácia čiastok v U.S.D.',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Aktualizujte množstvo U.S. dolárov pre obchod na základe aktuálneho menového kurzu. Táto hodnota sa používa na vypočítanie grafov a zoznamu hodnôt mien.',
  'UPDATE_DONE' => 'Dokončené',
  'UPDATE_FAIL' => 'Nemožno aktualizovať -',
  'UPDATE_FIX' => 'Stanoviť čiastky',
  'UPDATE_FIX_TXT' => 'Pokúša sa opraviť neplatné počty vytváraním platných desatinných čísiel z aktuálneho množstva. Akékoľvek upravené čiastky sú zálohované v amount_backup databázovom poli. Ak toto skúsite a nájdete chybu, neskúšajte to znovu bez obnovy zálohy, lebo to môže prepísať zálohu neplatnými dátami.',
  'UPDATE_INCLUDE_CLOSE' => 'Zahrnúť uzatvorené záznamy',
  'UPDATE_MERGE' => 'Zlúčenie mien',
  'UPDATE_MERGE_TXT' => 'Zlúčenie viacerých mien do jednej meny. Ak je tu viac záznamov mien pre rovnakú menu, zlúčte ich do jednej. Zlúčia sa tiež meny všetkých modulov.',
  'UPDATE_NULL_VALUE' => 'Množstvo je NULA nastavené na 0 -',
  'UPDATE_RESTORE' => 'Obnoviť množstvo',
  'UPDATE_RESTORE_COUNT' => 'Obnovené množstvá záznamov:',
  'UPDATE_RESTORE_TXT' => 'Obnovi množstvo hodnôt zo zálohy vytvorenej počas opravy.',
  'UPDATE_VERIFY' => 'Overiť čiastky',
  'UPDATE_VERIFY_CURAMOUNT' => 'Aktuálna Čiastka:',
  'UPDATE_VERIFY_FAIL' => 'Záznam sa nepodarilo overiť:',
  'UPDATE_VERIFY_FIX' => 'Spustením Opravy dostanete',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nové množstvo:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nová mena:',
  'UPDATE_VERIFY_TXT' => 'Overí, že suma hodnoty v predaji, sú platné desatinné čísla s iba číselnými znakmi (0-9) a desatinnými miestami (.)',
);

