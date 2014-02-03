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
  'COLUMN_TITLE_FTS' => 'Full Text Searchable',
  'LBL_HAS_PARENT' => 'Has Parent',
  'LBL_PARENT_DROPDOWN' => 'Parent Dropdown',
  'LBL_EDIT_VIS' => 'Edit Visibility',
  'COLUMN_TITLE_EXT1' => 'Extra Meta Field 1',
  'COLUMN_TITLE_EXT2' => 'Extra Meta Field 2',
  'COLUMN_TITLE_EXT3' => 'Extra Meta Field 3',
  'COLUMN_TITLE_HTML_CONTENT' => 'HTML',
  'LBL_ENFORCED' => 'Enforced',
  'LNK_NEW_CALL' => 'Планиране на обаждане',
  'LNK_NEW_MEETING' => 'Насрочване на среща',
  'LNK_NEW_TASK' => 'Добавяне на задача',
  'LNK_NEW_NOTE' => 'Добавяне на бележка или приложение',
  'LNK_NEW_EMAIL' => 'Създаване на запис за изпратена поща',
  'LNK_CALL_LIST' => 'Обаждания',
  'LNK_MEETING_LIST' => 'Срещи',
  'LNK_TASK_LIST' => 'Задачи',
  'LNK_NOTE_LIST' => 'Бележки',
  'LNK_EMAIL_LIST' => 'Електронна поща',
  'LBL_ADD_FIELD' => 'Добави поле',
  'LBL_MODULE_SELECT' => 'Редактиране на модули',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модули',
  'COLUMN_TITLE_NAME' => 'Име',
  'COLUMN_TITLE_DISPLAY_LABEL' => 'Етикет',
  'COLUMN_TITLE_LABEL_VALUE' => 'Стойност на етикета',
  'COLUMN_TITLE_LABEL' => 'Етикет за администратора',
  'COLUMN_TITLE_DATA_TYPE' => 'Тип',
  'COLUMN_TITLE_MAX_SIZE' => 'Максимален размер',
  'COLUMN_TITLE_HELP_TEXT' => 'Помощен текст',
  'COLUMN_TITLE_COMMENT_TEXT' => 'Коментар за администратора',
  'COLUMN_TITLE_REQUIRED_OPTION' => 'Задължително поле',
  'COLUMN_TITLE_DEFAULT_VALUE' => 'Стойност по подразбиране',
  'COLUMN_TITLE_DEFAULT_EMAIL' => 'Стойност по подразбиране',
  'COLUMN_TITLE_FRAME_HEIGHT' => 'Моят портал',
  'COLUMN_TITLE_URL' => 'URL',
  'COLUMN_TITLE_AUDIT' => 'История на промените',
  'COLUMN_TITLE_REPORTABLE' => 'Използва се в справки:',
  'COLUMN_TITLE_MIN_VALUE' => 'Минимален размер',
  'COLUMN_TITLE_MAX_VALUE' => 'Максимален размер',
  'COLUMN_TITLE_LABEL_ROWS' => 'Редове',
  'COLUMN_TITLE_LABEL_COLS' => 'Колони',
  'COLUMN_TITLE_DISPLAYED_ITEM_COUNT' => 'none',
  'COLUMN_TITLE_AUTOINC_NEXT' => 'Автоматично нарастване на следващата стойност',
  'COLUMN_DISABLE_NUMBER_FORMAT' => 'Забранен формат',
  'COLUMN_TITLE_ENABLE_RANGE_SEARCH' => 'Търсене за период',
  'COLUMN_TITLE_GLOBAL_SEARCH' => 'Глобално търсене',
  'LBL_DROP_DOWN_LIST' => 'Списък с падащи менюта',
  'LBL_RADIO_FIELDS' => 'Radio бутон',
  'LBL_MULTI_SELECT_LIST' => 'Падащо меню "MultiSelect"',
  'COLUMN_TITLE_PRECISION' => 'Точност',
  'MSG_DELETE_CONFIRM' => 'Сигурни ли сте че искате да изтриете избраните записи?',
  'POPUP_INSERT_HEADER_TITLE' => 'Добавяне на поле',
  'POPUP_EDIT_HEADER_TITLE' => 'Редактиране',
  'LNK_SELECT_CUSTOM_FIELD' => 'Избор на полета',
  'LNK_REPAIR_CUSTOM_FIELD' => 'Редакция на полета',
  'LBL_MODULE' => 'Модул',
  'COLUMN_TITLE_MASS_UPDATE' => 'Масова актуализация',
  'COLUMN_TITLE_IMPORTABLE' => 'Импорт на стойности:',
  'COLUMN_TITLE_DUPLICATE_MERGE' => 'Сливане на дублирани записи',
  'LBL_LABEL' => 'Етикет',
  'LBL_DATA_TYPE' => 'Тип',
  'LBL_DEFAULT_VALUE' => 'Стойност по подразбиране:',
  'LBL_AUDITED' => 'История на промените',
  'LBL_REPORTABLE' => 'Импорт на стойности:',
  'ERR_RESERVED_FIELD_NAME' => 'Запази',
  'ERR_SELECT_FIELD_TYPE' => 'Моля, изберете типа на полето',
  'ERR_FIELD_NAME_ALREADY_EXISTS' => 'Вече съществува поле с такова име',
  'LBL_BTN_ADD' => 'Добави',
  'LBL_BTN_EDIT' => 'Редактирай',
  'LBL_GENERATE_URL' => 'URL',
  'LBL_DEPENDENT_CHECKBOX' => 'Зависимост',
  'LBL_DEPENDENT_TRIGGER' => 'Тригер:',
  'LBL_CALCULATED' => 'Изчислява се по формула',
  'LBL_FORMULA' => 'Формула',
  'LBL_DYNAMIC_VALUES_CHECKBOX' => 'Зависимост',
  'LBL_BTN_EDIT_VISIBILITY' => 'Редактирай',
  'LBL_LINK_TARGET' => 'Отваряне на връзката в',
  'LBL_IMAGE_WIDTH' => 'Ширина',
  'LBL_IMAGE_HEIGHT' => 'Височина',
  'LBL_IMAGE_BORDER' => 'Граница',
  'COLUMN_TITLE_VALIDATE_US_FORMAT' => 'U.S. формат',
  'LBL_DEPENDENT' => 'Визуализира се по формула',
  'LBL_VISIBLE_IF' => 'Показва се при условие',
  'LBL_HELP' => 'Помощ',
);

