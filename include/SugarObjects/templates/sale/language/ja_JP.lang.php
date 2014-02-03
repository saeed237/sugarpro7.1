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
  'ERR_DELETE_RECORD' => '商談を削除するにはレコード番号を指定する必要があります。',
  'LBL_ACCOUNT_ID' => '取引先ID',
  'LBL_ACCOUNT_NAME' => '取引先:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活動',
  'LBL_AMOUNT' => '金額:',
  'LBL_AMOUNT_USDOLLAR' => '金額USD:',
  'LBL_ASSIGNED_TO_ID' => 'アサイン先',
  'LBL_ASSIGNED_TO_NAME' => 'アサイン先:',
  'LBL_CAMPAIGN' => 'キャンペーン:',
  'LBL_CLOSED_WON_SALES' => '受注済み商談',
  'LBL_CONTACTS_SUBPANEL_TITLE' => '取引先担当者',
  'LBL_CREATED_ID' => '作成者ID',
  'LBL_CURRENCY' => '通貨:',
  'LBL_CURRENCY_ID' => '通貨ID',
  'LBL_CURRENCY_NAME' => '通貨名',
  'LBL_CURRENCY_SYMBOL' => '通貨シンボル',
  'LBL_DATE_CLOSED' => '受注予定日:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => '商談',
  'LBL_DESCRIPTION' => '詳細:',
  'LBL_DUPLICATE' => '重複の可能性がある商談',
  'LBL_EDIT_BUTTON' => '編集',
  'LBL_HISTORY_SUBPANEL_TITLE' => '履歴',
  'LBL_LEADS_SUBPANEL_TITLE' => 'リード',
  'LBL_LEAD_SOURCE' => 'リードソース:',
  'LBL_LIST_ACCOUNT_NAME' => '取引先',
  'LBL_LIST_AMOUNT' => '金額',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'アサイン先',
  'LBL_LIST_DATE_CLOSED' => '完了',
  'LBL_LIST_FORM_TITLE' => '商談一覧',
  'LBL_LIST_SALE_NAME' => '名前',
  'LBL_LIST_SALE_STAGE' => '商談ステージ',
  'LBL_MODIFIED_ID' => '更新者ID',
  'LBL_MODIFIED_NAME' => '更新者',
  'LBL_MODULE_NAME' => '商談',
  'LBL_MODULE_TITLE' => '商談: ホーム',
  'LBL_MY_CLOSED_SALES' => '私のクローズ済み商談',
  'LBL_NAME' => '商談名',
  'LBL_NEW_FORM_TITLE' => '商談作成',
  'LBL_NEXT_STEP' => '次ステップ:',
  'LBL_PROBABILITY' => '確度 (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'プロジェクト',
  'LBL_RAW_AMOUNT' => '金額',
  'LBL_REMOVE' => 'はずす',
  'LBL_SALE' => '商談名:',
  'LBL_SALES_STAGE' => '商談ステージ:',
  'LBL_SALE_INFORMATION' => '商談情報',
  'LBL_SALE_NAME' => '商談名:',
  'LBL_SEARCH_FORM_TITLE' => '商談検索',
  'LBL_TEAM_ID' => 'チームID',
  'LBL_TOP_SALES' => '交渉中の私の商談',
  'LBL_TOTAL_SALES' => '商談総額',
  'LBL_TYPE' => 'タイプ:',
  'LBL_VIEW_FORM_TITLE' => '商談を見る',
  'LNK_NEW_SALE' => '商談作成',
  'LNK_SALE_LIST' => '商談',
  'MSG_DUPLICATE' => '作成しようとしている商談は既存の商談と重複する可能性があります。類似の商談は以下に表示されています。保存をクリックして新たに商談を作成するか、キャンセルをクリックして商談を作成せずにモジュールに戻ります。',
  'NTC_REMOVE_OPP_CONFIRMATION' => '本当にこの取引先担当者を商談からはずしてよいですか？',
  'SALE_REMOVE_PROJECT_CONFIRM' => '本当にこの商談をプロジェクトからはずしてよいですか？',
  'UPDATE' => '商談の通貨更新',
  'UPDATE_BUGFOUND_COUNT' => '不具合が見つかりました:',
  'UPDATE_BUG_COUNT' => '実行時に不具合が見つかりました:',
  'UPDATE_COUNT' => 'レコードが更新されました:',
  'UPDATE_CREATE_CURRENCY' => '通貨作成:',
  'UPDATE_DOLLARAMOUNTS' => 'USドルの金額を更新',
  'UPDATE_DOLLARAMOUNTS_TXT' => '商談のUSドルの更新は設定されている通貨レートに基づきます。グラフとリストビューでの金額の値に反映されます。',
  'UPDATE_DONE' => '完了',
  'UPDATE_FAIL' => '更新できません -',
  'UPDATE_FIX' => '金額を修正',
  'UPDATE_FIX_TXT' => '現在の金額から正しい区切り文字を使って不正な金額を修正します。修正された金額のバックアップはデータベースのamount_backupフィールドに保存されます。これを実行して問題が発生した場合、バックアップから以前の値を戻してください。さもないと、再度実行すると不正な値でバックアップ値が上書きされます。',
  'UPDATE_INCLUDE_CLOSE' => '完了したレコードを含む',
  'UPDATE_MERGE' => '通貨を統合',
  'UPDATE_MERGE_TXT' => '複数の通貨を１つにまとめます。同じ通貨のレコードが複数ある場合、それらを１つにします。これは他のモジュールの通貨も統合します。',
  'UPDATE_NULL_VALUE' => '金額は空です。0に設定されました。  -',
  'UPDATE_RESTORE' => '金額をリストア',
  'UPDATE_RESTORE_COUNT' => '金額がリストアされました:',
  'UPDATE_RESTORE_TXT' => '修復中にバックアップした内容をリストア',
  'UPDATE_VERIFY' => '金額を検証',
  'UPDATE_VERIFY_CURAMOUNT' => '現在の金額:',
  'UPDATE_VERIFY_FAIL' => '確認に失敗しました:',
  'UPDATE_VERIFY_FIX' => '修正は',
  'UPDATE_VERIFY_NEWAMOUNT' => '金額作成:',
  'UPDATE_VERIFY_NEWCURRENCY' => '通貨作成:',
  'UPDATE_VERIFY_TXT' => '商談の金額が数字（0-9）と小数点（.）で正しく入力されているかどうかを検証します。',
);

