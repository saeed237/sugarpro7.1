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
  'ERROR_EMPTY_RECORD_ID' => 'Ошибка: Id записи не указана или она пуста.',
  'ERROR_EMPTY_SOURCE_ID' => 'Ошибка: Источник данных не указан или он пуст.',
  'ERROR_EMPTY_WRAPPER' => 'Ошибка: Невозможно получить wrapper instance для источника [{$source_id}]<br />олег',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Ошибка: Для данной записи не обнаружено дополнительной информации.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Ошибка: С данным модулем не связано ни одного подключения.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Ошибка: Не указано ни одного поля модуля для отображения в результирующих данных. Обратитесь к системному администратору.',
  'ERROR_NO_FIELDS_MAPPED' => 'Ошибка: Для каждого модуля Вы должны указать как минимум одно поле подключения.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Для данного подключения не указан ни один модуль. Укажите модуль на странице выбора модулей.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Ошибка: Нет активированных подключений с определенными полями поиска.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Ошибка: Не определены поля поиска для модуля и подключения. Для решения проблемы свяжитесь с системным администратором.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Ошибка: Файл sourcedefs.php не найден.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Ошибка: Не указан источник получения данных.',
  'ERROR_RECORD_NOT_SELECTED' => 'Ошибка: Выберите запись из списка перед тем как продолжить.',
  'LBL_ADDRCITY' => 'Город',
  'LBL_ADDRCOUNTRY' => 'Страна',
  'LBL_ADDRCOUNTRY_ID' => 'Id страны',
  'LBL_ADDRSTATEPROV' => 'Область',
  'LBL_ADD_MODULE' => 'Добавить',
  'LBL_ADMINISTRATION' => 'Администрирование подключения',
  'LBL_ADMINISTRATION_MAIN' => 'Параметры подключения',
  'LBL_AVAILABLE' => 'Доступно',
  'LBL_BACK' => '< Назад',
  'LBL_CLOSE' => 'Закрыть',
  'LBL_COMPANY_ID' => 'ID компании',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Некоторые поля, требующие обязательного заполнения, оставлены пустыми. Продолжить сохранение?',
  'LBL_CONNECTOR' => 'Подключение',
  'LBL_CONNECTOR_FIELDS' => 'Поля подключения',
  'LBL_DATA' => 'Данные',
  'LBL_DEFAULT' => 'По умолчанию',
  'LBL_DELETE_MAPPING_ENTRY' => 'Вы действительно хотите удалить эту запись?',
  'LBL_DISABLED' => 'Отключенные модули',
  'LBL_DUNS' => 'DUNS (Data Universal Numbering System - Универсальная система идентификации организаций) Data Universal Numbering System',
  'LBL_EMPTY_BEANS' => 'В результате поиска ничего не найдено.',
  'LBL_ENABLED' => 'Подключенные модули',
  'LBL_EXTERNAL' => 'Разрешить пользователям создавать внешние учётные записи к этому коннектору. Для использования этого коннектора, настройте его свойства на странице Свойства коннектора.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Для того, чтобы использовать это Подключение, необходимо настроить свойства. Откройте Настроить свойства подключения на странице настроек.',
  'LBL_FINSALES' => 'Ежегодный объем продаж',
  'LBL_INFO_INLINE' => 'Информация',
  'LBL_MARKET_CAP' => 'Рыночная капитализация<br />олег',
  'LBL_MERGE' => 'Объединить',
  'LBL_MODIFY_DISPLAY_DESC' => 'Выбор модулей, связанных с указанным подключением.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Параметры подключения: активировать подключения',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Активировать подключения',
  'LBL_MODIFY_MAPPING_DESC' => 'Настройка соответствия полей подключения полям модулей. Данные полей подключения будут объединены с данными полей модулей.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Параметры подключения: Настройка полей',
  'LBL_MODIFY_MAPPING_TITLE' => 'Настройка полей',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Настройка свойств каждого подключения, включая URL и ключи API',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Параметры подключения: настроить параметы подключения',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Настройка параметров подключения',
  'LBL_MODIFY_SEARCH' => 'Поиск',
  'LBL_MODIFY_SEARCH_DESC' => 'Укажите поля подключения, используемые для поиска по каждому модулю.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Параметры подключения: управление поиском подключений',
  'LBL_MODIFY_SEARCH_TITLE' => 'Управление поиском подключения',
  'LBL_MODULE_FIELDS' => 'Поля модуля',
  'LBL_MODULE_NAME' => 'Подключения',
  'LBL_NO_PROPERTIES' => 'Для данного подключения нет настраиваемых параметров.',
  'LBL_PARENT_DUNS' => 'Родительский DUNS<br />олег',
  'LBL_PREVIOUS' => '< Назад',
  'LBL_QUOTE' => 'Коммерческое предложение',
  'LBL_RECNAME' => 'Название компании',
  'LBL_RESET_BUTTON_TITLE' => 'Сброс [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Сброс до стандартных значений',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Вы действительно хотите вернуться к стандартным настройкам?',
  'LBL_RESULT_LIST' => 'Список данных',
  'LBL_RUN_WIZARD' => 'Запуск мастера',
  'LBL_SAVE' => 'Сохранить',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Поиск...',
  'LBL_SHOW_IN_LISTVIEW' => 'Показывать при совмещённом просмотре списка<br />олег',
  'LBL_SMART_COPY' => 'Умное копирование<br />олег',
  'LBL_STEP1' => 'Поиск и просмотр данных',
  'LBL_STEP2' => 'Объединение записей с',
  'LBL_SUMMARY' => 'Резюме',
  'LBL_TEST_SOURCE' => 'Тестирование подключения',
  'LBL_TEST_SOURCE_FAILED' => 'Тестирование неуспешно',
  'LBL_TEST_SOURCE_RUNNING' => 'Выполнение тестового подключения...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Тестирование успешно',
  'LBL_TITLE' => 'Объединение данных',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Основной родительский DUNS<br />олег',
);

