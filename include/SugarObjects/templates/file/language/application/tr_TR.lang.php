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


/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
$app_list_strings = array (
strtolower($object_name).'_category_dom' =>
    array (
    '' => '',
    'Marketing' => 'Pazarlama',
    'Knowledege Base' => 'Bilgi Tabanı',
    'Sales' => 'Satışlar',
  ),

    strtolower($object_name).'_subcategory_dom' =>
    array (
    '' => '',
    'Marketing Collateral' => 'Pazarlama Teminatı',
    'Product Brochures' => 'Ürün Broşürleri',
    'FAQ' => 'FAQ',
  ),

    strtolower($object_name).'_status_dom' =>
    array (
    'Active' => 'Aktif',
    'Draft' => 'Taslak',
    'FAQ' => 'SSS',
    'Expired' => 'Süresi Geçmiş',
    'Under Review' => 'İncelemede',
    'Pending' => 'Beklemede',
  ),
  );
?>