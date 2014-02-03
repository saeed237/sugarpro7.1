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
  'ERR_DELETE_RECORD' => 'Zum Löschen der Firma muss eine Datensatznummer angegeben werden.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Firmen',
  'LBL_ACCOUNT_ID' => 'Firma ID',
  'LBL_ACCOUNT_NAME' => 'Firmenname:',
  'LBL_ACCOUNT_NAME_MOD' => 'Firmenname Mod',
  'LBL_ACCOUNT_NAME_OWNER' => 'Firmenname Zugewiesener',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivitäten',
  'LBL_ASSIGNED_TO_NAME' => 'Zugewiesen an',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Zugewiesen an',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Zugewiesen an',
  'LBL_ATTACH_NOTE' => 'Notiz anhängen',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Fehler',
  'LBL_CASE' => 'Ticket:',
  'LBL_CASE_INFORMATION' => 'Überblick Tickets',
  'LBL_CASE_NUMBER' => 'Ticketnummer:',
  'LBL_CASE_SUBJECT' => 'Betreff:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakte',
  'LBL_CONTACT_CASE_TITLE' => 'Kontakt:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Verknüpfte Kontakt E-Mails',
  'LBL_CONTACT_NAME' => 'Name:',
  'LBL_CONTACT_ROLE' => 'Beruf:',
  'LBL_CREATED_BY_NAME_MOD' => 'Ersteller',
  'LBL_CREATED_BY_NAME_OWNER' => 'Ersteller',
  'LBL_CREATED_USER' => 'Erstellter Benutzer',
  'LBL_CREATE_KB_DOCUMENT' => 'Artikel erstellen',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Tickets',
  'LBL_DESCRIPTION' => 'Beschreibung:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumente',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Zugewiesen an',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Zugewiesen an',
  'LBL_EXPORT_CREATED_BY' => 'Ersteller',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Ersteller',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Bearbeiter:',
  'LBL_EXPORT_TEAM_COUNT' => 'Team Anzahl',
  'LBL_FILENANE_ATTACHMENT' => 'Dateianhang',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Verlauf',
  'LBL_INVITEE' => 'Kontakte',
  'LBL_LIST_ACCOUNT_NAME' => 'Firmenname',
  'LBL_LIST_ASSIGNED' => 'Zugewiesen an',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Zugew. Benutzer',
  'LBL_LIST_CLOSE' => 'Schließen',
  'LBL_LIST_DATE_CREATED' => 'Erstellt am:',
  'LBL_LIST_FORM_TITLE' => 'Tickets Liste',
  'LBL_LIST_LAST_MODIFIED' => 'Geändert am:',
  'LBL_LIST_MY_CASES' => 'Meine offenen Tickets',
  'LBL_LIST_NUMBER' => 'Num.',
  'LBL_LIST_PRIORITY' => 'Priorität',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Betreff',
  'LBL_MEMBER_OF' => 'Firma',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Geändert von',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Geändert von',
  'LBL_MODIFIED_USER' => 'Veränderter Benutzer',
  'LBL_MODIFIED_USER_NAME' => 'Geändert von',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Geändert von',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Geändert von',
  'LBL_MODULE_NAME' => 'Tickets',
  'LBL_MODULE_NAME_SINGULAR' => 'Fall',
  'LBL_MODULE_TITLE' => 'Tickets: Home',
  'LBL_NEW_FORM_TITLE' => 'Neues Ticket',
  'LBL_NUMBER' => 'Nummer:',
  'LBL_PORTAL_VIEWABLE' => 'Im Portal sichtbar',
  'LBL_PRIORITY' => 'Priorität:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekte',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projekte',
  'LBL_RESOLUTION' => 'Lösung:',
  'LBL_SEARCH_FORM_TITLE' => 'Tickets Suche',
  'LBL_SHOW_IN_PORTAL' => 'Im Portal anzeigen',
  'LBL_SHOW_MORE' => 'Mehere Fälle anzeigen',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Betreff:',
  'LBL_SYSTEM_ID' => 'System ID',
  'LBL_TEAM_COUNT_MOD' => 'Team Count Mod',
  'LBL_TEAM_COUNT_OWNER' => 'Team Count Owner',
  'LBL_TEAM_NAME_MOD' => 'Team Name Mod',
  'LBL_TEAM_NAME_OWNER' => 'Team Name Owner',
  'LBL_TYPE' => 'Typ:',
  'LBL_WORK_LOG' => 'Arbeits Log',
  'LNK_CASE_LIST' => 'Tickets',
  'LNK_CASE_REPORTS' => 'Case Reports',
  'LNK_CREATE' => 'Neuer Fall',
  'LNK_CREATE_WHEN_EMPTY' => 'Erstellen Sie jetzt einen Fall.',
  'LNK_IMPORT_CASES' => 'Tickets importieren',
  'LNK_NEW_CASE' => 'Neues Ticket',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Möchten Sie dieses Ticket wirklich entfernen?',
  'NTC_REMOVE_INVITEE' => 'Möchten Sie diesen Kontakt wirklich von diesem Ticket entfernen?',
);

