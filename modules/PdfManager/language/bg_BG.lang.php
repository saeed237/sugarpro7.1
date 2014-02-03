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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Дейности',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'ВНИМАНИЕ: Ако промените основния модул, всички полета вече добавени към шаблона ще бъдат премахнати.',
  'LBL_ASSIGNED_TO_ID' => 'Идентификатор на отговорник',
  'LBL_ASSIGNED_TO_NAME' => 'Отговорник',
  'LBL_AUTHOR' => 'Автор',
  'LBL_BASE_MODULE' => 'Модул',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Изберете модул, в който този шаблон ще може да бъде използван.',
  'LBL_BODY_HTML' => 'Шаблон',
  'LBL_BODY_HTML_POPUP_HELP' => 'Създайте шаблон като използвате HTML редактора. След запазване на шаблона, ще можете да видите как изглежда той във PDF формат.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Създайте шаблон като използвате HTML редактора. След запазване на шаблона, ще можете да видите как изглежда той във PDF формат.<br /><br />За да редактирате цикъка на създаване на продукти, натиснете бутона "HTML" в редактора и ще можете да достъпите кода.  Кодът се съдържа между &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => 'Вмъкни',
  'LBL_CREATED' => 'Създадено от',
  'LBL_CREATED_ID' => 'Създадено от',
  'LBL_CREATED_USER' => 'Създадено от',
  'LBL_DATE_ENTERED' => 'Създадено на',
  'LBL_DATE_MODIFIED' => 'Модифицирано на',
  'LBL_DELETED' => 'Изтрити',
  'LBL_DESCRIPTION' => 'Описание',
  'LBL_EDITVIEW_PANEL1' => 'Настройки на PDF документа',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Това е заявеният файл (Не можете да променяте този текст)',
  'LBL_FIELD' => 'Поле',
  'LBL_FIELDS_LIST' => 'Полета',
  'LBL_FIELD_POPUP_HELP' => 'Изберете поле, чиято стойност да се използва като променлива в шаблона. За да изберете поле от свързани модули, първо изберете модулът от "Links area" в края на първото падащото меню и след това изберете полето във второто падащо меню.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'История',
  'LBL_HOMEPAGE_TITLE' => 'Моите PDF шаблони',
  'LBL_ID' => 'Идентидикатор',
  'LBL_KEYWORDS' => 'Ключови думи',
  'LBL_KEYWORDS_POPUP_HELP' => 'Избройте ключови думи, асоциирани с документа във формат "ключова_дума_1 ключова_дума_2..."',
  'LBL_LINK_LIST' => 'Връзки',
  'LBL_LIST_FORM_TITLE' => 'PDF шаблони',
  'LBL_LIST_NAME' => 'Име',
  'LBL_MODIFIED' => 'Модифицирано от',
  'LBL_MODIFIED_ID' => 'Модифицирано от',
  'LBL_MODIFIED_NAME' => 'Модифицирано от',
  'LBL_MODIFIED_USER' => 'Модифицирано от',
  'LBL_MODULE_NAME' => 'PDF мениджър',
  'LBL_MODULE_TITLE' => 'PDF мениджър',
  'LBL_NAME' => 'Име',
  'LBL_NEW_FORM_TITLE' => 'Нов PDF шаблон',
  'LBL_PAYMENT_TERMS' => 'Условия на плащане:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PDF мениджър',
  'LBL_PREVIEW' => 'Преглед',
  'LBL_PUBLISHED' => 'Публикуван',
  'LBL_PUBLISHED_POPUP_HELP' => 'Публикувайте шаблона, за да бъде достъпен за потребителите.',
  'LBL_PURCHASE_ORDER_NUM' => 'Номер на заявката:',
  'LBL_SEARCH_FORM_TITLE' => 'Търси PDF шаблони',
  'LBL_SUBJECT' => 'Относно',
  'LBL_TEAM' => 'Екипи',
  'LBL_TEAMS' => 'Екипи',
  'LBL_TEAM_ID' => 'Идентификатор на екип',
  'LBL_TITLE' => 'Заглавие',
  'LBL_TPL_BILL_TO' => 'Клиент',
  'LBL_TPL_CURRENCY' => 'Валута:',
  'LBL_TPL_DISCOUNT' => 'Отстъпка:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Общо с включена отстъпка:',
  'LBL_TPL_EXT_PRICE' => 'Ext. Price',
  'LBL_TPL_GRAND_TOTAL' => 'Стойност на офертата',
  'LBL_TPL_INVOICE' => 'Фактура',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Този шаблон се използва за печат на Фактури в PDF формат.',
  'LBL_TPL_INVOICE_NAME' => 'Фактура',
  'LBL_TPL_INVOICE_NUMBER' => 'Номер на фактура:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'фактура',
  'LBL_TPL_LIST_PRICE' => 'Каталожна цена',
  'LBL_TPL_PART_NUMBER' => 'Партиден номер:',
  'LBL_TPL_PRODUCT' => 'Продукт',
  'LBL_TPL_QUANTITY' => 'Количество',
  'LBL_TPL_QUOTE' => 'Оферта',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Шаблонът се използва за печат на Оферта в PDF формат.',
  'LBL_TPL_QUOTE_NAME' => 'Оферта',
  'LBL_TPL_QUOTE_NUMBER' => 'Номер на оферта:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'оферта',
  'LBL_TPL_SALES_PERSON' => 'Търговец:',
  'LBL_TPL_SHIPPING' => 'Доставка:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Доставчик:',
  'LBL_TPL_SHIP_TO' => 'Потребител',
  'LBL_TPL_SUBTOTAL' => 'Общо:',
  'LBL_TPL_TAX' => 'Такси:',
  'LBL_TPL_TAX_RATE' => 'Такси:',
  'LBL_TPL_TOTAL' => 'Общо',
  'LBL_TPL_UNIT_PRICE' => 'Единична цена',
  'LBL_TPL_VALID_UNTIL' => 'Валидна до:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Редактирай PDF шаблон',
  'LNK_IMPORT_PDFMANAGER' => 'Импорт на PDF шаблони',
  'LNK_LIST' => 'Разгледай PDF шаблоните',
  'LNK_NEW_RECORD' => 'Създай PDF шаблон',
);

