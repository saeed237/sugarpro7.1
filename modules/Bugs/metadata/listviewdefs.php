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





$listViewDefs['Bugs'] = array(
	'BUG_NUMBER' => array(
		'width' => '5',
		'label' => 'LBL_LIST_NUMBER',
		'link' => true,
        'default' => true),
	'NAME' => array(
		'width' => '32',
		'label' => 'LBL_LIST_SUBJECT',
		'default' => true,
        'link' => true),
	'STATUS' => array(
		'width' => '10',
		'label' => 'LBL_LIST_STATUS',
        'default' => true),
    'TYPE' => array(
        'width' => '10',
        'label' => 'LBL_LIST_TYPE',
        'default' => true),
    'PRIORITY' => array(
        'width' => '10',
        'label' => 'LBL_LIST_PRIORITY',
        'default' => true),
    'RELEASE_NAME' => array(
        'width' => '10',
        'label' => 'LBL_FOUND_IN_RELEASE',
        'default' => false,
        'related_fields' => array('found_in_release'),
        'module' => 'Releases',
        'id' => 'FOUND_IN_RELEASE',),
    'FIXED_IN_RELEASE_NAME' => array(
        'width' => '10',
        'label' => 'LBL_LIST_FIXED_IN_RELEASE',
        'default' => true,
        'related_fields' => array('fixed_in_release'),
        'module' => 'Releases',
        'id' => 'FIXED_IN_RELEASE',),
    'RESOLUTION' => array(
        'width' => '10',
        'label' => 'LBL_LIST_RESOLUTION',
        'default' => false),
	'TEAM_NAME' => array(
		'width' => '9',
		'label' => 'LBL_LIST_TEAM',
        'default' => false),
	'ASSIGNED_USER_NAME' => array(
		'width' => '9',
		'label' => 'LBL_LIST_ASSIGNED_USER',
		'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true)
);
?>
