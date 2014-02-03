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
$fields_array['EmailMarketing'] = array ('column_fields' => array (
		'id', 'date_entered', 'date_modified',
		'modified_user_id', 'created_by', 'name',
		'from_addr', 'from_name', 'reply_to_name', 'reply_to_addr', 'date_start','time_start', 'template_id', 'campaign_id','status','inbound_email_id','all_prospect_lists',
	),
        'list_fields' =>  array (
		'id','name','date_start','time_start', 'template_id', 'status','all_prospect_lists','campaign_id',
	),
    'required_fields' => array (
		'name'=>1, 'from_name'=>1,'from_addr'=>1, 'date_start'=>1,'time_start'=>1,
		'template_id'=>1, 'status'=>1,
	),
);
?>