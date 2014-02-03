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
  'LBL_EDITLAYOUT' => 'Редактиране на подредби',
  'LBL_LIST_ARRAY_TYPE' => 'Action Type',
  'LBL_LIST_RELATE_TYPE' => 'Relate Type',
  'LBL_LIST_ADDRESS_TYPE' => 'Address Type',
  'LBL_LIST_REL_MODULE2' => 'Related Related Module',
  'LBL_ARRAY_TYPE' => 'Action Type:',
  'LBL_REL_MODULE2' => 'Related Related Module:',
  'LBL_CUSTOM_USER' => 'Custom User:',
  'LNK_WORKFLOW' => 'Workflow Objects',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 'Members of the team associated with target module',
  'LBL_ROLE' => 'role',
  'LBL_ADDRESS_CC' => 'cc:',
  'LBL_ADDRESS_BCC' => 'bcc:',
  'LBL_BLANK' => '',
  'LBL_MODULE_NAME' => 'Списък с получатели на известяването',
  'LBL_MODULE_TITLE' => 'Получатели',
  'LBL_SEARCH_FORM_TITLE' => 'Търсене в модул получатели на известяването',
  'LBL_LIST_FORM_TITLE' => 'Списък с получатели',
  'LBL_NEW_FORM_TITLE' => 'Добавяне на получател',
  'LBL_LIST_USER_TYPE' => 'Тип потребител',
  'LBL_LIST_FIELD_VALUE' => 'Потребител',
  'LBL_LIST_REL_MODULE1' => 'Свързан модул',
  'LBL_LIST_WHERE_FILTER' => 'Статус',
  'LBL_USER_TYPE' => 'Тип потребител:',
  'LBL_RELATE_TYPE' => 'Тип връзка:',
  'LBL_WHERE_FILTER' => 'Статус:',
  'LBL_FIELD_VALUE' => 'Избран потребител:',
  'LBL_REL_MODULE1' => 'Свързан модул:',
  'LNK_NEW_WORKFLOW' => 'Дефиниране на процес',
  'LBL_LIST_STATEMENT' => 'Получатели:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Изпращане на известяване до следните получатели:',
  'LBL_ALERT_CURRENT_USER' => 'Потребител, асоцииран с избран',
  'LBL_ALERT_CURRENT_USER_TITLE' => 'Потребител, асоцииран с избрания модул',
  'LBL_ALERT_REL_USER' => 'Потребител, асоцииран със свързания',
  'LBL_ALERT_REL_USER_TITLE' => 'Потребител, асоцииран със свързания модул',
  'LBL_ALERT_REL_USER_CUSTOM' => 'Получател, асоцииран със свързания',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 'Получател, асоцииран със свързания модул',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 'Получател, асоцииран с избрания модул',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 'Получател, асоцииран с избрания модул',
  'LBL_ALERT_SPECIFIC_USER' => 'Определен',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 'Определен потребител',
  'LBL_ALERT_SPECIFIC_TEAM' => 'Всички потребители, включени в определен',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 'Всички потребители, включени в определен екип',
  'LBL_ALERT_SPECIFIC_ROLE' => 'Всички потребители, включени в определен',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 'Всички потребители с определена роля',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 'All users that belong to the team(s) asscoiated with the target module',
  'LBL_ALERT_LOGIN_USER_TITLE' => 'Активен потребител към момента на изпълнението',
  'LBL_RECORD' => 'Модул',
  'LBL_TEAM' => 'Екип',
  'LBL_USER' => 'Потребител',
  'LBL_USER_MANAGER' => 'Ръководител на птребителя',
  'LBL_SEND_EMAIL' => 'Изпращане на електронно писмо до:',
  'LBL_USER1' => ', създал записа',
  'LBL_USER2' => ', модифицирал записа последен',
  'LBL_USER3' => 'Current',
  'LBL_USER3b' => 'of system.',
  'LBL_USER4' => 'who is assigned the record',
  'LBL_USER5' => 'who was assigned the record',
  'LBL_ADDRESS_TO' => '-:',
  'LBL_ADDRESS_TYPE' => 'using address',
  'LBL_ADDRESS_TYPE_TARGET' => 'тип',
  'LBL_ALERT_REL1' => 'Свързан модул:',
  'LBL_ALERT_REL2' => 'Related Related Module:',
  'LBL_NEXT_BUTTON' => 'Следваща',
  'LBL_PREVIOUS_BUTTON' => 'Предишна',
  'NTC_REMOVE_ALERT_USER' => 'Сигурни ли сте че искате да премахнете този получател?',
  'LBL_REL_CUSTOM_STRING' => 'Изберете custom email and name fields',
  'LBL_REL_CUSTOM' => 'Изберете Custom Email Field:',
  'LBL_REL_CUSTOM2' => 'Поле',
  'LBL_AND' => 'и Name Field:',
  'LBL_REL_CUSTOM3' => 'Поле',
  'LBL_FILTER_CUSTOM' => '(Additional Filter) Filter related module by specific',
  'LBL_FIELD' => 'Поле',
  'LBL_SPECIFIC_FIELD' => 'поле',
  'LBL_FILTER_BY' => '(Additional Filter) Filter related module by',
  'LBL_MODULE_NAME_INVITE' => 'Списък с поканени потребители',
  'LBL_LIST_STATEMENT_INVITE' => 'Покани за срещи/обаждания:',
  'LBL_SELECT_VALUE' => 'Необходимо е да изберете валидна стойност.',
  'LBL_SELECT_NAME' => 'Необходимо е да изберете име на потребителско поле',
  'LBL_SELECT_EMAIL' => 'Необходимо е да изберете a custom e-mail field',
  'LBL_SELECT_FILTER' => 'Необходимо е да изберете поле за филтриране',
  'LBL_SELECT_NAME_EMAIL' => 'Необходимо е да изберете полета the name and e-mail',
  'LBL_PLEASE_SELECT' => 'Моля, изберете',
);

