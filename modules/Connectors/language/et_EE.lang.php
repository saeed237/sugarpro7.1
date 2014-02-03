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
  'LBL_EXTERNAL' => 'Enable users to create external account records to this connector. In order to use this connector, the properties should also be set in the Set Connector Properties settings page.',
  'LBL_MARKET_CAP' => 'Market Cap',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Ultimate Parent DUNS',
  'ERROR_EMPTY_WRAPPER' => 'Error: Unable to retrieve wrapper instance for the source [{$source_id}]',
  'LBL_CONNECTOR' => 'Connector',
  'LBL_DUNS' => 'DUNS',
  'LBL_PARENT_DUNS' => 'Parent DUNS',
  'LBL_SMART_COPY' => 'Smart Copy',
  'LBL_TEST_SOURCE' => 'Test Connector',
  'LBL_ADD_MODULE' => 'Lisa',
  'LBL_ADDRCITY' => 'Linn',
  'LBL_ADDRCOUNTRY' => 'Riik',
  'LBL_ADDRCOUNTRY_ID' => 'Riigi Id',
  'LBL_ADDRSTATEPROV' => 'Maakond',
  'LBL_ADMINISTRATION' => 'Connectori administratsioon',
  'LBL_ADMINISTRATION_MAIN' => 'Connector sätted',
  'LBL_AVAILABLE' => 'Saadaval',
  'LBL_BACK' => '< Tagasi',
  'LBL_COMPANY_ID' => 'Ettevõtte Id',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Mõned nõutud väljad on jäetud tühjaks. Jätkata muudatuste salvestamist?',
  'LBL_CONNECTOR_FIELDS' => 'Connector väljadq',
  'LBL_DATA' => 'Andmed',
  'LBL_DEFAULT' => 'Vaikimisi',
  'LBL_DELETE_MAPPING_ENTRY' => 'Oled kindel, et soovid seda sissekannet kustutada?',
  'LBL_DISABLED' => 'Mittelubatud',
  'LBL_EMPTY_BEANS' => 'Sinu otsingukriteeriumile vastavaid vasteid ei leitud.',
  'LBL_ENABLED' => 'Lubatud',
  'LBL_FINSALES' => 'Aasta müük',
  'LBL_MERGE' => 'Mesti',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Luba Connectorid',
  'LBL_MODIFY_DISPLAY_DESC' => 'Vali, millised mooduli on lubatud iga korrektori jaoks.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Connectori sätted: Luba connectorid',
  'LBL_MODULE_FIELDS' => 'Mooduliväljad',
  'LBL_MODIFY_MAPPING_TITLE' => 'Kaardista Connectori väljad',
  'LBL_MODIFY_MAPPING_DESC' => 'Kaardista connectori väljad mooduli väljadeks, kui soovid kindlaks määrata, millist connectori infot saab vaadata ja mestida mooduli kirjetega.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Connectori sätted: Kaardista Connectori väljad',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Määra Connectori omadused',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Konfigureeri iga connectori omadused, kaasaarvatud URL-id ja API key-d.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Connector sätted: Määra connectori omadused',
  'LBL_MODIFY_SEARCH_TITLE' => 'Halda Connectori otsingut',
  'LBL_MODIFY_SEARCH' => 'Otsi',
  'LBL_MODIFY_SEARCH_DESC' => 'Vali connectorväli, mida kasutada iga mooduli andmete otsimiseks.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Connector sätted: Halda Connector otsingut',
  'LBL_MODULE_NAME' => 'Connectorid',
  'LBL_NO_PROPERTIES' => 'Selle connectori jaoks pole konfigureeritavaid omadusi.',
  'LBL_PREVIOUS' => '< Tagasi',
  'LBL_QUOTE' => 'Pakkumine',
  'LBL_RECNAME' => 'Ettevõtte nimi',
  'LBL_RESET_TO_DEFAULT' => 'Lahtesta vaikeseadesse',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Kas oled kindel, et soovid lähtestada vaike konfiguratsiooni?',
  'LBL_RESET_BUTTON_TITLE' => 'Lähtesta [Alt+R]',
  'LBL_RESULT_LIST' => 'Andmeloend',
  'LBL_RUN_WIZARD' => 'Käivita viisard',
  'LBL_SAVE' => 'Salvesta',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Otsimine...',
  'LBL_SHOW_IN_LISTVIEW' => 'Näita mestitud loendivaades',
  'LBL_SUMMARY' => 'Kokkuvõte',
  'LBL_STEP1' => 'Otsi ja vaata andmeid',
  'LBL_STEP2' => 'Mesti kirjed',
  'LBL_TEST_SOURCE_FAILED' => 'Test ebaõnnestus',
  'LBL_TEST_SOURCE_RUNNING' => 'Testi näitamine...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test oli edukas',
  'LBL_TITLE' => 'Andme mestimine',
  'ERROR_RECORD_NOT_SELECTED' => 'Viga: Palun vali kirje loendist enne toimingut.',
  'ERROR_EMPTY_SOURCE_ID' => 'Viga: Allika Id ei ole määratletud või on tühi.',
  'ERROR_EMPTY_RECORD_ID' => 'Viga: Kirje id on määratlemata või tühi.',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Viga: Lisainfot kirje jaoks ei leitud.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Selle connectori jaoks pole mooduleid lubatud. Vali selle connectori jaoks moodul lehel Luba Connectorid.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Viga: Puuduvad lubatud connectorid, millel on ettenähtud otsinguväljad.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Viga: sourcedefs.php faili ei leidu.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Viga: Allikaid, kust leida infot ei täpsustatud.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Viga: Selle mooduli jaoks ei ole connectoreid kaardistatud.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Viga: Mooduli ja connectori jaoks pole otsinguvälju määratletud. Palun kontakteeru süsteemiadministraatoriga.',
  'ERROR_NO_FIELDS_MAPPED' => 'Viga: On vaja kaardistada vähemalt üks Connectorväli iga mooduli sissekande jaoks.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Viga: Tulemuste kuvamise jaoks pole kaardistatud mooduli välju. Palun kontakteeru süsteemiadministraatoriga.',
);

