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
$fields_array['Email'] = array(
	'column_fields' => array(
		"id"
		, "date_entered"
		, "date_modified"
		, "assigned_user_id"
		, "modified_user_id"
		, "created_by"
		,"team_id"
		, "description"
		, "description_html"
		, "name"
		, "date_start"
		, "time_start"
		, "parent_type"
		, "parent_id"
		, "from_addr"
		, "from_name"
		, "to_addrs"
		, "cc_addrs"
		, "bcc_addrs"
		, "to_addrs_ids"
		, "to_addrs_names"
		, "to_addrs_emails"
		, "cc_addrs_ids"
		, "cc_addrs_names"
		, "cc_addrs_emails"
		, "bcc_addrs_ids"
		, "bcc_addrs_names"
		, "bcc_addrs_emails"
		, "type"
		, "status"
		, "intent"
		),
	'list_fields' => array(
		'id', 'name', 'parent_type', 'parent_name', 'parent_id', 'date_start', 'time_start', 'assigned_user_name', 'assigned_user_id', 'contact_name', 'contact_id', 'first_name','last_name','to_addrs','from_addr','date_sent','type_name','type','status','link_action','date_entered','attachment_image','intent','date_sent'
	, "team_id"
	, "team_name"
		),
);
?>