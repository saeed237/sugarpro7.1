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
$fields_array['Task'] = array ('column_fields' =>Array("id"
		, "date_entered"
		, "date_modified"
		, "assigned_user_id"
		, "modified_user_id"
		, "created_by"
		,"team_id"
		, "description"
		, "name"
		, "status"
		, "date_due"
		, "time_due"
		, "date_start_flag"
		, "date_start"
		, "time_start"
		, "priority"
		, "date_due_flag"
		, "parent_type"
		, "parent_id"
		, "contact_id"
		),
        'list_fields' =>  Array('id', 'status', 'name', 'parent_type', 'parent_name', 'parent_id', 'date_due', 'contact_id', 'contact_name', 'assigned_user_name', 'assigned_user_id','first_name','last_name','time_due', 'priority'
	, "team_id"
	, "team_name"
		),
    'required_fields' =>   array('name'=>1),
);
?>