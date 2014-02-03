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
  'ERR_NO_OPPS' => 'Molim, kreirajte neke Prodajne prilike da bi mogli da vidite grafike Prodajnih prilika.',
  'LBL_ALL_OPPORTUNITIES' => 'Ukupan iznos prodajnih prilika je',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'Prikazuje odziv kampanje po povratku investicije.',
  'LBL_CHART_ACTION' => 'Akcija',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'DCE akcije po tipu (trenutni mesec)',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Izvor potencijalnog klijenta po ishodu:',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => 'Korišćeni moduli po Mojim direktnim izveštajima (Poslednjih 30 dana)',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Moji korišćeni moduli (Poslednjih 30 dana)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'Moj prodajni levak po fazama prodaje',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => 'Prodajne prilike ovog kvartala',
  'LBL_CHART_OUTCOME_BY_MONTH' => 'Ishod po mesecu',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Prodajni levak po izvoru informacije o potencijalnom klijentu',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Prodajni levak po fazama prodaje',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'Levak prodaje grupisan po fazama prodaje',
  'LBL_CHART_TYPE' => 'Tip dijagrama',
  'LBL_CLOSE_DATE_END' => 'Datum završetka:',
  'LBL_CLOSE_DATE_START' => 'Očekivani datum zatvaranja - Od:',
  'LBL_CREATED_ON' => 'Poslednji put pokrenut',
  'LBL_DATE_END' => 'Datum završetka',
  'LBL_DATE_RANGE' => 'Vremenski opseg je',
  'LBL_DATE_RANGE_TO' => 'za',
  'LBL_DATE_START' => 'Datum početka',
  'LBL_EDIT' => 'Izmeni',
  'LBL_LEAD_SOURCES' => 'Izvor potencijalnog klijenta:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Sve Prodajne prilike po izvoru informacija o potencijalnim klijentima po ishodu',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Prikazuje za odabranog korisnika kumulativne iznose prodajnih prilika po odabranom izvoru informacija o potencijalnom klijentu po ishodu. Ishod se zasniva na tome da li je stanje prodaje završeno dobitkom, završeno gubitkom ili drugačije.',
  'LBL_LEAD_SOURCE_FORM_DESC' => 'Prikazuje kumulativne iznose Prodajnih prilika po odabranom izvoru informacija o potencijalnom klijentu za odabrane korisnike.',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'Sve Prodajne prilike po izvoru informacije o potencijalnom klijentu',
  'LBL_LEAD_SOURCE_OTHER' => 'Ostalo',
  'LBL_MODULE_NAME' => 'Kontrolna tabla',
  'LBL_MODULE_NAME_SINGULAR' => 'Kontrolna tabla',
  'LBL_MODULE_TITLE' => 'Kontrolna tabla: Početna strana',
  'LBL_MONTH_BY_OUTCOME_DESC' => 'Prikazuje kumulativne iznose Prodajne prilike po mesecu po ishodu za izabrane korisnike kod kojih je očekivani datum završetka u okviru navedenog opsega datuma. Ishod je zasnovan na tome da li je stanje prodaje završeno dobitkom, završeno gubitkom ili neka druga vrednost.',
  'LBL_MY_MODULES_USED_SIZE' => 'Broj pristupa',
  'LBL_NUMBER_OF_OPPS' => 'Broj Prodajnih prilika',
  'LBL_OPPS_IN_LEAD_SOURCE' => 'prodajne prilike kod kojih je izvor informacija o potencijalnom klijentu',
  'LBL_OPPS_IN_STAGE' => 'gde je stanje prodaje',
  'LBL_OPPS_OUTCOME' => 'gde je ishod',
  'LBL_OPPS_WORTH' => 'prodajne prilike vrede',
  'LBL_OPP_SIZE' => 'Veličina Prodajne prilike u',
  'LBL_OPP_THOUSANDS' => 'K',
  'LBL_PIPELINE_FORM_TITLE_DESC' => 'Prikazuje kumulativane iznose izabranih stanja prodaje za prodajne prilike kod kojih je očekivani datum završetka u okviru zadatog opsega datuma.',
  'LBL_REFRESH' => 'Osveži',
  'LBL_ROLLOVER_DETAILS' => 'Pređite mišem preko stubca za više detalja.',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'Pređite mišem preko klina za više detalja.',
  'LBL_SALES_STAGES' => 'Faze prodaje:',
  'LBL_SALES_STAGE_FORM_DESC' => 'Prikazuje kumulativne iznose prodajnih prilika po izabranoj fazi prodaje za izabranog korisnika kod kojih je očekivani datum završetka u okviru navedenog opsega datuma.',
  'LBL_SALES_STAGE_FORM_TITLE' => 'Prodajni levak po fazama prodaje',
  'LBL_TITLE' => 'Naslov:',
  'LBL_TOTAL_PIPELINE' => 'Prodajni levak ukupno je',
  'LBL_USERS' => 'Korisnici:',
  'LBL_YEAR' => 'Godina:',
  'LBL_YEAR_BY_OUTCOME' => 'Prodajni levak po mesecu po prihodu',
  'LNK_NEW_ACCOUNT' => 'Kreiraj kompaniju',
  'LNK_NEW_CALL' => 'Evidentiraj poziv',
  'LNK_NEW_CASE' => 'Kreiraj slučaj',
  'LNK_NEW_CONTACT' => 'Kreiraj kontakt',
  'LNK_NEW_ISSUE' => 'Prijavi defekt',
  'LNK_NEW_LEAD' => 'Kreiraj potencijalnog klijenta',
  'LNK_NEW_MEETING' => 'Zakaži sastanak',
  'LNK_NEW_NOTE' => 'Kreiraj belešku ili prilog',
  'LNK_NEW_OPPORTUNITY' => 'Kreiraj Prodajnu priliku',
  'LNK_NEW_QUOTE' => 'Kreiraj ponudu',
  'LNK_NEW_TASK' => 'Kreiraj zadatak',
  'NTC_NO_LEGENDS' => 'Nijedna',
);

