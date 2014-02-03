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
  'ERR_DELETE_RECORD' => 'Трябва да определите номер, за да изтриете този запис.',
  'LBL_ACCEPT' => 'Приеми',
  'LBL_ACCEPT_THIS' => 'Приемате ли?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Контакт:',
  'LBL_DATE' => 'Начална дата:',
  'LBL_DATE_TIME' => 'Начална дата и час:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Текущи дейности',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DESCRIPTION_INFORMATION' => 'Допълнителна информация',
  'LBL_DIRECTION' => 'Направление',
  'LBL_DURATION' => 'Продължителност:',
  'LBL_DURATION_MINUTES' => 'Продължителност (мин.):',
  'LBL_HISTORY' => 'История',
  'LBL_HOURS_MINS' => '(час./мин.)',
  'LBL_INVITEE' => 'Поканени потребители',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_LIST_CLOSE' => 'Затвори',
  'LBL_LIST_CONTACT' => 'Контакт',
  'LBL_LIST_DATE' => 'Дата',
  'LBL_LIST_DIRECTION' => 'Направление',
  'LBL_LIST_DUE_DATE' => 'Падежна дата',
  'LBL_LIST_FORM_TITLE' => 'Списък с дейности',
  'LBL_LIST_LAST_MODIFIED' => 'Последно модифициран',
  'LBL_LIST_RELATED_TO' => 'Свързано със:',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUBJECT' => 'Относно',
  'LBL_LIST_TIME' => 'Начален час',
  'LBL_LOCATION' => 'Място:',
  'LBL_MEETING' => 'Среща:',
  'LBL_MODULE_NAME' => 'Дейности',
  'LBL_MODULE_TITLE' => 'Дейности',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Добавяне на бележка или приложение',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Добавяне на бележка или приложение [Alt+T]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Добавяне на задача',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Добавяне на задача [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'Текущи дейности',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Планиране на обаждане',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Планиране на обаждане [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Насрочване на среща',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Насрочване на среща [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модул "Дейности"',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Относно:',
  'LBL_TIME' => 'Начален час:',
  'LBL_TODAY' => 'през',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'хил.',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Създаване на запис за изпратена поща',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Създаване на запис за изпратена електронна поща [Alt+K]',
  'LBL_UPCOMING' => 'Моите предстоящи ангажименти',
  'LNK_CALL_LIST' => 'Обаждания',
  'LNK_EMAIL_LIST' => 'Електронна поща',
  'LNK_IMPORT_CALLS' => 'Импортиране на обаждания',
  'LNK_IMPORT_MEETINGS' => 'Импортиране на срещи',
  'LNK_IMPORT_NOTES' => 'Импортиране на бележки',
  'LNK_IMPORT_TASKS' => 'Импортиране на задачи',
  'LNK_MEETING_LIST' => 'Срещи',
  'LNK_NEW_APPOINTMENT' => 'Създаване на ангажимент',
  'LNK_NEW_CALL' => 'Планиране на обаждане',
  'LNK_NEW_EMAIL' => 'Създаване на запис за изпратена електронна поща',
  'LNK_NEW_MEETING' => 'Насрочване на среща',
  'LNK_NEW_NOTE' => 'Добавяне на бележка или приложение',
  'LNK_NEW_TASK' => 'Добавяне на задача',
  'LNK_NOTE_LIST' => 'Бележки',
  'LNK_TASK_LIST' => 'Задачи',
  'LNK_VIEW_CALENDAR' => 'Календар',
  'NTC_NONE' => 'Няма',
  'NTC_NONE_SCHEDULED' => 'Непланиран.',
  'NTC_REMOVE_INVITEE' => 'Сигурни ли сте, че желаете да премахнете поканения потребител от срещата?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'следващия месец',
    'last this_month' => 'текущия месец',
    'next Saturday' => 'следващата седмица',
    'this Saturday' => 'текущата седмица',
    'today' => 'днес',
    'tomorrow' => 'утре',
  ),
);

