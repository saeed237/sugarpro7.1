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




$listViewDefs['EmailTemplates'] = array(
	'NAME' => array(
		'width' => '20', 
		'label' => 'LBL_NAME', 
		'link' => true,
        'default' => true),
    'TYPE' => array(
        'width' => '20',
        'label' => 'LBL_TYPE',
        'link' => false,
        'default' => true),
    'DESCRIPTION' => array(
        'width' => '40', 
        'default' => true,
        'sortable' => false,
        'label' => 'LBL_DESCRIPTION'),
    'ASSIGNED_USER_NAME' => array (
        'width' => '10',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,),
    'DATE_MODIFIED' => array(
        'width' => '10', 
        'default' => true,
        'label' => 'LBL_DATE_MODIFIED'),
	'DATE_ENTERED' => array (
	    'width' => '10',
	    'label' => 'LBL_DATE_ENTERED',
	    'default' => true),
);
?>
