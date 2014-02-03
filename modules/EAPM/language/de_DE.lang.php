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
  'LBL_ACTIVE' => 'Aktiv',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivitäten',
  'LBL_API_CONSKEY' => 'Kunden Schlüssel',
  'LBL_API_CONSSECRET' => 'Kunden Kennwort',
  'LBL_API_DATA' => 'API Daten',
  'LBL_API_OAUTHTOKEN' => 'OAuth Token',
  'LBL_API_TYPE' => 'Logintyp',
  'LBL_APPLICATION' => 'Anwendung',
  'LBL_APPLICATION_FOUND_NOTICE' => 'Ein Konto für diese Anwendung existiert bereits. Das existierende Konto ist wieder aktiviert.',
  'LBL_ASSIGNED_TO_ID' => 'Zugewiesene BenutzerID',
  'LBL_ASSIGNED_TO_NAME' => 'zugeordnet zu',
  'LBL_AUTH_ERROR' => 'Die Verbindung mit diesem Konto war nicht erfolgreich',
  'LBL_AUTH_UNSUPPORTED' => 'Diese Authentifizierungsmethode ist von der Anwendung nicht unterstützt.',
  'LBL_BASIC_SAVE_NOTICE' => 'Verbinden auswählen, um mit diesem Konto mit Sugar zu verbinden',
  'LBL_CONNECTED' => 'Verbunden',
  'LBL_CONNECT_BUTTON_TITLE' => 'Verbinden',
  'LBL_CREATED' => 'Erstellt von',
  'LBL_CREATED_ID' => 'Erstellt von ID',
  'LBL_CREATED_USER' => 'Erstellter Benutzer',
  'LBL_DATE_ENTERED' => 'Erstellt am',
  'LBL_DATE_MODIFIED' => 'Geändert am',
  'LBL_DELETED' => 'Gelöscht',
  'LBL_DESCRIPTION' => 'Beschreibung',
  'LBL_DISCONNECTED' => 'Nicht verbunden',
  'LBL_DISPLAY_PROPERTIES' => 'Anzeigeeigenschaften',
  'LBL_ERR_FACEBOOK' => 'Facebook hat einen Fehler gemeldet, deshalb kann der Feed nicht angezeigt werden.',
  'LBL_ERR_FAILED_QUICKCHECK' => 'Sie sind momentan mit Ihrem Konto verbunden. Bitte OK, um die Verbindung herzustellen.',
  'LBL_ERR_NO_AUTHINFO' => 'Es gibt keine Zugangsdaten für dieses Konto',
  'LBL_ERR_NO_RESPONSE' => 'Ein Fehler ist bei der Verbindung mit diesem Konto aufgetreten',
  'LBL_ERR_NO_TOKEN' => 'Es gibt keine gültigen Tokens für dieses Konto.',
  'LBL_ERR_OAUTH_FACEBOOK_1' => 'Die Facebook Sitzung ist abgelaufen. Um sich zu verbinden bitte',
  'LBL_ERR_OAUTH_FACEBOOK_2' => 'neu bei Facebook anmelden',
  'LBL_ERR_POPUPS_DISABLED' => 'Bitte Browser Popups erlauben oder eine Ausnahme für diese Webseite erlauben, um eine Verbindung aufzubauen.',
  'LBL_ERR_TWITTER' => 'Twitter hat einen Fehler gemeldet, deshalb kann der Feed nicht angezeigt werden.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Verlauf ansehen',
  'LBL_HOMEPAGE_TITLE' => 'Meine externe Konten',
  'LBL_ID' => 'ID',
  'LBL_LIST_FORM_TITLE' => 'Externe Kontenliste',
  'LBL_LIST_NAME' => 'Name',
  'LBL_MEET_NOW_BUTTON' => 'Meeting jetzt',
  'LBL_MODIFIED' => 'Geändert von',
  'LBL_MODIFIED_ID' => 'Geändert von ID',
  'LBL_MODIFIED_NAME' => 'Geändert von Name',
  'LBL_MODIFIED_USER' => 'Geändert von',
  'LBL_MODULE_NAME' => 'Externe Konten',
  'LBL_MODULE_NAME_SINGULAR' => 'Externes Konto',
  'LBL_MODULE_TITLE' => 'Externe Konten',
  'LBL_NAME' => 'Anwendung User Name',
  'LBL_NEW_FORM_TITLE' => 'Neue externe Konten',
  'LBL_NOTE' => 'Hinweis:',
  'LBL_OAUTH_NAME' => '%s',
  'LBL_OAUTH_SAVE_NOTICE' => 'Verbinden auswählen, um Ihre Kontodaten über die Verifizierungsseite aus Sugar zu verifizieren. Nachdem Sie verbunden sind, werden Sie nach Sugar zurückgeschickt',
  'LBL_OMIT_URL' => '( http:// or https:// weglassen)',
  'LBL_PASSWORD' => 'Passwort',
  'LBL_REAUTHENTICATE_KEY' => 'a',
  'LBL_REAUTHENTICATE_LABEL' => 'Revalidieren',
  'LBL_SEARCH_FORM_TITLE' => 'Suche externe Konten',
  'LBL_SUCCESS' => 'Erfolg',
  'LBL_SUGAR_EAPM_SUBPANEL_TITLE' => 'Externe Konten',
  'LBL_SUGAR_USER_NAME' => 'Sugar User',
  'LBL_TEAM' => 'Team',
  'LBL_TEAMS' => 'Teams',
  'LBL_TEAM_ID' => 'Team ID',
  'LBL_TITLE_LOTUS_LIVE_DOCUMENTS' => 'LotusLive&trade; Dateien',
  'LBL_TITLE_LOTUS_LIVE_MEETINGS' => 'Geplante LotusLive&trade; Meetings',
  'LBL_URL' => 'URL',
  'LBL_USER_NAME' => 'Benutzername',
  'LBL_VALIDATED' => 'Verbunden',
  'LBL_VIEW_LOTUS_LIVE_DOCUMENTS' => 'LotusLive&trade; Dateien anschauen',
  'LBL_VIEW_LOTUS_LIVE_MEETINGS' => 'Geplante LotusLive&trade; Meetings anschauen',
  'LNK_IMPORT_SUGAR_EAPM' => 'Externe Konten importieren',
  'LNK_LIST' => 'Externe Konten anschauen',
  'LNK_NEW_RECORD' => 'Externe Konten erstellen',
);

