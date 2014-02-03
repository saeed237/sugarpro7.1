<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright 2004-2013 SugarCRM Inc. All rights reserved.
 */

$fields = array(
    'NAME' => array (
        'width' => '40',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true
    ),
    'ACCOUNT_NAME' => array (
        'width' => '20',
        'label' => 'LBL_LIST_ACCOUNT_NAME',
        'id' => 'ACCOUNT_ID',
        'module' => 'Accounts',
        'link' => true,
        'default' => true,
        'ACLTag' => 'ACCOUNT',
        'related_fields' => array (
            'account_id'
        ),
        'sortable' => true
    ),
    'STATUS' => array (
        'width' => '10',
        'label' => 'LBL_LIST_STATUS',
        'link' => false,
        'default' => true
    ),
    'QUANTITY' => array (
        'width' => '10',
        'label' => 'LBL_LIST_QUANTITY',
        'link' => false,
        'default' => true
    ),
    'DISCOUNT_USDOLLAR' => array (
        'width' => '10',
        'label' => 'LBL_LIST_DISCOUNT_PRICE',
        'link' => false,
        'default' => true,
        'currency_format' => true,
        'align' => 'right'
    ),
    'LIST_USDOLLAR' => array (
        'width' => '10',
        'label' => 'LBL_LIST_LIST_PRICE',
        'link' => false,
        'default' => true,
        'currency_format' => true,
        'align' => 'right',
        
    ),
    'COST_PRICE' =>  array(
        'width' => '10',
        'label' => 'LBL_LIST_COST_PRICE',
        'link' => false,
        'default' => true,
        'currency_format' => true,
        'align' => 'right',
        ),
    'DATE_ENTERED' => array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10',
        'default' => true
    )
);
 

$listViewDefs['RevenueLineItems'] = $fields;
