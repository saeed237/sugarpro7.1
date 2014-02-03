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

$listViewDefs['ProductTemplates'] = array(
    'NAME' => array(
		'width' => '30', 
		'label' => 'LBL_LIST_NAME', 
		'link' => true,
        'default' => true),
 	'TYPE_NAME' => array (
        'width' => '10',
		'label' =>'LBL_LIST_TYPE',
        'link' => false,
        'sortable' => true,
        'default' => true),
	'CATEGORY_NAME' => array (
        'width' => '10',
		'label' =>'LBL_LIST_CATEGORY',
        'link' => false,
        'sortable' => true,
        'default' => true),
	'STATUS' => array (
        'width' => '10',
		'label' =>'LBL_LIST_STATUS',
        'link' => false,
        'default' => true),
    'QTY_IN_STOCK' => array (
        'width' => '10',
		'label' =>'LBL_LIST_QTY_IN_STOCK',
        'link' => false,
        'default' => true),
    'COST_USDOLLAR'  => array (
        'width' => '10',
		'label' =>'LBL_LIST_COST_PRICE',
        'link' => false,
        'default' => true,
        'align' => 'right',
        'related_fields' => array('currency_id'),
        'currency_format' => true),
    'LIST_USDOLLAR' => array (
        'width' => '10',
		'label' =>'LBL_LIST_LIST_PRICE',
        'link' => false,
        'default' => true,
        'align' => 'right',
        'related_fields' => array('currency_id'),
        'currency_format' => true),
    'DISCOUNT_USDOLLAR' => array (
        'width' => '10',
		'label' =>'LBL_LIST_DISCOUNT_PRICE',
        'link' => false,
        'default' => true,
        'align' => 'right',
        'related_fields' => array('currency_id'),
        'currency_format' => true),	    
        
);
?>
