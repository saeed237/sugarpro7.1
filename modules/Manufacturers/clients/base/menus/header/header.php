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

$module_name = 'Manufacturers';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#'.'ProductTemplates'.'/create',
        'label' =>'LNK_NEW_PRODUCT',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#' . 'ProductTemplates',
        'label' =>'LNK_PRODUCT_LIST',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=Manufacturers&action=EditView&return_module=Manufacturers&return_action=DetailView',
        'label' =>'LNK_NEW_MANUFACTURER',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#ProductCategories',
        'label' =>'LNK_NEW_PRODUCT_CATEGORY',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=ProductTypes&action=EditView&return_module=ProductTypes&return_action=DetailView',
        'label' =>'LNK_NEW_PRODUCT_TYPE',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=Import&action=Step1&import_module=Manufacturers&return_module=Manufacturers&return_action=index',
        'label' =>'LNK_IMPORT_MANUFACTURERS',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-upload',
    ),

);
