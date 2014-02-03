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
  'ERR_DELETE_RECORD' => 'Per eliminare l´azienda deve essere specificato il numero del record.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Aziende',
  'LBL_ACCOUNT_ID' => 'ID Azienda',
  'LBL_ACCOUNT_NAME' => 'Nome azienda:',
  'LBL_ACCOUNT_NAME_MOD' => 'Account Name Mod',
  'LBL_ACCOUNT_NAME_OWNER' => 'Account Name Owner',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Attività',
  'LBL_ASSIGNED_TO_NAME' => 'Assegnato a',
  'LBL_ASSIGNED_USER_NAME_MOD' => 'Assigned User Name Mod',
  'LBL_ASSIGNED_USER_NAME_OWNER' => 'Assigned User Name Owner',
  'LBL_ATTACH_NOTE' => 'Allega nota',
  'LBL_BUGS_SUBPANEL_TITLE' => 'Bug',
  'LBL_CASE' => 'Reclamo:',
  'LBL_CASE_INFORMATION' => 'Informazioni Reclamo',
  'LBL_CASE_NUMBER' => 'Numero Reclamo:',
  'LBL_CASE_SUBJECT' => 'Oggetto Reclamo:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contatti',
  'LBL_CONTACT_CASE_TITLE' => 'Contatto - Reclamo:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Email Contatti Relazionati',
  'LBL_CONTACT_NAME' => 'Nome Contatto:',
  'LBL_CONTACT_ROLE' => 'Ruolo:',
  'LBL_CREATED_BY_NAME_MOD' => 'Created By Name Mod',
  'LBL_CREATED_BY_NAME_OWNER' => 'Created By Name Owner',
  'LBL_CREATED_USER' => 'Utente Creato',
  'LBL_CREATE_KB_DOCUMENT' => 'Crea Articolo',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Reclami',
  'LBL_DESCRIPTION' => 'Descrizione:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documenti',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID Utente Assegnato',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Nome Utente Assegnato',
  'LBL_EXPORT_CREATED_BY' => 'Creato da ID',
  'LBL_EXPORT_CREATED_BY_NAME' => 'Creato da Nome Utente',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificato da ID',
  'LBL_EXPORT_TEAM_COUNT' => 'Totale Gruppo',
  'LBL_FILENANE_ATTACHMENT' => 'File Allegato',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Cronologia',
  'LBL_INVITEE' => 'Contatti',
  'LBL_LIST_ACCOUNT_NAME' => 'Nome Azienda',
  'LBL_LIST_ASSIGNED' => 'Assegnato A',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Utente Assegnato:',
  'LBL_LIST_CLOSE' => 'Chiuso',
  'LBL_LIST_DATE_CREATED' => 'Data Creazione',
  'LBL_LIST_FORM_TITLE' => 'Elenco Reclami',
  'LBL_LIST_LAST_MODIFIED' => 'Ultima Modifica',
  'LBL_LIST_MY_CASES' => 'I miei Reclami Aperti',
  'LBL_LIST_NUMBER' => 'Num.',
  'LBL_LIST_PRIORITY' => 'Priorità',
  'LBL_LIST_STATUS' => 'Stato',
  'LBL_LIST_SUBJECT' => 'Oggetto',
  'LBL_MEMBER_OF' => 'Azienda',
  'LBL_MODIFIED_BY_NAME_MOD' => 'Modified By Name Mod',
  'LBL_MODIFIED_BY_NAME_OWNER' => 'Modified By Name Owner',
  'LBL_MODIFIED_USER' => 'Utente Modificato',
  'LBL_MODIFIED_USER_NAME' => 'Nome Utente Modificato',
  'LBL_MODIFIED_USER_NAME_MOD' => 'Modified User Name Mod',
  'LBL_MODIFIED_USER_NAME_OWNER' => 'Modified User Name Owner',
  'LBL_MODULE_NAME' => 'Reclami',
  'LBL_MODULE_NAME_SINGULAR' => 'Reclamo',
  'LBL_MODULE_TITLE' => 'Reclami: Home',
  'LBL_NEW_FORM_TITLE' => 'Nuovo Reclamo',
  'LBL_NUMBER' => 'Numero:',
  'LBL_PORTAL_VIEWABLE' => 'Area di visualizzazione del portale',
  'LBL_PRIORITY' => 'Priorità:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Progetti',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Progetti',
  'LBL_RESOLUTION' => 'Soluzione:',
  'LBL_SEARCH_FORM_TITLE' => 'Cerca Reclamo',
  'LBL_SHOW_IN_PORTAL' => 'Mostra nel Portale',
  'LBL_SHOW_MORE' => 'Mostra Più Reclami',
  'LBL_STATUS' => 'Stato:',
  'LBL_SUBJECT' => 'Oggetto:',
  'LBL_SYSTEM_ID' => 'ID Sistema',
  'LBL_TEAM_COUNT_MOD' => 'Team Count Mod',
  'LBL_TEAM_COUNT_OWNER' => 'Team Count Owner',
  'LBL_TEAM_NAME_MOD' => 'Team Name Mod',
  'LBL_TEAM_NAME_OWNER' => 'Team Name Owner',
  'LBL_TYPE' => 'Tipo',
  'LBL_WORK_LOG' => 'Work Log',
  'LNK_CASE_LIST' => 'Visualizza Reclami',
  'LNK_CASE_REPORTS' => 'Visualizza Report dei Reclami',
  'LNK_CREATE' => 'Nuovo Reclamo',
  'LNK_CREATE_WHEN_EMPTY' => 'Crea un Reclamo adesso.',
  'LNK_IMPORT_CASES' => 'Importa Reclami',
  'LNK_NEW_CASE' => 'Nuovo Reclamo',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => 'Sei sicuro di voler rimuovere il reclamo dal bug?',
  'NTC_REMOVE_INVITEE' => 'Sei sicuro di voler rimuovere questo contatto dal reclamo?',
);

