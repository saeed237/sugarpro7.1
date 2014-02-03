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
  'LBL_ACTION_ERROR' => 'Šo darbību nevar izpildīt. Rediģējiet darbību, lai visi lauki un lauku vērtības būtu derīgas.',
  'LBL_ACTION_ERRORS' => 'Paziņojums: Viena vai vairākas no zemāk redzamām darbībām ir kļūdainas.',
  'LBL_ALERT_ERROR' => 'Šis brīdinājums nav izpildāms. Rediģējiet brīdinājumu, lai visi iestatījumi būtu derīgi.',
  'LBL_ALERT_ERRORS' => 'Paziņojums: Viens vai vairāki no sekojošiem brīdinājumiem ir kļūdaini.',
  'LBL_ALERT_SUBJECT' => 'DARBPLŪSMAS BRĪDINĀJUMS',
  'LBL_ALERT_TEMPLATES' => 'Brīdinājuma veidnes',
  'LBL_ANY_FIELD' => 'jebkurš lauks',
  'LBL_AS' => 'kā',
  'LBL_BASE_MODULE' => 'Mērķa modulis:',
  'LBL_BODY' => 'Ķermenis:',
  'LBL_CREATE_ALERT_TEMPLATE' => 'Izveidot brīdinājuma veidni:',
  'LBL_DESCRIPTION' => 'Apraksts:',
  'LBL_DOWN' => 'Uz leju',
  'LBL_EDITLAYOUT' => 'Rediģēt izkārtojumu',
  'LBL_EDIT_ALT_TEXT' => 'Cits teksts',
  'LBL_EMAILTEMPLATES_TYPE' => 'Tips',
  'LBL_EMAILTEMPLATES_TYPE_LIST_WORKFLOW' => 
  array (
    'workflow' => 'Darbplūsma',
  ),
  'LBL_FIRE_ORDER' => 'Atstrādes secība:',
  'LBL_FROM_ADDRESS' => 'No adreses:',
  'LBL_FROM_NAME' => 'No vārda:',
  'LBL_HIDE' => 'Slēpt',
  'LBL_INSERT' => 'Ievietot',
  'LBL_INVITEES' => 'Uzaicinātie',
  'LBL_INVITEE_NOTICE' => 'Uzmanību, lai izveidotu jāizvēlas vismaz viens ielūgtais.',
  'LBL_INVITE_LINK' => 'Tikšanās/zvana ielūguma saite',
  'LBL_LACK_OF_NOTIFICATIONS_ON' => 'Paziņojums: Lai sūtītu brīdinājumus, ievadi SMTP Servera informāciju sadaļā Administrators > E-pasta iestatījumi.',
  'LBL_LACK_OF_TRIGGER_ALERT' => 'Paziņojums: Lai šī darbplūsma funkcionētu, tai jāizveido trigeris.',
  'LBL_LINK_RECORD' => 'Saite uz ierakstu',
  'LBL_LIST_BASE_MODULE' => 'Mērķa modulis:',
  'LBL_LIST_DN' => 'lejup',
  'LBL_LIST_FORM_TITLE' => 'Darbplūsmu saraksts',
  'LBL_LIST_NAME' => 'Nosaukums',
  'LBL_LIST_ORDER' => 'Apstrādes secība:',
  'LBL_LIST_STATUS' => 'Statuss',
  'LBL_LIST_TYPE' => 'Izpilde notiek:',
  'LBL_LIST_UP' => 'augšup',
  'LBL_MODULE_ID' => 'Darbplūsma',
  'LBL_MODULE_NAME' => 'Darbplūsmu definīcijas',
  'LBL_MODULE_NAME_SINGULAR' => 'Darbplūsmas definīcija',
  'LBL_MODULE_TITLE' => 'Darbplūsma: Sākums',
  'LBL_NAME' => 'Nosaukums:',
  'LBL_NEW_FORM_TITLE' => 'Izveidot darbplūsmu definīciju',
  'LBL_PLEASE_SELECT' => 'Izvēlieties',
  'LBL_PROCESS_LIST' => 'Darbplūsmu secība',
  'LBL_PROCESS_SELECT' => 'Izvēlieties moduli:',
  'LBL_RECIPIENTS' => 'Saņēmēji',
  'LBL_RECORD_TYPE' => 'Attiecas uz:',
  'LBL_RELATED_MODULE' => 'Saistītais modulis:',
  'LBL_SEARCH_FORM_TITLE' => 'Darbplūsmas meklēšana',
  'LBL_SELECT_FILTER' => 'Jums ir jāizvēlas lauks, ar ko filtrēt saistīto moduli.',
  'LBL_SELECT_MODULE' => 'Izvēlieties saistītu moduli.',
  'LBL_SELECT_OPTION' => 'Atzīmējiet izvēli.',
  'LBL_SELECT_VALUE' => 'Jums jāizvēlas vērtība.',
  'LBL_SET' => 'Iestatīt',
  'LBL_SHOW' => 'Parādīt',
  'LBL_SPECIFIC_FIELD' => 'noteikts lauks',
  'LBL_STATUS' => 'Statuss:',
  'LBL_SUBJECT' => 'Temats:',
  'LBL_TRIGGER_ERROR' => 'Paziņojums: Šis trigeris satur nederīgas vērtības un nevar tikt izpildīts.',
  'LBL_TRIGGER_ERRORS' => 'Paziņojums: Viens vai vairāki no sekojošiem trigeriem ir kļūdaini.',
  'LBL_TYPE' => 'Izpilde notiek:',
  'LBL_UP' => 'Uz augšu',
  'LBL__S' => '$#39;s',
  'LNK_ALERT_TEMPLATES' => 'Brīdinājuma e-pasta veidnes',
  'LNK_NEW_WORKFLOW' => 'Izveidot darbplūsmas definīciju',
  'LNK_PROCESS_VIEW' => 'Darbplūsmas secība',
  'LNK_WORKFLOW' => 'Izvadīt darbplūsmas definīcijas',
  'NTC_REMOVE_ALERT' => 'Vai esat pārliecināts, ka vēlaties izņemt šo darba plūsmu?',
);

