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
  'ERROR_EMPTY_RECORD_ID' => 'Chyba: ID Záznamu nebol špecifikovaný alebo je prázdny.',
  'ERROR_EMPTY_SOURCE_ID' => 'Chyba: ID Zdroja nebol špecifikovaný alebo je prázdny.',
  'ERROR_EMPTY_WRAPPER' => 'Chyba: Nemožno načítal obálku inštancie pre zdroj [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Chyba:  Nebolí nájdené žiadne rozširuhúce informácie pre tento záznam.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Chyba: Žiadne zmapované konektory pre tento modul.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Chyba: Žiadne zmapované polia modulu, pre zobrazenie vo výsledkoch. Prosím, kontaktujte správcu systému/Administrátora.',
  'ERROR_NO_FIELDS_MAPPED' => 'Chyba: Musíte namapovať apoň jedno pole Konektora do poľa modulu, pre vstup do každého modulu.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Žiadne moduly neboli povolené pre tento konektor. Vyberte modul pre tento konektor na stránke Povolenie konektorov.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Chyba: Žiadne konektory, povolené pre vyhľadávanie definovaných polí.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Chyba: Žiadne polia definované pre vyhľadávanie pre tento modul a konektor. Prosím, kontaktujte správcu systému/Administrátora.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Chyba: Súbor sourcedefs.php nebol nájdený.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Chyba: Žiadne zdroje špecifikované k obnove údajov.',
  'ERROR_RECORD_NOT_SELECTED' => 'Chyba: Prosím, pre pokračovaním vyberte záznam zo zoznamu.',
  'LBL_ADDRCITY' => 'Mesto:',
  'LBL_ADDRCOUNTRY' => 'Krajina:',
  'LBL_ADDRCOUNTRY_ID' => 'Krajina ID',
  'LBL_ADDRSTATEPROV' => 'Kraj:',
  'LBL_ADD_MODULE' => 'Pridať',
  'LBL_ADMINISTRATION' => 'Správa konektorov',
  'LBL_ADMINISTRATION_MAIN' => 'Nastavenie konektorov',
  'LBL_AVAILABLE' => 'Dostupné',
  'LBL_BACK' => '< Späť',
  'LBL_CLOSE' => 'Zavrieť',
  'LBL_COMPANY_ID' => 'ID Spoločnosti',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Niektoré požadované údaje neboli vyplnené. Pokračovať v uložení zmien?',
  'LBL_CONNECTOR' => 'Konektor',
  'LBL_CONNECTOR_FIELDS' => 'Polia konektora',
  'LBL_DATA' => 'Údaje',
  'LBL_DEFAULT' => 'Prednastavený',
  'LBL_DELETE_MAPPING_ENTRY' => 'Ste si istý, že chcete vymazať tento vstup?',
  'LBL_DISABLED' => 'Zakázané',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Žiadne zhody pre vaše vyhľadávacie kritériá neboli nájdené.',
  'LBL_ENABLED' => 'Povolené',
  'LBL_EXTERNAL' => 'Povoliť užívateľom vytvárať záznamy externých účtov k tomuto konektoru. Za účelom uplatňovania konektora, vlastnosti by mali byť určené na stránke nastavení Nastavenie vlastností konektora',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Za účelom uplatňovania tohto konektora, vlastnosti by mali byť nastavené v Nastavenie konektora, na stránke nastavení',
  'LBL_FINSALES' => 'Ročný predaj',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Trhová kapitalizácia',
  'LBL_MERGE' => 'Zlúčiť',
  'LBL_MODIFY_DISPLAY_DESC' => 'Vybrať, ktoré moduly budú povolené pre každý konektor.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Nastavenia konektora: Povoliť konektory',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Povoliť konektory',
  'LBL_MODIFY_MAPPING_DESC' => 'Mapa polí konektora do polí modulu, za účelom vymedzenia dát, ktoré majú byť zobrazené a zlužované do záznamov modulu.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Nastavenie konektora: Mapa polí konektora',
  'LBL_MODIFY_MAPPING_TITLE' => 'Mapa polí konektora',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Configurovať vlastnosti pre každý konektor, vrátane URL adries a API kľúčov.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Nastavenie konektora: Nastavenie vlastností konektora',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Nastavenie vlastností konektora',
  'LBL_MODIFY_SEARCH' => 'Vyhľadávanie',
  'LBL_MODIFY_SEARCH_DESC' => 'Výber polí konektora k vyhľadávaniu pre každý modul.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Nastavenie konektora: Správa prehľadávania konektorov',
  'LBL_MODIFY_SEARCH_TITLE' => 'Správa prehľadávania konektorov',
  'LBL_MODULE_FIELDS' => 'Polia modulu',
  'LBL_MODULE_NAME' => 'Konektory',
  'LBL_MODULE_NAME_SINGULAR' => 'Konektor',
  'LBL_NO_PROPERTIES' => 'Tu nie sú konfigurovateľné vlastnosti pre tento konektor.',
  'LBL_PARENT_DUNS' => 'Nadriadený DUNS',
  'LBL_PREVIOUS' => '< Späť',
  'LBL_QUOTE' => 'Ponuka',
  'LBL_RECNAME' => 'Názov spoločnosti',
  'LBL_RESET_BUTTON_TITLE' => 'Reset',
  'LBL_RESET_TO_DEFAULT' => 'Reset do prednastavenia',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Ste si istý, že chcete resetovať do prednastavenej konfigurácii?',
  'LBL_RESULT_LIST' => 'Prehľad údajov',
  'LBL_RUN_WIZARD' => 'Spustiť sprievodcu',
  'LBL_SAVE' => 'Uložiť',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Vyhľadávanie...',
  'LBL_SHOW_IN_LISTVIEW' => 'Zobraziť v zlúčenom zozname',
  'LBL_SMART_COPY' => 'Smart Copy',
  'LBL_STEP1' => 'Údaje vyhľadať a zobraziť',
  'LBL_STEP2' => 'Zlúčiť záznam s',
  'LBL_SUMMARY' => 'Sumár',
  'LBL_TEST_SOURCE' => 'Test konektora',
  'LBL_TEST_SOURCE_FAILED' => 'Test zlyhal',
  'LBL_TEST_SOURCE_RUNNING' => 'Vykonávanie testu...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test bol úspešný',
  'LBL_TITLE' => 'Zlúčenie údajov',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Konečné nadriadené DUNS',
);

