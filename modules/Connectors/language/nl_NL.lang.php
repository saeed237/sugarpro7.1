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
  'ERROR_EMPTY_RECORD_ID' => 'Error: Record Id not specified or empty.',
  'ERROR_EMPTY_SOURCE_ID' => 'Error: Source Id not specified or empty.',
  'ERROR_EMPTY_WRAPPER' => 'Error: Unable to retrieve wrapper instance for the source [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Error: No additional details were found for the record.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Error: There are no connectors mapped to this module.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Error: There are no module fields that have been mapped for display in the results.  Please contact the system administrator.',
  'ERROR_NO_FIELDS_MAPPED' => 'Error: You must map at least one Connector field to a module field for each module entry.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'No modules have been enabled for this connector.  Select a module for this connector in the Enable Connectors page.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Error: There are no connectors enabled that have search fields defined.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Error: There are no search fields defined for the module and connector.  Please contact the system administrator.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Error: No sourcedefs.php file could be found.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Error: No sources were specified from which to retrieve data.',
  'ERROR_RECORD_NOT_SELECTED' => 'Fout: Selecteer een record in de lijst.',
  'LBL_ADDRCITY' => 'Plaats',
  'LBL_ADDRCOUNTRY' => 'Land',
  'LBL_ADDRCOUNTRY_ID' => 'Land ID',
  'LBL_ADDRSTATEPROV' => 'Provincie',
  'LBL_ADD_MODULE' => 'Toevoegen',
  'LBL_ADMINISTRATION' => 'Connector beheer',
  'LBL_ADMINISTRATION_MAIN' => 'Connector instellingen',
  'LBL_AVAILABLE' => 'Beschikbaar',
  'LBL_BACK' => '< Terug',
  'LBL_CLOSE' => 'Sluiten',
  'LBL_COMPANY_ID' => 'Organisatie ID',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Enkele verplichte velden zijn nog leeg. Wijzigingen toch opslaan?',
  'LBL_CONNECTOR' => 'Connector',
  'LBL_CONNECTOR_FIELDS' => 'Connector velden',
  'LBL_DATA' => 'Data',
  'LBL_DEFAULT' => 'Standaard',
  'LBL_DELETE_MAPPING_ENTRY' => 'Weet u zeker dat u deze input wilt verwijderen?',
  'LBL_DISABLED' => 'Uitgeschakeld',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Geen resultaten gevonden met de huidige zoekcriteria',
  'LBL_ENABLED' => 'Ingeschakeld',
  'LBL_EXTERNAL' => 'Stel gebruikers in staat externe accounts aan te maken in deze connector. De eigenschappen moeten ook worden ingesteld in de "Connector eigenschappen instellen" pagina.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Om deze connector te gebruiken dienen ook de eigenschappen worden ingesteld in de "Connector eigenschappen instellen" pagina.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Market Cap',
  'LBL_MERGE' => 'Samenvoegen',
  'LBL_MODIFY_DISPLAY_DESC' => 'Bepaal welke modules ingeschakeld zijn per connector.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Connector instellingen: Inschakelen connectoren',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Connectoren inschakelen',
  'LBL_MODIFY_MAPPING_DESC' => 'In kaart brengen welke connect velden gekoppeld zijn aan welke module velden om te bepalen welke connector data kan worden bekeken en samengevoegd in de module records.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Connector instellingen: Connector velden in kaart brengen',
  'LBL_MODIFY_MAPPING_TITLE' => 'In kaart brengen van connector velden',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Configureer de eigenschappen per connector, inclusief URL&#39;s en API keys.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Connector instellingen: Connector eigenschappen instellen',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Connector eigenschappen instellen',
  'LBL_MODIFY_SEARCH' => 'Zoeken',
  'LBL_MODIFY_SEARCH_DESC' => 'Selecteer welke connector velden gebruikt worden bij zoekopdrachten per module.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Connector instellingen: Beheer connector zoekfunctie',
  'LBL_MODIFY_SEARCH_TITLE' => 'Beheer Connector zoekfunctie',
  'LBL_MODULE_FIELDS' => 'Module velden',
  'LBL_MODULE_NAME' => 'Connectoren',
  'LBL_MODULE_NAME_SINGULAR' => 'Connector',
  'LBL_NO_PROPERTIES' => 'Er zijn geen configureerbare eigenschappen bij deze connector.',
  'LBL_PARENT_DUNS' => 'Parent DUNS',
  'LBL_PREVIOUS' => '< Terug',
  'LBL_QUOTE' => 'Offerte',
  'LBL_RECNAME' => 'Organisatienaam',
  'LBL_RESET_BUTTON_TITLE' => 'Reset [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Terug naar standaardwaarde',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Weet u zeker dat u terug wilt gaan naar de standaard configuratie?',
  'LBL_RESULT_LIST' => 'Data lijst',
  'LBL_RUN_WIZARD' => 'Start wizard',
  'LBL_SAVE' => 'Opslaan',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Zoeken...',
  'LBL_SHOW_IN_LISTVIEW' => 'Toon samenvoegen lijstweergave',
  'LBL_SMART_COPY' => 'Smart copy',
  'LBL_STEP1' => 'Doorzoek en bekijk data',
  'LBL_STEP2' => 'Voeg records samen met',
  'LBL_SUMMARY' => 'Samenvatting',
  'LBL_TEST_SOURCE' => 'Test Connector',
  'LBL_TEST_SOURCE_FAILED' => 'Test mislukt',
  'LBL_TEST_SOURCE_RUNNING' => 'Test uitvoeren...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test was succesvol',
  'LBL_TITLE' => 'Data samenvoegen',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Ultimate Parent DUNS',
);

