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
  'ERR_DELETE_RECORD' => 'Вы должны указать номер записи перед удалением сделки.',
  'LBL_ACCOUNT_ID' => 'Контрагент',
  'LBL_ACCOUNT_NAME' => 'Контрагент:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Мероприятия',
  'LBL_AMOUNT' => 'Сумма сделки:',
  'LBL_AMOUNT_USDOLLAR' => 'Сумма, доллары США:',
  'LBL_ASSIGNED_TO_ID' => 'Ответственный (-ая)',
  'LBL_ASSIGNED_TO_NAME' => 'Ответственный (-ая):',
  'LBL_CAMPAIGN' => 'Маркетинговая кампания:',
  'LBL_CLOSED_WON_SALES' => 'Успешно закрытые сделки',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Контакты',
  'LBL_CREATED_ID' => 'Создано пользователем',
  'LBL_CURRENCY' => 'Валюта:',
  'LBL_CURRENCY_ID' => 'Ввалюта',
  'LBL_CURRENCY_NAME' => 'Валюта',
  'LBL_CURRENCY_SYMBOL' => 'Символ валюты',
  'LBL_DATE_CLOSED' => 'Ожидаемая дата закрытия:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Сделки',
  'LBL_DESCRIPTION' => 'Описание:',
  'LBL_DUPLICATE' => 'Возможно дублирующая сделка',
  'LBL_EDIT_BUTTON' => 'Правка',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Предварительные контакты',
  'LBL_LEAD_SOURCE' => 'Источник предварительного контакта:',
  'LBL_LIST_ACCOUNT_NAME' => 'Контрагент',
  'LBL_LIST_AMOUNT' => 'Сумма',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Ответственный (-ая)',
  'LBL_LIST_DATE_CLOSED' => 'Дата закрытия',
  'LBL_LIST_FORM_TITLE' => 'Список сделок',
  'LBL_LIST_SALE_NAME' => 'Название',
  'LBL_LIST_SALE_STAGE' => 'Стадия продажи',
  'LBL_MODIFIED_ID' => 'Изменено пользователем',
  'LBL_MODIFIED_NAME' => 'Изменено',
  'LBL_MODULE_NAME' => 'Сделки',
  'LBL_MODULE_TITLE' => 'Сделки: Главная',
  'LBL_MY_CLOSED_SALES' => 'Мои закрытые сделки',
  'LBL_NAME' => 'Сделка',
  'LBL_NEW_FORM_TITLE' => 'Новая сделка',
  'LBL_NEXT_STEP' => 'Следующий шаг:',
  'LBL_PROBABILITY' => 'Вероятность (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Проекты',
  'LBL_RAW_AMOUNT' => 'Сырой объем',
  'LBL_REMOVE' => 'Удалить',
  'LBL_SALE' => 'Сделка:',
  'LBL_SALES_STAGE' => 'Этап продаж:',
  'LBL_SALE_INFORMATION' => 'Информация по сделке',
  'LBL_SALE_NAME' => 'Сделка:',
  'LBL_SEARCH_FORM_TITLE' => 'Найти сделку',
  'LBL_TEAM_ID' => 'Команда',
  'LBL_TOP_SALES' => 'Мои основные открытые сделки',
  'LBL_TOTAL_SALES' => 'Все сделки',
  'LBL_TYPE' => 'Тип:',
  'LBL_VIEW_FORM_TITLE' => 'Обзор сделки',
  'LNK_NEW_SALE' => 'Новая сделка',
  'LNK_SALE_LIST' => 'Сделка',
  'MSG_DUPLICATE' => 'Запись, которую Вы создаете, возможно, дублирует уже имеющуюся запись. Похожие сделки показаны ниже. Нажмите кнопку "Сохранить"  для продолжения создания новой сделки или кнопку "Отмена" для возврата в модуль без создания сделки.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Вы действительно хотите удалить этот контакт из сделки?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Вы действительно хотите удалить эту сделку из проекта?',
  'UPDATE' => 'Сделка - обновление валюты',
  'UPDATE_BUGFOUND_COUNT' => 'Найдены ошибки:',
  'UPDATE_BUG_COUNT' => 'Количество найденных ошибок и попыток их решения:',
  'UPDATE_COUNT' => 'Обновлённые записи:',
  'UPDATE_CREATE_CURRENCY' => 'Создание новой валюты:',
  'UPDATE_DOLLARAMOUNTS' => 'Обновить суммы в долларах США',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Обновление сумм в долларах США для сделок, основанное на текущих установках курса обмена валют. Эта величина используется для расчета графиков и списков просмотра валютных сумм.',
  'UPDATE_DONE' => 'Готово',
  'UPDATE_FAIL' => 'Не обновлено -',
  'UPDATE_FIX' => 'Исправление сумм',
  'UPDATE_FIX_TXT' => 'Попытки исправить неверные суммы, посредством создания правильного разделителя из текущей суммы. Любое изменение суммы будет сохранено в виде резервной копии в поле БД amount_backup. Если Вы получили уведомление об ошибке, не повторяйте этот шаг без восстановления данных из резервной копии, в противном случае в архив будут перезаписаны новые неверные данные.',
  'UPDATE_INCLUDE_CLOSE' => 'Включить закрытые записи',
  'UPDATE_MERGE' => 'Объединить валюты',
  'UPDATE_MERGE_TXT' => 'Объединение многих валют в одну. Если имеется много записей валют для одной и той же валюты, то объедините их вместе. Это также объединит данные валюты  для всех остальных модулей.',
  'UPDATE_NULL_VALUE' => 'Сумма NULL установлена на 0 -',
  'UPDATE_RESTORE' => 'Восстановление сумм',
  'UPDATE_RESTORE_COUNT' => 'Суммы в записях восстановлены:',
  'UPDATE_RESTORE_TXT' => 'Восстановление сумм из резервной копии, созданной во время исправления ошибок.',
  'UPDATE_VERIFY' => 'Проверить суммы',
  'UPDATE_VERIFY_CURAMOUNT' => 'Текущая сумма:',
  'UPDATE_VERIFY_FAIL' => 'Неудачная проверка записи:',
  'UPDATE_VERIFY_FIX' => 'Запуск проверки данных',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Новая сумма:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Новая валюта:',
  'UPDATE_VERIFY_TXT' => 'Проверьте, что суммы в сделках имеют правильные значения, используются только цифры (0-9) и знак разряда (.)',
);

