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
  'ERR_DELETE_RECORD' => 'Duhet përcaktuar numrin e regjistrimit për të fshirë gabimin',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Llogaritë',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivitetet',
  'LBL_ASSIGNED_TO_NAME' => 'Drejtuar:',
  'LBL_BUG' => 'Bug',
  'LBL_BUG_INFORMATION' => 'Pasqyra',
  'LBL_BUG_NUMBER' => 'Numri i bug',
  'LBL_BUG_SUBJECT' => 'Subjekti i gabimit',
  'LBL_CASES_SUBPANEL_TITLE' => 'Rastet',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaktet',
  'LBL_CONTACT_BUG_TITLE' => 'Kontakt për Bug',
  'LBL_CONTACT_NAME' => 'Emri i kontaktit',
  'LBL_CONTACT_ROLE' => 'Rolo:',
  'LBL_CREATED_BY' => 'Krijuar nga',
  'LBL_DATE_CREATED' => 'Krijo të dhëna:',
  'LBL_DATE_LAST_MODIFIED' => 'Data e modifikimit:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Gjyrmues i bug',
  'LBL_DESCRIPTION' => 'Përshkrim',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentacionet',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID e përdoruesit të caktuar',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Emri i përdoruesit të caktuar',
  'LBL_EXPORT_CREATED_BY' => 'Krijuar Nga ID',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Ndrequr në emrin e publikimit',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modifikuar nga ID',
  'LBL_FIXED_IN_RELEASE' => 'Ndrequr në publikim',
  'LBL_FOUND_IN_RELEASE' => 'Gjetur në publikim',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Gjetur në emrin e publikimit',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_INVITEE' => 'Kontaktet',
  'LBL_LIST_ACCOUNT_NAME' => 'Emri i llogarisë:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Përdorues i caktuar',
  'LBL_LIST_CONTACT_NAME' => 'Emri i kontaktit',
  'LBL_LIST_EMAIL_ADDRESS' => 'Email adresa',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Ndrequr në publikim',
  'LBL_LIST_FORM_TITLE' => 'Lista e Bugs',
  'LBL_LIST_LAST_MODIFIED' => 'Ndryshimi i fundit',
  'LBL_LIST_MY_BUGS' => 'Bugst e mia të caktuara',
  'LBL_LIST_NUMBER' => 'Num.',
  'LBL_LIST_PHONE' => 'Telefoni',
  'LBL_LIST_PRIORITY' => 'Prioriteti',
  'LBL_LIST_RELEASE' => 'Publikimi',
  'LBL_LIST_RESOLUTION' => 'Zgjidhja',
  'LBL_LIST_STATUS' => 'Statusi',
  'LBL_LIST_SUBJECT' => 'Subjekti',
  'LBL_LIST_TYPE' => 'Lloji',
  'LBL_MODIFIED_BY' => 'Modifikim i fundit nga',
  'LBL_MODULE_ID' => 'Bugs',
  'LBL_MODULE_NAME' => 'gabimet',
  'LBL_MODULE_NAME_SINGULAR' => 'Bug',
  'LBL_MODULE_TITLE' => 'Gjyrmues i Bugs: Ballina',
  'LBL_NEW_FORM_TITLE' => 'Bug i ri',
  'LBL_NUMBER' => 'Numri',
  'LBL_PORTAL_VIEWABLE' => 'Portali i shikueshëm',
  'LBL_PRIORITY' => 'Priorieti:',
  'LBL_PRODUCT_CATEGORY' => 'Kategoria',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektet',
  'LBL_RELEASE' => 'Publikimi',
  'LBL_RESOLUTION' => 'Zgjidhja',
  'LBL_SEARCH_FORM_TITLE' => 'Kërkimi i Bugs',
  'LBL_SHOW_IN_PORTAL' => 'Shfaqe në portal',
  'LBL_SHOW_MORE' => 'Trego më shumë Bugs',
  'LBL_SOURCE' => 'Burimi',
  'LBL_STATUS' => 'Statusi',
  'LBL_SUBJECT' => 'Subjekti',
  'LBL_SYSTEM_ID' => 'ID e sistemit',
  'LBL_TYPE' => 'Lloji',
  'LBL_WORK_LOG' => 'Identifikimi i punës',
  'LNK_BUG_LIST' => 'Shiko Bugs',
  'LNK_BUG_REPORTS' => 'Shiko raportin e bugave',
  'LNK_CREATE' => 'Raporto Bug',
  'LNK_CREATE_WHEN_EMPTY' => 'Raporto një bug tash.',
  'LNK_IMPORT_BUGS' => 'Importo Bugs',
  'LNK_NEW_BUG' => 'Raporto Bug',
  'NTC_DELETE_CONFIRMATION' => 'A jeni të sigurtë që dëshironi që të fshini këtë kontakt nga ky bug?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'A jeni të sigurtë që dëshironi të largoni këtë gabim nga kjo llogari?',
  'NTC_REMOVE_INVITEE' => 'A jeni të sigurt që dëshironi të fshini këtë kontakt nga bugu?',
);

