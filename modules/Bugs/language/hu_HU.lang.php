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
  'ERR_DELETE_RECORD' => 'Adjon meg egy azonosítót a hiba törléséhez!',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Kliensek',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Tevékenységek',
  'LBL_ASSIGNED_TO_NAME' => 'Felelős',
  'LBL_BUG' => 'Hiba:',
  'LBL_BUG_INFORMATION' => 'Hiba áttekintés',
  'LBL_BUG_NUMBER' => 'Hiba száma:',
  'LBL_BUG_SUBJECT' => 'Hiba tárgya:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Esetek',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kapcsolatok',
  'LBL_CONTACT_BUG_TITLE' => 'Kapcsolat-hiba:',
  'LBL_CONTACT_NAME' => 'Kapcsolat neve:',
  'LBL_CONTACT_ROLE' => 'Szerepkör:',
  'LBL_CREATED_BY' => 'Létrehozta:',
  'LBL_DATE_CREATED' => 'Létrehozás dátuma:',
  'LBL_DATE_LAST_MODIFIED' => 'Módosítás dátuma:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Hibakövető',
  'LBL_DESCRIPTION' => 'Leírás:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentumok',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Felelőse felhasználói azonosító',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Felelős felhasználó neve',
  'LBL_EXPORT_CREATED_BY' => 'Létrehozó azonosítója',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Kiadás nevében rögzítve',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Módosító azonosítója',
  'LBL_FIXED_IN_RELEASE' => 'Javítások ebben a kiadásban:',
  'LBL_FOUND_IN_RELEASE' => 'Találatok ebben a kiadásban:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Megtalálható a kiadás nevében',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Előzmények',
  'LBL_INVITEE' => 'Kapcsolatok',
  'LBL_LIST_ACCOUNT_NAME' => 'Fiók neve',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Hozzárendelt felhasználó',
  'LBL_LIST_CONTACT_NAME' => 'Kapcsolat neve:',
  'LBL_LIST_EMAIL_ADDRESS' => 'Email cím',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Javítva ebben a kiadásban',
  'LBL_LIST_FORM_TITLE' => 'Hibalista',
  'LBL_LIST_LAST_MODIFIED' => 'Utolsó módosítás',
  'LBL_LIST_MY_BUGS' => 'Hozzárendelt hibáim',
  'LBL_LIST_NUMBER' => 'Szám',
  'LBL_LIST_PHONE' => 'Telefon',
  'LBL_LIST_PRIORITY' => 'Prioritás',
  'LBL_LIST_RELEASE' => 'Kiadás',
  'LBL_LIST_RESOLUTION' => 'Felbontás',
  'LBL_LIST_STATUS' => 'Állapot',
  'LBL_LIST_SUBJECT' => 'Tárgy',
  'LBL_LIST_TYPE' => 'Típus',
  'LBL_MODIFIED_BY' => 'Utoljára módosította:',
  'LBL_MODULE_ID' => 'Hibák',
  'LBL_MODULE_NAME' => 'Hibák',
  'LBL_MODULE_NAME_SINGULAR' => 'Hiba',
  'LBL_MODULE_TITLE' => 'Hibakereső: Főoldal',
  'LBL_NEW_FORM_TITLE' => 'Új hiba',
  'LBL_NUMBER' => 'Szám:',
  'LBL_PORTAL_VIEWABLE' => 'Megtekinthető portál',
  'LBL_PRIORITY' => 'Prioritás:',
  'LBL_PRODUCT_CATEGORY' => 'Kategória:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektek',
  'LBL_RELEASE' => 'Kiadás:',
  'LBL_RESOLUTION' => 'Felbontás:',
  'LBL_SEARCH_FORM_TITLE' => 'Hibakeresés',
  'LBL_SHOW_IN_PORTAL' => 'Mutassa Portál formában',
  'LBL_SHOW_MORE' => 'Több mutatása',
  'LBL_SOURCE' => 'Forrás:',
  'LBL_STATUS' => 'Állapot:',
  'LBL_SUBJECT' => 'Tárgy:',
  'LBL_SYSTEM_ID' => 'Rendszer azonosító',
  'LBL_TYPE' => 'Típus:',
  'LBL_WORK_LOG' => 'Munkanapló:',
  'LNK_BUG_LIST' => 'Hibák megtekitése',
  'LNK_BUG_REPORTS' => 'Hibajelentések megtekintése',
  'LNK_CREATE' => 'Hiba bejelentése',
  'LNK_CREATE_WHEN_EMPTY' => 'Hiba azonnali bejelentése.',
  'LNK_IMPORT_BUGS' => 'Hibák importálása',
  'LNK_NEW_BUG' => 'Hiba bejelentése',
  'NTC_DELETE_CONFIRMATION' => 'Biztosan el akarja távolítani ezt a kapcsolatot ebből a hiba rekordból?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Biztosan el akarja távolítani ezt a hibát ettől a klienstől?',
  'NTC_REMOVE_INVITEE' => 'Biztosan el akarja távolítani ezt a kapcsolatot ebből a hiba rekordból?',
);

