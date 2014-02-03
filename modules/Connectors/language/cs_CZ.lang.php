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
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Aby bylo možné použít tento konektor, je třeba jej nastavit v Nastavení konektorů',
  'LBL_INFO_INLINE' => 'Informace',
  'LBL_CLOSE' => 'Zavřít',
  'LBL_DATA' => 'Data',
  'LBL_DUNS' => 'DUNS',
  'LBL_ADD_MODULE' => 'Přidat',
  'LBL_ADDRCITY' => 'Město',
  'LBL_ADDRCOUNTRY' => 'Země',
  'LBL_ADDRCOUNTRY_ID' => 'ID země',
  'LBL_ADDRSTATEPROV' => 'Stát',
  'LBL_ADMINISTRATION' => 'Administrace konektoru',
  'LBL_ADMINISTRATION_MAIN' => 'Nastavení konektoru',
  'LBL_AVAILABLE' => 'Dostupnost',
  'LBL_BACK' => '< Zpět',
  'LBL_COMPANY_ID' => 'ID společnosti',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Některé požadované údaje byly ponechány prázdné. Přistoupit k uložení změn?',
  'LBL_CONNECTOR' => 'Konektor',
  'LBL_CONNECTOR_FIELDS' => 'Pole Konektoru',
  'LBL_DEFAULT' => 'Vychozí',
  'LBL_DELETE_MAPPING_ENTRY' => 'Jste si jisti, že chcete smazat tento záznam?',
  'LBL_DISABLED' => 'Zakázán',
  'LBL_EMPTY_BEANS' => 'Pro vaše kritéria vyhledávání nebyly nalezeny žádné záznamy.',
  'LBL_ENABLED' => 'Povolen',
  'LBL_EXTERNAL' => 'Umožnit uživatelům vytvářet externí účty pro tento konektor.Vlastnosti musí být také nastaveny.',
  'LBL_FINSALES' => 'Roční obrat (Finsales)',
  'LBL_MARKET_CAP' => 'Tržní kapitalizace',
  'LBL_MERGE' => 'Spojit',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Povolit konektory',
  'LBL_MODIFY_DISPLAY_DESC' => 'Zvolit, které moduly jsou povoleny pro každý konektor.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Nastavení konektoru: Povolit konektory',
  'LBL_MODULE_FIELDS' => 'Pole mudulu',
  'LBL_MODIFY_MAPPING_TITLE' => 'Zmapovat pole konnektoru',
  'LBL_MODIFY_MAPPING_DESC' => 'Zmapovat pole konnektoru na pole modulu pro zobrazení a spojení dat konektoru do záznamů modulu.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Nastavení konektoru: Zmapovat pole konektoru',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Zvolit nastavení konektoru',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Nastavit vlastnosti pro každý konektor, včetně adres URL a API klíče.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Nastavení konektoru: Nastavit vlastnosti konektoru',
  'LBL_MODIFY_SEARCH_TITLE' => 'Spravovat vyhledávání konektoru',
  'LBL_MODIFY_SEARCH' => 'Vyhledávání',
  'LBL_MODIFY_SEARCH_DESC' => 'Vyberte pole konektoru pro vyhledávání dát pro každý modul.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Nastavení konektoru: Spravovat vyhledávání konektoru',
  'LBL_MODULE_NAME' => 'Konektory',
  'LBL_NO_PROPERTIES' => 'Nejsou žádné konfigurovatelné vlastnosti tohoto konektoru.',
  'LBL_PARENT_DUNS' => 'Rodičovské DUNS',
  'LBL_PREVIOUS' => '< Zpět',
  'LBL_QUOTE' => 'Nabídka',
  'LBL_RECNAME' => 'Název společnosti',
  'LBL_RESET_TO_DEFAULT' => 'Nastavit výchozí',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Jste si jisti, že chcete obnovit výchozí nastavení?',
  'LBL_RESET_BUTTON_TITLE' => 'Obnovit [Alt+R]',
  'LBL_RESULT_LIST' => 'Seznam dat',
  'LBL_RUN_WIZARD' => 'Spustit průvodce',
  'LBL_SAVE' => 'Uložit',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Vyhledávání...',
  'LBL_SHOW_IN_LISTVIEW' => 'Zobrazit v spojeném zobrazení seznamu',
  'LBL_SMART_COPY' => 'Chytré kopírování',
  'LBL_SUMMARY' => 'Souhrn',
  'LBL_STEP1' => 'Vyhledat a prohlédnout data',
  'LBL_STEP2' => 'Spojit záznamy s',
  'LBL_TEST_SOURCE' => 'Otestovat konektor',
  'LBL_TEST_SOURCE_FAILED' => 'Test selhal',
  'LBL_TEST_SOURCE_RUNNING' => 'Probíha test...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test úspěšný',
  'LBL_TITLE' => 'Spojit data',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Konečné mateřské DUNS',
  'ERROR_RECORD_NOT_SELECTED' => 'Chyba: Prosím, vyberte záznam ze seznamu před pokračováním.',
  'ERROR_EMPTY_WRAPPER' => 'Chyba: Nepodařilo se získat obal(wrapper) pro zdroj [{$source_id}]',
  'ERROR_EMPTY_SOURCE_ID' => 'Chyba: ID zdroje nebylo zadáno nebo je prázdné.',
  'ERROR_EMPTY_RECORD_ID' => 'Chyba: ID záznamu nebylo zadáno nebo je prázdné.',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Chyba: Žádné další podrobnosti nebyly nalezeny pro záznam.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Žádné moduly nebyly povoleny pro tento konektor. Vyberte modul pro tento konektor na stránce Povolit konektory.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Chyba: Nejsou povoleny žádné konnektory ktere mají definovaná vyhledávací pole.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Chyba: Nebyl nalezen soubor sourcedefs.php .',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Chyba: Nebyly specifikovány žádný zdroje k načtení dat.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Chyba: Nejsou žádné konektory mapovány na tento modul.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Chyba: Nejsou žádné vyhledávací pole definovany pro tento modul a konektor. Prosím, kontaktujte správce systému.',
  'ERROR_NO_FIELDS_MAPPED' => 'Chyba: Musíte namapovat alespoň jedno pole konektororu na pole modulu pro každý záznam modulu',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Chyba: Neexistují žádné pole modulu, které by byly mapovány pro zobrazení ve výsledcích. Prosím, kontaktujte správce systému.',
);

