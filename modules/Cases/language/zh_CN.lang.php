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
  'ERR_DELETE_RECORD' => '必须指定记录编号才能删除客户。',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => '客户',
  'LBL_ACCOUNT_ID' => '客户ID',
  'LBL_ACCOUNT_NAME' => '客户名称:',
  'LBL_ACCOUNT_NAME_MOD' => '客户名称模块',
  'LBL_ACCOUNT_NAME_OWNER' => '客户所有者',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
  'LBL_ASSIGNED_TO_NAME' => '负责人',
  'LBL_ASSIGNED_USER_NAME_MOD' => '被分配者的模块名称',
  'LBL_ASSIGNED_USER_NAME_OWNER' => '被分配者的名字所有者',
  'LBL_ATTACH_NOTE' => '附加备忘录',
  'LBL_BUGS_SUBPANEL_TITLE' => '缺陷',
  'LBL_CASE' => '客户反馈:',
  'LBL_CASE_INFORMATION' => '概览',
  'LBL_CASE_NUMBER' => '客户反馈编号:',
  'LBL_CASE_SUBJECT' => '客户反馈主题:',
  'LBL_CONTACTS_SUBPANEL_TITLE' => '联系人',
  'LBL_CONTACT_CASE_TITLE' => '客户反馈联系人:',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => '相关联系人$#39; 电子邮件',
  'LBL_CONTACT_NAME' => '联系人姓名:',
  'LBL_CONTACT_ROLE' => '角色:',
  'LBL_CREATED_BY_NAME_MOD' => '由模组名称创建',
  'LBL_CREATED_BY_NAME_OWNER' => '由名字所有者创建',
  'LBL_CREATED_USER' => '创建用户',
  'LBL_CREATE_KB_DOCUMENT' => '创建文章',
  'LBL_DEFAULT_SUBPANEL_TITLE' => '客户反馈',
  'LBL_DESCRIPTION' => '说明:',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => '文档',
  'LBL_EXPORT_ASSIGNED_USER_ID' => '被分配用户ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => '被分配者名称',
  'LBL_EXPORT_CREATED_BY' => '由ID创建',
  'LBL_EXPORT_CREATED_BY_NAME' => '由用户名创建',
  'LBL_EXPORT_MODIFIED_USER_ID' => '修改ID',
  'LBL_EXPORT_TEAM_COUNT' => '团队数量',
  'LBL_FILENANE_ATTACHMENT' => '附加文件',
  'LBL_HISTORY_SUBPANEL_TITLE' => '历史记录',
  'LBL_INVITEE' => '联系人',
  'LBL_LIST_ACCOUNT_NAME' => '客户姓名',
  'LBL_LIST_ASSIGNED' => '负责人',
  'LBL_LIST_ASSIGNED_TO_NAME' => '负责人',
  'LBL_LIST_CLOSE' => '关闭',
  'LBL_LIST_DATE_CREATED' => '创建日期',
  'LBL_LIST_FORM_TITLE' => '客户反馈列表',
  'LBL_LIST_LAST_MODIFIED' => '最新修改',
  'LBL_LIST_MY_CASES' => '我的客户反馈',
  'LBL_LIST_NUMBER' => '编号',
  'LBL_LIST_PRIORITY' => '优先级',
  'LBL_LIST_STATUS' => '状态',
  'LBL_LIST_SUBJECT' => '主题',
  'LBL_MEMBER_OF' => '客户',
  'LBL_MODIFIED_BY_NAME_MOD' => '由模组名称修改',
  'LBL_MODIFIED_BY_NAME_OWNER' => '由名字所有者修改',
  'LBL_MODIFIED_USER' => '修改人',
  'LBL_MODIFIED_USER_NAME' => '更改过的用户名',
  'LBL_MODIFIED_USER_NAME_MOD' => '更改过的用户模组名称',
  'LBL_MODIFIED_USER_NAME_OWNER' => '更改过的用户名所有者',
  'LBL_MODULE_NAME' => '客户反馈',
  'LBL_MODULE_NAME_SINGULAR' => '客户反馈',
  'LBL_MODULE_TITLE' => '客户反馈: 首页',
  'LBL_NEW_FORM_TITLE' => '新增客户反馈',
  'LBL_NUMBER' => '编号:',
  'LBL_PORTAL_VIEWABLE' => '可视门户站点',
  'LBL_PRIORITY' => '优先级:',
  'LBL_PROJECTS_SUBPANEL_TITLE' => '工程',
  'LBL_PROJECT_SUBPANEL_TITLE' => '项目',
  'LBL_RESOLUTION' => '分析:',
  'LBL_SEARCH_FORM_TITLE' => '查找客户反馈',
  'LBL_SHOW_IN_PORTAL' => '显示在门户中',
  'LBL_SHOW_MORE' => '显示更多反馈',
  'LBL_STATUS' => '状态:',
  'LBL_SUBJECT' => '主题:',
  'LBL_SYSTEM_ID' => '系统编号',
  'LBL_TEAM_COUNT_MOD' => '团队数模组',
  'LBL_TEAM_COUNT_OWNER' => '团队数所有者',
  'LBL_TEAM_NAME_MOD' => '团队模组名称',
  'LBL_TEAM_NAME_OWNER' => '团队名称所有者',
  'LBL_TYPE' => '类型',
  'LBL_WORK_LOG' => '工作日志',
  'LNK_CASE_LIST' => '客户反馈',
  'LNK_CASE_REPORTS' => '客户反馈报表',
  'LNK_CREATE' => '创建客户反馈',
  'LNK_CREATE_WHEN_EMPTY' => '现在创建一条客户反馈',
  'LNK_IMPORT_CASES' => '导入用例',
  'LNK_NEW_CASE' => '新增客户反馈',
  'NTC_REMOVE_FROM_BUG_CONFIRMATION' => '您确定要从缺陷中移除这个客户反馈？',
  'NTC_REMOVE_INVITEE' => '您确定要从客户反馈中移除这个联系人？',
);

