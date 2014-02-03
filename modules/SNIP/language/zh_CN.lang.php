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
  'ERROR_BAD_RESULT' => '服务器上返回坏结果',
  'ERROR_NO_CURL' => 'cURL扩展已请求，但还没有授权',
  'ERROR_REQUEST_FAILED' => '无法联系服务器',
  'LBL_CANCEL_BUTTON_TITLE' => '取消',
  'LBL_CONFIGURE_SNIP' => '电子邮件归档',
  'LBL_CONTACT_SUPPORT' => '请重新尝试或联系SugarCRM 支持.',
  'LBL_DISABLE_SNIP' => '禁用',
  'LBL_REGISTER_SNIP_FAIL' => '联系电子邮件归档服务失败: %s!<br>',
  'LBL_SNIP_ACCOUNT' => '账号',
  'LBL_SNIP_AGREE' => '我同意上述条款和 <a href=$#39;http://www.sugarcrm.com/crm/TRUSTe/privacy.html$#39; target=$#39;_blank$#39;>隐私协议</a>.',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => '程序唯一密匙',
  'LBL_SNIP_BUTTON_DISABLE' => '退出邮件归档',
  'LBL_SNIP_BUTTON_ENABLE' => '允许邮件归档',
  'LBL_SNIP_BUTTON_RETRY' => '尝试重新连接',
  'LBL_SNIP_CALLBACK_URL' => '电子邮件归档服务链接',
  'LBL_SNIP_DESCRIPTION' => '邮件归档服务器是一种自动归档邮件的系统',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => '它能让你看到SugarCRM中你发出或从你的联系人发过来的邮件, 不需要你再去手工导入或链接邮件',
  'LBL_SNIP_EMAIL' => '邮件归档地址',
  'LBL_SNIP_ERROR_DISABLING' => '在尝试与邮件归档服务器联系时发送错误, 服务器不能被禁止',
  'LBL_SNIP_ERROR_ENABLING' => '在尝试与邮件归档服务器联系时发送错误，服务器不能被授权',
  'LBL_SNIP_GENERIC_ERROR' => '邮件归档服务器暂时不可用. 不是服务器断线就是连接这个Sugar 实例失败.',
  'LBL_SNIP_KEY_DESC' => '邮件存档授权密钥.在访问该实例时用于导入邮件.',
  'LBL_SNIP_LAST_SUCCESS' => '上一次成功运行',
  'LBL_SNIP_MOUSEOVER_EMAIL' => '这是邮件归档服务器的地址发送，导入邮件到Sugar里.',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => '这是你的Sugar实例web服务URL. 邮件归档服务器将通过这个URL连接到你的服务器.',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => '这个邮件归档服务器的URL. 所有请求, 例如授权或禁止邮件归档服务器都将通过这个URL转播.',
  'LBL_SNIP_MOUSEOVER_STATUS' => '这是你邮件归档服务器的状态实例. 状态反应了邮件归档服务器和你的sugar实例是否连接成功.',
  'LBL_SNIP_NEVER' => '从不',
  'LBL_SNIP_PRIVACY' => '隐私协议',
  'LBL_SNIP_PURCHASE' => '点击这里购买',
  'LBL_SNIP_PURCHASE_SUMMARY' => '你必须购买SugarCRM实例的许可证才能用邮件归档',
  'LBL_SNIP_PWD' => '电子邮件归档密码',
  'LBL_SNIP_STATUS' => '状态',
  'LBL_SNIP_STATUS_ERROR' => '错误',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => '该实例有有效的电子邮件归档服务器证书，但是服务器因以下错误信息退回:',
  'LBL_SNIP_STATUS_FAIL' => '不能在邮件归档服务器注册',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => '邮件归档服务器暂时不可用.  不是服务器断线就是连接这个Sugar 实例失败.',
  'LBL_SNIP_STATUS_OK' => '启用',
  'LBL_SNIP_STATUS_OK_SUMMARY' => '该Sugar实例已成功连接到电子邮件归档服务器.',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => '回ping失败',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => '邮件归档服务器不能与你的sugar实例建立连接. 请重新尝试或 <a href="http://www.sugarcrm.com/crm/case-tracker/submit.html?lsd=supportportal&tmpl=" target="_blank">联系客户支持</a>.',
  'LBL_SNIP_STATUS_PROBLEM' => '问题: %s',
  'LBL_SNIP_STATUS_RESET' => '还未运行',
  'LBL_SNIP_STATUS_SUMMARY' => '邮件归档服务器状态:',
  'LBL_SNIP_SUGAR_URL' => '该Sugar实例的链接',
  'LBL_SNIP_SUMMARY' => '电子邮件归档是一种自动导入服务，它允许用户在其他任何的邮件客户端或者是Sugar支持的邮件地址发送邮件并同步到Sugar。每个Sugar实例都有它唯一的电子邮件地址。用户通过所提供的电子邮件地址发送，抄送和秘密抄送电子邮件并将其导入。邮件同步服务会把电子邮件同步导入到Sugar的线索记录中。该服务同步导入电子邮件，包括附带的附件，图片，日历事件，也可以在系统中与匹配的电邮地址相关联的已有记录同步并创建记录。<br />    <br><br>例如: 作为用户，当我查看一个账户时，我可以看到与该账户关联的所有电子邮件记录。我同样可以看到与该账户相关联的联系人的电子邮件记录。<br />    <br><br>接受以下条款，点击启用就可以开始使用该服务。您可以随时禁用该服务，一旦启用，同步所有的电子邮件地址就会显示。<br />    <br><br>',
  'LBL_SNIP_SUPPORT' => '请联系SugarCRM支持来获取帮助.',
  'LBL_SNIP_USER' => '邮件归档用户',
  'LBL_SNIP_USER_DESC' => '电子邮件归档用户',
);

