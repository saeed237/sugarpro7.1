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

$searchFields['EmailMan'] = 
	array (
		'campaign_name' => array( 'query_type'=>'default','db_field'=>array('campaigns.name')),
		'to_name'=> array('query_type'=>'default','db_field'=>array('contacts.first_name','contacts.last_name','leads.first_name','leads.last_name','prospects.first_name','prospects.last_name')),
        'to_email'=> array('query_type'=>'default','db_field'=>array('contacts.email1','leads.email1','prospects.email1')),
        'current_user_only'=> array('query_type'=>'default','db_field'=>array('assigned_user_id'),'my_items'=>true, 'vname' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'),
	);
?>
