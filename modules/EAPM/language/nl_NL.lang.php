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
  'LBL_ACTIVE' => 'Actief',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activiteiten',
  'LBL_API_CONSKEY' => 'API Consumer Key',
  'LBL_API_CONSSECRET' => 'API Consumer Secret',
  'LBL_API_DATA' => 'API Data',
  'LBL_API_OAUTHTOKEN' => 'API OAuth Token',
  'LBL_API_TYPE' => 'Type Login',
  'LBL_APPLICATION' => 'Applicatie',
  'LBL_APPLICATION_FOUND_NOTICE' => 'Er is reeds een account aanwezig voor deze applicatie. We hebben zojuist uw vorige account opnieuw ingesteld.',
  'LBL_ASSIGNED_TO_ID' => 'Toegewezen Gebruiker Id',
  'LBL_ASSIGNED_TO_NAME' => 'Toegewezen aan',
  'LBL_AUTH_ERROR' => 'Fouten tijdens login: %s',
  'LBL_AUTH_UNSUPPORTED' => 'Deze authorisatiemethodiek wordt niet ondersteund door de applicatie',
  'LBL_BASIC_SAVE_NOTICE' => 'Klik op Opslaan om een externe account regel aan te maken. SugarCRM zal uw referenties controleren.',
  'LBL_CONNECTED' => 'Verbonden',
  'LBL_CONNECT_BUTTON_TITLE' => 'Verbinden',
  'LBL_CREATED' => 'Gemaakt door',
  'LBL_CREATED_ID' => 'Gemaakt door ID',
  'LBL_CREATED_USER' => 'Aangemaakt door Gebruiker',
  'LBL_DATE_ENTERED' => 'Datum ingevoerd',
  'LBL_DATE_MODIFIED' => 'Laatste wijziging',
  'LBL_DELETED' => 'Verwijderd',
  'LBL_DESCRIPTION' => 'Beschrijving',
  'LBL_DISCONNECTED' => 'Niet verbonden',
  'LBL_DISPLAY_PROPERTIES' => 'Eigenschappen voor Tonen',
  'LBL_ERR_FACEBOOK' => 'Facebook geeft een fout terug en de feed kan niet worden weergegeven.',
  'LBL_ERR_FAILED_QUICKCHECK' => 'U bent op dit moment niet ingelogd in uw {0} account. Klik op Ok om opnieuw in te loggen en de externe account te activeren.',
  'LBL_ERR_NO_AUTHINFO' => 'Er is geen authenticatie informatie bij deze account',
  'LBL_ERR_NO_RESPONSE' => 'Er trad een fout op tijdens het opslaan van de externe account.',
  'LBL_ERR_NO_TOKEN' => 'Er zijn geen geldige login tekens voor deze account',
  'LBL_ERR_OAUTH_FACEBOOK_1' => 'Facebook sessie is verlopen. Om Facebook data te krijgen,',
  'LBL_ERR_OAUTH_FACEBOOK_2' => 'log opnieuw in bij Facebook',
  'LBL_ERR_POPUPS_DISABLED' => 'Sta browser pop-up vensters toe of voeg een uitzondering toe voor website "{0}"',
  'LBL_ERR_TWITTER' => 'Twitter geeft een error terug en de feed kan niet worden weergegeven.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Toon Historie',
  'LBL_HOMEPAGE_TITLE' => 'Mijn Externe Accounts',
  'LBL_ID' => 'ID',
  'LBL_LIST_FORM_TITLE' => 'Overzicht Externe Accounts',
  'LBL_LIST_NAME' => 'Naam',
  'LBL_MEET_NOW_BUTTON' => 'Nu vergaderen',
  'LBL_MODIFIED' => 'Gewijzigd door',
  'LBL_MODIFIED_ID' => 'Gewijzigd door ID',
  'LBL_MODIFIED_NAME' => 'Gewijzigd door Naam',
  'LBL_MODIFIED_USER' => 'Gewijzigd door Gebruiker',
  'LBL_MODULE_NAME' => 'Externe Account',
  'LBL_MODULE_NAME_SINGULAR' => 'Externe Account',
  'LBL_MODULE_TITLE' => 'Externe Accounts',
  'LBL_NAME' => 'App Gebruikersnaam',
  'LBL_NEW_FORM_TITLE' => 'Nieuwe Externe Account',
  'LBL_NOTE' => 'Let op',
  'LBL_OAUTH_NAME' => '%s',
  'LBL_OAUTH_SAVE_NOTICE' => 'Klik op Opslaan om de externe account-record maken. U wordt omgeleid naar een pagina om uw account informatie te toegang te verlenen door Sugar in te voeren. Na het ingeven van uw account informatie, wordt u omgeleid naar Sugar.',
  'LBL_OMIT_URL' => '(weglaten http:// of https: / /)',
  'LBL_PASSWORD' => 'App. Wachtwoord:',
  'LBL_REAUTHENTICATE_KEY' => 'a',
  'LBL_REAUTHENTICATE_LABEL' => 'Opnieuw authenticeren',
  'LBL_SEARCH_FORM_TITLE' => 'Zoek externe bron',
  'LBL_SUCCESS' => 'SUCCESS',
  'LBL_SUGAR_EAPM_SUBPANEL_TITLE' => 'Externe Accounts',
  'LBL_SUGAR_USER_NAME' => 'Sugar Gebruiker',
  'LBL_TEAM' => 'Teams',
  'LBL_TEAMS' => 'Teams',
  'LBL_TEAM_ID' => 'Team Id',
  'LBL_TITLE_LOTUS_LIVE_DOCUMENTS' => 'LotusLive™ Documenten',
  'LBL_TITLE_LOTUS_LIVE_MEETINGS' => 'Aankomende LotusLive™ Meetings',
  'LBL_URL' => 'URL',
  'LBL_USER_NAME' => 'App. Gebruikersnaam',
  'LBL_VALIDATED' => 'Toegang geldig',
  'LBL_VIEW_LOTUS_LIVE_DOCUMENTS' => 'Bekijk LotusLive™ Documenten',
  'LBL_VIEW_LOTUS_LIVE_MEETINGS' => 'Bekijk aankomende LotusLive™ Meetings',
  'LNK_IMPORT_SUGAR_EAPM' => 'Importeer Externe Accounts',
  'LNK_LIST' => 'Bekijk Externe Accounts',
  'LNK_NEW_RECORD' => 'Nieuwe Externe Account',
);

