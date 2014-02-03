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

$searchFields['Products'] = array (
    'name' => array (
        'query_type' => 'default',
        'force_unifiedsearch' => true
    ),
    'account_name'=> array('query_type'=>'default','db_field'=>array('accounts.name')),
    'opportunity_name'=> array('query_type'=>'default','db_field'=>array('opportunities.name')),
    'status' => array (
        'query_type' => 'default',
        'options' => 'product_status_dom',
        'template_var' => 'STATUS_OPTIONS',
        'options_add_blank' => true
    ),
    'type_id' => array (
        'query_type' => 'default',
        'options' => 'product_type_dom',
        'template_var' => 'TYPE_OPTIONS'
    ),
    'category_id' => array (
        'query_type' => 'default',
        'options' => 'products_cat_dom',
        'template_var' => 'CATEGORY_OPTIONS'
    ),
    'manufacturer_id' => array (
        'query_type' => 'default',
        'options' => 'manufacturer_dom',
        'template_var' => 'MANUFACTURER_OPTIONS'
    ),
    'mft_part_num' => array (
        'query_type' => 'default'
    ),
    'vendor_part_num' => array (
        'query_type' => 'default'
    ),
    'tax_class' => array (
        'query_type' => 'default',
        'options' => 'tax_class_dom',
        'template_var' => 'TAX_CLASS_OPTIONS',
        'options_add_blank' => true
    ),
    'date_available' => array (
        'query_type' => 'default'
    ),
    'support_term' => array (
        'query_type' => 'default'
    ),
    'favorites_only' => array (
        'query_type' => 'format',
        'operator' => 'subquery',
        'subquery' => 'SELECT sugarfavorites.record_id FROM sugarfavorites 
                                        WHERE sugarfavorites.deleted=0 
                                            and sugarfavorites.module = \'Products\'
                                            and sugarfavorites.assigned_user_id = \'{0}\'',
        'db_field' => array (
            'id'
        )
    ),
    //Range Search Support
    'range_date_entered' => array (
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'start_range_date_entered' => array (
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'end_range_date_entered' => array (
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'range_date_modified' => array (
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'start_range_date_modified' => array (
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'end_range_date_modified' => array (
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    //Range Search Support
    
);
