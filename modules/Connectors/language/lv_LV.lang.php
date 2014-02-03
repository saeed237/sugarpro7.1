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
  'ERROR_EMPTY_RECORD_ID' => 'Kļūda: Ieraksta ID nav norādīts vai ir tukšs.',
  'ERROR_EMPTY_SOURCE_ID' => 'Kļūda: Avota ID nav norādīts vai ir tukšs.',
  'ERROR_EMPTY_WRAPPER' => 'Kļūda: Nevar iegūt konteiner instances avotu [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Kļūda: Šim ierakstam nav papildus datu',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Kļūda: Nav konektoru, kas būtu saistīti ar šo moduli.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Kļūda: Nav norādīts neviens moduļa lauks, ko rādīt rezultātos. Sazinieties ar sistēmas administratoru.',
  'ERROR_NO_FIELDS_MAPPED' => 'Kļūda: Vismaz vienam konektora laukam ir jābūt attiecinātam uz moduļa lauku katrā moduļa ierakstā.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Konektoram nav aktivēts nevien modulis. Norādiet šim konektoram moduli konektoru aktivēšanas lapā.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Kļūda: Nav neviena konektora, kuram būtu nodefinēti meklēšanas lauki.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Kļūda: Modulim un konektoram nav nodefinēti meklēšanas lauki. Sazinieties ar sistēmas administratoru.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Kļūda: Nevar atrast failu sourcedefs.php.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Kļūda: Nav norādīti avoti datu ieguvei.',
  'ERROR_RECORD_NOT_SELECTED' => 'Kļūda: Pirms turpiniet, atzīmējiet ierakstu sarakstā.',
  'LBL_ADDRCITY' => 'Pilsēta',
  'LBL_ADDRCOUNTRY' => 'Valsts',
  'LBL_ADDRCOUNTRY_ID' => 'Valsts ID',
  'LBL_ADDRSTATEPROV' => 'Novads',
  'LBL_ADD_MODULE' => 'Pievienot',
  'LBL_ADMINISTRATION' => 'Konektoru administrēšana',
  'LBL_ADMINISTRATION_MAIN' => 'Konektoru uzstādījumi',
  'LBL_AVAILABLE' => 'Pieejams',
  'LBL_BACK' => '< Atpakaļ',
  'LBL_CLOSE' => 'Aizvērt',
  'LBL_COMPANY_ID' => 'Uzņēmuma ID',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Daži obligātie lauki nav aizpildīti. Vai turpināt saglabāšanu?',
  'LBL_CONNECTOR' => 'Konektors',
  'LBL_CONNECTOR_FIELDS' => 'Konektora lauki',
  'LBL_DATA' => 'Dati',
  'LBL_DEFAULT' => 'Noklusētā',
  'LBL_DELETE_MAPPING_ENTRY' => 'Vai tiešām vēlaties dzēst šo entīti?',
  'LBL_DISABLED' => 'Izslēgts',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Nekas netika atrast pēc jūsu norādītajiem meklēšanas parametriem.',
  'LBL_ENABLED' => 'Aktivizēts',
  'LBL_EXTERNAL' => 'Atļaut lietotājiem veidot ārējā konta ierakstus šim konektoram',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Lai lietotu šo konektoru, ir jābūt uzstādītiem parametriem konektoru parametru uzstādījumu lapā.',
  'LBL_FINSALES' => 'Gada apgrozījums',
  'LBL_INFO_INLINE' => 'Informācija',
  'LBL_MARKET_CAP' => 'Tirgus vērtība',
  'LBL_MERGE' => 'Sapludināt',
  'LBL_MODIFY_DISPLAY_DESC' => 'Norādīt, kuri moduļi ir pieejami katram konektoram.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Konektoru uzstādījumi: Aktivēt koneektorus',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Aktivēt konektorus',
  'LBL_MODIFY_MAPPING_DESC' => 'Kartēt konektoru laukus pret moduļu laukiem, lai noteiktu, kuri konektoru dati var tikt parādīti un ievietoti  moduļu ierakstos.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Konektoru uzstādījumi: Lauku kartēšana',
  'LBL_MODIFY_MAPPING_TITLE' => 'Kartēt konektora laukus',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Konektoru parametru konfigurēšana, ieskaitot URL un API atslēgas.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Konektoru uzstādījumi: Konektora parametri',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Konektoru parametri',
  'LBL_MODIFY_SEARCH' => 'Meklēt',
  'LBL_MODIFY_SEARCH_DESC' => 'Atzīmējiet konektora laukus, kurus lietot, meklējot datus katrā modulī.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Konektora uzstādījumi: Konektoru meklēšanas pārvaldība',
  'LBL_MODIFY_SEARCH_TITLE' => 'Konektoru meklēšanas pārvaldība',
  'LBL_MODULE_FIELDS' => 'Moduļu lauki',
  'LBL_MODULE_NAME' => 'Konektori',
  'LBL_MODULE_NAME_SINGULAR' => 'Konektors',
  'LBL_NO_PROPERTIES' => 'Konektoram nav konfigurējamu parametru.',
  'LBL_PARENT_DUNS' => 'Priekšteča DUNS',
  'LBL_PREVIOUS' => '< Atpakaļ',
  'LBL_QUOTE' => 'Piedāvājums',
  'LBL_RECNAME' => 'Uzņēmuma nosaukums',
  'LBL_RESET_BUTTON_TITLE' => 'Atjaunot[Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Atjaunot noklusējumu',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Vai tiešām vēlaties atjaunot noklusējuma konfigurāciju?',
  'LBL_RESULT_LIST' => 'Datu saraksts',
  'LBL_RUN_WIZARD' => 'Darbināt vedni',
  'LBL_SAVE' => 'Saglabāt',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Meklē ...',
  'LBL_SHOW_IN_LISTVIEW' => 'Rādīt sapludināšanas sarakstā',
  'LBL_SMART_COPY' => 'Gudrā kopēšana',
  'LBL_STEP1' => 'Meklēt un aplūkot datus',
  'LBL_STEP2' => 'Sapludināt ierakstus ar',
  'LBL_SUMMARY' => 'Kopsavilkums',
  'LBL_TEST_SOURCE' => 'Konektora tests',
  'LBL_TEST_SOURCE_FAILED' => 'Tests neizdevās',
  'LBL_TEST_SOURCE_RUNNING' => 'Izpilda testu...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Tests veiksmīgs',
  'LBL_TITLE' => 'Datu sapludināšana',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Galējais Priekšteča DUNS',
);

