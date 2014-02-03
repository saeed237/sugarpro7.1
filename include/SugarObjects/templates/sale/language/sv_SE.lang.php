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
  'ERR_DELETE_RECORD' => 'Ett postnummer måste vara specifierat för att ta bort denna försäljning.',
  'LBL_ACCOUNT_ID' => 'Organisations ID',
  'LBL_ACCOUNT_NAME' => 'Organisationsnamn:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivitet',
  'LBL_AMOUNT' => 'Summa:',
  'LBL_AMOUNT_USDOLLAR' => 'Summa USD:',
  'LBL_ASSIGNED_TO_ID' => 'Tilldelad till ID',
  'LBL_ASSIGNED_TO_NAME' => 'Tilldelad till:',
  'LBL_CAMPAIGN' => 'Kampanj:',
  'LBL_CLOSED_WON_SALES' => 'Stängda vunna försäljningar',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakter',
  'LBL_CREATED_ID' => 'Skapad av ID',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_ID' => 'Valuta ID',
  'LBL_CURRENCY_NAME' => 'Valutanamn',
  'LBL_CURRENCY_SYMBOL' => 'Valutasymbol',
  'LBL_DATE_CLOSED' => 'Förväntat slutdatum:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Försäljning',
  'LBL_DESCRIPTION' => 'Beskrivning:',
  'LBL_DUPLICATE' => 'Möjlig duplicerad försäljning',
  'LBL_EDIT_BUTTON' => 'Redigera',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Leadkälla:',
  'LBL_LIST_ACCOUNT_NAME' => 'Organisationsnamn',
  'LBL_LIST_AMOUNT' => 'Summa',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Tilldelad användare',
  'LBL_LIST_DATE_CLOSED' => 'Stäng',
  'LBL_LIST_FORM_TITLE' => 'Försäljningslista',
  'LBL_LIST_SALE_NAME' => 'Namn',
  'LBL_LIST_SALE_STAGE' => 'Försäljningsstage',
  'LBL_MODIFIED_ID' => 'Ändrad av ID',
  'LBL_MODIFIED_NAME' => 'Ändrad av användarnamn',
  'LBL_MODULE_NAME' => 'Försäljning',
  'LBL_MODULE_TITLE' => 'Försäljning: Hem',
  'LBL_MY_CLOSED_SALES' => 'Mina stängda försäljningar',
  'LBL_NAME' => 'Försäljningsnamn',
  'LBL_NEW_FORM_TITLE' => 'Skapa försäljning',
  'LBL_NEXT_STEP' => 'Nästa steg:',
  'LBL_PROBABILITY' => 'Trolighet (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekt',
  'LBL_RAW_AMOUNT' => 'Rå summa',
  'LBL_REMOVE' => 'Ta bort',
  'LBL_SALE' => 'Försäljning:',
  'LBL_SALES_STAGE' => 'Försäljningsstage:',
  'LBL_SALE_INFORMATION' => 'Försäljningsinformation',
  'LBL_SALE_NAME' => 'Försäljningsnamn:',
  'LBL_SEARCH_FORM_TITLE' => 'Sök försäljning',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TOP_SALES' => 'Mina topp öpnna-försäljningar',
  'LBL_TOTAL_SALES' => 'Total försäljning',
  'LBL_TYPE' => 'Typ:',
  'LBL_VIEW_FORM_TITLE' => 'Försäljningsvy',
  'LNK_NEW_SALE' => 'Skapa försäljning',
  'LNK_SALE_LIST' => 'Försäljning',
  'MSG_DUPLICATE' => 'Försäljningsposten du håller på att skapa kan vara en dublett av en redan existerande post. Försäljningar med liknande namn är listade nedan.<br>Klicka Spara för att fortsätta att skapa denna nya försäljning, eller klicka Avbryt för att återgå till modulen utan att skapa försäljningen.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Är du säker att du vill ta bort denna kontakt från försäljningen?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Är du säker att du vill ta bort denna försäljning från detta projekt?',
  'UPDATE' => 'Försäljning - Valuta uppdatering',
  'UPDATE_BUGFOUND_COUNT' => 'Hittade buggar:',
  'UPDATE_BUG_COUNT' => 'Bugg funnen och försökt lösas:',
  'UPDATE_COUNT' => 'Poster uppdaterade:',
  'UPDATE_CREATE_CURRENCY' => 'Skapa ny valuta:',
  'UPDATE_DOLLARAMOUNTS' => 'Uppdatera summa U.S. Dollar',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Uppdatera summan av U.S. Dollars för försäljning baserat på den nuvarande valutakursen. Detta värde används för att räkna ut grafer och ListVy valuta summan.',
  'UPDATE_DONE' => 'Klart',
  'UPDATE_FAIL' => 'Kunde inte uppdatera -',
  'UPDATE_FIX' => 'Fixa summa',
  'UPDATE_FIX_TXT' => 'Försäker fixa ogiltiga summor genom att skapa en giltig decimal från den nuvarande summan. Ändrade summor är sparade i amount_backup databas-fältet. On du kör detta och hittar buggar, kör inte igen utan att först ha återskapat från backup eftersom det kan skriva över backuppen med felaktig data.',
  'UPDATE_INCLUDE_CLOSE' => 'Inkludera stängda poster',
  'UPDATE_MERGE' => 'Slå ihop valutor',
  'UPDATE_MERGE_TXT' => 'Slå ihop multipla valutor till en valuta. Om det finns flera valuta-poster för samma valuta slår du ihop dom. Detta kommer också att slå ihop valutor för alla andra moduler.',
  'UPDATE_NULL_VALUE' => 'Summan är NULL sätter den till 0 -',
  'UPDATE_RESTORE' => 'Återskapa summa',
  'UPDATE_RESTORE_COUNT' => 'Summa av poster återskapade:',
  'UPDATE_RESTORE_TXT' => 'Återskapa summa från backup skapade under fixen.',
  'UPDATE_VERIFY' => 'Verifiera summa',
  'UPDATE_VERIFY_CURAMOUNT' => 'Nuvarande summa:',
  'UPDATE_VERIFY_FAIL' => 'Misslyckad verifiering av post:',
  'UPDATE_VERIFY_FIX' => 'Att köra fix skulle ge',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Ny summa:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Ny valuta:',
  'UPDATE_VERIFY_TXT' => 'Verifiera att summan i försäljningen har giltiga decimaler med endast numeriska tecken (0-9) och av separerare (.)',
);

