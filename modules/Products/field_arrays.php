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
$fields_array['Product'] = array ('column_fields' => Array("id"
		,"product_template_id"
		,"name"
		,"date_entered"
		,"date_modified"
		,"modified_user_id"
		, "created_by"
		,"date_purchased"
		,"manufacturer_id"
		,"type_id"
		,"quote_id"
		,"tax_class"
		,"vendor_part_num"
		,"category_id"
		,'cost_usdollar'
		,'list_usdollar'
		,'discount_usdollar'
		,'deal_calc_usdollar'
		,'currency_id'
		,"status"
		,"cost_price"
		,"discount_price"
		,"discount_amount"
		,"deal_calc"
		,"discount_select"
		,"list_price"
		,"mft_part_num"
		,"weight"
		,"quantity"
		,"website"
		,"support_name"
		,"support_description"
		,"support_contact"
		,"support_term"
		,"date_support_expires"
		,"date_support_starts"
		,"pricing_formula"
		,"pricing_factor"
		,"description"
		,"account_id"
		,"contact_id"
		,"team_id"
		,"serial_number"
		,"asset_number"
		,"book_value"
		,"book_value_date"
		),
        'list_fields' =>  array('id', 'name', 'status', 'quantity', 'date_purchased', 'cost_price',
			'cost_usdollar', 'discount_amount', 'discount_select', 'discount_price','discount_usdollar', 'list_price','list_usdollar','deal_calc','deal_calc_usdollar',
			'mft_part_num', 'manufacturer_name', 'account_name', 'account_id', 'contact_id',
			'contact_name', 'date_support_expires'),
    'required_fields' =>  array("name"=>1,  ),
);
?>