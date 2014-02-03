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
$fields_array['Campaign'] = array ('column_fields' => array(
				"id", "date_entered",
				"date_modified", "modified_user_id",
				"assigned_user_id", "created_by",
				"team_id",
				"name", "start_date",
				"end_date", "status",
				"budget", "expected_cost",
				"actual_cost", "expected_revenue",
				"campaign_type", "objective",
				"content", "tracker_key","refer_url","tracker_text",
				"tracker_count","currency_id","impressions",
                "frequency",
	),
        'list_fields' => array(
				'id', 'name', 'status',
				'campaign_type','assigned_user_id','assigned_user_name','end_date',
				'team_id',
				'team_name',
				'refer_url',"currency_id",
	),
        'required_fields' => array(
				'name'=>1, 'end_date'=>2,
				'status'=>3, 'campaign_type'=>4
	),
);
?>