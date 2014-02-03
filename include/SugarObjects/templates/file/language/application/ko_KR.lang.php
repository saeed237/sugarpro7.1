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
    'Knowledege Base' => '지식 기반',
    'Marketing' => '마케팅',
    'Sales' => '영업',
  ),
  $object_name.'_status_dom' => 
  array (
    'Active' => '작동중',
    'Draft' => '초안',
    'Expired' => '기간 만료됨',
    'FAQ' => '자주묻는질문',
    'Pending' => '보류중',
    'Under Review' => '검토중',
  ),
  $object_name.'_subcategory_dom' => 
  array (
    '' => '',
    'FAQ' => '자주묻는질문',
    'Marketing Collateral' => '판촉물 및 홍보포스터',
    'Product Brochures' => '제품 소책자',
  ),
);

