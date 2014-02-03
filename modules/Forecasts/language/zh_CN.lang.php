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
  'ERR_FORECAST_AMOUNT' => '必须提交数字金额。',
  'LBL_ACTIONS' => '操作',
  'LBL_AMOUNT' => '数量',
  'LBL_BASE_RATE' => '基本利率',
  'LBL_BEST_CASE' => '最好情形:',
  'LBL_BEST_CASE_BASE_CURRENCY' => '最佳(调整过的)基础货币',
  'LBL_BEST_CASE_VALUE' => '最佳(已调整)',
  'LBL_CANCEL' => '取消',
  'LBL_CHANGES_BY' => '按 {0}改变',
  'LBL_CHART_ADJUSTED' => '(调整过的)',
  'LBL_CHART_AMOUNT' => '数量',
  'LBL_CHART_FOOTER' => '销售预测历史<br />定额 vs. 预测金额 vs. 完成商业机会价值',
  'LBL_CHART_FORECAST_FOR' => '预测 {0}',
  'LBL_CHART_INCLUDED' => '包括',
  'LBL_CHART_NOT_INCLUDED' => '不包括',
  'LBL_CHART_OPTIONS' => '图表选项',
  'LBL_CHART_TITLE' => '配额 vs. 承诺 vs.实际',
  'LBL_CHART_TYPE' => '图表类型',
  'LBL_CLOSED' => '已关闭',
  'LBL_COMMITTED_HISTORY_1_SHOWN' => '{0} {1}',
  'LBL_COMMITTED_HISTORY_2_SHOWN' => '{0} {1}, {2}',
  'LBL_COMMITTED_HISTORY_3_SHOWN' => '{0} {1}, {2}, 和{3}',
  'LBL_COMMITTED_HISTORY_BEST_CHANGED' => '最佳的{0} {1} 到 {2}',
  'LBL_COMMITTED_HISTORY_BEST_SAME' => '最好保持不变',
  'LBL_COMMITTED_HISTORY_LIKELY_CHANGED' => '可能 {0} {1} 到 {2}',
  'LBL_COMMITTED_HISTORY_LIKELY_SAME' => '可能保持不变',
  'LBL_COMMITTED_HISTORY_SETUP_FORECAST' => '设置销售预测',
  'LBL_COMMITTED_HISTORY_UPDATED_FORECAST' => '更新销售预测',
  'LBL_COMMITTED_HISTORY_WORST_CHANGED' => '最坏的{0} {1} 到 {2}',
  'LBL_COMMITTED_HISTORY_WORST_SAME' => '最差保持不变',
  'LBL_COMMITTED_MONTHS_AGO' => '{0} 月以前的 {1}',
  'LBL_COMMITTED_THIS_MONTH' => '本月在 {0}',
  'LBL_COMMIT_AMOUNT' => '承诺价值总和。',
  'LBL_COMMIT_HEADER' => '销售预测提交',
  'LBL_COMMIT_MESSAGE' => '您确定要承诺这些金额吗?',
  'LBL_COMMIT_NOTE' => '为选择的时段输入承诺的金额:',
  'LBL_COMMIT_STAGE' => '提交阶段',
  'LBL_COPY' => '复制价值',
  'LBL_COPY_AMOUNT' => '总金额',
  'LBL_COPY_FROM' => '复制价值从:',
  'LBL_COPY_WEIGH_AMOUNT' => '总加权金额',
  'LBL_CREATED_BY' => '创建人',
  'LBL_CURRENCY' => '货币:',
  'LBL_CURRENCY_ID' => '货币编号',
  'LBL_CURRENCY_RATE' => '汇率',
  'LBL_DATA_SET' => '数据设置:',
  'LBL_DATE_CLOSED' => '预期完成日期：',
  'LBL_DATE_COMMITTED' => '提交日期',
  'LBL_DATE_ENTERED' => '输入日期',
  'LBL_DATE_MODIFIED' => '修改日期',
  'LBL_DELETED' => '已删除',
  'LBL_DISTANCE_ABOVE_BEST_FROM_CLOSED' => '最好高于关闭',
  'LBL_DISTANCE_ABOVE_BEST_FROM_QUOTA' => '最好高于配额',
  'LBL_DISTANCE_ABOVE_LIKELY_FROM_CLOSED' => '可能高于关闭',
  'LBL_DISTANCE_ABOVE_LIKELY_FROM_QUOTA' => '可能高于配额',
  'LBL_DISTANCE_ABOVE_WORST_FROM_CLOSED' => '最差高于关闭',
  'LBL_DISTANCE_ABOVE_WORST_FROM_QUOTA' => '最差高于配额',
  'LBL_DISTANCE_LEFT_BEST_TO_CLOSED' => '最好低于关闭',
  'LBL_DISTANCE_LEFT_BEST_TO_QUOTA' => '最好低于配额',
  'LBL_DISTANCE_LEFT_LIKELY_TO_CLOSED' => '可能低于关闭',
  'LBL_DISTANCE_LEFT_LIKELY_TO_QUOTA' => '可能低于配额',
  'LBL_DISTANCE_LEFT_WORST_TO_CLOSED' => '最差低于关闭',
  'LBL_DISTANCE_LEFT_WORST_TO_QUOTA' => '最差低于配额',
  'LBL_DOWN' => '向下',
  'LBL_DV_FORECAST_OPPORTUNITY' => '预测商业机会',
  'LBL_DV_FORECAST_PERIOD' => '预测时段',
  'LBL_DV_FORECAST_ROLLUP' => '预测汇总',
  'LBL_DV_HEADER' => '销售预测:工作单',
  'LBL_DV_LAST_COMMIT_AMOUNT' => '上一次承诺金额:',
  'LBL_DV_LAST_COMMIT_DATE' => '上次承诺日期:',
  'LBL_DV_MY_FORECASTS' => '我的预测',
  'LBL_DV_MY_TEAM' => '我的团队预测',
  'LBL_DV_TIMEPERIOD' => '时间段:',
  'LBL_DV_TIMEPERIODS' => '时间段:',
  'LBL_DV_TIMPERIOD_DATES' => '日期范围:',
  'LBL_EDITABLE_INVALID' => '无效值 {0}',
  'LBL_EDITABLE_INVALID_RANGE' => '值必须在 {0} 和 {1} 之间',
  'LBL_ERROR_NOT_MANAGER' => 'Error: user {0} does not have manager access to request forecasts for {1}<br />错误：用户{0}没有权限管理{1}的销售预测',
  'LBL_EXPECTED_OPPORTUNITIES' => '预期的商业机会',
  'LBL_EXPORT_CSV' => '导出CSV',
  'LBL_FC_START_DATE' => '开始日期',
  'LBL_FC_USER' => '安排为',
  'LBL_FDR_ADJ_AMOUNT' => '调整后金额',
  'LBL_FDR_COMMIT' => '已承诺金额',
  'LBL_FDR_C_BEST_CASE' => '最好情形',
  'LBL_FDR_C_LIKELY_CASE' => '可能情形',
  'LBL_FDR_C_WORST_CASE' => '最坏情形',
  'LBL_FDR_DATE_COMMIT' => '承诺日期',
  'LBL_FDR_OPPORTUNITIES' => '销售预测中的商业机会:',
  'LBL_FDR_USER_NAME' => '直接报告人',
  'LBL_FDR_WEIGH' => '加权商业机会金额:',
  'LBL_FDR_WK_BEST_CASE' => '估计最好情形',
  'LBL_FDR_WK_LIKELY_CASE' => '估计可能情形',
  'LBL_FDR_WK_WORST_CASE' => '估计最坏情形',
  'LBL_FILTERS' => '过滤',
  'LBL_FMT_DIRECT_FORECAST' => '(直属)',
  'LBL_FMT_ROLLUP_FORECAST' => '(汇总)',
  'LBL_FORECAST' => '销售预测',
  'LBL_FORECASTS_CONFIG_ADMIN_SPLASH_1' => '欢迎来到销售预测设置!',
  'LBL_FORECASTS_CONFIG_ADMIN_SPLASH_2' => '这个向导程序将指导您一步一步的设置销售预测模块。您可以在任何时间和方式，设置每个部分的默认值。',
  'LBL_FORECASTS_CONFIG_ADMIN_SPLASH_3' => '你也可以通过点击进行手工设置。',
  'LBL_FORECASTS_CONFIG_BREADCRUMB_RANGES' => '范围',
  'LBL_FORECASTS_CONFIG_BREADCRUMB_SCENARIOS' => '情景',
  'LBL_FORECASTS_CONFIG_BREADCRUMB_TIMEPERIODS' => '时间周期',
  'LBL_FORECASTS_CONFIG_BREADCRUMB_VARIABLES' => '变量',
  'LBL_FORECASTS_CONFIG_LEAFPERIOD' => '选择子周期,查看你的时间周期:',
  'LBL_FORECASTS_CONFIG_PROJECTED_SCENARIOS' => '在总数中显示计划场景',
  'LBL_FORECASTS_CONFIG_PROJECTED_SCENARIOS_BEST' => '显示最佳情况总数',
  'LBL_FORECASTS_CONFIG_PROJECTED_SCENARIOS_LIKELY' => '显示可能出现的情况总数',
  'LBL_FORECASTS_CONFIG_PROJECTED_SCENARIOS_WORST' => '显示最差情况总数',
  'LBL_FORECASTS_CONFIG_RANGES' => '预测范围选项:',
  'LBL_FORECASTS_CONFIG_RANGES_EXCLUDE_INFO' => '所有其他的机会将被排除在外。',
  'LBL_FORECASTS_CONFIG_RANGES_OPTIONS' => '为机会预测配置默认机率范围。',
  'LBL_FORECASTS_CONFIG_RANGES_SETUP_NOTICE' => '在预测模块中,范围设置不能在首次保存草稿或提交后更改 。然而为了升级实例,范围设置不能在初始设置后更改,可以通过升级解决。',
  'LBL_FORECASTS_CONFIG_SHOW_BINARY_RANGES_DESCRIPTION' => '在预测中机会可以包含或排除。',
  'LBL_FORECASTS_CONFIG_SHOW_BUCKETS_RANGES_DESCRIPTION' => '在预测中机会可以标记为包括,提升或排除。好处是不包括在预测在默认情况下,允许用户进一步排除机会，并基于可能性来关闭。',
  'LBL_FORECASTS_CONFIG_SHOW_CUSTOM_BUCKETS_RANGES' => '定制范围：该选项提供用户分类商业机会，能够将预测设置成固定的范围，排除范围和其他的设置。',
  'LBL_FORECASTS_CONFIG_START_DATE' => '选择财政年度开始日期',
  'LBL_FORECASTS_CONFIG_TIMEPERIOD' => '选择类型的时间周期',
  'LBL_FORECASTS_CONFIG_TIMEPERIODS_BACKWARD' => '未来时间段查看工作表中选择。这个数值用于选择基本时间。例如,每月选择2将显示6表示过去几个月。',
  'LBL_FORECASTS_CONFIG_TIMEPERIODS_FORWARD' => '未来时间段查看工作表中选择。这个数值用于选择基本时间。例如,每年选择2将显示8代表未来几个季度。',
  'LBL_FORECASTS_CONFIG_TIMEPERIOD_DESC' => '配置时间用于预测。',
  'LBL_FORECASTS_CONFIG_TIMEPERIOD_SETUP_NOTICE' => '时间段设置初始后不能更改。',
  'LBL_FORECASTS_CONFIG_TIMEPERIOD_TYPE' => '选择你的组织使用的会计年度类型。',
  'LBL_FORECASTS_CONFIG_TITLE' => '预测设置',
  'LBL_FORECASTS_CONFIG_USER_SPLASH' => '预测还没有配置。请联系您的系统管理员。',
  'LBL_FORECASTS_CONFIG_VARIABLES' => '变量',
  'LBL_FORECASTS_CONFIG_VARIABLES_CLOSED_LOST_STAGE' => '请选择销售阶段,关闭或丢失商业机会:',
  'LBL_FORECASTS_CONFIG_VARIABLES_CLOSED_WON_STAGE' => 'Please select the Sales Stage that represent closed and won opportunities:<br />请选择销售阶段,关闭异议,赢得机会:',
  'LBL_FORECASTS_CONFIG_VARIABLES_DESC' => '指标表的公式依赖于销售阶段，需要从pipleline排除，也就是说，关闭和丢失的商业机会。',
  'LBL_FORECASTS_CONFIG_VARIABLES_FORMULA_DESC' => '因此管道公式将:',
  'LBL_FORECASTS_CONFIG_WORKSHEET_LIKELY_INFO' => '可能是基本输入数量在机会模块。',
  'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS' => '选择场景包括在预测表。',
  'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_BEST' => '最佳',
  'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_LIKELY' => '可能',
  'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_WORST' => '最差',
  'LBL_FORECASTS_TABBED_CONFIG_SUCCESS_MESSAGE' => '设置已保存。请稍候,加载的模块。',
  'LBL_FORECASTS_WIZARD_REFRESH_NOTICE' => '你第一次使用预测模块和商业机会需要加载。这个过程可能需要几分钟,您可能需要刷新页面。',
  'LBL_FORECASTS_WIZARD_SUCCESS_MESSAGE' => '你成功地建立你的预测模块。请稍候,加载的模块。',
  'LBL_FORECASTS_WIZARD_SUCCESS_TITLE' => '成功:',
  'LBL_FORECAST_FOR' => '销售预测工作单为:',
  'LBL_FORECAST_HISTORY' => '预测:历史',
  'LBL_FORECAST_HISTORY_TITLE' => '历史',
  'LBL_FORECAST_ID' => 'ID',
  'LBL_FORECAST_OPP_BEST_CASE' => '最好情形',
  'LBL_FORECAST_OPP_COMMIT' => '可能情形',
  'LBL_FORECAST_OPP_COUNT' => '商业机会',
  'LBL_FORECAST_OPP_WEIGH' => '加权金额',
  'LBL_FORECAST_OPP_WORST' => '最坏情形',
  'LBL_FORECAST_PIPELINE_OPP_COUNT' => '商业机会通道计数',
  'LBL_FORECAST_SETTINGS' => '设置',
  'LBL_FORECAST_TIME_ID' => '时段编号',
  'LBL_FORECAST_TITLE' => '销售预测',
  'LBL_FORECAST_TYPE' => '销售预测类型',
  'LBL_FORECAST_USER' => '用户',
  'LBL_FS_CASCADE' => '级联?',
  'LBL_FS_CREATED_BY' => '创建人',
  'LBL_FS_DATE_ENTERED' => '输入日期',
  'LBL_FS_DATE_MODIFIED' => '修改日期',
  'LBL_FS_DELETED' => '已删除',
  'LBL_FS_END_DATE' => '结束日期',
  'LBL_FS_FORECAST_FOR' => '安排:',
  'LBL_FS_FORECAST_START_DATE' => '预测开始日期',
  'LBL_FS_MODULE_NAME' => '销售预测安排',
  'LBL_FS_START_DATE' => '开始日期',
  'LBL_FS_STATUS' => '状态',
  'LBL_FS_TIMEPERIOD' => '时段',
  'LBL_FS_TIMEPERIOD_ID' => '时段编号',
  'LBL_FS_USER_ID' => '用户编号',
  'LBL_GRAPH_COMMIT_ALTTEXT' => '提交定额为%s',
  'LBL_GRAPH_COMMIT_LEGEND' => '已提交的销售预测',
  'LBL_GRAPH_OPPS_ALTTEXT' => '完成商业机会的价值是%s',
  'LBL_GRAPH_OPPS_LEGEND' => '完成的商业机会',
  'LBL_GRAPH_QUOTA_ALTTEXT' => '定额为%s',
  'LBL_GRAPH_QUOTA_LEGEND' => '定额',
  'LBL_GRAPH_TITLE' => '销售预测历史',
  'LBL_GROUP_BY' => '分组',
  'LBL_INCLUDED_TOTAL' => '包括合计',
  'LBL_LESS' => '少于',
  'LBL_LIKELY_CASE' => '可能情形:',
  'LBL_LIKELY_CASE_BASE_CURRENCY' => '适合(调整过的)基础货币',
  'LBL_LIKELY_CASE_VALUE' => '可能(已调整)',
  'LBL_LIST_FORM_TITLE' => '提交销售预测',
  'LBL_LOADING' => '加载中 ...',
  'LBL_LOADING_COMMIT_HISTORY' => '指派历史',
  'LBL_LV_COMMIT' => '已提交金额',
  'LBL_LV_COMMIT_DATE' => '提交日期',
  'LBL_LV_OPPORTUNITIES' => '商业机会',
  'LBL_LV_TIMPERIOD' => '时段',
  'LBL_LV_TIMPERIOD_END_DATE' => '结束日期',
  'LBL_LV_TIMPERIOD_START_DATE' => '开始日期',
  'LBL_LV_TYPE' => '销售预测类型',
  'LBL_LV_WEIGH' => '加权金额',
  'LBL_MODIFIED_USER_ID' => '修改人',
  'LBL_MODULE_NAME' => '销售预测',
  'LBL_MODULE_NAME_SINGULAR' => '销售预测',
  'LBL_MODULE_TITLE' => '销售预测',
  'LBL_MORE' => '更多',
  'LBL_MY_OPPORTUNITIES' => '商业机会 ({0})',
  'LBL_NO_ACTIVE_TIMEPERIOD' => '没有可用的销售预测时段。',
  'LBL_OVERALL_TOTAL' => '综合总计',
  'LBL_OW_ACCOUNTNAME' => '帐户',
  'LBL_OW_DESCRIPTION' => '说明',
  'LBL_OW_MODULE_TITLE' => '商业机会工作单',
  'LBL_OW_NEXT_STEP' => '下一步',
  'LBL_OW_OPPORTUNITIES' => '商业机会',
  'LBL_OW_PROBABILITY' => '概率',
  'LBL_OW_REVENUE' => '金额',
  'LBL_OW_TYPE' => '类型',
  'LBL_OW_WEIGHTED' => '加权金额',
  'LBL_PIPELINE_OPPORTUNITIES' => '机会管道',
  'LBL_PIPELINE_REVENUE' => '收入管道',
  'LBL_PIPELINE_SIZE' => '管道导出大小',
  'LBL_PREVIOUS_COMMIT' => '最近提交:',
  'LBL_PRODUCT_ID' => '产品编号：',
  'LBL_PROJECTED' => '计划',
  'LBL_QC_COMMIT_BEST_CASE' => '承诺金额(最好情形):',
  'LBL_QC_COMMIT_BUTTON' => '承诺',
  'LBL_QC_COMMIT_LIKELY_CASE' => '承诺金额(可能情形):',
  'LBL_QC_COMMIT_VALUE' => '承诺金额:',
  'LBL_QC_COMMIT_WORST_CASE' => '承诺金额(最坏情形):',
  'LBL_QC_DIRECT_FORECAST' => '我的直接预测:',
  'LBL_QC_HEADER_DELIM' => '至',
  'LBL_QC_LAST_BEST_CASE' => '上次承诺金额(最好情形):',
  'LBL_QC_LAST_COMMIT_VALUE' => '上次承诺金额:',
  'LBL_QC_LAST_DATE_COMMITTED' => '上次承诺日期:',
  'LBL_QC_LAST_LIKELY_CASE' => '上次承诺金额(可能情形):',
  'LBL_QC_LAST_WORST_CASE' => '上次承诺金额(最坏情形):',
  'LBL_QC_OPPORTUNITY_COUNT' => '商业机会总数:',
  'LBL_QC_ROLLUP_FORECAST' => '我的组销售预测:',
  'LBL_QC_ROLL_BEST_VALUE' => '汇总承诺金额(最好情形):',
  'LBL_QC_ROLL_COMMIT_VALUE' => '汇总承诺金额:',
  'LBL_QC_ROLL_LIKELY_VALUE' => '汇总承诺金额(可能情形):',
  'LBL_QC_ROLL_WORST_VALUE' => '汇总承诺金额(最坏情形):',
  'LBL_QC_TIME_PERIOD' => '时段:',
  'LBL_QC_UPCOMING_FORECASTS' => '我的销售预测:',
  'LBL_QC_WEIGHT_VALUE' => '加权金额:',
  'LBL_QC_WORKSHEET_BUTTON' => '工作单',
  'LBL_QUOTA' => '定额',
  'LBL_QUOTA_ID' => '配额编号',
  'LBL_REPORTS_TO_USER_NAME' => '汇报人',
  'LBL_RESET_CHECK' => '所有选择时段中的工作单数据和登录的用户将被移除，继续?',
  'LBL_RESET_WOKSHEET' => '重设工作单',
  'LBL_REVENUE' => '收入',
  'LBL_SALES_STAGE' => '销售阶段：',
  'LBL_SAVE_DRAFT' => '保存草稿',
  'LBL_SAVE_WOKSHEET' => '保存工作单',
  'LBL_SEARCH' => '选择',
  'LBL_SEARCH_LABEL' => '选择',
  'LBL_SHOW_CHART' => '查看图表',
  'LBL_SVFS_CASCADE' => '级联报告?',
  'LBL_SVFS_FORECASTDATE' => '安排开始日期',
  'LBL_SVFS_HEADER' => '销售预测安排:',
  'LBL_SVFS_STATUS' => '状态',
  'LBL_SVFS_USER' => '为',
  'LBL_TIMEPERIOD_NAME' => '时段',
  'LBL_TOTAL' => '总计',
  'LBL_TOTAL_VALUE' => '总计:',
  'LBL_TP_QUOTA' => '定额:',
  'LBL_TREE_PARENT' => '父类',
  'LBL_UNAUTH_FORECASTS' => '预测设置访问未经授权。',
  'LBL_UP' => '向上',
  'LBL_USER_NAME' => '用户名',
  'LBL_VERSION' => '版本',
  'LBL_WK_REVISION' => '修订版本',
  'LBL_WK_VERSION' => '版本',
  'LBL_WORKSHEET_AMOUNT' => '总估算金额',
  'LBL_WORKSHEET_COMMIT_ALERT' => '你提交了Rep 视图，但是你不能管理它；团队视图也不能被提交，直到管理器视图被提交。',
  'LBL_WORKSHEET_COMMIT_CONFIRM' => '你有未保存修改的提交。在你提交前保存的更改将不可见。< br >按下OK提交更改和继续,或取消修改更改并继续。',
  'LBL_WORKSHEET_EXPORT_CONFIRM' => '请注意,只有保存或提交的数据可以被导出。单击OK继续导出,或者点击取消返回工作表',
  'LBL_WORKSHEET_ID' => '工作表编号',
  'LBL_WORKSHEET_SAVE_CONFIRM' => '您有未保存修改的工作表。按下Ok来保存为草稿,继续或取消修改并继续。',
  'LBL_WORKSHEET_SAVE_CONFIRM_UNLOAD' => '您有未保存的改变你的工作表。',
  'LBL_WORST_CASE' => '最坏情形:',
  'LBL_WORST_CASE_BASE_CURRENCY' => '最差(调整过的)基础货币',
  'LBL_WORST_CASE_VALUE' => '最坏(已调整)',
  'LB_FS_BEST_CASE' => '最好情形',
  'LB_FS_KEY' => '编号',
  'LB_FS_LIKELY_CASE' => '可能情形',
  'LB_FS_WORST_CASE' => '最坏情形',
  'LNK_FORECASTS_CONFIG_ADMIN_SPLASH_HERE' => '这里。',
  'LNK_FORECAST_LIST' => '销售预测历史',
  'LNK_NEW_OPPORTUNITY' => '新增商业机会',
  'LNK_NEW_TIMEPERIOD' => '新增时段',
  'LNK_QUOTA' => '定额',
  'LNK_TIMEPERIOD_LIST' => '时段',
  'LNK_UPD_FORECAST' => '预测工作单',
);
