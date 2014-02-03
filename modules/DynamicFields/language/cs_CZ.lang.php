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
  'COLUMN_TITLE_FTS' => 'Full text',
  'COLUMN_TITLE_GLOBAL_SEARCH' => 'Vyhledávání',
  'LBL_HELP' => 'Nápověda',
  'LBL_HAS_PARENT' => 'Rodič',
  'LBL_PARENT_DROPDOWN' => 'Dropdown',
  'LBL_EDIT_VIS' => 'Upravit viditelnost',
  'COLUMN_TITLE_HTML_CONTENT' => 'HTML',
  'LNK_NEW_CALL' => 'Naplánovat hovor',
  'LNK_NEW_MEETING' => 'Naplánovat schůzku',
  'LNK_NEW_TASK' => 'Přidat úkol',
  'LNK_NEW_NOTE' => 'Přidat poznámku nebo přílohu',
  'LNK_NEW_EMAIL' => 'Archivovat zprávu',
  'LNK_CALL_LIST' => 'Hovory',
  'LNK_MEETING_LIST' => 'Schůzky',
  'LNK_TASK_LIST' => 'Úkoly',
  'LNK_NOTE_LIST' => 'Poznámky',
  'LNK_EMAIL_LIST' => 'Pošta',
  'LBL_ADD_FIELD' => 'Přidat pole:',
  'LBL_MODULE_SELECT' => 'Editovat modul',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledat modul',
  'COLUMN_TITLE_NAME' => 'Název pole',
  'COLUMN_TITLE_DISPLAY_LABEL' => 'Zobrazující se název',
  'COLUMN_TITLE_LABEL_VALUE' => 'Název hodnoty',
  'COLUMN_TITLE_LABEL' => 'Systémový název',
  'COLUMN_TITLE_DATA_TYPE' => 'Datový typ',
  'COLUMN_TITLE_MAX_SIZE' => 'Maximální velikost',
  'COLUMN_TITLE_HELP_TEXT' => 'Text nápovědy pro pole',
  'COLUMN_TITLE_COMMENT_TEXT' => 'Komentář k poli',
  'COLUMN_TITLE_REQUIRED_OPTION' => 'Povinné pole',
  'COLUMN_TITLE_DEFAULT_VALUE' => 'Výchozí hodnota',
  'COLUMN_TITLE_DEFAULT_EMAIL' => 'Výchozí hodnota',
  'COLUMN_TITLE_EXT1' => 'Speciální pole 1',
  'COLUMN_TITLE_EXT2' => 'Speciální pole 2',
  'COLUMN_TITLE_EXT3' => 'Speciální pole 3',
  'COLUMN_TITLE_FRAME_HEIGHT' => 'Výška IFrame',
  'COLUMN_TITLE_URL' => 'Výchozí URL',
  'COLUMN_TITLE_AUDIT' => 'Revidovat',
  'COLUMN_TITLE_REPORTABLE' => 'Reportovatelné',
  'COLUMN_TITLE_MIN_VALUE' => 'Minimální hodnota',
  'COLUMN_TITLE_MAX_VALUE' => 'Maximální hodnota',
  'COLUMN_TITLE_LABEL_ROWS' => 'Řádky',
  'COLUMN_TITLE_LABEL_COLS' => 'Sloupce',
  'COLUMN_TITLE_DISPLAYED_ITEM_COUNT' => '# počet zobrazených položek',
  'COLUMN_TITLE_AUTOINC_NEXT' => 'Automatický přírustek pro další hodnotu',
  'COLUMN_DISABLE_NUMBER_FORMAT' => 'Zakázaný formát',
  'COLUMN_TITLE_ENABLE_RANGE_SEARCH' => 'Povolit rozsah vyhledávání',
  'LBL_DROP_DOWN_LIST' => 'Rozevírací seznam',
  'LBL_RADIO_FIELDS' => '"Radio" pole',
  'LBL_MULTI_SELECT_LIST' => 'Rozevírací seznam - vícenásobný',
  'COLUMN_TITLE_PRECISION' => 'Přesnost',
  'MSG_DELETE_CONFIRM' => 'Jste si jisti, že chcete odstranit tuto položku?',
  'POPUP_INSERT_HEADER_TITLE' => 'Přidat vlastní pole',
  'POPUP_EDIT_HEADER_TITLE' => 'Upravit vlastní pole',
  'LNK_SELECT_CUSTOM_FIELD' => 'Vybrat vlastní pole',
  'LNK_REPAIR_CUSTOM_FIELD' => 'Opravit vlastní políčka',
  'LBL_MODULE' => 'Modul',
  'COLUMN_TITLE_MASS_UPDATE' => 'Hromadná úprava',
  'COLUMN_TITLE_IMPORTABLE' => 'Importovatelný',
  'COLUMN_TITLE_DUPLICATE_MERGE' => 'Sloučit duplikáty',
  'LBL_LABEL' => 'Název',
  'LBL_DATA_TYPE' => 'Datový typ',
  'LBL_DEFAULT_VALUE' => 'Výchozí hodnota',
  'LBL_AUDITED' => 'Revidovaný',
  'LBL_REPORTABLE' => 'Reportovatelný',
  'ERR_RESERVED_FIELD_NAME' => 'Rezervovaná klávesa',
  'ERR_SELECT_FIELD_TYPE' => 'Prosím vyberte typ pole',
  'ERR_FIELD_NAME_ALREADY_EXISTS' => 'Název pole již existuje',
  'LBL_BTN_ADD' => 'Přidat',
  'LBL_BTN_EDIT' => 'Upavit',
  'LBL_GENERATE_URL' => 'Generovat URL',
  'LBL_DEPENDENT_CHECKBOX' => 'Závisející',
  'LBL_DEPENDENT_TRIGGER' => 'Trigger',
  'LBL_CALCULATED' => 'Vypočtená hodnota',
  'LBL_FORMULA' => 'Výraz',
  'LBL_DYNAMIC_VALUES_CHECKBOX' => 'Závisející',
  'LBL_BTN_EDIT_VISIBILITY' => 'Změnit viditelnost',
  'LBL_LINK_TARGET' => 'Otevřít odkaz v',
  'LBL_IMAGE_WIDTH' => 'Šířka',
  'LBL_IMAGE_HEIGHT' => 'Výška',
  'LBL_IMAGE_BORDER' => 'Okraj',
  'COLUMN_TITLE_VALIDATE_US_FORMAT' => 'U. S. Formát',
  'LBL_DEPENDENT' => 'Závisející',
  'LBL_VISIBLE_IF' => 'Viditelný pokud',
  'LBL_ENFORCED' => 'Vynucené',
);

