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

 * Description:  Contains field arrays that are used for caching
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
$fields_array['ProductTemplate'] = array ('column_fields' => Array("id"
		,"name"
		,"date_entered"
		,"date_modified"
		,"modified_user_id"
		, "created_by"
		,"date_available"
		,"manufacturer_id"
		,"type_id"
		,"tax_class"
		,"vendor_part_num"
		,"category_id"
		,'cost_usdollar'
		,'list_usdollar'
		,'discount_usdollar'
		,'currency_id'
		,"status"
		,"cost_price"
		,"discount_price"
		,"list_price"
		,"mft_part_num"
		,"weight"
		,"qty_in_stock"
		,"website"
		,"support_name"
		,"support_description"
		,"support_contact"
		,"support_term"
		,"pricing_formula"
		,"pricing_factor"
		,"description"
		),
        'list_fields' =>  array('id', 'name', 'status', 'qty_in_stock', 'cost_price','cost_usdollar', 'discount_price','discount_usdollar', 'list_price','list_usdollar', 'mft_part_num', 'pricing_factor', 'pricing_formula', 'type_id', 'tax_class', 'manufacturer_id', 'currency_id', 'website', 'vendor_part_num', 'description', 'support_contact', 'support_term', 'support_name', 'support_description', 'weight', 'category_id'),
        'required_fields' => array("name"=>1,"cost_price"=>1,"discount_price"=>1,"list_price"=>1),
);
?>