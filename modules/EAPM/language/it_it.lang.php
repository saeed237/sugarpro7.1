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
  'LBL_ACTIVE' => 'Attivo',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Attività',
  'LBL_API_CONSKEY' => 'Consumer Key',
  'LBL_API_CONSSECRET' => 'Consumer Secret',
  'LBL_API_DATA' => 'Dati API',
  'LBL_API_OAUTHTOKEN' => 'OAuth Token',
  'LBL_API_TYPE' => 'Tipo Login',
  'LBL_APPLICATION' => 'Applicazione',
  'LBL_APPLICATION_FOUND_NOTICE' => 'Per questa applicazione esiste già un account. Abbiamo ripristinato l´account esistente.',
  'LBL_ASSIGNED_TO_ID' => 'Id Utente assegnato',
  'LBL_ASSIGNED_TO_NAME' => 'Utente Sugar',
  'LBL_AUTH_ERROR' => 'Tentativo di autenticazione dell´account esterno fallito.',
  'LBL_AUTH_UNSUPPORTED' => 'Questa modalità di autorizzazione non è supportata dall´pplicazione.',
  'LBL_BASIC_SAVE_NOTICE' => 'Clicca Salva per creare il record dell´account esterno. In seguito Sugar convaliderà le tue credenziali.',
  'LBL_CONNECTED' => 'Connesso',
  'LBL_CONNECT_BUTTON_TITLE' => 'Connetti',
  'LBL_CREATED' => 'Creato Da',
  'LBL_CREATED_ID' => 'Creato Da Id',
  'LBL_CREATED_USER' => 'Creato dall´Utente',
  'LBL_DATE_ENTERED' => 'Data Creazione',
  'LBL_DATE_MODIFIED' => 'Data Modifica',
  'LBL_DELETED' => 'Eliminato',
  'LBL_DESCRIPTION' => 'Descrizione',
  'LBL_DISCONNECTED' => 'Non connesso',
  'LBL_DISPLAY_PROPERTIES' => 'Visualizza Proprietà',
  'LBL_ERR_FACEBOOK' => 'Facebook ha riscontrato un errore, e i feed non possono essere visualizzati.',
  'LBL_ERR_FAILED_QUICKCHECK' => 'Al momento non sei connesso al tuo {0} account. Clicca OK per rieffettuare il login al tuo account e attivare il record dell´account esterno.',
  'LBL_ERR_NO_AUTHINFO' => 'Non ci sono informazioni relative all´autenticazione per questo account.',
  'LBL_ERR_NO_RESPONSE' => 'Si è verificato un errore nel salvataggio dell´account esterno.',
  'LBL_ERR_NO_TOKEN' => 'Non ci sono tokens di login validi per questo account.',
  'LBL_ERR_OAUTH_FACEBOOK_1' => 'La sessione di Facebook è scaduta. Per ottenere lo stream, si prega di',
  'LBL_ERR_OAUTH_FACEBOOK_2' => 'accedere nuovamente a Facebook',
  'LBL_ERR_POPUPS_DISABLED' => 'Si prega di abilitare le finestre popup del browser o di aggiungere un´eccezione per il sito "{0}" alla lista delle eccezioni al fine di connettersi.',
  'LBL_ERR_TWITTER' => 'Twitter ha riscontrato un errore, e i feed non possono essere visualizzati',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Visualizza Cronologia',
  'LBL_HOMEPAGE_TITLE' => 'I miei Accounts Esterni',
  'LBL_ID' => 'ID',
  'LBL_LIST_FORM_TITLE' => 'Elenco Account Esterni',
  'LBL_LIST_NAME' => 'Nome',
  'LBL_MEET_NOW_BUTTON' => 'Meet Now',
  'LBL_MODIFIED' => 'Modificato Da',
  'LBL_MODIFIED_ID' => 'Modificato Da Id',
  'LBL_MODIFIED_NAME' => 'Modificato dal Nome',
  'LBL_MODIFIED_USER' => 'Modificato dall´Utente',
  'LBL_MODULE_NAME' => 'Account Esterno',
  'LBL_MODULE_NAME_SINGULAR' => 'Account Esterno',
  'LBL_MODULE_TITLE' => 'Accounts Esterni',
  'LBL_NAME' => 'Nome Utente App',
  'LBL_NEW_FORM_TITLE' => 'Nuovo Account Esterno',
  'LBL_NOTE' => 'Nota',
  'LBL_OAUTH_NAME' => '%s',
  'LBL_OAUTH_SAVE_NOTICE' => 'Clicca Salva per creare il record dell´account esterno. Sarai indirizzato in una pagina in cui dovrai inserire le informazioni del tuo account per autorizzare l´accesso da Sugar. Dopo aver inserito le informazioni sul tuo account, sarai rindirizzato in Sugar.',
  'LBL_OMIT_URL' => '(Ometti http:// o https://)',
  'LBL_PASSWORD' => 'Password App',
  'LBL_REAUTHENTICATE_KEY' => 'a',
  'LBL_REAUTHENTICATE_LABEL' => 'Riautenticazione',
  'LBL_SEARCH_FORM_TITLE' => 'Ricerca sorgente esterna',
  'LBL_SUGAR_EAPM_SUBPANEL_TITLE' => 'Accounts Esterni',
  'LBL_SUGAR_USER_NAME' => 'Utente Sugar',
  'LBL_TEAM' => 'Gruppi',
  'LBL_TEAMS' => 'Gruppi',
  'LBL_TEAM_ID' => 'Id Gruppo',
  'LBL_TITLE_LOTUS_LIVE_DOCUMENTS' => 'Documenti di LotusLive™',
  'LBL_TITLE_LOTUS_LIVE_MEETINGS' => 'Riunioni di LotusLive™ pianificate',
  'LBL_URL' => 'URL',
  'LBL_USER_NAME' => 'Nome Utente App',
  'LBL_VALIDATED' => 'Accesso convalidato',
  'LBL_VIEW_LOTUS_LIVE_DOCUMENTS' => 'Visualizza i Documenti di LotusLive™',
  'LBL_VIEW_LOTUS_LIVE_MEETINGS' => 'Visualizza le Riunioni di LotusLive™ pianificate',
  'LNK_IMPORT_SUGAR_EAPM' => 'Importa Accounts Esterni',
  'LNK_LIST' => 'Visualizza Accounts Esterni',
  'LNK_NEW_RECORD' => 'Crea un Account Esterno',
);

