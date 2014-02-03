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


$popupMeta = array (
    'moduleMain' => 'Lead',
    'varName' => 'LEAD',
    'orderBy' => 'last_name, first_name',
    'whereClauses' => array (
		'first_name' => 'leads.first_name',
		'last_name' => 'leads.last_name',
		'lead_source' => 'leads.lead_source',
		'status' => 'leads.status',
		'account_name' => 'leads.account_name',
		'assigned_user_id' => 'leads.assigned_user_id',
	),
    'searchInputs' => array (
	  0 => 'first_name',
	  1 => 'last_name',
	  2 => 'lead_source',
	  3 => 'status',
	  4 => 'account_name',
	  5 => 'assigned_user_id',
	),
    'searchdefs' => array (
	  'first_name' => 
	  array (
	    'name' => 'first_name',
	    'width' => '10%',
	  ),
	  'last_name' => 
	  array (
	    'name' => 'last_name',
	    'width' => '10%',
	  ),
	  'email',
	  'account_name' => 
	  array (
	    'type' => 'varchar',
	    'label' => 'LBL_ACCOUNT_NAME',
	    'width' => '10%',
	    'name' => 'account_name',
	  ),
	  'lead_source' => 
	  array (
	    'name' => 'lead_source',
	    'width' => '10%',
	  ),
	  'status' => 
	  array (
	    'name' => 'status',
	    'width' => '10%',
	  ),
	  'assigned_user_id' => 
	  array (
	    'name' => 'assigned_user_id',
	    'type' => 'enum',
	    'label' => 'LBL_ASSIGNED_TO',
	    'function' => 
	    array (
	      'name' => 'get_user_array',
	      'params' => 
	      array (
	        0 => false,
	      ),
	    ),
	    'width' => '10%',
	  ),
	),
    'listviewdefs' => array (
	  'NAME' => 
	  array (
	    'width' => '30%',
	    'label' => 'LBL_LIST_NAME',
	    'link' => true,
	    'default' => true,
	    'related_fields' => 
	    array (
	      0 => 'first_name',
	      1 => 'last_name',
	      2 => 'salutation',
	    ),
	    'name' => 'name',
	  ),
	  'ACCOUNT_NAME' => 
	  array (
	    'type' => 'varchar',
	    'label' => 'LBL_ACCOUNT_NAME',
	    'width' => '10%',
	    'default' => true,
	    'name' => 'account_name',
	  ),
	  'STATUS' => 
	  array (
	    'width' => '10%',
	    'label' => 'LBL_LIST_STATUS',
	    'default' => true,
	    'name' => 'status',
	  ),
	  'LEAD_SOURCE' => 
	  array (
	    'width' => '10%',
	    'label' => 'LBL_LEAD_SOURCE',
	    'default' => true,
	    'name' => 'lead_source',
	  ),
	  'ASSIGNED_USER_NAME' => 
	  array (
	    'width' => '10%',
	    'label' => 'LBL_LIST_ASSIGNED_USER',
	    'default' => true,
	    'name' => 'assigned_user_name',
	  ),
	),
);
