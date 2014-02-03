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
  'ERR_DELETE_RECORD' => 'Ett objektnummer måste specificeras för att kunna radera organisationen.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Organisationer',
  'LBL_ACCOUNT_ID' => 'Organisations ID',
  'LBL_ACCOUNT_NAME' => 'Organisationsnamn:',
  'LBL_ACCOUNT_NAME_MOD' => 'Konto Namn Mod',
  'LBL_ACCOUNT_NAME_OWNER' => 'Konto Namn Ägare',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteter',
  'LBL_ASSIGNED_TO_NAME' => 'Tilldelad till',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Tilldelad Användare Namn Mod',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Tilldelad Användare Namn Ägare',
  'LBL_ATTACH_NOTE' => 'Lägg till anteckning',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Buggar',
  'LBL_CASE' => 'Ärende:',
  'LBL_CASE_INFORMATION' => 'Ärende översikt',
  'LBL_CASE_NUMBER' => 'Ärendenummer:',
  'LBL_CASE_SUBJECT' => 'Ärendeämne:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakter',
  'LBL_CONTACT_CASE_TITLE' => 'Kontakt-Ärende:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Relaterad Kontakts Emails',
  'LBL_CONTACT_NAME' => 'Kontaktnamn:',
  'LBL_CONTACT_ROLE' => 'Roll:',
  'LBL_CREATED_BY_NAME_MOD' => 'Skapad Av Namn Mod',
  'LBL_CREATED_BY_NAME_OWNER' => 'Skapad Av Namn Ägare',
  'LBL_CREATED_USER' => 'Skapad användare',
  'LBL_CREATE_KB_DOCUMENT' => 'Skapa artikel',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Ärenden',
  'LBL_DESCRIPTION' => 'Beskrivning:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokument',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Tilldelad Användar ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Tilldelat Användarnamn',
  'LBL_EXPORT_CREATED_BY' => 'Skapad av ID',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Skapad Av Användare Namn',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Ändrad av ID',
  'LBL_EXPORT_TEAM_COUNT' => 'Team Räknare',
  'LBL_FILENANE_ATTACHMENT' => 'Filbilaga',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historik',
  'LBL_INVITEE' => 'Kontakter',
  'LBL_LIST_ACCOUNT_NAME' => 'Organisationsnamn',
  'LBL_LIST_ASSIGNED' => 'Tilldelad till',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Tilldelad användare',
  'LBL_LIST_CLOSE' => 'Stäng',
  'LBL_LIST_DATE_CREATED' => 'Skapande datum',
  'LBL_LIST_FORM_TITLE' => 'Lista ärende',
  'LBL_LIST_LAST_MODIFIED' => 'Senast ändrad',
  'LBL_LIST_MY_CASES' => 'Mina öppna ärenden',
  'LBL_LIST_NUMBER' => 'Nr.',
  'LBL_LIST_PRIORITY' => 'Prioritet',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Ämne',
  'LBL_MEMBER_OF' => 'Organisation',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Ändrad Av Namn Mod',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Ändrad Av Namn Ägare',
  'LBL_MODIFIED_USER' => 'Ändrad användare',
  'LBL_MODIFIED_USER_NAME' => 'Ändrad Användare Namn',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Ändrad Användare Namn Mod',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Ändrad Användare Namn Ägare',
  'LBL_MODULE_NAME' => 'Ärenden',
  'LBL_MODULE_NAME_SINGULAR' => 'Ärende',
  'LBL_MODULE_TITLE' => 'Ärenden: Hem',
  'LBL_NEW_FORM_TITLE' => 'Nytt ärende',
  'LBL_NUMBER' => 'Nummer:',
  'LBL_PORTAL_VIEWABLE' => 'Portabel Visning Möjlig',
  'LBL_PRIORITY' => 'Prioritet:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekt',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projekt',
  'LBL_RESOLUTION' => 'Lösning:',
  'LBL_SEARCH_FORM_TITLE' => 'Sök ärende',
  'LBL_SHOW_IN_PORTAL' => 'Visa i portal',
  'LBL_SHOW_MORE' => 'Visa Fler Ärenden',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Ämne',
  'LBL_SYSTEM_ID' => 'System ID',
  'LBL_TEAM_COUNT_MOD' => 'Team Räknare Mod',
  'LBL_TEAM_COUNT_OWNER' => 'Team Räknare Ägare',
  'LBL_TEAM_NAME_MOD' => 'Team Namn Mod',
  'LBL_TEAM_NAME_OWNER' => 'Team Namn Ägare',
  'LBL_TYPE' => 'Typ',
  'LBL_WORK_LOG' => 'Arbetslogg',
  'LNK_CASE_LIST' => 'Ärenden',
  'LNK_CASE_REPORTS' => 'Ärenderapporter',
  'LNK_CREATE' => 'Skapa ärende',
  'LNK_CREATE_WHEN_EMPTY' => 'Skapa nytt protokoll nu.',
  'LNK_IMPORT_CASES' => 'Importera ärenden',
  'LNK_NEW_CASE' => 'Skapa ärende',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Är du säker på att du vill ta bort ärendet från buggen?',
  'NTC_REMOVE_INVITEE' => 'Är du säker på att du vill ta bort kontakten från ärendet?',
);

