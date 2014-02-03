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


$fields_array['Contract'] = array (
	'column_fields' => array(
		'id',
		'name',
		'status',
		'reference_code',
		'start_date',
		'account_id',
		'end_date',
		'opportunity_id',
		'quote_id',
		'currency_id',
		'total_contract_value',
		'total_contract_value_usdollar',
		'team_id',
		'customer_signed_date',
		'assigned_user_id',
		'company_signed_date',
		'expiration_notice_date',
		'expiration_notice_time',
		'description',
		'date_entered',
		'date_modified',
		'deleted',
		'modified_user_id',
		'created_by',
		'type',
	),
	'list_fields' => array(
		'id',
		'name',
		'account_id',
		'account_name',
		'status',
		'start_date',
		'end_date',
		'team_id',
		'team_name',
		'assigned_user_id',
		'assigned_user_name',
		'description',
	),
	'required_fields' => array(
		'name' => 1,
		'account_name' => 2,
		'status' => 3,
	),
);
?>
