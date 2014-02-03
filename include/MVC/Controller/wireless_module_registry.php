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


$wireless_module_registry = array(
	'Accounts' => array(),
	'Contacts' => array(),
	'Leads' => array(),
	'Opportunities' => array('disable_create' => true),
	'Cases' => array('disable_create' => true),
	'Calls' => array(),
	'Tasks' => array(),
    'Meetings' => array(),
	'Employees' => array('disable_create' => true),
	'Reports' => array('disable_create' => true),
    'Users' => array('disable_create' => true),
);
