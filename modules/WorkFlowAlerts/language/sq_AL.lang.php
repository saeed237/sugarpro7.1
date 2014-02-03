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
  'LBL_ADDRESS_TO' => 'tek:',
  'LBL_ADDRESS_TYPE' => 'adresa e përdorur',
  'LBL_ADDRESS_TYPE_TARGET' => 'lloji',
  'LBL_ALERT_CURRENT_USER' => 'Përdorues i lidhur me objektivin',
  'LBL_ALERT_CURRENT_USER_TITLE' => 'Përdorues i lidhur me modulin e synuar',
  'LBL_ALERT_LOGIN_USER_TITLE' => 'Identifikimi i përdoruesit në kohën ekzekutimit',
  'LBL_ALERT_REL1' => 'moduli i lidhur',
  'LBL_ALERT_REL2' => 'lidhje e modelit të lidhur',
  'LBL_ALERT_REL_USER' => 'Përdoruesi i lidhur me ngjashmërinë',
  'LBL_ALERT_REL_USER_CUSTOM' => 'Pranuesit i lidhur me ngjashmërinë',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 'Pranuesit i lidhur me modulet e ngjashme',
  'LBL_ALERT_REL_USER_TITLE' => 'Përdoruesi i lidhur me module të ngjashme',
  'LBL_ALERT_SPECIFIC_ROLE' => 'Të gjithë përdoruesit në specifik',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 'Të gjithë përdoruesit në rol specifik',
  'LBL_ALERT_SPECIFIC_TEAM' => 'Të gjithë përdoruesit në specifik',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 'Të gjithë përdoruesit që i përkasin ekipit(ve) të lidhur me modulin e synuar',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 'Anëtarët e ekipit të lidhur me modulin e synuar',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 'Të gjithë përdoruesit në grup specifik',
  'LBL_ALERT_SPECIFIC_USER' => 'specifik',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 'Përdorues specifik',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 'Pranuesit i lidhur me modulin e synuar',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 'Pranuesit i lidhur me modulin e synuar',
  'LBL_AND' => 'Dhe emri i fushës:',
  'LBL_ARRAY_TYPE' => 'Lloji i veprimit',
  'LBL_BLANK' => '',
  'LBL_CUSTOM_USER' => 'përdorues i zakonshëm',
  'LBL_EDITLAYOUT' => 'Ndrysho formatin',
  'LBL_FIELD' => 'Fusha',
  'LBL_FIELD_VALUE' => 'Përdoruesi i selektuar:',
  'LBL_FILTER_BY' => '(Filtër Shtesë) Filtër i moduleve të ngjashme nga',
  'LBL_FILTER_CUSTOM' => '(Filtër Shtesë) Filtër i moduleve të ngjashme nga specifik',
  'LBL_LIST_ADDRESS_TYPE' => 'lloji i adresës',
  'LBL_LIST_ARRAY_TYPE' => 'lloji i veprimit',
  'LBL_LIST_FIELD_VALUE' => 'Përdorues',
  'LBL_LIST_FORM_TITLE' => 'Lista e pranuesve',
  'LBL_LIST_RELATE_TYPE' => 'lloji ilidhjes',
  'LBL_LIST_REL_MODULE1' => 'Modul i lidhur',
  'LBL_LIST_REL_MODULE2' => 'lidhje e moedlit të lidhur',
  'LBL_LIST_STATEMENT' => 'Pranuesit alarmues:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Dërgo alarm të pranuesi në vijim:',
  'LBL_LIST_STATEMENT_INVITE' => 'T[ ftuarit e mbledhjes/thirjes',
  'LBL_LIST_USER_TYPE' => 'Lloji i përdoruesit',
  'LBL_LIST_WHERE_FILTER' => 'Statusi',
  'LBL_MODULE_NAME' => 'Lista e pranuesve alarmues',
  'LBL_MODULE_NAME_INVITE' => 'Lista e të ftuarve',
  'LBL_MODULE_NAME_SINGULAR' => 'paralajmëro Listën e pranuesve',
  'LBL_MODULE_NAME_SINGULAR_INVITE' => 'Lista e të ftuarve',
  'LBL_MODULE_TITLE' => 'Pranuesit: Ballina',
  'LBL_NEW_FORM_TITLE' => 'Krijo rrjedhë pune të pranuesit',
  'LBL_NEXT_BUTTON' => 'Vijues',
  'LBL_PLEASE_SELECT' => 'ju lutemi selektoni',
  'LBL_PREVIOUS_BUTTON' => 'Mëparshëm',
  'LBL_RECORD' => 'Moduli',
  'LBL_RELATE_TYPE' => 'lloji i lidhjes',
  'LBL_REL_CUSTOM' => 'selekto fushë të emailit të zakontë',
  'LBL_REL_CUSTOM2' => 'Fusha',
  'LBL_REL_CUSTOM3' => 'Fusha',
  'LBL_REL_CUSTOM_STRING' => 'Selektoni emailin e porositur dhe emrin e fushave',
  'LBL_REL_MODULE1' => 'Moduli i lidhur',
  'LBL_REL_MODULE2' => 'lidhje e modulit të lidhur',
  'LBL_ROLE' => 'Roli',
  'LBL_SEARCH_FORM_TITLE' => 'Kërkimi i rrjedhës së  punës së pranuesve',
  'LBL_SELECT_EMAIL' => 'Ju duhet të selektoni me porosi fushën e emailit',
  'LBL_SELECT_FILTER' => 'Ju duhet të selektoni fushën për të filtruar nga',
  'LBL_SELECT_NAME' => 'Ju duhet të selektoni fushën me porosi të emrit',
  'LBL_SELECT_NAME_EMAIL' => 'Ju duhet të selektoni emrin e dhe e-mailin e fushës',
  'LBL_SELECT_VALUE' => 'Duhet selektuar vlerë valide',
  'LBL_SEND_EMAIL' => 'dërgo emaili tek',
  'LBL_SPECIFIC_FIELD' => 'Fusha',
  'LBL_TEAM' => 'Grupi',
  'LBL_USER' => 'Përdorues',
  'LBL_USER1' => 'kush e krijoi regjistrimin',
  'LBL_USER2' => 'kush i fundit e modifikoi regjistrimin',
  'LBL_USER3' => 'aktual',
  'LBL_USER3b' => 'të sistemit',
  'LBL_USER4' => 'kush është caktuar për regjistrim',
  'LBL_USER5' => 'kush ishte caktuar për regjistrim',
  'LBL_USER_MANAGER' => 'menaxxheri i përdoruesit',
  'LBL_USER_TYPE' => 'Lloji i përdoruesit',
  'LBL_WHERE_FILTER' => 'statusi',
  'LNK_NEW_WORKFLOW' => 'Krijo rrjedhë pune',
  'LNK_WORKFLOW' => 'Objektet e rrjedhës së punës',
  'NTC_REMOVE_ALERT_USER' => 'A jeni të sigurt që dëshironi të largoni këtë pranues alarmues?',
);

