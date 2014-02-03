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
  'ERR_DELETE_RECORD' => 'Adjon meg egy azonosítót a kliens törléséhez!',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Kliensek',
  'LBL_ACCOUNT_ID' => 'Kliens azonosító',
  'LBL_ACCOUNT_NAME' => 'Kliensnév:',
  'LBL_ACCOUNT_NAME_MOD' => 'Kliens neve',
  'LBL_ACCOUNT_NAME_OWNER' => 'Kliens neve',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Tevékenységek',
  'LBL_ASSIGNED_TO_NAME' => 'Felelős',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Kijelölt felelős',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Kijelölt felelős',
  'LBL_ATTACH_NOTE' => 'Feljegyzés csatolása',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Hibák',
  'LBL_CASE' => 'Eset:',
  'LBL_CASE_INFORMATION' => 'Eset áttekintés',
  'LBL_CASE_NUMBER' => 'Eset száma:',
  'LBL_CASE_SUBJECT' => 'Eset tárgya:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kapcsolatok',
  'LBL_CONTACT_CASE_TITLE' => 'Eset kapcsolat:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Kontakszemélyek emailjei',
  'LBL_CONTACT_NAME' => 'Kapcsolat neve:',
  'LBL_CONTACT_ROLE' => 'Szerepkör:',
  'LBL_CREATED_BY_NAME_MOD' => 'Létrehozta',
  'LBL_CREATED_BY_NAME_OWNER' => 'Létrehozta',
  'LBL_CREATED_USER' => 'Felhasználó által létrehozva',
  'LBL_CREATE_KB_DOCUMENT' => 'Új cikk létrehozása',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Esetek',
  'LBL_DESCRIPTION' => 'Leírás:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumentumok',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Felelőse felhasználói azonosító',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Felelős felhasználó',
  'LBL_EXPORT_CREATED_BY' => 'Létrehozó azonosítója',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Létrehozó neve',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Módosító azonosítója',
  'LBL_EXPORT_TEAM_COUNT' => 'Csoportlétszám',
  'LBL_FILENANE_ATTACHMENT' => 'Melléklet',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Előzmények',
  'LBL_INVITEE' => 'Kapcsolatok',
  'LBL_LIST_ACCOUNT_NAME' => 'Kliens neve',
  'LBL_LIST_ASSIGNED' => 'Felelős',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Felelős felhasználó',
  'LBL_LIST_CLOSE' => 'Zárás',
  'LBL_LIST_DATE_CREATED' => 'Létrehozás dátuma',
  'LBL_LIST_FORM_TITLE' => 'Eset lista',
  'LBL_LIST_LAST_MODIFIED' => 'Utolsó módosítás',
  'LBL_LIST_MY_CASES' => 'Nyitott eseteim',
  'LBL_LIST_NUMBER' => 'Szám',
  'LBL_LIST_PRIORITY' => 'Prioritás',
  'LBL_LIST_STATUS' => 'Állapot',
  'LBL_LIST_SUBJECT' => 'Tárgy',
  'LBL_MEMBER_OF' => 'Kliens',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Módosította',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Módosította',
  'LBL_MODIFIED_USER' => 'Felhasználó által módosítva',
  'LBL_MODIFIED_USER_NAME' => 'Módosított felhasználónév',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Módosított felhasználónév',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Módosított felhasználónév tulajdonosa',
  'LBL_MODULE_NAME' => 'Esetek',
  'LBL_MODULE_NAME_SINGULAR' => 'Eset',
  'LBL_MODULE_TITLE' => 'Esetek: Főoldal',
  'LBL_NEW_FORM_TITLE' => 'Új eset',
  'LBL_NUMBER' => 'Száma:',
  'LBL_PORTAL_VIEWABLE' => 'Látható portál',
  'LBL_PRIORITY' => 'Prioritás:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektek',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projektek',
  'LBL_RESOLUTION' => 'Felbontás:',
  'LBL_SEARCH_FORM_TITLE' => 'Esetek keresése',
  'LBL_SHOW_IN_PORTAL' => 'Mutassa portál-formában',
  'LBL_SHOW_MORE' => 'Több mutatása',
  'LBL_STATUS' => 'Állapot:',
  'LBL_SUBJECT' => 'Tárgy:',
  'LBL_SYSTEM_ID' => 'Rendszer azonosító',
  'LBL_TEAM_COUNT_MOD' => 'Csoport',
  'LBL_TEAM_COUNT_OWNER' => 'Csoport felelőse',
  'LBL_TEAM_NAME_MOD' => 'Csoport neve',
  'LBL_TEAM_NAME_OWNER' => 'Csoport neve',
  'LBL_TYPE' => 'Típus',
  'LBL_WORK_LOG' => 'Munkanapló',
  'LNK_CASE_LIST' => 'Esetek megtekintése',
  'LNK_CASE_REPORTS' => 'Eset jelentések megtekintése',
  'LNK_CREATE' => 'Új eset létrehozása',
  'LNK_CREATE_WHEN_EMPTY' => 'Ügy azonnali létrehozása.',
  'LNK_IMPORT_CASES' => 'Esetek importálása',
  'LNK_NEW_CASE' => 'Új eset létrehozása',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Biztos, hogy törli ezt az esetet a hibák közül?',
  'NTC_REMOVE_INVITEE' => 'Biztosan el akarja távolítani a kapcsolatot az esettől?',
);

