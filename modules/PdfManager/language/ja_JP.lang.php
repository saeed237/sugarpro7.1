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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活動',
  'LBL_ALERT_SWITCH_BASE_MODULE' => '警告: 主モジュールを変更するとテンプレートに追加したフィールドはすべて削除されます。',
  'LBL_ASSIGNED_TO_ID' => 'アサイン先ID',
  'LBL_ASSIGNED_TO_NAME' => 'アサイン先',
  'LBL_AUTHOR' => '著作者',
  'LBL_BASE_MODULE' => 'モジュール',
  'LBL_BASE_MODULE_POPUP_HELP' => 'テンプレートで利用可能なモジュールを選択してください。',
  'LBL_BODY_HTML' => 'テンプレート',
  'LBL_BODY_HTML_POPUP_HELP' => 'HTMLエディタでテンプレートを作成します。テンプレートを保存後、テンプレートのPDF版をプレビューできます。',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'HTMLエディタでテンプレートを作成します。 テンプレートを保存後、テンプレートのPDF版をプレビューできます。<br /><br />エディタ内の「HTML」ボタンをクリックすることで項目情報を生成するためのコードを編集できます。本コードは以下のようなコードで囲まれています。 &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => '挿入',
  'LBL_CREATED' => '作成者',
  'LBL_CREATED_ID' => '作成者ID',
  'LBL_CREATED_USER' => '作成者',
  'LBL_DATE_ENTERED' => '作成日',
  'LBL_DATE_MODIFIED' => '更新日',
  'LBL_DELETED' => '削除済み',
  'LBL_DESCRIPTION' => '詳細',
  'LBL_EDITVIEW_PANEL1' => 'PDFドキュメントプロパティ',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'これは要求されたファイルです（テキストは変更可能です）',
  'LBL_FIELD' => 'フィールド',
  'LBL_FIELDS_LIST' => 'フィールド',
  'LBL_FIELD_POPUP_HELP' => 'フィールドに挿入する値を選択します。親モジュールのフィールドを使用するには、初めに表示されたドロップダウンのフィールド一覧の下にあるリンクエリアのモジュールを選択し、次に表示されたドロップダウンでフィールドを選択してください。',
  'LBL_HISTORY_SUBPANEL_TITLE' => '履歴',
  'LBL_HOMEPAGE_TITLE' => '私のPDFテンプレート',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'キーワード',
  'LBL_KEYWORDS_POPUP_HELP' => 'ドキュメントに付加されるキーワード。一般的に「キーワード1 キーワード2...」のように表記します。',
  'LBL_LINK_LIST' => 'リンク',
  'LBL_LIST_FORM_TITLE' => 'PDFテンプレート一覧',
  'LBL_LIST_NAME' => '名前',
  'LBL_MODIFIED' => '更新者',
  'LBL_MODIFIED_ID' => '更新者ID',
  'LBL_MODIFIED_NAME' => '更新者',
  'LBL_MODIFIED_USER' => '更新ユーザ',
  'LBL_MODULE_NAME' => 'PDF設定',
  'LBL_MODULE_NAME_SINGULAR' => 'PDFマネージャー',
  'LBL_MODULE_TITLE' => 'PDF設定',
  'LBL_NAME' => '名前',
  'LBL_NEW_FORM_TITLE' => 'PDFテンプレート作成',
  'LBL_PAYMENT_TERMS' => '支払条件:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PDF設定',
  'LBL_PREVIEW' => 'プレビュー',
  'LBL_PUBLISHED' => '公開済み',
  'LBL_PUBLISHED_POPUP_HELP' => 'ユーザが利用できるようにテンプレートを公開してください。',
  'LBL_PURCHASE_ORDER_NUM' => '注文番号:',
  'LBL_SEARCH_FORM_TITLE' => 'PDF検索',
  'LBL_SUBJECT' => '件名',
  'LBL_TEAM' => 'チーム',
  'LBL_TEAMS' => 'チーム',
  'LBL_TEAM_ID' => 'チームID',
  'LBL_TITLE' => 'タイトル',
  'LBL_TPL_BILL_TO' => '請求先',
  'LBL_TPL_CURRENCY' => '通貨:',
  'LBL_TPL_DISCOUNT' => '値引',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => '値引き後計',
  'LBL_TPL_EXT_PRICE' => '価格',
  'LBL_TPL_GRAND_TOTAL' => '総計',
  'LBL_TPL_INVOICE' => '請求書',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'このテンプレートは請求書をPDFで作成するときに使用されます。',
  'LBL_TPL_INVOICE_NAME' => '請求書',
  'LBL_TPL_INVOICE_NUMBER' => '請求番号:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => '請求',
  'LBL_TPL_LIST_PRICE' => '定価',
  'LBL_TPL_PART_NUMBER' => 'パートナンバー',
  'LBL_TPL_PRODUCT' => '商品',
  'LBL_TPL_QUANTITY' => '数量',
  'LBL_TPL_QUOTE' => '見積書',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'このテンプレートは見積書をPDFで作成するときに使用されます。',
  'LBL_TPL_QUOTE_NAME' => '見積書',
  'LBL_TPL_QUOTE_NUMBER' => '見積番号:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => '見積',
  'LBL_TPL_SALES_PERSON' => '営業:',
  'LBL_TPL_SHIPPING' => '配送料:',
  'LBL_TPL_SHIPPING_PROVIDER' => '配送業者:',
  'LBL_TPL_SHIP_TO' => '出荷先',
  'LBL_TPL_SUBTOTAL' => '小計:',
  'LBL_TPL_TAX' => '税金:',
  'LBL_TPL_TAX_RATE' => '税率:',
  'LBL_TPL_TOTAL' => '計',
  'LBL_TPL_UNIT_PRICE' => '単価',
  'LBL_TPL_VALID_UNTIL' => '有効期限:',
  'LNK_EDIT_PDF_TEMPLATE' => 'PDFテンプレートを編集',
  'LNK_IMPORT_PDFMANAGER' => 'PDテンプレートのインポート',
  'LNK_LIST' => 'PDFテンプレート一覧',
  'LNK_NEW_RECORD' => 'PDFテンプレート作成',
);

