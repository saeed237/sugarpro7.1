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

	

$connector_strings = array (
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">IBM SmartCloud&copy;でSugarインスタンスを新規アプリケーションとして登録することで、コンシューマキーとコンシューマシークレットを取得してください。<br>
&nbsp;<br>
登録方法は以下の通りです。<br>
&nbsp;<br>
<ol>
<li>IBM SmartCloudにログインしてください（管理者である必要があります）。</li>
<li>管理 -> 組織の管理 を開いてください。</li>
<li>サイドバーの「統合サードパーティアプリ」リンクをクリックしてSugarCRMのすべてのユーザが利用できるようにしてください。</li>
<li>サイドバーの「内部アプリ」で「アプリの登録」をクリックしてください。</li>
<li>このアプリの名称を入力してください（例：SugarCRM Production）。このとき、ポップアップ画面の下部に表示されるOAuth 2.xチェックボックスをオンにしないでください。</li>
<li>アプリを作成後、アプリの名称の右に表示されている三角のアイコンをクリックして、ドロップダウンメニューから「認証情報の表示」を選択します。</li>
<li>以下の認証情報を複製してください。</li>
</ol>
</td></tr></table>',
  'oauth_consumer_key' => 'OAuthコンシューマキー',
  'oauth_consumer_secret' => 'OAuthコンシューマシークレット',
);

