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
  'ERR_DELETE_RECORD' => 'Satışı silmek için kayıt no&#39;su belirtilmelidir.',
  'LBL_ACCOUNT_ID' => 'Müşteri ID',
  'LBL_ACCOUNT_NAME' => 'Müşteri İsmi:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteler',
  'LBL_AMOUNT' => 'Tutar:',
  'LBL_AMOUNT_USDOLLAR' => 'YTL Tutarı:',
  'LBL_ASSIGNED_TO_ID' => 'Atanan Kullanıcı ID',
  'LBL_ASSIGNED_TO_NAME' => 'Atanan Kişi:',
  'LBL_CAMPAIGN' => 'Kampanya:',
  'LBL_CLOSED_WON_SALES' => 'Kazanılarak Kapanan Satışlar',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontaklar',
  'LBL_CREATED_ID' => 'Oluşturan ID',
  'LBL_CURRENCY' => 'Para Birimi:',
  'LBL_CURRENCY_ID' => 'Para Birimi ID',
  'LBL_CURRENCY_NAME' => 'Para Birimi İsmi',
  'LBL_CURRENCY_SYMBOL' => 'Para Birimi Sembolü',
  'LBL_DATE_CLOSED' => 'Tahmini Kapanış Tarihi:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Satış',
  'LBL_DESCRIPTION' => 'Tanım:',
  'LBL_DUPLICATE' => 'Muhtemelen Tekrar Eden Satış',
  'LBL_EDIT_BUTTON' => 'Değiştir',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Tarihçe',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Potansiyeller',
  'LBL_LEAD_SOURCE' => 'Potansiyel Kaynağı:',
  'LBL_LIST_ACCOUNT_NAME' => 'Müşteri İsmi',
  'LBL_LIST_AMOUNT' => 'Tutar',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Atanan Kullanıcı',
  'LBL_LIST_DATE_CLOSED' => 'Kapat',
  'LBL_LIST_FORM_TITLE' => 'Satış Listesi',
  'LBL_LIST_SALE_NAME' => 'İsim',
  'LBL_LIST_SALE_STAGE' => 'Satış Aşaması',
  'LBL_MODIFIED_ID' => 'Değiştiren ID',
  'LBL_MODIFIED_NAME' => 'Değiştiren Kullanıcı İsmi',
  'LBL_MODULE_NAME' => 'Satış',
  'LBL_MODULE_TITLE' => 'Satış: Ana Sayfa',
  'LBL_MY_CLOSED_SALES' => 'Kapanmış Satışlarım',
  'LBL_NAME' => 'Satış İsmi',
  'LBL_NEW_FORM_TITLE' => 'Satış Oluştur',
  'LBL_NEXT_STEP' => 'Bir Sonraki Adım:',
  'LBL_PROBABILITY' => 'Olasılık (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projeler',
  'LBL_RAW_AMOUNT' => 'İşlenmemiş Miktar',
  'LBL_REMOVE' => 'Sil',
  'LBL_SALE' => 'Satış:',
  'LBL_SALES_STAGE' => 'Satış Aşaması:',
  'LBL_SALE_INFORMATION' => 'Satış Bilgisi',
  'LBL_SALE_NAME' => 'Satış İsmi:',
  'LBL_SEARCH_FORM_TITLE' => 'Satış Arama',
  'LBL_TEAM_ID' => 'Takım ID',
  'LBL_TOP_SALES' => 'En Önemli Açık Satışım',
  'LBL_TOTAL_SALES' => 'Toplam Satışlar',
  'LBL_TYPE' => 'Tipi:',
  'LBL_VIEW_FORM_TITLE' => 'Satış Görüntüleme',
  'LNK_NEW_SALE' => 'Satış Oluştur',
  'LNK_SALE_LIST' => 'Satış',
  'MSG_DUPLICATE' => 'Şu anda oluşturmakta olduğunuz Satış kaydı, başka bir Satış kaydının benzeri olabilir. Benzer ismi içeren Satış kayıtları aşağıda listelenmektedir.<br>Kaydet butonuna basarak Satışı oluşturmaya devam edebilir, veya İptal butonuna basarak Satışı oluşturmadan modüle geri dönebilirsiniz.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Bu kontağı satıştan silmek istediğinizden emin misiniz?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Bu satışı projeden çıkartmak istediğinizden emin misiniz?',
  'UPDATE' => 'Satış - Para Birimi Güncelle',
  'UPDATE_BUGFOUND_COUNT' => 'Hatalar Bulundu:',
  'UPDATE_BUG_COUNT' => 'Hatalar Bulundu ve Düzeltilmesi Denendi:',
  'UPDATE_COUNT' => 'Güncellenen Kayıtlar:',
  'UPDATE_CREATE_CURRENCY' => 'Yeni Para Birimi Oluşturma:',
  'UPDATE_DOLLARAMOUNTS' => 'ABD Doları Tutarını Güncelle',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Şu anki döviz kurlarına göre satışların U.S. Dolar miktarlarını güncelle. Bu değer, Grafik ve Liste Görünümlerinde Para Birimi Miktarlarını hesaplamak için kullanılmaktadır.',
  'UPDATE_DONE' => 'Tamam',
  'UPDATE_FAIL' => 'Güncellenemiyor -',
  'UPDATE_FIX' => 'Sabit Tutarlar',
  'UPDATE_FIX_TXT' => 'Hatalı miktarlar şu anki değerlerden sayısal değer üretilerek düzeltmeye çalışılıyor. Değiştirilen herhangi bir değer, amount_backup veritabanı alanında yedeklenecek. Eğer bu rutini çalıştırır ve hata ile karşılaşırsanız, bu alanı yedekten dönmeden tekrar çalıştırmayınız, çünkü tekrar çalıştırma yedeklenen değerin bozulmasına neden olacaktır.',
  'UPDATE_INCLUDE_CLOSE' => 'Kapanmış Kayıtları İçerir',
  'UPDATE_MERGE' => 'Para Birimlerini Birleştir',
  'UPDATE_MERGE_TXT' => 'Birden fazla para birimini tek bir para birimine birleştir. Aynı para birimi için birden fazla para birimi kayıtları varsa, bunları beraber birleştirirsiniz. Bu işlem ayrıca bütün diğer modüller için para birimlerini de birleştirecektir.',
  'UPDATE_NULL_VALUE' => 'Tutar değeri BOŞ, 0 olarak değiştiriliyor-',
  'UPDATE_RESTORE' => 'Yenilenen Tutarlar',
  'UPDATE_RESTORE_COUNT' => 'Yenilenen Kayıt Miktarları:',
  'UPDATE_RESTORE_TXT' => 'Düzeltme işlemi sırasında oluşturulmuş yedeklerden tutar değerleri geri döndürür.',
  'UPDATE_VERIFY' => 'Tutarları Kontrol Et',
  'UPDATE_VERIFY_CURAMOUNT' => 'Şu Anki Tutar:',
  'UPDATE_VERIFY_FAIL' => 'Hatalı Kontrol Kaydı:',
  'UPDATE_VERIFY_FIX' => 'Düzeltmenin Çalıştırılmasının sonucu şu olacak:',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Yeni Tutar:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Yeni Para Birimi:',
  'UPDATE_VERIFY_TXT' => 'Satışlardaki miktarların düzgün  sayısal değerler olduğunu, yalnızca (0-9) arasında rakam içerdiğini ve (.) ayıracını kontrol eder',
);

