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
  'ERROR_EMPTY_RECORD_ID' => 'Fehler: Satz ID nicht angegeben oder leer.',
  'ERROR_EMPTY_SOURCE_ID' => 'Fehler: Quell ID nicht angegeben oder leer.',
  'ERROR_EMPTY_WRAPPER' => 'Fehler: Kann keine Wrapper Instanz für die Quelle holen [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Fehler: Für diesen Eintrag wurden keine weiteren Details gefunden.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Fehler: Zu diesem Modul sind keine Konnektoren zugeordnet.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Fehler: Es wurden keine Modulfelder für die Anzeige des Resultats zugeordnet. Bitte kontaktieren Sie den Systemadministrator.',
  'ERROR_NO_FIELDS_MAPPED' => 'Fehler: Sie müssen für jeden Moduleintrag zumindest ein Konnektorfeld einem Modulfeld zuordnen.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Für diesen Konnektor wurden keine Module aktiviert. Wählen Sie ein Modul für diesen Konnektor auf der Seite Konnektor aktivieren.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'ERROR: es sind keine Verbindungen vorhanden für die derartige Felder definiert sind.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Fehler: Es wurden keine Suchfelder für Konnektor und Modul definiert. Bitte kontaktieren Sie den Systemadministrator.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Fehler: Keine sourcedefs.php Datei gefunden.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Fehler: Es wurden keine Quellen angegeben von denen Daten geholt werden sollten',
  'ERROR_RECORD_NOT_SELECTED' => 'Fehler: Bitte wählen Sie einen Eintrag aus bevor SIe weitermachen.',
  'LBL_ADDRCITY' => 'Stadt',
  'LBL_ADDRCOUNTRY' => 'Land',
  'LBL_ADDRCOUNTRY_ID' => 'Länder ID',
  'LBL_ADDRSTATEPROV' => 'Bundesland',
  'LBL_ADD_MODULE' => 'Hinzufügen',
  'LBL_ADMINISTRATION' => 'Konnektor Verwaltung',
  'LBL_ADMINISTRATION_MAIN' => 'Konnektor Einstellungen',
  'LBL_AVAILABLE' => 'Verfügbar',
  'LBL_BACK' => '< Zurück',
  'LBL_CLOSE' => 'Beenden',
  'LBL_COMPANY_ID' => 'Firmen ID',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Einige erforderliche Felder sind leer. Wollen Sie Ihre Änderungen sichern?',
  'LBL_CONNECTOR' => 'Konnektor',
  'LBL_CONNECTOR_FIELDS' => 'Konnektorfelder',
  'LBL_DATA' => 'Daten',
  'LBL_DEFAULT' => 'Standard',
  'LBL_DELETE_MAPPING_ENTRY' => 'Sind Sie sicher, dass Sie diesen Eintrag löschen wollen?',
  'LBL_DISABLED' => 'Inaktiv',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Keine passenden Treffer für Ihre Suchkriterien.',
  'LBL_ENABLED' => 'Aktiv',
  'LBL_EXTERNAL' => 'Konnektor erlaubt User externe Kontendatensätze anzulegen',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Um diesen Konnektor zu verwenden, bitte die Werte in das Dialog "Konnektor Eigenschaften" setzen.',
  'LBL_FINSALES' => 'Umsatz',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Marktkapitalisierung',
  'LBL_MERGE' => 'Zusammenführen',
  'LBL_MODIFY_DISPLAY_DESC' => 'Wählen Sie aus, welche Module für den jeweiligen Konnektor aktiviert werden sollen',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Konnektor Einstellungen: Konnektoren aktivieren',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Konnektoren aktivieren',
  'LBL_MODIFY_MAPPING_DESC' => 'Ordnen Sie Konnektorfelder den Modulfeldern zu um zu bestimmen, welche Konnektordaten gesehen bzw. in die Moduleinträge mit einbezogen werden sollen.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Konnektor Einstellungen: Konnektorfelder zuordnen',
  'LBL_MODIFY_MAPPING_TITLE' => 'Konnektorfelder zuordnen',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Konfigurieren Sie die Einstellungen für jeden Konnektor, inklusive URLs und API Schlüsseln.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Konnektor Einstellungen: Konnektoreigenschaften setzen',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Konnektoreigenschaften setzen',
  'LBL_MODIFY_SEARCH' => 'Suchen',
  'LBL_MODIFY_SEARCH_DESC' => 'Wählen Sie die Konnektorfelder aus mit denen in dem jeweiligen Modul nach Daten gesucht werden soll.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Konnektor Einstellungen: Konnektorsuche verwalten',
  'LBL_MODIFY_SEARCH_TITLE' => 'Konnektorsuche verwalten',
  'LBL_MODULE_FIELDS' => 'Modulfelder',
  'LBL_MODULE_NAME' => 'Konnektoren',
  'LBL_MODULE_NAME_SINGULAR' => 'Konnektor',
  'LBL_NO_PROPERTIES' => 'Für diesen Konnektor gibt es keine konfigurierbaren Eigenschaften',
  'LBL_PARENT_DUNS' => 'Mutter DUNS',
  'LBL_PREVIOUS' => '< Zurück',
  'LBL_QUOTE' => 'Angebot',
  'LBL_RECNAME' => 'Firmenname',
  'LBL_RESET_BUTTON_TITLE' => 'Zurücksetzen [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Zurücksetzen auf Standard',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Sind Sie sicher dass Sie auf die Standardeinstellungen zurücksetzen wollen?',
  'LBL_RESULT_LIST' => 'Datenliste',
  'LBL_RUN_WIZARD' => 'Assistent starten',
  'LBL_SAVE' => 'Speichern',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Suche...',
  'LBL_SHOW_IN_LISTVIEW' => 'In der Zusammenführen Ansicht anzeigen',
  'LBL_SMART_COPY' => 'Intelligente Kopie',
  'LBL_STEP1' => 'Daten suchen und betrachten',
  'LBL_STEP2' => 'Einträge verbinden mit',
  'LBL_SUMMARY' => 'Zusammenfassung',
  'LBL_TEST_SOURCE' => 'Test Konnektor',
  'LBL_TEST_SOURCE_FAILED' => 'Test nicht erfolgreich',
  'LBL_TEST_SOURCE_RUNNING' => 'Führe Test aus...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test erfolgreich',
  'LBL_TITLE' => 'Daten verbinden',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Letzte Mutter DUNS',
);

