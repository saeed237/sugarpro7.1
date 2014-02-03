<?php
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


/*
 * Created on Aug 14, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
$object_name = strtolower($object_name);
 $app_list_strings = array (

  $object_name.'_type_dom' =>
  array (
  	'Administration' => 'Yönetim',
    'Product' => 'Ürün',
    'User' => 'Kullanıcı',
  ),
   $object_name.'_status_dom' =>
  array (
    'Assigned' => 'Atanmış',
    'Closed' => 'Kapalı',
    'Duplicate' => 'Aynı Kayıttan Oluştur',
    'New' => 'Yeni',
    'Pending Input' => 'Cevap Bekleniyor',
    'Rejected' => 'Reddedildi',
  ),
  $object_name.'_priority_dom' =>
  array (
    'P1' => 'Yüksek',
    'P2' => 'Orta',
    'P3' => 'Düşük',
  ),
  $object_name.'_resolution_dom' =>
  array (
  	'' => '',
  	'Accepted' => 'Kabul edildi',
    'Closed' => 'Kapalı',
    'Duplicate' => 'Aynı Kayıttan Oluştur',
    'Invalid' => 'Geçersiz',
    'Out of Date' => 'Geçerliliğini Yitirmiş',
  ),
  );
?>
