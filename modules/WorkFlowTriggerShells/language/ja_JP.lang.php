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
  'LBL_ALERT_TEMPLATES' => '通知用Eメールテンプレート',
  'LBL_APOSTROPHE_S' => 'のもの',
  'LBL_COMPARE_ANY_TIME_PART2' => '以下の時間変更しない:',
  'LBL_COMPARE_ANY_TIME_PART3' => '一定時間',
  'LBL_COMPARE_ANY_TIME_TITLE' => '一定時間、フィールドは変更しない',
  'LBL_COMPARE_CHANGE_PART' => 'が変更されたとき',
  'LBL_COMPARE_CHANGE_TITLE' => '対象モジュールのフィールドが変更されたとき',
  'LBL_COMPARE_COUNT_TITLE' => '一定の数量で発行',
  'LBL_COMPARE_SPECIFIC_PART' => 'が次の値に（から）変更されたとき',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => '対象モジュールのフィールドが特定の値に、もしくは特定の値から変更されたとき',
  'LBL_COUNT_TRIGGER1' => '計',
  'LBL_COUNT_TRIGGER1_2' => 'この値と比較',
  'LBL_COUNT_TRIGGER2' => '関連でフィルタ',
  'LBL_COUNT_TRIGGER2_2' => 'のみ',
  'LBL_COUNT_TRIGGER3' => '特に以下でフィルタ',
  'LBL_COUNT_TRIGGER4' => '秒でフィルタ',
  'LBL_EVAL' => 'トリガーの評価:',
  'LBL_FIELD' => 'フィールド',
  'LBL_FILTER_FIELD_PART1' => '次でフィルタ:',
  'LBL_FILTER_FIELD_TITLE' => '対象モジュールのフィールドが次の値を含むとき',
  'LBL_FILTER_FORM_TITLE' => 'ワークフロー条件を定義',
  'LBL_FILTER_LIST_STATEMEMT' => '以下に従って対象をフィルタ:',
  'LBL_FILTER_REL_FIELD_PART1' => '以下のフィールドが次の値をもつとき:',
  'LBL_FILTER_REL_FIELD_TITLE' => '対象モジュールが変更され、関連モジュールのフィールドが特定の値を含むとき',
  'LBL_FUTURE_TRIGGER' => '新しい値を指定',
  'LBL_LIST_EVAL' => '評価:',
  'LBL_LIST_FIELD' => 'フィールド:',
  'LBL_LIST_FORM_TITLE' => 'トリガー一覧',
  'LBL_LIST_FRAME_PRI' => 'トリガー:',
  'LBL_LIST_FRAME_SEC' => 'フィルタ:',
  'LBL_LIST_NAME' => '詳細:',
  'LBL_LIST_STATEMEMT' => '以下に従ってイベントを発行:',
  'LBL_LIST_TYPE' => 'タイプ:',
  'LBL_LIST_VALUE' => '値:',
  'LBL_MODULE' => 'モジュール',
  'LBL_MODULE_NAME' => '条件',
  'LBL_MODULE_NAME_SINGULAR' => '条件',
  'LBL_MODULE_SECTION_TITLE' => '実行条件',
  'LBL_MODULE_TITLE' => 'ワークフロートリガー: ホーム',
  'LBL_MUST_SELECT_VALUE' => 'フィールドの値を選択してください。',
  'LBL_NAME' => 'トリガー名:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'フィルタ作成',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'フィルタ作成[Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'トリガー作成',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'トリガー作成',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'トリガー作成[Alt+T]',
  'LBL_PAST_TRIGGER' => '古い値を指定',
  'LBL_RECORD' => 'モジュールの',
  'LBL_SEARCH_FORM_TITLE' => 'ワークフロートリガー検索',
  'LBL_SELECT_1ST_FILTER' => '１番目のフィールドに対して適切なフィルタを選択してください。',
  'LBL_SELECT_2ND_FILTER' => '２番目のフィールドに対して適切なフィルタを選択してください。',
  'LBL_SELECT_AMOUNT' => '数量を選択してください。',
  'LBL_SELECT_OPTION' => 'オプションを選択してください。',
  'LBL_SELECT_TARGET_FIELD' => 'ターゲットフィールドを選択してください。',
  'LBL_SELECT_TARGET_MOD' => 'ターゲットの関連モジュールを選択してください。',
  'LBL_SHOW' => '表示',
  'LBL_SHOW_PAST' => '以前の値を修正:',
  'LBL_SPECIFIC_FIELD' => 'が特定したフィールド',
  'LBL_SPECIFIC_FIELD_LNK' => 'フィールドの選択',
  'LBL_TRIGGER' => '以下の場合:',
  'LBL_TRIGGER_FILTER_TITLE' => 'フィルタを発行',
  'LBL_TRIGGER_FORM_TITLE' => 'ワークフロー実行のための条件を定義',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => '対象モジュールが変更されたとき',
  'LBL_TYPE' => 'タイプ:',
  'LBL_VALUE' => '値',
  'LBL_WHEN_VALUE1' => 'フィールドの値が次の時',
  'LBL_WHEN_VALUE2' => '値が次の時',
  'LNK_NEW_TRIGGER' => 'トリガー作成',
  'LNK_NEW_WORKFLOW' => 'ワークフロー作成',
  'LNK_TRIGGER' => 'ワークフロートリガー',
  'LNK_WORKFLOW' => 'ワークフローの対象',
  'NTC_REMOVE_TRIGGER' => '本当にこのトリガーをはずしてよいですか？',
);

