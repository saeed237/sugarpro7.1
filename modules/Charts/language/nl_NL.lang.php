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
  'ERR_NO_OPPS' => 'Er zijn geen Opportunities.',
  'LBL_ALL_OPPORTUNITIES' => 'Het totaal van alle Opportunities is',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'Toon campagnereacties op basis van ROI',
  'LBL_CHART_ACTION' => 'Actie',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'DCE Actions per Types (Huidige maand)',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Lead bron per Uitkomst',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => 'Modules gebruikt door degenen die aan mij rapporteren (laatste 30 dagen)',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Modules door mij gebruikt (Laatste 30 dagen)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'Mijn pijplijn per verkoopstadium',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => 'Opportunities dit kwartaal',
  'LBL_CHART_OUTCOME_BY_MONTH' => 'Uitkomst per maand',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Pijplijn per Lead bron',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Pijplijn per verkoopstadium',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'Pijplijn per verkoopstadium tunnel',
  'LBL_CHART_TYPE' => 'Grafiektype:',
  'LBL_CLOSE_DATE_END' => 'Verwachte afsluitdatum - Tot:',
  'LBL_CLOSE_DATE_START' => 'Verwachte afsluitdatum - Vanaf:',
  'LBL_CREATED_ON' => 'Laatste berekening op',
  'LBL_DATE_END' => 'Einddatum:',
  'LBL_DATE_RANGE' => 'Datum bereik is',
  'LBL_DATE_RANGE_TO' => 'tot',
  'LBL_DATE_START' => 'Begindatum:',
  'LBL_EDIT' => 'Wijzigen',
  'LBL_LEAD_SOURCES' => 'Leadbronnen:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Resultaten van alle Opportunities per Herkomst Lead',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Cumulatieve Opportunitybedragen voor geselecteerde gebruikers. De resultaten worden bepaald aan de hand van gewogen waarden per verkoopfase (gewonnen/verloren/anders).',
  'LBL_LEAD_SOURCE_FORM_DESC' => 'Cumulatieve Opportunityresultaten voor geselecteerde gebruikers.',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'Alle Opportunities per Herkomst Lead',
  'LBL_LEAD_SOURCE_OTHER' => 'Anders',
  'LBL_MODULE_NAME' => 'Dashboard',
  'LBL_MODULE_NAME_SINGULAR' => 'Dashboard',
  'LBL_MODULE_TITLE' => 'Dashboard: Start',
  'LBL_MONTH_BY_OUTCOME_DESC' => 'Toon cumulatieve opportunities per maand voor geselecteerde gebruikers waar de verwachte einddatum binnen het aangegeven tijdsvak ligt. De resultaten worden bepaald aan de hand van gewogen waarden per verkoopfase (gewonnen/verloren/anders).',
  'LBL_MY_MODULES_USED_SIZE' => 'Toegangsteller',
  'LBL_NUMBER_OF_OPPS' => 'Aantal opportunities',
  'LBL_OPPS_IN_LEAD_SOURCE' => 'Opportunities met Leadherkomst gelijk aan',
  'LBL_OPPS_IN_STAGE' => 'met Verkoopfase gelijk aan',
  'LBL_OPPS_OUTCOME' => 'met Resultaat gelijk aan',
  'LBL_OPPS_WORTH' => 'de waarde van alle Opportunities',
  'LBL_OPP_SIZE' => 'Opportunity grootte in',
  'LBL_OPP_THOUSANDS' => 'x 1000',
  'LBL_PIPELINE_FORM_TITLE_DESC' => 'Cumulatieve Opportunity bedragen per verkoopfase waar de verwachte einddatum binnen het aangegeven tijdsvak ligt.',
  'LBL_REFRESH' => 'Refresh',
  'LBL_ROLLOVER_DETAILS' => 'Mouse-over een grafiek voor details',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'Mouse-over een taartpunt voor details',
  'LBL_SALES_STAGES' => 'Verkoopfase:',
  'LBL_SALES_STAGE_FORM_DESC' => 'Cumulatieve Opportunitybedragen per Verkoopfase voor geselecteerde gebruikers waar de verwachte einddatum binnen de aangegeven tijdsvak ligt.',
  'LBL_SALES_STAGE_FORM_TITLE' => 'Pipeline per verkoopfase',
  'LBL_TITLE' => 'Titel:',
  'LBL_TOTAL_PIPELINE' => 'Totaal Pipeline',
  'LBL_USERS' => 'Gebruikers:',
  'LBL_YEAR' => 'Jaar:',
  'LBL_YEAR_BY_OUTCOME' => 'Jaar per Resultaat',
  'LNK_NEW_ACCOUNT' => 'Nieuwe Organisatie',
  'LNK_NEW_CALL' => 'Nieuw Telefoongesprek',
  'LNK_NEW_CASE' => 'Nieuwe Case',
  'LNK_NEW_CONTACT' => 'Nieuw Persoon',
  'LNK_NEW_ISSUE' => 'Nieuw Defect',
  'LNK_NEW_LEAD' => 'Nieuwe Lead',
  'LNK_NEW_MEETING' => 'Nieuwe Afspraak',
  'LNK_NEW_NOTE' => 'Nieuwe Notitie of Bijlage',
  'LNK_NEW_OPPORTUNITY' => 'Nieuwe Opportunity',
  'LNK_NEW_QUOTE' => 'Nieuwe Offerte',
  'LNK_NEW_TASK' => 'Nieuwe Taak',
  'NTC_NO_LEGENDS' => 'geen',
);

