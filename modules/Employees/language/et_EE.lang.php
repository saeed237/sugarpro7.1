<?php

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





if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


	
$mod_strings = array (
  'LBL_LIST_ADMIN' => 'Admin',
  'LBL_NEW_EMPLOYEE_BUTTON_KEY' => 'N',
  'LBL_FAX' => 'Fax:',
  'LBL_CREATE_USER_BUTTON_KEY' => 'N',
  'LBL_PORTAL_ONLY' => 'Portal Only User',
  'LBL_MODULE_NAME' => 'Töötajad',
  'LBL_MODULE_TITLE' => 'Töötajad: Avaleht',
  'LBL_SEARCH_FORM_TITLE' => 'Töötaja otsing',
  'LBL_LIST_FORM_TITLE' => 'Töötajad',
  'LBL_NEW_FORM_TITLE' => 'Uus töötaja',
  'LBL_EMPLOYEE' => 'Töötajad:',
  'LBL_LOGIN' => 'Logi sisse',
  'LBL_RESET_PREFERENCES' => 'Taasta esmased eelistused',
  'LBL_TIME_FORMAT' => 'Ajaformaat:',
  'LBL_DATE_FORMAT' => 'Kuupäeva formaat:',
  'LBL_TIMEZONE' => 'Praegune aeg:',
  'LBL_CURRENCY' => 'Valuuta:',
  'LBL_LIST_NAME' => 'Nimi',
  'LBL_LIST_LAST_NAME' => 'Perekonnanimi',
  'LBL_LIST_EMPLOYEE_NAME' => 'Töötaja nimi',
  'LBL_LIST_DEPARTMENT' => 'Osakond',
  'LBL_LIST_REPORTS_TO_NAME' => 'Juhataja',
  'LBL_LIST_EMAIL' => 'E-post',
  'LBL_LIST_PRIMARY_PHONE' => 'Töötelefon',
  'LBL_LIST_USER_NAME' => 'Kasutajanimi',
  'LBL_NEW_EMPLOYEE_BUTTON_TITLE' => 'Uus töötaja [Alt+N]',
  'LBL_NEW_EMPLOYEE_BUTTON_LABEL' => 'Uus töötaja',
  'LBL_ERROR' => 'Viga:',
  'LBL_PASSWORD' => 'Parool:',
  'LBL_EMPLOYEE_NAME' => 'Töötaja nimi:',
  'LBL_USER_NAME' => 'Kasutajanimi:',
  'LBL_FIRST_NAME' => 'Eesnimi:',
  'LBL_LAST_NAME' => 'Perekonnanimi:',
  'LBL_EMPLOYEE_SETTINGS' => 'Töötaja sätted',
  'LBL_THEME' => 'Teema:',
  'LBL_LANGUAGE' => 'Keel:',
  'LBL_ADMIN' => 'Administraator:',
  'LBL_EMPLOYEE_INFORMATION' => 'Töötaja info',
  'LBL_OFFICE_PHONE' => 'Töötelefon:',
  'LBL_REPORTS_TO' => 'Juhataja Id:',
  'LBL_REPORTS_TO_NAME' => 'Juhataja',
  'LBL_OTHER_PHONE' => 'Teine telefon:',
  'LBL_OTHER_EMAIL' => 'Teine E-post:',
  'LBL_NOTES' => 'Märkused:',
  'LBL_DEPARTMENT' => 'Osakond:',
  'LBL_TITLE' => 'Tiitel:',
  'LBL_ANY_ADDRESS' => 'Muu aadress:',
  'LBL_ANY_PHONE' => 'Muu telefon:',
  'LBL_ANY_EMAIL' => 'Muu E-post:',
  'LBL_ADDRESS' => 'Aadress:',
  'LBL_CITY' => 'Linn:',
  'LBL_STATE' => 'Maakond:',
  'LBL_POSTAL_CODE' => 'Postiindeks:',
  'LBL_COUNTRY' => 'Riik:',
  'LBL_NAME' => 'Nimi:',
  'LBL_MOBILE_PHONE' => 'Mobiil:',
  'LBL_OTHER' => 'Muu:',
  'LBL_EMAIL' => 'E-post:',
  'LBL_HOME_PHONE' => 'Telefon kodus:',
  'LBL_WORK_PHONE' => 'Telefon tööl:',
  'LBL_ADDRESS_INFORMATION' => 'Aadressi info:',
  'LBL_EMPLOYEE_STATUS' => 'Töötaja olek:',
  'LBL_PRIMARY_ADDRESS' => 'Esmane aadress:',
  'LBL_SAVED_SEARCH' => 'Paigutuse valikud',
  'LBL_CREATE_USER_BUTTON_TITLE' => 'Loo kasutaja [Alt+N]',
  'LBL_CREATE_USER_BUTTON_LABEL' => 'Loo kasutaja',
  'LBL_FAVORITE_COLOR' => 'Lemmikvärv:',
  'LBL_MESSENGER_ID' => 'IM nimi:',
  'LBL_MESSENGER_TYPE' => 'IM tüüp:',
  'ERR_EMPLOYEE_NAME_EXISTS_1' => 'Töötaja nimi',
  'ERR_EMPLOYEE_NAME_EXISTS_2' => 'juba eksisteerib. Samasugune töötaja nimi pole lubatud. Muuda töötaja nimi unikaalseks.',
  'ERR_LAST_ADMIN_1' => 'Töötaja nimi "',
  'ERR_LAST_ADMIN_2' => '" on viimane töötaja, kes on administraator. Vähemalt üks töötaja peab olema administraator.',
  'LNK_NEW_EMPLOYEE' => 'Loo töötaja',
  'LNK_EMPLOYEE_LIST' => 'Vaata töötajaid',
  'ERR_DELETE_RECORD' => 'Ettevõtte kustutamiseks täpsusta kirje numbrit.',
  'LBL_DEFAULT_TEAM' => 'Esmane meeskond:',
  'LBL_DEFAULT_TEAM_TEXT' => 'Valib esmase meeskonna uute kirjete jaoks',
  'LBL_MY_TEAMS' => 'Minu meeskonnad',
  'LBL_LIST_DESCRIPTION' => 'Kirjeldus',
  'LNK_EDIT_TABS' => 'Redigeeri sakid',
  'NTC_REMOVE_TEAM_MEMBER_CONFIRMATION' => 'Oled kindel, et soovid eemaldada selle töötaja liikmelisuse?',
  'LBL_LIST_EMPLOYEE_STATUS' => 'Töötaja olek',
  'LBL_SUGAR_LOGIN' => 'On Sugari kasutaja',
  'LBL_RECEIVE_NOTIFICATIONS' => 'Teavita määramisest',
  'LBL_IS_ADMIN' => 'On administraator',
  'LBL_GROUP' => 'Grupi kasutaja',
  'LBL_PHOTO' => 'Foto',
  'LBL_DELETE_USER_CONFIRM' => 'See töötaja on ka Kasutaja. Töötaja kirje kustutamisel kustutatakse ka Kasutaja kirje ning Kasutaja ei oma enam ligipääsu rakendusele. Kas soovid selle kirje kustutamisega jätkata?',
  'LBL_DELETE_EMPLOYEE_CONFIRM' => 'Kas oled kindel, et soovid selle töötaja kustutada?',
);

