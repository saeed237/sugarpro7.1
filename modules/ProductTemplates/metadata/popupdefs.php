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


$popupMeta = array (
    'moduleMain' => 'ProductTemplates',
    'varName' => 'ProductTemplate',
    'orderBy' => 'producttemplates.name',
    'whereClauses' => array (
        'name' => 'producttemplates.name',
        'category_name' => 'producttemplates.category_name',
    ),
    'searchInputs' => array (
        'name',
        'category_name',
    ),
    'searchdefs' => array (
        'name',
        'category_name'
    ),
    'listviewdefs' => array (
        'NAME' =>
        array (
            'width' => '30',
            'label' => 'LBL_LIST_NAME',
            'link' => true,
            'default' => true,
            'name' => 'name',
        ),
        'TYPE_NAME' =>
        array (
            'width' => '10',
            'label' => 'LBL_LIST_TYPE',
            'sortable' => true,
            'default' => true,
            'name' => 'type_name',
        ),
        'CATEGORY_NAME' =>
        array (
            'width' => '10',
            'label' => 'LBL_LIST_CATEGORY',
            'sortable' => true,
            'default' => true,
            'name' => 'category_name',
        ),
        'STATUS' =>
        array (
            'width' => '10',
            'label' => 'LBL_LIST_STATUS',
            'default' => true,
            'name' => 'status',
        ),
        'QTY_IN_STOCK' =>
        array (
            'width' => '10',
            'label' => 'LBL_LIST_QTY_IN_STOCK',
            'default' => true,
            'name' => 'qty_in_stock',
        ),
        'COST_PRICE' =>
        array (
            'type' => 'currency',
            'label' => 'LBL_COST_PRICE',
            'currency_format' => true,
            'width' => '10',
            'default' => true,
            'name' => 'cost_price',
        ),
        'LIST_PRICE' =>
        array (
            'type' => 'currency',
            'label' => 'LBL_LIST_PRICE',
            'currency_format' => true,
            'width' => '10',
            'default' => true,
            'name' => 'list_price',
        ),
        'DISCOUNT_PRICE' =>
        array (
            'type' => 'currency',
            'label' => 'LBL_DISCOUNT_PRICE',
            'currency_format' => true,
            'width' => '10',
            'default' => true,
        ),
    ),
);