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
  'ERROR_EMPTY_RECORD_ID' => 'Feil: Postens Id er ikke spesifisert eller tom.',
  'ERROR_EMPTY_SOURCE_ID' => 'Feil: Kilde Id er ikke spesifisert eller tom.',
  'ERROR_EMPTY_WRAPPER' => 'Feil: Kan ikke hente wrapper-eksempel for kilden [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Feil: Ingen flere detaljer ble funnet for posten.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Feil: Det er ingen Connectors knyttet til denne modulen.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Feil: Det finnes ingen modul felt som er knyttet til resultatvisning. Vennligst kontakt systemadministrator.',
  'ERROR_NO_FIELDS_MAPPED' => 'Feil: Du må knytte minst et Connector felt til et modul felt for hver enkelt modul.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Ingen moduler er aktivert for denne Connector. Velg en modul for denne Connector på Aktiver Connectors siden.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Feil: Det er ingen aktiverte Connectors som har definert søkefelt.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Feil: Det er ingen søkefelt i modulen og Connector. Vennligst kontakt systemadministrator.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Feil: Ingen sourcedefs.php ble funnet.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Feil: Ingen kilder ble spesifisert for å hente data.',
  'ERROR_RECORD_NOT_SELECTED' => 'Feil: Vennligst velg en post fra listen før du fortsetter.',
  'LBL_ADDRCITY' => 'Poststed',
  'LBL_ADDRCOUNTRY' => 'Land',
  'LBL_ADDRCOUNTRY_ID' => 'Land ID',
  'LBL_ADDRSTATEPROV' => 'Fylke',
  'LBL_ADD_MODULE' => 'Legg til',
  'LBL_ADMINISTRATION' => 'Connector Administrasjon',
  'LBL_ADMINISTRATION_MAIN' => 'Connector innstillinger',
  'LBL_AVAILABLE' => 'Tilgjengelig',
  'LBL_BACK' => '<Tilbake',
  'LBL_CLOSE' => 'Lukk',
  'LBL_COMPANY_ID' => 'Selskap ID',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Noen obligatoriske felt er tomme. Fortsett å lagre endringene?',
  'LBL_CONNECTOR' => 'Connector',
  'LBL_CONNECTOR_FIELDS' => 'Connector felt',
  'LBL_DATA' => 'Data',
  'LBL_DEFAULT' => 'Standard',
  'LBL_DELETE_MAPPING_ENTRY' => 'Er du sikker på at du vil slette denne oppføringen?',
  'LBL_DISABLED' => 'Deaktivert',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Det ble ikke funnet noen poster som oppfyller dine søkekriterier.',
  'LBL_ENABLED' => 'Aktivert',
  'LBL_EXTERNAL' => 'Gi brukerne mulighet til å opprette eksterne Bedrift poster til denne "connector". For å bruke denne "connector", bør egenskapene også settes i Set Connector Properties-siden.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'For å bruke denne koblingen, bør egenskapene også angis på siden for innstillinger av "Set Connector Properties".',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Market Cap',
  'LBL_MERGE' => 'Slå sammen',
  'LBL_MODIFY_DISPLAY_DESC' => 'Velg hvilke moduler som er aktivert for hver Connector',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Connector Innstillinger: Aktiver Connectors',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Aktiver Connectors',
  'LBL_MODIFY_MAPPING_DESC' => 'Knytt Connector felt til modul felt for å kunne fastslå hvilke Connector data som kan vises og slåes sammen med poster inn i modulen.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Connector innstillinger: Knytt Connector felt',
  'LBL_MODIFY_MAPPING_TITLE' => 'Knytt Connector felt',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Konfigurer egenskapene for hver Connector, inkludert nettadresser og API-nøkler.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Connector innstillinger: Sett Connector egenskaper',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Angi Connector egenskaper',
  'LBL_MODIFY_SEARCH' => 'Søk',
  'LBL_MODIFY_SEARCH_DESC' => 'Velg Connector feltene som skal brukes til å søke etter data for hver modul.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Connector innstillinger: Administrere Connector søk',
  'LBL_MODIFY_SEARCH_TITLE' => 'Behandle Connector søk',
  'LBL_MODULE_FIELDS' => 'Modul felt',
  'LBL_MODULE_NAME' => 'Connectors',
  'LBL_NO_PROPERTIES' => 'Det er ingen konfigurerbare egenskaper for denne Connector.',
  'LBL_PARENT_DUNS' => 'Parent DUNS',
  'LBL_PREVIOUS' => '<Tilbake',
  'LBL_QUOTE' => 'Tilbud',
  'LBL_RECNAME' => 'Firmanavn:',
  'LBL_RESET_BUTTON_TITLE' => 'Reset [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Tilbakestill til standard',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Er du sikker på at du vil tilbakestille til standard konfigurasjon?',
  'LBL_RESULT_LIST' => 'Data liste',
  'LBL_RUN_WIZARD' => 'Kjør veiviseren',
  'LBL_SAVE' => 'Lagre',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Søker...',
  'LBL_SHOW_IN_LISTVIEW' => 'Vis i flettet Listview',
  'LBL_SMART_COPY' => 'Smart kopi',
  'LBL_STEP1' => 'Søk og vis data',
  'LBL_STEP2' => 'Flett poster med',
  'LBL_SUMMARY' => 'Oppsummering',
  'LBL_TEST_SOURCE' => 'Test Connector',
  'LBL_TEST_SOURCE_FAILED' => 'Test mislyktes',
  'LBL_TEST_SOURCE_RUNNING' => 'Utfører test...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test vellykket',
  'LBL_TITLE' => 'Datafletting',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Ultimate Parent DUNS',
);

