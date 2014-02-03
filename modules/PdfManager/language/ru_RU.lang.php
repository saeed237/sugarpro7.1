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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Действия',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'ВНИМАНИЕ: если Вы измените основной модуль, все поля, уже добавленные в шаблон, должны быть удалены.',
  'LBL_ASSIGNED_TO_ID' => 'Ответственный (-ая)',
  'LBL_ASSIGNED_TO_NAME' => 'Ответственный (-ая)',
  'LBL_AUTHOR' => 'Автор',
  'LBL_BASE_MODULE' => 'Модуль',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Выберите модуль, для которого этот шаблон будет доступен.',
  'LBL_BODY_HTML' => 'Шаблон',
  'LBL_BODY_HTML_POPUP_HELP' => 'Создайте шаблон используя редактор HTML. Сохраненив шаблон, вам будет доступен предварительный просмотр PDF-версии шаблона.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Создайте шаблон, используя редактор HTML. Сохранив шаблон, вы сможете предварительно просмотреть PDF-версию шаблона.',
  'LBL_BTN_INSERT' => 'Вставить',
  'LBL_CREATED' => 'Создано',
  'LBL_CREATED_ID' => 'Создано (Id)',
  'LBL_CREATED_USER' => 'Создано пользователем',
  'LBL_DATE_ENTERED' => 'Дата создания',
  'LBL_DATE_MODIFIED' => 'Дата изменения',
  'LBL_DELETED' => 'Удалено',
  'LBL_DESCRIPTION' => 'Описание',
  'LBL_EDITVIEW_PANEL1' => 'Свойства PDF-документа',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Вот файл, который Вы просили (Этот текст можно изменить)',
  'LBL_FIELD' => 'Поле',
  'LBL_FIELDS_LIST' => 'Поля',
  'LBL_FIELD_POPUP_HELP' => 'Выберите поле для вставки переменной в значение поля. Чтобы выбрать поля родительского модуля, сначала выберите модель в первом выпадающем списке, в разделе Ссылки внизу списка Поля, затем выберите поле во втором выпадающем списке.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_HOMEPAGE_TITLE' => 'Мои PDF шаблоны',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Ключевое слово (слова)',
  'LBL_KEYWORDS_POPUP_HELP' => 'Связать ключевые слова с документом, обычно в виде "ключевоеслово1 ключевоеслово2..."',
  'LBL_LINK_LIST' => 'Ссылки',
  'LBL_LIST_FORM_TITLE' => 'Список шаблонов PDF',
  'LBL_LIST_NAME' => 'Название',
  'LBL_MODIFIED' => 'Изменено',
  'LBL_MODIFIED_ID' => 'Изменено (Id)',
  'LBL_MODIFIED_NAME' => 'Изменено пользователем',
  'LBL_MODIFIED_USER' => 'Изменено пользователем',
  'LBL_MODULE_NAME' => 'Менеджер PDF',
  'LBL_MODULE_NAME_SINGULAR' => 'Менеджер PDF',
  'LBL_MODULE_TITLE' => 'Менеджер PDF',
  'LBL_NAME' => 'Название',
  'LBL_NEW_FORM_TITLE' => 'Создать шаблон PDF',
  'LBL_PAYMENT_TERMS' => 'Условия платежа:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'Менеджер PDF',
  'LBL_PREVIEW' => 'Предварительный просмотр',
  'LBL_PUBLISHED' => 'Опубликовано',
  'LBL_PUBLISHED_POPUP_HELP' => 'Опубликовать шаблон, чтоб он стал доступным пользователям.',
  'LBL_PURCHASE_ORDER_NUM' => 'Номер заказа:',
  'LBL_SEARCH_FORM_TITLE' => 'Поиск PDF-менеджера',
  'LBL_SUBJECT' => 'Тема',
  'LBL_TEAM' => 'Команды',
  'LBL_TEAMS' => 'Команды',
  'LBL_TEAM_ID' => 'ID команды',
  'LBL_TITLE' => 'Название',
  'LBL_TPL_BILL_TO' => 'Юридический адрес',
  'LBL_TPL_CURRENCY' => 'Валюта:',
  'LBL_TPL_DISCOUNT' => 'Скидка:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Сумма со скидкой:',
  'LBL_TPL_EXT_PRICE' => 'Внешняя цена',
  'LBL_TPL_GRAND_TOTAL' => 'Итого',
  'LBL_TPL_INVOICE' => 'Инвойс',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Этот шаблон используется для вывода инвойса на экран в PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Инвойс',
  'LBL_TPL_INVOICE_NUMBER' => 'Номер инвойса:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'инйовс',
  'LBL_TPL_LIST_PRICE' => 'Цена по прайсу',
  'LBL_TPL_PART_NUMBER' => 'Номер части',
  'LBL_TPL_PRODUCT' => 'Продукт',
  'LBL_TPL_QUANTITY' => 'Количество',
  'LBL_TPL_QUOTE' => 'Коммерческое предложение',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Этот шаблон используется для вывода коммерческого предложения на экран в PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Коммерческое предложение',
  'LBL_TPL_QUOTE_NUMBER' => 'Номер КП:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'коммерческое предложение',
  'LBL_TPL_SALES_PERSON' => 'Менеджер по продажам',
  'LBL_TPL_SHIPPING' => 'Доставка:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Перевозчик:',
  'LBL_TPL_SHIP_TO' => 'Адрес доставки',
  'LBL_TPL_SUBTOTAL' => 'Сумма:',
  'LBL_TPL_TAX' => 'Налог:',
  'LBL_TPL_TAX_RATE' => 'Размер налога:',
  'LBL_TPL_TOTAL' => 'Итого',
  'LBL_TPL_UNIT_PRICE' => 'Цена за единицу',
  'LBL_TPL_VALID_UNTIL' => 'Действительно до:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Изменить PDF шаблон',
  'LNK_IMPORT_PDFMANAGER' => 'Импорт PDF шаблонов',
  'LNK_LIST' => 'Обзор PDF шаблонов',
  'LNK_NEW_RECORD' => 'Новый PDF шаблон',
);

