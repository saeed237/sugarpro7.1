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
  'ERR_DELETE_RECORD' => '商品を削除するにはレコード番号を指定する必要があります。',
  'LBL_ACCOUNT_NAME' => '取引先:',
  'LBL_ASSIGNED_TO' => 'アサイン先:',
  'LBL_ASSIGNED_TO_ID' => 'アサイン先ID:',
  'LBL_CATEGORY' => 'カテゴリ:',
  'LBL_CATEGORY_ID' => 'カテゴリID',
  'LBL_CATEGORY_NAME' => 'カテゴリ名:',
  'LBL_CONTACT_NAME' => '取引先担当者:',
  'LBL_COST_PRICE' => '原価:',
  'LBL_COST_USDOLLAR' => '原価 USD:',
  'LBL_CURRENCY' => '通貨:',
  'LBL_CURRENCY_SYMBOL_NAME' => '通貨シンボル:',
  'LBL_DATE_AVAILABLE' => '出荷可能日:',
  'LBL_DATE_COST_PRICE' => '原価確定日:',
  'LBL_DESCRIPTION' => '詳細:',
  'LBL_DISCOUNT_PRICE' => '単価:',
  'LBL_DISCOUNT_PRICE_DATE' => '値引日:',
  'LBL_DISCOUNT_USDOLLAR' => '割引価格 USD:',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'アサイン先ID',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'アサイン先',
  'LBL_EXPORT_COST_PRICE' => '原価',
  'LBL_EXPORT_CREATED_BY' => '作成者ID',
  'LBL_EXPORT_CURRENCY' => '通貨',
  'LBL_EXPORT_CURRENCY_ID' => '通貨ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => '更新者ID',
  'LBL_LIST_CATEGORY' => 'カテゴリ:',
  'LBL_LIST_CATEGORY_ID' => 'カテゴリID:',
  'LBL_LIST_COST_PRICE' => '原価:',
  'LBL_LIST_DISCOUNT_PRICE' => '単価:',
  'LBL_LIST_FORM_TITLE' => 'カタログ商品一覧',
  'LBL_LIST_LBL_MFT_PART_NUM' => '製造元番号',
  'LBL_LIST_LIST_PRICE' => '定価',
  'LBL_LIST_MANUFACTURER' => '製造元',
  'LBL_LIST_MANUFACTURER_ID' => '製造元ID',
  'LBL_LIST_NAME' => '名前',
  'LBL_LIST_PRICE' => '定価:',
  'LBL_LIST_QTY_IN_STOCK' => '数量',
  'LBL_LIST_STATUS' => '在庫',
  'LBL_LIST_TYPE' => 'タイプ:',
  'LBL_LIST_TYPE_ID' => 'タイプID:',
  'LBL_LIST_USDOLLAR' => '表示価格 USD:',
  'LBL_MANUFACTURER' => '製造元',
  'LBL_MANUFACTURERS' => '製造元',
  'LBL_MANUFACTURER_ID' => '製造元ID',
  'LBL_MANUFACTURER_NAME' => '製造元名:',
  'LBL_MFT_PART_NUM' => '製造元パートナンバー:',
  'LBL_MODULE_ID' => '商品テンプレート',
  'LBL_MODULE_NAME' => '商品カタログ',
  'LBL_MODULE_NAME_SINGULAR' => '商品カタログ',
  'LBL_MODULE_TITLE' => '商品カタログ: ホーム',
  'LBL_NAME' => '商品名:',
  'LBL_NEW_FORM_TITLE' => 'アイテム作成',
  'LBL_PERCENTAGE' => 'パーセント（%）',
  'LBL_POINTS' => 'ポイント',
  'LBL_PRICING_FACTOR' => '価格設定要素:',
  'LBL_PRICING_FORMULA' => 'デフォルト価格計算式:',
  'LBL_PRODUCT' => '商品:',
  'LBL_PRODUCT_CATEGORIES' => '商品カテゴリ',
  'LBL_PRODUCT_ID' => '商品ID:',
  'LBL_PRODUCT_TYPES' => '商品タイプ',
  'LBL_QTY_IN_STOCK' => '在庫数量',
  'LBL_QUANTITY' => '在庫数量:',
  'LBL_RELATED_PRODUCTS' => '関連商品',
  'LBL_SEARCH_FORM_TITLE' => '商品カタログ検索',
  'LBL_STATUS' => '在庫:',
  'LBL_SUPPORT_CONTACT' => 'サポート問合せ先:',
  'LBL_SUPPORT_DESCRIPTION' => 'サポート詳細:',
  'LBL_SUPPORT_NAME' => 'サポート名:',
  'LBL_SUPPORT_TERM' => 'サポート期間:',
  'LBL_TAX_CLASS' => '税区分:',
  'LBL_TYPE' => 'タイプ',
  'LBL_TYPE_ID' => 'タイプID',
  'LBL_TYPE_NAME' => 'タイプ名',
  'LBL_URL' => '商品URL:',
  'LBL_VENDOR_PART_NUM' => '販売元パートナンバー:',
  'LBL_WEBSITE' => 'Webサイト',
  'LBL_WEIGHT' => '重量:',
  'LNK_IMPORT_PRODUCTS' => '商品のインポート',
  'LNK_NEW_MANUFACTURER' => '製造元',
  'LNK_NEW_PRODUCT' => 'カタログ用の商品を作成',
  'LNK_NEW_PRODUCT_CATEGORY' => '商品カテゴリ',
  'LNK_NEW_PRODUCT_TYPE' => '商品タイプ',
  'LNK_NEW_SHIPPER' => '運送会社',
  'LNK_PRODUCT_LIST' => '商品カタログ',
  'NTC_DELETE_CONFIRMATION' => '本当にこのレコードを削除してよいですか？',
);

