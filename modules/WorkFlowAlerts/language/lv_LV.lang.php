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
  'LBL_ADDRESS_BCC' => 'bcc:',
  'LBL_ADDRESS_CC' => 'cc:',
  'LBL_ADDRESS_TO' => 'Kam:',
  'LBL_ADDRESS_TYPE' => 'izmantojot adresi',
  'LBL_ADDRESS_TYPE_TARGET' => 'veids',
  'LBL_ALERT_CURRENT_USER' => 'Lietotājam, kurš saistīts ar mērķi',
  'LBL_ALERT_CURRENT_USER_TITLE' => 'Lietotājam, kurš saistīts ar mērķa moduli',
  'LBL_ALERT_LOGIN_USER_TITLE' => 'Lietotājam, kurš pieteicies izpildes laikā',
  'LBL_ALERT_REL1' => 'Saistītais modulis:',
  'LBL_ALERT_REL2' => 'Saistīti saistītais modulis:',
  'LBL_ALERT_REL_USER' => 'Lietotājs saistīts ar saistīto',
  'LBL_ALERT_REL_USER_CUSTOM' => 'Saņēmējs saistīts ar saistīto',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 'Saņēmējs saistīts ar saistīto moduli',
  'LBL_ALERT_REL_USER_TITLE' => 'Lietotājs saistīts ar saistīto moduli',
  'LBL_ALERT_SPECIFIC_ROLE' => 'Visi lietotāji noteiktā',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 'Visi lietotāji noteiktā lomā',
  'LBL_ALERT_SPECIFIC_TEAM' => 'Visi lietotāji noteiktā',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 'Visi lietotāji, kuri pieder darba grupai(ām) saistītai(ām) ar mērķa moduli',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 'Ar mērķa moduli saistītās darba grupas dalībnieki',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 'Visi lietotāji noteiktā darba grupā',
  'LBL_ALERT_SPECIFIC_USER' => 'Noteikts',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 'Noteikts lietotājs',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 'Saņēmējs saistīts ar mērķa moduli.',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 'Saņēmējs saistīts ar objekta moduli.',
  'LBL_AND' => 'un vārda lauks:',
  'LBL_ARRAY_TYPE' => 'Darbības veids:',
  'LBL_BLANK' => '',
  'LBL_CUSTOM_USER' => 'Pielāgots lietotājs:',
  'LBL_EDITLAYOUT' => 'Rediģēt izkārtojumu',
  'LBL_FIELD' => 'Lauks',
  'LBL_FIELD_VALUE' => 'Izvēlētais lietotājs:',
  'LBL_FILTER_BY' => '(Papildu filtrs) Ar filtru saistīts modulis ar',
  'LBL_FILTER_CUSTOM' => '(Papildu filtrs) Ar filtru saistīts modulis ar īpašu',
  'LBL_LIST_ADDRESS_TYPE' => 'Adreses veids',
  'LBL_LIST_ARRAY_TYPE' => 'Darbības veids',
  'LBL_LIST_FIELD_VALUE' => 'Lietotājs',
  'LBL_LIST_FORM_TITLE' => 'Saņēmēju saraksts',
  'LBL_LIST_RELATE_TYPE' => 'Saistītais tips',
  'LBL_LIST_REL_MODULE1' => 'Saistītais modulis',
  'LBL_LIST_REL_MODULE2' => 'Saistīti saistītais modulis',
  'LBL_LIST_STATEMENT' => 'Brīdinājuma saņēmēji:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Sūtīt brīdinājumu sekojošiem saņēmējiem:',
  'LBL_LIST_STATEMENT_INVITE' => 'Tikšanās/zvana dalībnieki:',
  'LBL_LIST_USER_TYPE' => 'Lietotāja veids',
  'LBL_LIST_WHERE_FILTER' => 'Statuss',
  'LBL_MODULE_NAME' => 'Brīdinājumu saņēmēji',
  'LBL_MODULE_NAME_INVITE' => 'Ielūgto saraksts',
  'LBL_MODULE_NAME_SINGULAR' => 'Brīdinājuma saņēmēju saraksts',
  'LBL_MODULE_NAME_SINGULAR_INVITE' => 'Uzaicināto saraksts',
  'LBL_MODULE_TITLE' => 'Saņēmēji: Sākums',
  'LBL_NEW_FORM_TITLE' => 'Izveidot darba plūsmas saņēmēju',
  'LBL_NEXT_BUTTON' => 'Nākamais',
  'LBL_PLEASE_SELECT' => 'Lūdzu izvēlieties',
  'LBL_PREVIOUS_BUTTON' => 'Iepriekšējais',
  'LBL_RECORD' => 'Modulis',
  'LBL_RELATE_TYPE' => 'Saites veids:',
  'LBL_REL_CUSTOM' => 'Izvēlieties pielāgotu e-pasta lauku:',
  'LBL_REL_CUSTOM2' => 'Lauks',
  'LBL_REL_CUSTOM3' => 'Lauks',
  'LBL_REL_CUSTOM_STRING' => 'Izvēlieties pielāgotus e-pasta un vārda laukus',
  'LBL_REL_MODULE1' => 'Saistītais modulis:',
  'LBL_REL_MODULE2' => 'Saistīti saistītais modulis:',
  'LBL_ROLE' => 'loma',
  'LBL_SEARCH_FORM_TITLE' => 'Darba plūsmas saņēmēja meklēšana',
  'LBL_SELECT_EMAIL' => 'Jānorāda pielāgots e-pasta lauks',
  'LBL_SELECT_FILTER' => 'Norādiet lauku, pēc kura filtrēt',
  'LBL_SELECT_NAME' => 'Jānorāda pielāgots vārda lauks',
  'LBL_SELECT_NAME_EMAIL' => 'Jānorāda vārda un un e-pasta lauki',
  'LBL_SELECT_VALUE' => 'Jānorāda derīga vērtība.',
  'LBL_SEND_EMAIL' => 'Sūtīt e-pastu uz:',
  'LBL_SPECIFIC_FIELD' => 'lauks',
  'LBL_TEAM' => 'Darba grupa',
  'LBL_USER' => 'Lietotājs',
  'LBL_USER1' => 'kurš izveidoja ierakstu',
  'LBL_USER2' => 'kurš pēdējais modificēja ierakstu',
  'LBL_USER3' => 'pašreizējais',
  'LBL_USER3b' => 'sistēmai.',
  'LBL_USER4' => 'kurš ir piešķīris ierakstu',
  'LBL_USER5' => 'kurš bija piešķīris ierakstu',
  'LBL_USER_MANAGER' => 'lietotāju vadītājs',
  'LBL_USER_TYPE' => 'Lietotāja veids:',
  'LBL_WHERE_FILTER' => 'Statuss:',
  'LNK_NEW_WORKFLOW' => 'Izveidot darba plūsmu',
  'LNK_WORKFLOW' => 'Darba plūsmas objekti',
  'NTC_REMOVE_ALERT_USER' => 'Vai tiešām vēlaties izņemt šo brīdinājuma saņēmēju?',
);

