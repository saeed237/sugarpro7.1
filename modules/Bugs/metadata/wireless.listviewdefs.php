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
		'label' => 'LBL_NUMBER',
		'link' => true,
        'default' => true),
	'NAME' => array(
		'width' => '32',
		'label' => 'LBL_SUBJECT',
		'default' => true,
        'link' => true),
	'STATUS' => array(
		'width' => '10',
		'label' => 'LBL_STATUS',
        'default' => true),
    'PRIORITY' => array(
        'width' => '10',
        'label' => 'LBL_PRIORITY',
        'default' => true),
    'RESOLUTION' => array(
        'width' => '10',
        'label' => 'LBL_RESOLUTION',
        'default' => true),
	'TEAM_NAME' => array(
		'width' => '9',
		'label' => 'LBL_TEAM',
        'default' => true),
	'ASSIGNED_USER_NAME' => array(
		'width' => '9',
		'label' => 'LBL_ASSIGNED_USER',
        'default' => true),

);
?>
