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
  'LBL_ACTIVE' => 'アクティブ',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活動',
  'LBL_API_CONSKEY' => 'コンシューマキー',
  'LBL_API_CONSSECRET' => 'コンシューマシークレット',
  'LBL_API_DATA' => 'APIデータ',
  'LBL_API_OAUTHTOKEN' => 'OAuthトークン',
  'LBL_API_TYPE' => 'ログインタイプ',
  'LBL_APPLICATION' => 'アプリケーション',
  'LBL_APPLICATION_FOUND_NOTICE' => 'このアプリケーションのアカウントは既に存在します。既存のアカウントに戻しました。',
  'LBL_ASSIGNED_TO_ID' => 'アサイン先ID',
  'LBL_ASSIGNED_TO_NAME' => 'アサイン先',
  'LBL_AUTH_ERROR' => 'このアカウントへの接続に失敗しました。',
  'LBL_AUTH_UNSUPPORTED' => 'この認証方法はアプリケーションがサポートしていません。',
  'LBL_BASIC_SAVE_NOTICE' => '接続をクリックしてこのアカウントをSugarに接続してください。',
  'LBL_CONNECTED' => '接続済み',
  'LBL_CONNECT_BUTTON_TITLE' => '接続',
  'LBL_CREATED' => '作成者',
  'LBL_CREATED_ID' => '作成者ID',
  'LBL_CREATED_USER' => '作成者',
  'LBL_DATE_ENTERED' => '作成日',
  'LBL_DATE_MODIFIED' => '更新日',
  'LBL_DELETED' => '削除済み',
  'LBL_DESCRIPTION' => '詳細',
  'LBL_DISCONNECTED' => '未接続',
  'LBL_DISPLAY_PROPERTIES' => 'プロパティの表示',
  'LBL_ERR_FACEBOOK' => 'Facebookがエラーを返しました。フィードは表示されません。',
  'LBL_ERR_FAILED_QUICKCHECK' => '{0} アカウントには接続していません。OKをクリックするとアカウントに接続して接続を再度アクティブにします。',
  'LBL_ERR_NO_AUTHINFO' => 'このアカウントの認証情報がありません。',
  'LBL_ERR_NO_RESPONSE' => 'このアカウントに接続する際にエラーが発生しました。',
  'LBL_ERR_NO_TOKEN' => 'このアカウントのログイントークンがありません。',
  'LBL_ERR_OAUTH_FACEBOOK_1' => 'Facebookセッションは期限切れとなりました。To get stream, please',
  'LBL_ERR_OAUTH_FACEBOOK_2' => 'Facebookに再びログインします',
  'LBL_ERR_POPUPS_DISABLED' => 'ブラウザのポップアップを許可するようにしてください。もしくは、「{0}」サイトを例外として追加して接続してください。',
  'LBL_ERR_TWITTER' => 'Twitterがエラーを返しました。フィードは表示されません。',
  'LBL_HISTORY_SUBPANEL_TITLE' => '履歴',
  'LBL_HOMEPAGE_TITLE' => '私のアカウント',
  'LBL_ID' => 'ID',
  'LBL_LIST_FORM_TITLE' => '外部アカウント',
  'LBL_LIST_NAME' => '名前',
  'LBL_MEET_NOW_BUTTON' => 'すぐ会議',
  'LBL_MODIFIED' => '更新者',
  'LBL_MODIFIED_ID' => '更新者ID',
  'LBL_MODIFIED_NAME' => '更新者',
  'LBL_MODIFIED_USER' => '更新者',
  'LBL_MODULE_NAME' => '外部アカウント',
  'LBL_MODULE_NAME_SINGULAR' => '外部アカウント',
  'LBL_MODULE_TITLE' => '外部アカウント',
  'LBL_NAME' => '名前',
  'LBL_NEW_FORM_TITLE' => '外部アカウント作成',
  'LBL_NOTE' => 'メモ',
  'LBL_OAUTH_NAME' => '%s',
  'LBL_OAUTH_SAVE_NOTICE' => '接続をクリックすると、Sugarからアカウントにアクセスする情報を入力する画面に移動します。接続するとSugarに戻ります。',
  'LBL_OMIT_URL' => '（http://またはhttps://は不要）',
  'LBL_PASSWORD' => 'Appパスワード',
  'LBL_REAUTHENTICATE_KEY' => 'a',
  'LBL_REAUTHENTICATE_LABEL' => '再認証',
  'LBL_SEARCH_FORM_TITLE' => '外部ソースの検索',
  'LBL_SUCCESS' => '成功',
  'LBL_SUGAR_EAPM_SUBPANEL_TITLE' => '外部アカウント',
  'LBL_SUGAR_USER_NAME' => 'Sugarユーザ',
  'LBL_TEAM' => 'チーム',
  'LBL_TEAMS' => 'チーム',
  'LBL_TEAM_ID' => 'チームID',
  'LBL_TITLE_LOTUS_LIVE_DOCUMENTS' => 'LotusLive™ファイル',
  'LBL_TITLE_LOTUS_LIVE_MEETINGS' => '直近のLotusLive™ Meetings',
  'LBL_URL' => 'URL',
  'LBL_USER_NAME' => 'Appユーザ名',
  'LBL_VALIDATED' => '接続済み',
  'LBL_VIEW_LOTUS_LIVE_DOCUMENTS' => 'LotusLive™ファイルを見る',
  'LBL_VIEW_LOTUS_LIVE_MEETINGS' => '直近のLotusLive™ Meetingsを見る',
  'LNK_IMPORT_SUGAR_EAPM' => '外部アカウントのインポート',
  'LNK_LIST' => '外部アカウント閲覧',
  'LNK_NEW_RECORD' => '外部アカウント作成',
);

