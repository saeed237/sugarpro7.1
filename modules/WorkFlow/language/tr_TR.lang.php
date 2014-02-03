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
  'LBL_ACTION_ERROR' => 'Bu aksiyon uygulanamaz. Aksiyonu değiştirerek tüm alanların ve alan değerlerinin geçerli olmasını sağlayın.',
  'LBL_ACTION_ERRORS' => 'Uyarı: Aşağıdaki bir veya daha fazla aksiyon hata içermektedir.',
  'LBL_ALERT_ERROR' => 'Bu uyarı uygulanamaz. Uyarıyı değiştirerek tüm ayarların geçerli olmasını sağlayın.',
  'LBL_ALERT_ERRORS' => 'Uyarı: Aşağıda bulunan bir veya daha fazla uyarı hata içermektedir.',
  'LBL_ALERT_SUBJECT' => 'İŞ AKIŞ UYARISI',
  'LBL_ALERT_TEMPLATES' => 'Uyarı Şablonları',
  'LBL_ANY_FIELD' => 'herhangi alan',
  'LBL_AS' => 'olarak',
  'LBL_BASE_MODULE' => 'Temel Modül:',
  'LBL_BODY' => 'Gövde:',
  'LBL_CREATE_ALERT_TEMPLATE' => 'Uyarı şablonu oluştur:',
  'LBL_DESCRIPTION' => 'Tanım:',
  'LBL_DOWN' => 'Aşağı',
  'LBL_EDITLAYOUT' => 'Yerleşimi Değiştir',
  'LBL_EDIT_ALT_TEXT' => 'Düz Metin Değiştir',
  'LBL_EMAILTEMPLATES_TYPE' => 'Tipi',
  'LBL_EMAILTEMPLATES_TYPE_LIST_WORKFLOW' => 
  array (
    'workflow' => 'İş Akışı',
  ),
  'LBL_FIRE_ORDER' => 'İşlem Sırası:',
  'LBL_FROM_ADDRESS' => 'Kimden Adresi:',
  'LBL_FROM_NAME' => 'Kimden İsmi:',
  'LBL_HIDE' => 'Gizle',
  'LBL_INSERT' => 'Gir',
  'LBL_INVITEES' => 'Davetliler',
  'LBL_INVITEE_NOTICE' => 'Dikkat, bunu oluşturmak için en az bir davetli seçmelisiniz.',
  'LBL_INVITE_LINK' => 'Toplantı/Arama Davet Linki',
  'LBL_LACK_OF_NOTIFICATIONS_ON' => 'Uyarı: Uyarı gönderebilmek için Yönetici > E-Posta Ayarları&#39;ndan SMTP Sunucu bilgisini sağlayın.',
  'LBL_LACK_OF_TRIGGER_ALERT' => 'Uyarı: Bu iş akış nesnesinin çalışması için tetikleyici oluşturmalısınız',
  'LBL_LINK_RECORD' => 'Kayıt etmek için link',
  'LBL_LIST_BASE_MODULE' => 'Temel Modül:',
  'LBL_LIST_DN' => 'aşğ',
  'LBL_LIST_FORM_TITLE' => 'İş Akışı Listesi',
  'LBL_LIST_NAME' => 'İsim',
  'LBL_LIST_ORDER' => 'İşlem Sırası:',
  'LBL_LIST_STATUS' => 'Durum',
  'LBL_LIST_TYPE' => 'Çalışma Zamanı:',
  'LBL_LIST_UP' => 'yukarı',
  'LBL_MODULE_ID' => 'İş Akışı',
  'LBL_MODULE_NAME' => 'İş Akış Tanımları',
  'LBL_MODULE_NAME_SINGULAR' => 'İş Akışı Tanımı',
  'LBL_MODULE_TITLE' => 'İş Akışı: Ana Sayfa',
  'LBL_NAME' => 'İsim:',
  'LBL_NEW_FORM_TITLE' => 'İş Akış Tanımı Oluştur',
  'LBL_PLEASE_SELECT' => 'Lütfen Seçiniz',
  'LBL_PROCESS_LIST' => 'İş Akışı Sırası',
  'LBL_PROCESS_SELECT' => 'Lütfen bir modül seçiniz:',
  'LBL_RECIPIENTS' => 'Alıcılar',
  'LBL_RECORD_TYPE' => 'Uygulandığı Yer:',
  'LBL_RELATED_MODULE' => 'İlişkili Modüller:',
  'LBL_SEARCH_FORM_TITLE' => 'İş Akışı Arama',
  'LBL_SELECT_FILTER' => 'İlişkili modülü filtrelemek için bir alanla birlikte seçmelisiniz.',
  'LBL_SELECT_MODULE' => 'Lütfen ilişkili modülü seçin.',
  'LBL_SELECT_OPTION' => 'Lütfen bir tercih yapın.',
  'LBL_SELECT_VALUE' => 'Geçerli bir değer seçmelisiniz.',
  'LBL_SET' => 'Ayarla',
  'LBL_SHOW' => 'Göster',
  'LBL_SPECIFIC_FIELD' => 'belirtilmiş alan',
  'LBL_STATUS' => 'Durum:',
  'LBL_SUBJECT' => 'Konusu:',
  'LBL_TRIGGER_ERROR' => 'Uyarı: Bu tetikleyici geçersiz değer içermektedir ve tetiklenmeyecektir.',
  'LBL_TRIGGER_ERRORS' => 'Uyarı: Aşağıda bulunan bir veya daha fazla tetikleyici hata içermektedir.',
  'LBL_TYPE' => 'Çalışma Zamanı:',
  'LBL_UP' => 'Yukarı',
  'LBL__S' => 'ler',
  'LNK_ALERT_TEMPLATES' => 'Uyarı E-Posta Şablonları',
  'LNK_NEW_WORKFLOW' => 'İş Akış Tanımı Oluştur',
  'LNK_PROCESS_VIEW' => 'İş Akışı Sırası',
  'LNK_WORKFLOW' => 'İş Akış Tanımlarını Listele',
  'NTC_REMOVE_ALERT' => 'Bu iş akışını silmek istediğinizden emin misiniz?',
);

