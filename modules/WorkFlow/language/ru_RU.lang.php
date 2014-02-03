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
  'LBL_ACTION_ERROR' => 'Это действие не может быть выполнено. Измените действие, чтобы все поля и значения полей были действительными.',
  'LBL_ACTION_ERRORS' => 'ВНИМАНИЕ: Одно или более действий содержат ошибки.',
  'LBL_ALERT_ERROR' => 'Это уведомление не может быть выполнено. Измените уведомление, чтобы все настройки были действительными.',
  'LBL_ALERT_ERRORS' => 'ВНИМАНИЕ: Одно или более уведомлений содержат ошибки.',
  'LBL_ALERT_SUBJECT' => 'УВЕДОМЛЕНИЕ РАБОЧЕГО ПРОЦЕССА',
  'LBL_ALERT_TEMPLATES' => 'Шаблоны уведомлений',
  'LBL_ANY_FIELD' => 'любое поле',
  'LBL_AS' => 'как',
  'LBL_BASE_MODULE' => 'Основной модуль:',
  'LBL_BODY' => 'Текст сообщеия:',
  'LBL_CREATE_ALERT_TEMPLATE' => 'Создать шаблон уведомления:',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DOWN' => 'Вниз',
  'LBL_EDITLAYOUT' => 'Правка расположения',
  'LBL_EDIT_ALT_TEXT' => 'Правка текстового сообщения',
  'LBL_EMAILTEMPLATES_TYPE' => 'Тип',
  'LBL_EMAILTEMPLATES_TYPE_LIST_WORKFLOW' => 
  array (
    'workflow' => 'Бизнес процесс',
  ),
  'LBL_FIRE_ORDER' => 'Последовательность обработки:',
  'LBL_FROM_ADDRESS' => 'От (адрес):',
  'LBL_FROM_NAME' => 'От (имя):',
  'LBL_HIDE' => 'Свернуть',
  'LBL_INSERT' => 'Вставить',
  'LBL_INVITEES' => 'Приглашенные',
  'LBL_INVITEE_NOTICE' => 'Внимание, для создания необходимо выбрать хотя бы одно приглашенного.',
  'LBL_INVITE_LINK' => 'Ссылка приглашения на встречу/звонок',
  'LBL_LACK_OF_NOTIFICATIONS_ON' => 'Предупреждение: Для отправки сообщений введите информацию сервера SMTP: Администрирование > Настройки E-mail',
  'LBL_LACK_OF_TRIGGER_ALERT' => 'Предупреждение: необходимо создать условие запуска для функционирования этого объекта бизнес-процесса',
  'LBL_LINK_RECORD' => 'Ссылка на запись',
  'LBL_LIST_BASE_MODULE' => 'Основной модуль:',
  'LBL_LIST_DN' => 'вниз',
  'LBL_LIST_FORM_TITLE' => 'Список бизнес-процессов',
  'LBL_LIST_NAME' => 'Название',
  'LBL_LIST_ORDER' => 'Обработать заказ:',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_TYPE' => 'Выполнение происходит:',
  'LBL_LIST_UP' => 'веерх',
  'LBL_MODULE_ID' => 'Бизнес-процесс',
  'LBL_MODULE_NAME' => 'Определения бизнес-процессов',
  'LBL_MODULE_TITLE' => 'Бизнес-процесс: Главная',
  'LBL_NAME' => 'Название:',
  'LBL_NEW_FORM_TITLE' => 'Создать определение бизнес-процесса',
  'LBL_PLEASE_SELECT' => 'Пожалуйста, выберите',
  'LBL_PROCESS_LIST' => 'Последовательность бизнес-процесса',
  'LBL_PROCESS_SELECT' => 'Пожалуйста, выберите модуль:',
  'LBL_RECIPIENTS' => 'Получатели',
  'LBL_RECORD_TYPE' => 'Применяется к:',
  'LBL_RELATED_MODULE' => 'Связанный модуль:',
  'LBL_SEARCH_FORM_TITLE' => 'Найти бизнес-процесс',
  'LBL_SELECT_FILTER' => 'Необходимо выбрать поле, по которому будет фильтроваться связанный модуль.',
  'LBL_SELECT_MODULE' => 'Пожалуйста, выберите связанный модуль.',
  'LBL_SELECT_OPTION' => 'Пожалуйста, выберите опцию.',
  'LBL_SELECT_VALUE' => 'Необходимо выбрать значение.',
  'LBL_SET' => 'Установить',
  'LBL_SHOW' => 'Показать',
  'LBL_SPECIFIC_FIELD' => 'индивидуальное поле',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Тема:',
  'LBL_TRIGGER_ERROR' => 'ВНИМАНИЕ: Данное условие запуска содержит неправильные значения и не сработает.',
  'LBL_TRIGGER_ERRORS' => 'ВНИМАНИЕ: Один или более условий запуска содержит ошибки.',
  'LBL_TYPE' => 'Выполнение происходит:',
  'LBL_UP' => 'Вверх',
  'LBL__S' => ' ',
  'LNK_ALERT_TEMPLATES' => 'Шаблоны уведомлений',
  'LNK_NEW_WORKFLOW' => 'Создать определение бизнес-процесса',
  'LNK_PROCESS_VIEW' => 'Последовательность бизнес-процесса',
  'LNK_WORKFLOW' => 'Список определений бизнес-процессов',
  'NTC_REMOVE_ALERT' => 'Вы действительно хотите удалить этот бизнес-процесс?',
);

