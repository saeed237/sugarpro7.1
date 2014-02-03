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
  'ERR_DELETE_RECORD' => 'Укажите номер записи для удаления ошибки.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Клиенты',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Действия',
  'LBL_ASSIGNED_TO_NAME' => 'Ответственный (-ая)',
  'LBL_BUG' => 'Ошибка:',
  'LBL_BUG_INFORMATION' => 'Описание ошибки',
  'LBL_BUG_NUMBER' => 'Номер ошибки:',
  'LBL_BUG_SUBJECT' => 'Тема ошибки:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Обращения',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакты',
  'LBL_CONTACT_BUG_TITLE' => 'Контакт - ошибка:',
  'LBL_CONTACT_NAME' => 'Контактное лицо:',
  'LBL_CONTACT_ROLE' => 'Роль:',
  'LBL_CREATED_BY' => 'Кем создано:',
  'LBL_DATE_CREATED' => 'Дата создания:',
  'LBL_DATE_LAST_MODIFIED' => 'Дата изменения:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Поиск ошибок',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Документы',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Ответственный (ID)',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Ответственный пользователь',
  'LBL_EXPORT_CREATED_BY' => 'Создано (ID)',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Исправлено в версии',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Изменено (ID)',
  'LBL_FIXED_IN_RELEASE' => 'Исправлено в версии:',
  'LBL_FOUND_IN_RELEASE' => 'Обнаружено в версии:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Найдено в версии',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_INVITEE' => 'Контакты',
  'LBL_LIST_ACCOUNT_NAME' => 'Имя Клиента',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ответственный (-ая)',
  'LBL_LIST_CONTACT_NAME' => 'Имя контакта',
  'LBL_LIST_EMAIL_ADDRESS' => 'E-mail-адрес',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Исправлено в версии',
  'LBL_LIST_FORM_TITLE' => 'Список ошибок',
  'LBL_LIST_LAST_MODIFIED' => 'Последнее изменение',
  'LBL_LIST_MY_BUGS' => 'Ошибки, назначенные мне',
  'LBL_LIST_NUMBER' => 'Ном.',
  'LBL_LIST_PHONE' => 'Телефон',
  'LBL_LIST_PRIORITY' => 'Приоритет',
  'LBL_LIST_RELEASE' => 'Версия',
  'LBL_LIST_RESOLUTION' => 'Решение',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUBJECT' => 'Тема',
  'LBL_LIST_TYPE' => 'Тип',
  'LBL_MODIFIED_BY' => 'Последнее изменение:',
  'LBL_MODULE_ID' => 'Ошибки',
  'LBL_MODULE_NAME' => 'Ошибки',
  'LBL_MODULE_NAME_SINGULAR' => 'Ошибка',
  'LBL_MODULE_TITLE' => 'Поиск ошибок: Главная',
  'LBL_NEW_FORM_TITLE' => 'Новая ошибка',
  'LBL_NUMBER' => 'Номер:',
  'LBL_PORTAL_VIEWABLE' => 'Отобразить в портале',
  'LBL_PRIORITY' => 'Приоритет:',
  'LBL_PRODUCT_CATEGORY' => 'Категория:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Проекты',
  'LBL_RELEASE' => 'Версия:',
  'LBL_RESOLUTION' => 'Решение:',
  'LBL_SEARCH_FORM_TITLE' => 'Поиск ошибок',
  'LBL_SHOW_IN_PORTAL' => 'Обзор в портале',
  'LBL_SHOW_MORE' => 'Показать больше ошибок',
  'LBL_SOURCE' => 'Источник:',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Тема:',
  'LBL_SYSTEM_ID' => 'Системный ID',
  'LBL_TYPE' => 'Тип:',
  'LBL_WORK_LOG' => 'Рабочий лог:',
  'LNK_BUG_LIST' => 'Обзор ошибок',
  'LNK_BUG_REPORTS' => 'Просмотр отчетов по ошибке',
  'LNK_CREATE' => 'Новая ошибка',
  'LNK_CREATE_WHEN_EMPTY' => 'Создать ошибку сейчас.',
  'LNK_IMPORT_BUGS' => 'Импорт ошибок',
  'LNK_NEW_BUG' => 'Новая ошибка',
  'NTC_DELETE_CONFIRMATION' => 'Вы действительно хотите удалить этот контакт из данной ошибки?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Вы действительно хотите удалить эту ошибку из данного контрагента?',
  'NTC_REMOVE_INVITEE' => 'Вы действительно хотите удалить этот контакт из данной ошибки?',
);

