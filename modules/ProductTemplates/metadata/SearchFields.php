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

$searchFields['ProductTemplates'] = 
	array (
		'name' => array( 'query_type'=>'default'),
        'status'=> array('query_type'=>'default', 'options' => 'product_status_dom', 'template_var' => 'STATUS_OPTIONS', 'options_add_blank' => true),
        'type_id'=> array('query_type'=>'default', 'options' => 'product_type_dom', 'template_var' => 'TYPE_OPTIONS'),
        'category_id'=> array('query_type'=>'default', 'options' => 'products_cat_dom', 'template_var' => 'CATEGORY_OPTIONS'),
        'manufacturer_id'=> array('query_type'=>'default', 'options' => 'manufacturer_dom', 'template_var' => 'MANUFACTURER_OPTIONS'),
        'mft_part_num' => array( 'query_type'=>'default'),
        'vendor_part_num' => array( 'query_type'=>'default'),
        'tax_class'=> array('query_type'=>'default', 'options' => 'tax_class_dom', 'template_var' => 'TAX_CLASS_OPTIONS', 'options_add_blank' => true),
        'date_available' => array( 'query_type'=>'default'),
	);
?>
