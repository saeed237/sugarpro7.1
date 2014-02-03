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
  'ERR_NO_OPPS' => '商談グラフを表示させるには、先に商談を作成してください。',
  'LBL_ALL_OPPORTUNITIES' => 'すべての商談の総額は',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'キャンペーンの反応をROI（対投資回収）で表示',
  'LBL_CHART_ACTION' => 'アクション',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'タイプごとのDCEアクション（今月）',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => '結果ごとのリードソース',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => '私の直属の部下の利用モジュール（過去30日間）',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => '私の利用モジュール(過去30日間)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'セールスステージごとの私のパイプライン',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => '今四半期の商談',
  'LBL_CHART_OUTCOME_BY_MONTH' => '月別の結果',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'リードソースごとのパイプライン',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'セールスステージごとのパイプライン',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'セールスステージフィルタによるパイプライン',
  'LBL_CHART_TYPE' => 'チャート種別:',
  'LBL_CLOSE_DATE_END' => '受注予定日 - 終了:',
  'LBL_CLOSE_DATE_START' => '受注予定日 - 開始:',
  'LBL_CREATED_ON' => '最終実行日は',
  'LBL_DATE_END' => '終了日:',
  'LBL_DATE_RANGE' => '日付の範囲は',
  'LBL_DATE_RANGE_TO' => 'から',
  'LBL_DATE_START' => '開始日:',
  'LBL_EDIT' => '編集',
  'LBL_LEAD_SOURCES' => 'リードソース:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'リードソース別商談結果',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => '選択されたユーザおよびリードソースに関して、商談結果ごとの商談金額の積上げ額を表示します。商談結果は商談ステージが「受注」、「失注」、その他によって区分されます。',
  'LBL_LEAD_SOURCE_FORM_DESC' => '選択されたユーザの商談積み上げ金額をリードソース別に表示します。',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'すべてのリードソース別商談',
  'LBL_LEAD_SOURCE_OTHER' => 'その他',
  'LBL_MODULE_NAME' => 'ダッシュボード',
  'LBL_MODULE_NAME_SINGULAR' => 'ダッシュボード',
  'LBL_MODULE_TITLE' => 'ダッシュボード: ホーム',
  'LBL_MONTH_BY_OUTCOME_DESC' => '選択されたユーザに関して、指定された期間内に受注予定日がある商談の金額を商談結果別に月次で積上げて表示します。商談結果は商談ステージが「受注」、「失注」、その他によって区分されます。',
  'LBL_MY_MODULES_USED_SIZE' => 'アクセス数',
  'LBL_NUMBER_OF_OPPS' => '商談数',
  'LBL_OPPS_IN_LEAD_SOURCE' => '次のリードソースの商談:',
  'LBL_OPPS_IN_STAGE' => '次の商談ステージの商談:',
  'LBL_OPPS_OUTCOME' => '次の商談結果の商談:',
  'LBL_OPPS_WORTH' => '商談の金額:',
  'LBL_OPP_SIZE' => '商談金額の単位は',
  'LBL_OPP_THOUSANDS' => 'K',
  'LBL_PIPELINE_FORM_TITLE_DESC' => '選択されたステージ別に、受注予定日が指定された期間にある商談について金額を積上げて表示します。',
  'LBL_REFRESH' => '更新',
  'LBL_ROLLOVER_DETAILS' => '棒グラフにマウスを重ねると詳細を参照できます。',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'くさびにマウスを重ねると詳細を参照できます。',
  'LBL_SALES_STAGES' => '商談ステージ:',
  'LBL_SALES_STAGE_FORM_DESC' => '選択されたユーザに関し、受注予定日が指定された期間にある商談の金額を商談ステージ別に積上げて表示します。',
  'LBL_SALES_STAGE_FORM_TITLE' => '商談ステージ別パイプライン',
  'LBL_TITLE' => 'タイトル:',
  'LBL_TOTAL_PIPELINE' => '総パイプラインは',
  'LBL_USERS' => 'ユーザ:',
  'LBL_YEAR' => '年:',
  'LBL_YEAR_BY_OUTCOME' => '結果別月次パイプライン',
  'LNK_NEW_ACCOUNT' => '取引先作成',
  'LNK_NEW_CALL' => '電話作成',
  'LNK_NEW_CASE' => 'ケース作成',
  'LNK_NEW_CONTACT' => '取引先担当者作成',
  'LNK_NEW_ISSUE' => '不具合作成',
  'LNK_NEW_LEAD' => 'リード作成',
  'LNK_NEW_MEETING' => '会議作成',
  'LNK_NEW_NOTE' => 'メモ作成',
  'LNK_NEW_OPPORTUNITY' => '商談作成',
  'LNK_NEW_QUOTE' => '見積作成',
  'LNK_NEW_TASK' => 'タスク作成',
  'NTC_NO_LEGENDS' => 'なし',
);

