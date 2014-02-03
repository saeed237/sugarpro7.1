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
  'ERR_DELETE_RECORD' => 'Вы должны указать номер записи перед удалением.',
  'LBL_ACCEPT' => 'Принять',
  'LBL_ACCEPT_THIS' => 'Принять?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Контактное лицо:',
  'LBL_DATE' => 'Дата начала:',
  'LBL_DATE_TIME' => 'Дата и время начала:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Открытые мероприятия',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DESCRIPTION_INFORMATION' => 'Описание',
  'LBL_DIRECTION' => 'Сортировка',
  'LBL_DURATION' => 'Продолжительность:',
  'LBL_DURATION_MINUTES' => 'Продолжительность минуты:',
  'LBL_HISTORY' => 'История',
  'LBL_HOURS_MINS' => '(часов:минут)',
  'LBL_INVITEE' => 'Приглашенные',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ответственный(ая)',
  'LBL_LIST_CLOSE' => 'Закрыть',
  'LBL_LIST_CONTACT' => 'Контакт',
  'LBL_LIST_DATE' => 'Дата',
  'LBL_LIST_DIRECTION' => 'Сортировка',
  'LBL_LIST_DUE_DATE' => 'Дата завершения',
  'LBL_LIST_FORM_TITLE' => 'Список мероприятий',
  'LBL_LIST_LAST_MODIFIED' => 'Последнее изменение',
  'LBL_LIST_RELATED_TO' => 'Относится к',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUBJECT' => 'Тема',
  'LBL_LIST_TIME' => 'Время начала',
  'LBL_LOCATION' => 'Место:',
  'LBL_MEETING' => 'Встреча:',
  'LBL_MODULE_NAME' => 'Мероприятия',
  'LBL_MODULE_NAME_SINGULAR' => 'Мероприятие',
  'LBL_MODULE_TITLE' => 'Мероприятия - ГЛАВНАЯ',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Создать заметку или вложение',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Создать заметку или вложение [Alt+T]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Создать задачу',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Создать задачу [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'Открытые мероприятия',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Назначить звонок',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Назначить звонок [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Назначить встречу',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Назначить встречу [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'Поиск мероприятий',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Тема:',
  'LBL_TIME' => 'Время начала:',
  'LBL_TODAY' => 'в течение',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Отправить E-mail в архив',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Отправить E-mail в архив [Alt+K]',
  'LBL_UPCOMING' => 'Предстоящие встречи/звонки',
  'LNK_CALL_LIST' => 'Звонки',
  'LNK_EMAIL_LIST' => 'E-mail',
  'LNK_IMPORT_CALLS' => 'Импорт звонков',
  'LNK_IMPORT_MEETINGS' => 'Импорт встреч',
  'LNK_IMPORT_NOTES' => 'Импорт заметок',
  'LNK_IMPORT_TASKS' => 'Импорт задач',
  'LNK_MEETING_LIST' => 'Встречи',
  'LNK_NEW_APPOINTMENT' => 'Новая встреча/звонок',
  'LNK_NEW_CALL' => 'Назначить звонок',
  'LNK_NEW_EMAIL' => 'Создать архивный E-mail',
  'LNK_NEW_MEETING' => 'Назначить встречу',
  'LNK_NEW_NOTE' => 'Создать заметку или вложение',
  'LNK_NEW_TASK' => 'Создать задачу',
  'LNK_NOTE_LIST' => 'Заметки',
  'LNK_TASK_LIST' => 'Задачи',
  'LNK_VIEW_CALENDAR' => 'Просмотр календаря',
  'NTC_NONE' => 'Нет',
  'NTC_NONE_SCHEDULED' => 'Не запланировано',
  'NTC_REMOVE_INVITEE' => 'Вы уверены, что хотите удалить это приглашение из данной встречи?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'следующий месяц',
    'last this_month' => 'этот месяц',
    'next Saturday' => 'следующая неделя',
    'this Saturday' => 'на этой неделе',
    'today' => 'сегодня',
    'tomorrow' => 'завтра',
  ),
);

