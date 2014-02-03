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
$fields_array['EmailMan'] = array ('column_fields' => Array(
		"id"
		, "date_entered"
		, "date_modified"
		, 'user_id'
		, 'module'
		, 'module_id'
		, 'marketing_id'
		, 'campaign_id'
		, 'list_id'
		, 'template_id'
		, 'from_email'
		, 'from_name'
		, 'invalid_email'
		, 'send_date_time'
		, 'in_queue'
		, 'in_queue_date'
		,'send_attempts'
		),
        'list_fields' =>  Array(
		"id"
		, 'user_id'
		, 'module'
		, 'module_id'
		, 'campaign_id'
		, 'marketing_id'
		, 'list_id'
		, 'invalid_email'
		, 'from_name'
		, 'from_email'
		, 'template_id'
		, 'send_date_time'
		, 'in_queue'
		, 'in_queue_date'
		,'send_attempts'
		,'user_name'
		,'to_email'
		,'from_email'
		,'campaign_name'
		,'to_contact'
		,'to_lead'
		,'to_prospect'
		,'contact_email'
		, 'lead_email'
		, 'prospect_email'
        ),
);
?>