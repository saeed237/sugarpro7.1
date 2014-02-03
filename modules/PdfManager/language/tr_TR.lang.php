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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteler',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'UYARI: Ana modülü değiştirirseniz, şablona önceden eklenen tüm alanların kaldırılması gerekir.',
  'LBL_ASSIGNED_TO_ID' => 'Atanan Kullanıcı ID',
  'LBL_ASSIGNED_TO_NAME' => 'Atanan Kişi',
  'LBL_AUTHOR' => 'Yazar',
  'LBL_BASE_MODULE' => 'Modül',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Bu şablonun kullanılacağı modül seçin.',
  'LBL_BODY_HTML' => 'Şablon',
  'LBL_BODY_HTML_POPUP_HELP' => 'HTML düzenleyicisini kullanarak şablonu oluşturun. Şablonunu kaydettikten sonra, şablonun PDF versiyonunun önizlemesini görüntüleyebilirsiniz.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'HTML düzenleyicisini kullanarak şablonu oluşturun. Şablonunu kaydettikten sonra, şablonun PDF versiyonunun önizlemesini görüntüleyebilirsiniz.<br/><br/>Ürünün satır öğelerini oluşturan döngüyü değiştirmek için, "HTML" editörü butonuna tıklayın ve koda ulaşın. Kod &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt; arasında yer almaktadır.',
  'LBL_BTN_INSERT' => 'Ekle',
  'LBL_CREATED' => 'Oluşturan',
  'LBL_CREATED_ID' => 'Oluşturan ID',
  'LBL_CREATED_USER' => 'Oluşturan Kullanıcı',
  'LBL_DATE_ENTERED' => 'Oluşturulma Tarihi',
  'LBL_DATE_MODIFIED' => 'Değiştirilme Tarihi',
  'LBL_DELETED' => 'Silindi',
  'LBL_DESCRIPTION' => 'Tanım',
  'LBL_EDITVIEW_PANEL1' => 'PDF Doküman Özellikleri',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'İstemiş olduğunuz dosya (Bu metni değiştirebilirsiniz)',
  'LBL_FIELD' => 'Alan',
  'LBL_FIELDS_LIST' => 'Alanlar',
  'LBL_FIELD_POPUP_HELP' => 'Alan değeri olarak kullanılacak değişken alanını seçin. Üst modülden alan seçmek için, açılır alan listesinin sonundaki Linkler seçeneğini, ikinci açılır listede de alanı seçin.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Tarihçeyi Gör',
  'LBL_HOMEPAGE_TITLE' => 'PDF Şablonlarım',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Anahtar kelime(ler)',
  'LBL_KEYWORDS_POPUP_HELP' => 'Anahtar kelimeleri, döküman ile eşleştirin. Anahtar kelimeler genellikle "anahtar1 anahtar2 ..." şeklindedir.',
  'LBL_LINK_LIST' => 'Linkler',
  'LBL_LIST_FORM_TITLE' => 'PDF Şablon Listesi',
  'LBL_LIST_NAME' => 'İsim',
  'LBL_MODIFIED' => 'Değiştiren',
  'LBL_MODIFIED_ID' => 'Değiştiren Id',
  'LBL_MODIFIED_NAME' => 'Değiştiren Kişinin İsmi',
  'LBL_MODIFIED_USER' => 'Değiştiren Kullanıcı',
  'LBL_MODULE_NAME' => 'Pdf Yöneticisi',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfYöneticisi',
  'LBL_MODULE_TITLE' => 'Pdf Yöneticisi',
  'LBL_NAME' => 'İsim',
  'LBL_NEW_FORM_TITLE' => 'Yeni PDF Şablonu',
  'LBL_PAYMENT_TERMS' => 'Ödeme Koşulları:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'Pdf Yöneticisi',
  'LBL_PREVIEW' => 'Ön izleme',
  'LBL_PUBLISHED' => 'Yayınlandı',
  'LBL_PUBLISHED_POPUP_HELP' => 'Kullanıcıların kullanabilmesi için bir şablon yayınla.',
  'LBL_PURCHASE_ORDER_NUM' => 'Sipariş No:',
  'LBL_SEARCH_FORM_TITLE' => 'Pdf Yöneticisi Ara',
  'LBL_SUBJECT' => 'Konu',
  'LBL_TEAM' => 'Takımlar',
  'LBL_TEAMS' => 'Takımlar',
  'LBL_TEAM_ID' => 'Takım Id',
  'LBL_TITLE' => 'Başlık',
  'LBL_TPL_BILL_TO' => 'Faturalanacak Kişi',
  'LBL_TPL_CURRENCY' => 'Para Birimi:',
  'LBL_TPL_DISCOUNT' => 'İndirim',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'İndirimli Alt Toplam:',
  'LBL_TPL_EXT_PRICE' => 'Tutar',
  'LBL_TPL_GRAND_TOTAL' => 'Genel Toplam',
  'LBL_TPL_INVOICE' => 'Fatura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Bu şablon Faturayı PDF formatında yazmak için kullanılır.',
  'LBL_TPL_INVOICE_NAME' => 'Fatura',
  'LBL_TPL_INVOICE_NUMBER' => 'Fatura numarası:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'fatura',
  'LBL_TPL_LIST_PRICE' => 'Liste Fiyatı',
  'LBL_TPL_PART_NUMBER' => 'Parça Numarası',
  'LBL_TPL_PRODUCT' => 'Ürün',
  'LBL_TPL_QUANTITY' => 'Miktar',
  'LBL_TPL_QUOTE' => 'Teklif',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Bu şablon Teklifi PDF formatında yazmak için kullanılır.',
  'LBL_TPL_QUOTE_NAME' => 'Teklif',
  'LBL_TPL_QUOTE_NUMBER' => 'Teklif numarası:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'teklif',
  'LBL_TPL_SALES_PERSON' => 'Satıcı:',
  'LBL_TPL_SHIPPING' => 'Nakliyat:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Nakliye Şirketi:',
  'LBL_TPL_SHIP_TO' => 'Teslim Yeri',
  'LBL_TPL_SUBTOTAL' => 'Alt toplam:',
  'LBL_TPL_TAX' => 'Vergi:',
  'LBL_TPL_TAX_RATE' => 'Vergi Oranı:',
  'LBL_TPL_TOTAL' => 'Toplam',
  'LBL_TPL_UNIT_PRICE' => 'Birim Fiyatı',
  'LBL_TPL_VALID_UNTIL' => 'Geçerlilik tarihi:',
  'LNK_EDIT_PDF_TEMPLATE' => 'PDF Şablonunu Değiştir',
  'LNK_IMPORT_PDFMANAGER' => 'PDF Şablon Verilerini Yükle',
  'LNK_LIST' => 'PDF Şablonlar Görüntüle',
  'LNK_NEW_RECORD' => 'PDF Şablonu Oluştur',
);

