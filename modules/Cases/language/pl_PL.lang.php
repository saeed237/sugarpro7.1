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
  'ERR_DELETE_RECORD' => 'Musisz podać numer rekordu, aby usunąć to kontrahenta.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Kontrahenci',
  'LBL_ACCOUNT_ID' => 'ID kontrahenta',
  'LBL_ACCOUNT_NAME' => 'Nazwa kontrahenta:',
  'LBL_ACCOUNT_NAME_MOD' => 'Mod nazwa kontrahenta',
  'LBL_ACCOUNT_NAME_OWNER' => 'Właściciel nazwa kontrahenta',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Wydarzenia',
  'LBL_ASSIGNED_TO_NAME' => 'Przydzielono do',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Mod przypisany do',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Właściciel przypisany do',
  'LBL_ATTACH_NOTE' => 'Załącz notatkę',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Błędy',
  'LBL_CASE' => 'Zgłoszenie:',
  'LBL_CASE_INFORMATION' => 'Informacje',
  'LBL_CASE_NUMBER' => 'Numer zgłoszenia:',
  'LBL_CASE_SUBJECT' => 'Temat zgłoszenia:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CONTACT_CASE_TITLE' => 'Zgłoszenie - kontakt:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Wiadomości e-mail powiązanych kontaktów',
  'LBL_CONTACT_NAME' => 'Nazwa kontaktu:',
  'LBL_CONTACT_ROLE' => 'Rola:',
  'LBL_CREATED_BY_NAME_MOD' => 'Mod stworzone przez',
  'LBL_CREATED_BY_NAME_OWNER' => 'Właściciel stworzone przez',
  'LBL_CREATED_USER' => 'Utworzony użytkownik',
  'LBL_CREATE_KB_DOCUMENT' => 'Utwórz artykuł',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Zgłoszenia',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Dokumenty',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Przydzielony do',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Przypisany do',
  'LBL_EXPORT_CREATED_BY' => 'Utworzony przez',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Utworzony przez',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Zmodyfikowany przez',
  'LBL_EXPORT_TEAM_COUNT' => 'Liczebność zespołu',
  'LBL_FILENANE_ATTACHMENT' => 'Plik załącznika',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_INVITEE' => 'Kontakty',
  'LBL_LIST_ACCOUNT_NAME' => 'Nazwa kontrahenta',
  'LBL_LIST_ASSIGNED' => 'Przydzielono do',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Przydzielono do',
  'LBL_LIST_CLOSE' => 'Zamknij',
  'LBL_LIST_DATE_CREATED' => 'Data utworzenia',
  'LBL_LIST_FORM_TITLE' => 'Lista zgłoszeń',
  'LBL_LIST_LAST_MODIFIED' => 'Ostatnio zmodyfikowano',
  'LBL_LIST_MY_CASES' => 'Bieżące zgłoszenia',
  'LBL_LIST_NUMBER' => 'Nr',
  'LBL_LIST_PRIORITY' => 'Priorytet',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Temat',
  'LBL_MEMBER_OF' => 'Kontrahent',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Zmodyfikowano przez',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Zmodyfikowano przez',
  'LBL_MODIFIED_USER' => 'Zmodyfikowany użytkownik',
  'LBL_MODIFIED_USER_NAME' => 'Zmodfikowane przez',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Mod zmodyfikowane przez',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Właściciel zmodyfikowane przez',
  'LBL_MODULE_NAME' => 'Zgłoszenia',
  'LBL_MODULE_NAME_SINGULAR' => 'Zgłoszenie',
  'LBL_MODULE_TITLE' => 'Zgłoszenia: Strona główna',
  'LBL_NEW_FORM_TITLE' => 'Utwórz zgłoszenie',
  'LBL_NUMBER' => 'Numer:',
  'LBL_PORTAL_VIEWABLE' => 'Portal widoczny',
  'LBL_PRIORITY' => 'Priorytet:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Projekty',
  'LBL_RESOLUTION' => 'Stan:',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie',
  'LBL_SHOW_IN_PORTAL' => 'Pokaż w Portalu',
  'LBL_SHOW_MORE' => 'Pokaż więcej zgłoszeń',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Temat:',
  'LBL_SYSTEM_ID' => 'ID systemu',
  'LBL_TEAM_COUNT_MOD' => 'Mod Liczebność zespołu',
  'LBL_TEAM_COUNT_OWNER' => 'Właściciel Liczebność zespołu',
  'LBL_TEAM_NAME_MOD' => 'Mod nazwa zespołu',
  'LBL_TEAM_NAME_OWNER' => 'Właściciel nazwa zespołu',
  'LBL_TYPE' => 'Typ',
  'LBL_WORK_LOG' => 'Dziennik pracy',
  'LNK_CASE_LIST' => 'Zgłoszenia',
  'LNK_CASE_REPORTS' => 'Raporty zgłoszeń',
  'LNK_CREATE' => 'Utwórz zgłoszenie',
  'LNK_CREATE_WHEN_EMPTY' => 'Utwórz teraz zgłoszenie.',
  'LNK_IMPORT_CASES' => 'Importuj zgłoszenia',
  'LNK_NEW_CASE' => 'Utwórz zgłoszenie',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Czy na pewno chcesz usunąć to zgłoszenie z błędu?',
  'NTC_REMOVE_INVITEE' => 'Czy na pewno chcesz usunąć ten kontakt ze zgłoszenia?',
);

