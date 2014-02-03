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
  'ERR_DELETE_RECORD' => 'Трябва да определите номер на записа, за да изтриете този проблем.',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Организации',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Дейности',
  'LBL_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_BUG' => 'Проблем:',
  'LBL_BUG_INFORMATION' => 'Проблеми',
  'LBL_BUG_NUMBER' => 'Номер на проблем:',
  'LBL_BUG_SUBJECT' => 'Относно:',
  'LBL_CASES_SUBPANEL_TITLE' => 'Казуси',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакти',
  'LBL_CONTACT_BUG_TITLE' => 'Контакт-Проблем:',
  'LBL_CONTACT_NAME' => 'Контакт:',
  'LBL_CONTACT_ROLE' => 'Роля:',
  'LBL_CREATED_BY' => 'Създадено от:',
  'LBL_DATE_CREATED' => 'Създадено на:',
  'LBL_DATE_LAST_MODIFIED' => 'Модифицирано на:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Проблеми',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Документи',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Отговорник',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Отговорник',
  'LBL_EXPORT_CREATED_BY' => 'Създаден от',
  'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Отстранен в издание',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Модифициран от',
  'LBL_FIXED_IN_RELEASE' => 'Разрешени във версия:',
  'LBL_FOUND_IN_RELEASE' => 'Намерени във версия:',
  'LBL_FOUND_IN_RELEASE_NAME' => 'Открит в издание',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_INVITEE' => 'Контакти',
  'LBL_LIST_ACCOUNT_NAME' => 'Oрганизация',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_LIST_CONTACT_NAME' => 'Контакт',
  'LBL_LIST_EMAIL_ADDRESS' => 'Адрес на ел. поща',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Разрешени във версия',
  'LBL_LIST_FORM_TITLE' => 'Списък с проблеми',
  'LBL_LIST_LAST_MODIFIED' => 'Последно модифициран',
  'LBL_LIST_MY_BUGS' => 'Моите отбелязани проблеми',
  'LBL_LIST_NUMBER' => 'Ном.',
  'LBL_LIST_PHONE' => 'Телефон',
  'LBL_LIST_PRIORITY' => 'Степен на важност',
  'LBL_LIST_RELEASE' => 'Версия',
  'LBL_LIST_RESOLUTION' => 'Решение',
  'LBL_LIST_STATUS' => 'Статус',
  'LBL_LIST_SUBJECT' => 'Относно',
  'LBL_LIST_TYPE' => 'Тип',
  'LBL_MODIFIED_BY' => 'Модифицирано от:',
  'LBL_MODULE_ID' => 'Проблеми',
  'LBL_MODULE_NAME' => 'Проблеми',
  'LBL_MODULE_NAME_SINGULAR' => 'Проблем',
  'LBL_MODULE_TITLE' => 'Проблеми',
  'LBL_NEW_FORM_TITLE' => 'Въвеждане на нов проблем',
  'LBL_NUMBER' => 'Номер:',
  'LBL_PORTAL_VIEWABLE' => 'Видим в Потребителски портал',
  'LBL_PRIORITY' => 'Степен на важност:',
  'LBL_PRODUCT_CATEGORY' => 'Категория:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Проекти',
  'LBL_RELEASE' => 'Версия:',
  'LBL_RESOLUTION' => 'Решение:',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модул "Проблеми"',
  'LBL_SHOW_IN_PORTAL' => 'Видим за портала',
  'LBL_SHOW_MORE' => 'Покажи повече',
  'LBL_SOURCE' => 'Източник:',
  'LBL_STATUS' => 'Статус:',
  'LBL_SUBJECT' => 'Относно:',
  'LBL_SYSTEM_ID' => 'ID на системата',
  'LBL_TYPE' => 'Категория:',
  'LBL_WORK_LOG' => 'Работен дневник на събития:',
  'LNK_BUG_LIST' => 'Списък с проблеми',
  'LNK_BUG_REPORTS' => 'Справки за проблеми',
  'LNK_CREATE' => 'Докладване за проблем',
  'LNK_CREATE_WHEN_EMPTY' => 'Докладвай проблем сега:',
  'LNK_IMPORT_BUGS' => 'Импортиране на проблеми',
  'LNK_NEW_BUG' => 'Докладване за проблем',
  'NTC_DELETE_CONFIRMATION' => 'Сигурни ли сте, че искате да изтриете този контакт от проблема?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Сигурни ли сте, че искате да изтриете проблема от този запис?',
  'NTC_REMOVE_INVITEE' => 'Сигурни ли сте, че искате да изтриете този контакт от проблема?',
);

