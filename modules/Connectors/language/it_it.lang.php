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
  'ERROR_EMPTY_RECORD_ID' => 'Errore: Id Record non specificato o vuoto.',
  'ERROR_EMPTY_SOURCE_ID' => 'Errore: Id Risorsa non specificata o vuota.',
  'ERROR_EMPTY_WRAPPER' => 'Error: Unable to retrieve wrapper instance for the source [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Errore: Non è stato trovato nessun ulteriore dettaglio per il record.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Errore: Non ci sono connettori mappati per questo modulo.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Errore: Non ci sono campi del modulo mappati per la visualizzazione dei risultati. Si prega di contattare l´amministratore del sistema.',
  'ERROR_NO_FIELDS_MAPPED' => 'Errore: Per ogni voce del modulo deve essere mappato almeno un campo Connettore con il campo con i campi del modulo.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Nessun modulo è stato abilitato per questo connettore. Si prega di selezionare un modulo per questo connettore nella pagina Abilita Connettori.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Errore: Non ci sono connettori attivati con campi di ricerca definiti.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Errore: Non ci sono campi di ricerca definiti per il modulo e per il connettore. Si prega di contattare l´amministratore del sistema.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Errore: nessun file sourcedefs.php è stato trovato.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Errore: Nessuna risorsa è stata specificata per l´archiviazione dei dati.',
  'ERROR_RECORD_NOT_SELECTED' => 'Errore: Si prega, prima di procedere, di selezionare un record dall´elenco.',
  'LBL_ADDRCITY' => 'Comune',
  'LBL_ADDRCOUNTRY' => 'Nazione',
  'LBL_ADDRCOUNTRY_ID' => 'Id Nazione',
  'LBL_ADDRSTATEPROV' => 'Provincia',
  'LBL_ADD_MODULE' => 'Aggiungi',
  'LBL_ADMINISTRATION' => 'Amministrazione Connettori',
  'LBL_ADMINISTRATION_MAIN' => 'Impostazioni Connettori',
  'LBL_AVAILABLE' => 'Disponibile',
  'LBL_BACK' => '< Indietro',
  'LBL_CLOSE' => 'Chiudi',
  'LBL_COMPANY_ID' => 'Id Azienda',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Alcuni dei campi richiesti sono vuoti. Procedere con il salvataggio delle modifiche?',
  'LBL_CONNECTOR' => 'Connettore',
  'LBL_CONNECTOR_FIELDS' => 'Campi del Connettore',
  'LBL_DATA' => 'Dati',
  'LBL_DEFAULT' => 'Predefinito',
  'LBL_DELETE_MAPPING_ENTRY' => 'Sei sicuro di voler cancellare questa voce?',
  'LBL_DISABLED' => 'Disabilitato',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Non è stata trovata nessuna corrispondenza per questi criteri di ricerca.',
  'LBL_ENABLED' => 'Abilitato',
  'LBL_EXTERNAL' => 'Permetti agli utenti di creare record di account esterni a questo connettore. Per utilizzare questo connettore, devi impostare le proprietà dei connettori dalla pagina di Impostazioni Connettori.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Per utilizzare questo connettore, devi impostare le proprietà anche nella pagina di impostazione del connettore.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Market Cap',
  'LBL_MERGE' => 'Unisci',
  'LBL_MODIFY_DISPLAY_DESC' => 'Seleziona quali moduli abilitare per ogni connettore.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Impostazioni Connettore: Abilita Connettori',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Abilita Connettori',
  'LBL_MODIFY_MAPPING_DESC' => 'Mappa i campi dei connettori con i campi dei moduli al fine di determinare quali dati dei connettori possono essere visti e uniti con i record del modulo.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Impostazioni Connettore: Mappa Campi Connettore',
  'LBL_MODIFY_MAPPING_TITLE' => 'Mappa Campi Connettore',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Configura le proprietà per ogni connettore, includendo gli URL e chiavi API.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Impostazioni Connettore: Imposta Proprietà Connettore',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Imposta Proprietà Connettore',
  'LBL_MODIFY_SEARCH' => 'Cerca',
  'LBL_MODIFY_SEARCH_DESC' => 'Seleziona i campi del connettore da usare per la ricerca dei dati per ogni modulo.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Impostazione Connettori: Gestisci Ricerca Connettori',
  'LBL_MODIFY_SEARCH_TITLE' => 'Gestisci Ricerca Connettori',
  'LBL_MODULE_FIELDS' => 'Campi del Modulo',
  'LBL_MODULE_NAME' => 'Connettori',
  'LBL_MODULE_NAME_SINGULAR' => 'Connettore',
  'LBL_NO_PROPERTIES' => 'Non ci sono proprietà configurabili per questo connettore.',
  'LBL_PARENT_DUNS' => 'Parent DUNS',
  'LBL_PREVIOUS' => '< Indietro',
  'LBL_QUOTE' => 'Offerta',
  'LBL_RECNAME' => 'Nome Azienda',
  'LBL_RESET_BUTTON_TITLE' => 'Azzera',
  'LBL_RESET_TO_DEFAULT' => 'Azzera a Predefinito',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Sei sicuro di voler azzerare la configurazione predefinita?',
  'LBL_RESULT_LIST' => 'Elenco Dati',
  'LBL_RUN_WIZARD' => 'Run Wizard',
  'LBL_SAVE' => 'Salva',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Ricerca in corso...',
  'LBL_SHOW_IN_LISTVIEW' => 'Visualizza nell´elenco dei campi da mappare',
  'LBL_SMART_COPY' => 'Copia breve',
  'LBL_STEP1' => 'Cerca e Visualizza i dati',
  'LBL_STEP2' => 'Unisci i records con',
  'LBL_SUMMARY' => 'Sommario',
  'LBL_TEST_SOURCE' => 'Test Connettore',
  'LBL_TEST_SOURCE_FAILED' => 'Test Fallito',
  'LBL_TEST_SOURCE_RUNNING' => 'Esecuzione Test...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test concluso con successo',
  'LBL_TITLE' => 'Unisci Dati',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Ultimate Parent DUNS',
);

