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

$fields_array['InboundEmail'] = array (
	'column_fields' => array (
		'id',
		'deleted',
		'date_entered',
		'date_modified',
		'modified_user_id',
		'created_by',
		'name',
		'status',
		'server_url',
		'email_user',
		'email_password',
		'port',
		'service',
		'mailbox',
		'delete_seen',
		'mailbox_type',
		'template_id',
	),
	'list_fields' => array (
		'id',
		'name',
		'server_url',
		'status',
		'mailbox_type_name',
	),
	'required_fields' => array (
		'server_url' => 1,
		'service' => 1,
	),
);
?>
