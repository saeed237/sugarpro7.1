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
  'ERROR_EMPTY_RECORD_ID' => 'Gabim: Id e burimit nuk është e përcaktuar është e zbrazët',
  'ERROR_EMPTY_SOURCE_ID' => 'Gabim: Id e burimit nuk është e përcaktuar është e zbrazët',
  'ERROR_EMPTY_WRAPPER' => 'Gabim: e pamundur të rifituar mbëshjtellëse për burimin [{$burimi_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Gabim: asnjë detaj plotësues nuk u gjet për regjistrimin.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Gabim: nuk ka konektues të gjetur në këtë modulë.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Gabim: nuk ka fusha të modulit të gjetura për të shfaqur rezultate. Ju lutemi kontaktoni administratorin e sistemit.',
  'ERROR_NO_FIELDS_MAPPED' => 'Gabim: duhet të gjeni së paku një fushë konektuese në fushën e modulit për çdo hyrje të modulit.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Nuk ka module që janë aktivizuar për këtë lidhje. Selekto një modul për këtë lidhje në faqen e lidhësit të mundësuar.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Gabim:Nuk ka lidhje të mundësuar që kanë fushat e përcaktuara të kërkimit.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Gabim: nuk ka fusha kërkimi të definuara për modulin dhe konektuesin. Ju lutemi kontaktoni administratorin e sistemit.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Gabim: asnjësourcedefs.php dosje nuk u gjet.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Gabim: asjnë burim nuk u përcaktua prej të cilit do të rifitoheshin të dhënat.',
  'ERROR_RECORD_NOT_SELECTED' => 'Gabim: ju lutemi selektoni një regjistrim nga lista para se të filloni',
  'LBL_ADDRCITY' => 'Qyteti',
  'LBL_ADDRCOUNTRY' => 'Shteti',
  'LBL_ADDRCOUNTRY_ID' => 'ID shtetërore',
  'LBL_ADDRSTATEPROV' => 'Shteti',
  'LBL_ADD_MODULE' => 'Shto',
  'LBL_ADMINISTRATION' => 'Administrata e konektuesit',
  'LBL_ADMINISTRATION_MAIN' => 'parametrat e konektuesit',
  'LBL_AVAILABLE' => 'E disponueshme',
  'LBL_BACK' => 'Kthe',
  'LBL_CLOSE' => 'Mbyll',
  'LBL_COMPANY_ID' => 'ID e kompanisë',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Disa fusha të nevojshme janë të lëra bosh. Vazhdoni të ruani ndryshimet?',
  'LBL_CONNECTOR' => 'Konektuesi',
  'LBL_CONNECTOR_FIELDS' => 'Fushat konektuese',
  'LBL_DATA' => 'Të dhëna',
  'LBL_DEFAULT' => 'I papërcaktuar',
  'LBL_DELETE_MAPPING_ENTRY' => 'A jeni të sigurt që dëshironi të fshini këtë hyrje?',
  'LBL_DISABLED' => 'E pamundur',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Asjnë përshtatje nuk u gjet për kriterien tuaj të kërkimit.',
  'LBL_ENABLED' => 'E mundur',
  'LBL_EXTERNAL' => 'Mudëson përdoruesit për të krijuar regjistrim të lloagrive të jashtme të këtij konektimi.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Për të përdorur këtë konektues, karakteristikat duhet të përcaktohen në faqen e Përcakto karakteristikat e konektuesit.',
  'LBL_FINSALES' => 'Shitjet finale',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Kapaku i tregut',
  'LBL_MERGE' => 'Bashko',
  'LBL_MODIFY_DISPLAY_DESC' => 'Selekto cilat modula janë të mundësuar për çdo konektues',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Parametrate e konektuesit: mundëso konektuesit',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Mundëso konektuesit',
  'LBL_MODIFY_MAPPING_DESC' => 'Harto fushat e konektuesve në fusha module për të përcaktuar cilat të dhëna të konektuesve mund të shihen dhe bashko me regjistrimet e modulit.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Parametrat e konektuesit: harto fushat e konektimit',
  'LBL_MODIFY_MAPPING_TITLE' => 'Harto fushat e konektuesve',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Konfiguro vetitë për çdo konektim, përfshirë URL dhe çelësin API',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Parametrat e konektimit: Përcakto vetitë e konektimit',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Përcakto vetitë e konektimit',
  'LBL_MODIFY_SEARCH' => 'Kërkim',
  'LBL_MODIFY_SEARCH_DESC' => 'Selekto fushat e konektimit për të përdorur për kërkim për çdo modulë.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Parametrat e konektimit: menaxho kërkimin e konektuesve',
  'LBL_MODIFY_SEARCH_TITLE' => 'menaxho kërkimin e konektuesve',
  'LBL_MODULE_FIELDS' => 'Fushat e modulave',
  'LBL_MODULE_NAME' => 'Lidhjet',
  'LBL_MODULE_NAME_SINGULAR' => 'Konektues',
  'LBL_NO_PROPERTIES' => 'Nuk ekzistojnë karakteristika të konfiguruara për këtë lidhje.',
  'LBL_PARENT_DUNS' => 'DUNS mëmë',
  'LBL_PREVIOUS' => 'Kthe',
  'LBL_QUOTE' => 'Kuota',
  'LBL_RECNAME' => 'Emri i kompanisë',
  'LBL_RESET_BUTTON_TITLE' => 'Rivendos[Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Rivendos në të papërcaktuar',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'A jeni të sigurt që dëshironi të rivendosni këtë në konfigurim i papërcaktuar?',
  'LBL_RESULT_LIST' => 'Lista e të dhënave',
  'LBL_RUN_WIZARD' => 'Drejto Wizardin',
  'LBL_SAVE' => 'Ruaj',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Kërkim...',
  'LBL_SHOW_IN_LISTVIEW' => 'Trego në bashkimin e pamjes së listës',
  'LBL_SMART_COPY' => 'Kopje e mençur',
  'LBL_STEP1' => 'Kërko dhe shih të dhëna',
  'LBL_STEP2' => 'Bashko regjistrimet me',
  'LBL_SUMMARY' => 'Përmbledhje',
  'LBL_TEST_SOURCE' => 'Testo konektuesin',
  'LBL_TEST_SOURCE_FAILED' => 'Testi dështoi',
  'LBL_TEST_SOURCE_RUNNING' => 'Duke performuar testin',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test i sukseshëm',
  'LBL_TITLE' => 'Bashkim i të dhënave',
  'LBL_ULTIMATE_PARENT_DUNS' => 'DUNS mëmë i fundit',
);

