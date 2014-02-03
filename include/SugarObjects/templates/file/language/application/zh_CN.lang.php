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

	

$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_category_dom' => 
  array (
    '' => '',
    'Knowledege Base' => '知识库',
    'Marketing' => '市场',
    'Sales' => '销售',
  ),
  $object_name.'_status_dom' => 
  array (
    'Active' => '启用',
    'Draft' => '草稿',
    'Expired' => '过期',
    'FAQ' => 'FAQ',
    'Pending' => '待定',
    'Under Review' => '审核中',
  ),
  $object_name.'_subcategory_dom' => 
  array (
    '' => '',
    'FAQ' => 'FAQ',
    'Marketing Collateral' => '营销资料',
    'Product Brochures' => '产品手册',
  ),
);

