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
  'ERR_DELETE_RECORD' => 'A record number must be specified to delete the sale.',
  'LBL_ACCOUNT_ID' => 'Organisatie ID',
  'LBL_ACCOUNT_NAME' => 'Organisatienaam:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activiteiten',
  'LBL_AMOUNT' => 'Bedrag:',
  'LBL_AMOUNT_USDOLLAR' => 'Bedrag USD:',
  'LBL_ASSIGNED_TO_ID' => 'Toegewezen aan ID',
  'LBL_ASSIGNED_TO_NAME' => 'Toegewezen aan:',
  'LBL_CAMPAIGN' => 'Campagne:',
  'LBL_CLOSED_WON_SALES' => 'Gewonnen Verkopen',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Personen',
  'LBL_CREATED_ID' => 'Aangemaakt door ID',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_ID' => 'Valuta ID',
  'LBL_CURRENCY_NAME' => 'Valutanaam',
  'LBL_CURRENCY_SYMBOL' => 'Valuta symbool',
  'LBL_DATE_CLOSED' => 'Verwachte afsluitdatum:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Verkoop',
  'LBL_DESCRIPTION' => 'Beschrijving:',
  'LBL_DUPLICATE' => 'Mogelijke dubbele verkoop',
  'LBL_EDIT_BUTTON' => 'Wijzig',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historie',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Leads',
  'LBL_LEAD_SOURCE' => 'Bron voor Lead:',
  'LBL_LIST_ACCOUNT_NAME' => 'Organisatienaam',
  'LBL_LIST_AMOUNT' => 'Bedrag',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Toegewezen Gebruiker',
  'LBL_LIST_DATE_CLOSED' => 'Sluiten',
  'LBL_LIST_FORM_TITLE' => 'Verkoop: Lijst',
  'LBL_LIST_SALE_NAME' => 'Naam',
  'LBL_LIST_SALE_STAGE' => 'Verkoopstadium',
  'LBL_MODIFIED_ID' => 'Gewijzigd door ID',
  'LBL_MODIFIED_NAME' => 'Gewijzigd door Gebruiker',
  'LBL_MODULE_NAME' => 'Verkoop',
  'LBL_MODULE_TITLE' => 'Verkoop: Start',
  'LBL_MY_CLOSED_SALES' => 'Mijn gewonnen verkopen',
  'LBL_NAME' => 'Verkoopnaam',
  'LBL_NEW_FORM_TITLE' => 'Nieuwe Verkoop',
  'LBL_NEXT_STEP' => 'Volgende stap:',
  'LBL_PROBABILITY' => 'Waarschijnlijkheid (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projecten',
  'LBL_RAW_AMOUNT' => 'Ruw Bedrag',
  'LBL_REMOVE' => 'Verwijder',
  'LBL_SALE' => 'Verkoop:',
  'LBL_SALES_STAGE' => 'Verkoopstadium:',
  'LBL_SALE_INFORMATION' => 'Verkoopinformatie',
  'LBL_SALE_NAME' => 'Verkoopnaam:',
  'LBL_SEARCH_FORM_TITLE' => 'Verkoop: Zoeken',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TOP_SALES' => 'Mijn Top Openstaande Verkopen',
  'LBL_TOTAL_SALES' => 'Totale Verkopen',
  'LBL_TYPE' => 'Type:',
  'LBL_VIEW_FORM_TITLE' => 'Verkoop: Bekijken',
  'LNK_NEW_SALE' => 'Nieuwe Verkoop',
  'LNK_SALE_LIST' => 'Verkoop',
  'MSG_DUPLICATE' => 'The Sale record you are about to create might be a duplicate of a sale record that already exists. Sale records containing similar names are listed below.<br>Click Save to continue creating this new Sale, or click Cancel to return to the module without creating the sale.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Ben je zeker dat je deze contactpersoon wil verwijderen uit de verkoop?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Ben je zeker dat je deze verkoop wil verwijderen uit het project?',
  'UPDATE' => 'Verkoop - Valuta Update',
  'UPDATE_BUGFOUND_COUNT' => 'Bugs Found:',
  'UPDATE_BUG_COUNT' => 'Bugs Found and Attempted to Resolve:',
  'UPDATE_COUNT' => 'Records Updated:',
  'UPDATE_CREATE_CURRENCY' => 'Nieuwe valuta aanmaken:',
  'UPDATE_DOLLARAMOUNTS' => 'Update U.S. Dollar Bedragen',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Update van de US Dollar bedragen voor de verkoop op basis van de huidige wisselkoersen. Deze waarde wordt gebruikt om grafieken en lijstweergave valuta bedragen te berekenen.',
  'UPDATE_DONE' => 'Klaar',
  'UPDATE_FAIL' => 'Could not update -',
  'UPDATE_FIX' => 'Herstel Bedragen',
  'UPDATE_FIX_TXT' => 'Poging tot het vaststellen van ongeldige bedragen door het creëren van een geldig decimaal getal van het huidige bedrag. Alle gewijzigde bedragen worden als een back-up in de amount_backup database veld gezet. Als u dit toepast en fouten constateert, dient u eerst de backup te restoren alvorens het nogmaals uit te voeren, anders overschrijft u de backup met ongeldige data.',
  'UPDATE_INCLUDE_CLOSE' => 'Include Closed Records',
  'UPDATE_MERGE' => 'Merge Currencies',
  'UPDATE_MERGE_TXT' => 'Merge multiple currencies into a single currency. If there are multiple currency records for the same currency, you merge them together. This will also merge the currencies for all other modules.',
  'UPDATE_NULL_VALUE' => 'Amount is NULL setting it to 0 -',
  'UPDATE_RESTORE' => 'Restore Amounts',
  'UPDATE_RESTORE_COUNT' => 'Record Amounts Restored:',
  'UPDATE_RESTORE_TXT' => 'Restores amount values from the backups created during fix.',
  'UPDATE_VERIFY' => 'Controleer Bedragen',
  'UPDATE_VERIFY_CURAMOUNT' => 'Huidig Bedrag:',
  'UPDATE_VERIFY_FAIL' => 'Record Failed Verification:',
  'UPDATE_VERIFY_FIX' => 'Running Fix would give',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nieuw bedrag:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nieuwe valuta:',
  'UPDATE_VERIFY_TXT' => 'Verifieert dat de bedragen in verkoop geldige decimale getallen zijn met alleen numerieke tekens (0-9) en decimalen (.)',
);

