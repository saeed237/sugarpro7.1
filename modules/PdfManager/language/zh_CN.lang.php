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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
  'LBL_ALERT_SWITCH_BASE_MODULE' => '警告：如果您改变主要模版，所有已添加到模版的字段将被移除。',
  'LBL_ASSIGNED_TO_ID' => '负责人ID',
  'LBL_ASSIGNED_TO_NAME' => '负责人',
  'LBL_AUTHOR' => '作者',
  'LBL_BASE_MODULE' => '模块',
  'LBL_BASE_MODULE_POPUP_HELP' => '选择一个这个模版应用的模块',
  'LBL_BODY_HTML' => '模版',
  'LBL_BODY_HTML_POPUP_HELP' => '创建模板使用的HTML编辑器。保存模板后，您将能够查看预览PDF版本的模板。',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => '创建模板使用的HTML编辑器。保存模板后，您将能够查看预览PDF版本的模板。<br /><br />编辑循环用于创建产品线的项目，单击“HTML”按钮，在编辑器中访问代码。代码被包含在 &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; 和&lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => '插入',
  'LBL_CREATED' => '创建人',
  'LBL_CREATED_ID' => '创建人ID',
  'LBL_CREATED_USER' => '创建用户',
  'LBL_DATE_ENTERED' => '创建日期',
  'LBL_DATE_MODIFIED' => '修改日期',
  'LBL_DELETED' => '已删除',
  'LBL_DESCRIPTION' => '描述',
  'LBL_EDITVIEW_PANEL1' => 'PDF文件属性',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => '这里是您要求的文件（您可以改变文字）',
  'LBL_FIELD' => '字段',
  'LBL_FIELDS_LIST' => '字段',
  'LBL_FIELD_POPUP_HELP' => '选择要插入的域的字段值的变量。父模块中选择字段，第一个在底部的字段列表中，在第一个下拉选择链接区域中的模块，然后在第二个下拉选择字段。',
  'LBL_HISTORY_SUBPANEL_TITLE' => '查看历史',
  'LBL_HOMEPAGE_TITLE' => '我的PDF模版',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => '关键字',
  'LBL_KEYWORDS_POPUP_HELP' => '关联关键词至文档，格式为 "关键词1 关键词2 ..."',
  'LBL_LINK_LIST' => '链接',
  'LBL_LIST_FORM_TITLE' => 'PDF模版列表',
  'LBL_LIST_NAME' => '名称',
  'LBL_MODIFIED' => '修改人',
  'LBL_MODIFIED_ID' => '修改人ID',
  'LBL_MODIFIED_NAME' => '修改人名称',
  'LBL_MODIFIED_USER' => '修改用户',
  'LBL_MODULE_NAME' => 'PDF经理',
  'LBL_MODULE_NAME_SINGULAR' => 'Pdf管理',
  'LBL_MODULE_TITLE' => 'PDF经理',
  'LBL_NAME' => '名称',
  'LBL_NEW_FORM_TITLE' => '新PDF模版',
  'LBL_PAYMENT_TERMS' => '付款条件:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PDF经理',
  'LBL_PREVIEW' => '预览',
  'LBL_PUBLISHED' => '已发布',
  'LBL_PUBLISHED_POPUP_HELP' => '发布一个模版并对用户开放',
  'LBL_PURCHASE_ORDER_NUM' => '采购订单编号:',
  'LBL_SEARCH_FORM_TITLE' => '搜索PDF经理',
  'LBL_SUBJECT' => '主题',
  'LBL_TEAM' => '团队',
  'LBL_TEAMS' => '团队',
  'LBL_TEAM_ID' => '团队ID',
  'LBL_TITLE' => '职位',
  'LBL_TPL_BILL_TO' => '购买者',
  'LBL_TPL_CURRENCY' => '货币：',
  'LBL_TPL_DISCOUNT' => '折扣：',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => '折扣小计：',
  'LBL_TPL_EXT_PRICE' => '额外费用',
  'LBL_TPL_GRAND_TOTAL' => '总计',
  'LBL_TPL_INVOICE' => '发票',
  'LBL_TPL_INVOICE_DESCRIPTION' => '这个模版是用于打印PDF发票。',
  'LBL_TPL_INVOICE_NAME' => '发票',
  'LBL_TPL_INVOICE_NUMBER' => '发票号码：',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => '发票',
  'LBL_TPL_LIST_PRICE' => '定价',
  'LBL_TPL_PART_NUMBER' => '参与人数',
  'LBL_TPL_PRODUCT' => '产品',
  'LBL_TPL_QUANTITY' => '数量',
  'LBL_TPL_QUOTE' => '报价',
  'LBL_TPL_QUOTE_DESCRIPTION' => '这个模版用于在报价模块打印PDF。',
  'LBL_TPL_QUOTE_NAME' => '报价',
  'LBL_TPL_QUOTE_NUMBER' => '报价编号：',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => '报价',
  'LBL_TPL_SALES_PERSON' => '销售顾问：',
  'LBL_TPL_SHIPPING' => '运输：',
  'LBL_TPL_SHIPPING_PROVIDER' => '货运供应商：',
  'LBL_TPL_SHIP_TO' => '到达地',
  'LBL_TPL_SUBTOTAL' => '小计：',
  'LBL_TPL_TAX' => '税：',
  'LBL_TPL_TAX_RATE' => '税率：',
  'LBL_TPL_TOTAL' => '总计',
  'LBL_TPL_UNIT_PRICE' => '单价',
  'LBL_TPL_VALID_UNTIL' => '有效期至：',
  'LNK_EDIT_PDF_TEMPLATE' => '编辑PDF模版',
  'LNK_IMPORT_PDFMANAGER' => '导入PDF模版',
  'LNK_LIST' => '查看PDF模版',
  'LNK_NEW_RECORD' => '创建PDF模版',
);

