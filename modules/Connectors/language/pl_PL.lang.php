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
  'ERROR_EMPTY_RECORD_ID' => 'Błąd: ID rekordu jest nieokreślone lub puste.',
  'ERROR_EMPTY_SOURCE_ID' => 'Błąd: ID źródła jest nieokreślone lub puste.',
  'ERROR_EMPTY_WRAPPER' => 'Błąd: Nie można otrzymać instancji dla źródła [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Błąd: Nie znaleziono dodatkowych szczegółów dla tego rekordu.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Bład: Nie ma konektorów zmapowanych do tego modułu.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Bład: Nie ma zdefiniowanych pól modułu, które zostały zamapowane do wyświetlenia w wynikach . Skontaktuj się z administratorem systemu.',
  'ERROR_NO_FIELDS_MAPPED' => 'Błąd: Musisz zmapować co najmniej jedno pole konektora do pola modułu dla każdego wybranego modułu.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Żadne moduły nie zostały włączone dla tego konektora. Wybierz moduł dla tego konektora na stronie <b>Włączanie konektorów</b>.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Błąd: Nie znaleziono aktywnych konektorów, które mają zdefiniowane pola wyszukiwania.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Bład: Nie ma zdefiniowanych pól wyszukiwania dla modułu i konektora. Skontaktuj się z administratorem systemu.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Błąd: Nie odnaleziono pliku sourcedefs.php.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Błąd: Nie określono źródeł, z których należało pobrać dane.',
  'ERROR_RECORD_NOT_SELECTED' => 'Błąd: Proszę wybrać rekord z listy.',
  'LBL_ADDRCITY' => 'Miejscowość',
  'LBL_ADDRCOUNTRY' => 'Kraj',
  'LBL_ADDRCOUNTRY_ID' => 'ID kraju',
  'LBL_ADDRSTATEPROV' => 'Województwo',
  'LBL_ADD_MODULE' => 'Dodaj',
  'LBL_ADMINISTRATION' => 'Administracja konektorów',
  'LBL_ADMINISTRATION_MAIN' => 'Ustawienia konektora',
  'LBL_AVAILABLE' => 'Dostępne',
  'LBL_BACK' => '< Wstecz',
  'LBL_CLOSE' => 'Zamknij',
  'LBL_COMPANY_ID' => 'ID przedsiębiorstwa',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Niektóre wymagane pola są puste.  Kontynuować zapisywanie zmian?',
  'LBL_CONNECTOR' => 'Konektor',
  'LBL_CONNECTOR_FIELDS' => 'Pola konektora',
  'LBL_DATA' => 'Dane',
  'LBL_DEFAULT' => 'Domyślne',
  'LBL_DELETE_MAPPING_ENTRY' => 'Czy na pewno chcesz usunąć ten wpis?',
  'LBL_DISABLED' => 'Nie',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Nie znaleziono wyników pasujących do kryteriów wyszukiwania.',
  'LBL_ENABLED' => 'Tak',
  'LBL_EXTERNAL' => 'Zezwól użytkownikom na tworzenie zewnętrznych kont do tego konektora.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'By używać tego konektora, właściwości powinny być ustawione na stronie ustawień konektora.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => 'Informacje',
  'LBL_MARKET_CAP' => 'Market Cap',
  'LBL_MERGE' => 'Scal',
  'LBL_MODIFY_DISPLAY_DESC' => 'Wybierz, które konektory zostaną włączone dla poszczególnych modułów.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Ustawienia konektorów: Włączanie konektorów',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Włącz konektory',
  'LBL_MODIFY_MAPPING_DESC' => 'Mapuj pola konektora do pól modułów w celu określnia, które dane konektora będą widoczne i scalone z rekordami modułu.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Ustawienia konektora: Mapuj pola konektora',
  'LBL_MODIFY_MAPPING_TITLE' => 'Mapuj pola konektora',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Konfiguruj właściwości dla każdego konektora, włącznie z adresami URL i kluczami API.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Ustawienia konektorów: Konfiguruj właściwości konektora',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Konfiguruj właściwości konektora',
  'LBL_MODIFY_SEARCH' => 'Wyszukiwanie',
  'LBL_MODIFY_SEARCH_DESC' => 'Wybierz pola konektora, które będą przeszukiwane dla każdego modułu.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Ustawienia konektorów: Zarządzaj wyszukiwaniem w konektorach',
  'LBL_MODIFY_SEARCH_TITLE' => 'Zarządzaj wyszukiwaniem w konektorach',
  'LBL_MODULE_FIELDS' => 'Pola modułu',
  'LBL_MODULE_NAME' => 'Konektory',
  'LBL_MODULE_NAME_SINGULAR' => 'Konektor',
  'LBL_NO_PROPERTIES' => 'Nie ma konfigurowalnych właściwości dla tego konektora.',
  'LBL_PARENT_DUNS' => 'Nadrzędne DUNS',
  'LBL_PREVIOUS' => '< Wstecz',
  'LBL_QUOTE' => 'Zapytanie',
  'LBL_RECNAME' => 'Nazwa kontrahenta',
  'LBL_RESET_BUTTON_TITLE' => 'Przywróć',
  'LBL_RESET_TO_DEFAULT' => 'Przywróć domyślne ustawienia',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Czy na pewno chcesz przywrócić ustawienia domyślne?',
  'LBL_RESULT_LIST' => 'Lista danych',
  'LBL_RUN_WIZARD' => 'Uruchom kreatora',
  'LBL_SAVE' => 'Zapisz',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Wyszukiwanie...',
  'LBL_SHOW_IN_LISTVIEW' => 'Pokaż w widoku scalania',
  'LBL_SMART_COPY' => 'Sprytna kopia',
  'LBL_STEP1' => 'Wyszukaj i pokaż dane',
  'LBL_STEP2' => 'Scal rekordy z',
  'LBL_SUMMARY' => 'Podsumowanie',
  'LBL_TEST_SOURCE' => 'Testuj działanie konektora',
  'LBL_TEST_SOURCE_FAILED' => 'Test nie powiódł się',
  'LBL_TEST_SOURCE_RUNNING' => 'Przeprowadzanie testu...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test zakończony powodzeniem',
  'LBL_TITLE' => 'Scalanie danych',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Podstawowy numer jednostki nadrzędnej',
);

