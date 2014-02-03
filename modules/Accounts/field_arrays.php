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
$fields_array['Account'] = array ('column_fields' => Array(
		"annual_revenue"
		,"billing_address_street"
		,"billing_address_city"
		,"billing_address_state"
		,"billing_address_postalcode"
		,"billing_address_country"
		,"date_entered"
		,"date_modified"
		,"modified_user_id"
		,"assigned_user_id"
		,"description"
		,"email1"
		,"email2"
		,"employees"
		,"id"
		,"industry"
		,"name"
		,"ownership"
		,"parent_id"
		,"phone_alternate"
		,"phone_fax"
		,"phone_office"
		,"rating"
		,"shipping_address_street"
		,"shipping_address_city"
		,"shipping_address_state"
		,"shipping_address_postalcode"
		,"shipping_address_country"
		,"sic_code"
		,"ticker_symbol"
		,"account_type"
		,"website"
		, "created_by"
		,"team_id"
		),
        'list_fields' => Array('id', 'name', 'website', 'phone_office', 'assigned_user_name', 'assigned_user_id'
	, 'billing_address_street'
	, 'billing_address_city'
	, 'billing_address_state'
	, 'billing_address_postalcode'
	, 'billing_address_country'
	, 'shipping_address_street'
	, 'shipping_address_city'
	, 'shipping_address_state'
	, 'shipping_address_postalcode'
	, 'shipping_address_country'
	, "team_id"
	, "team_name"
		),
        'required_fields' => array("name"=>1),
);
?>