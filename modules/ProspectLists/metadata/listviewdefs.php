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




$listViewDefs['ProspectLists'] = array(
    'NAME' => array(
        'width' => '25', 
        'label' => 'LBL_LIST_PROSPECT_LIST_NAME', 
        'link' => true,
        'default' => true),
    'LIST_TYPE' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_TYPE_LIST_NAME', 
        'default' => true),
    'DESCRIPTION' => array(
        'width' => '40', 
        'label' => 'LBL_LIST_DESCRIPTION', 
        'default' => true),
    'ASSIGNED_USER_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID', 
        'default' => true),
  	'DATE_ENTERED' => array (
	    'type' => 'datetime',
	    'label' => 'LBL_DATE_ENTERED',
	    'width' => '10',
	    'default' => true),
);
