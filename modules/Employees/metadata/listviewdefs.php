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




$listViewDefs['Employees'] = array(
    'NAME' => array(
        'width' => '20', 
        'label' => 'LBL_LIST_NAME', 
        'link' => true,
        'related_fields' => array('last_name', 'first_name'),
        'orderBy' => 'last_name',
        'default' => true),
    'DEPARTMENT' => array(
        'width' => '10', 
        'label' => 'LBL_DEPARTMENT', 
        'link' => true,
        'default' => true),
    'TITLE' => array(
        'width' => '15', 
        'label' => 'LBL_TITLE', 
        'link' => true,
        'default' => true), 
    'REPORTS_TO_NAME' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_REPORTS_TO_NAME', 
        'link' => true,
        'sortable' => false,
        'default' => true),
    'EMAIL1' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_EMAIL', 
        'link' => true,
        'customCode' => '{$EMAIL1_LINK}{$EMAIL1}</a>',
        'default' => true,
        'sortable' => false),
    'PHONE_WORK' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_PHONE', 
        'link' => true,
        'default' => true),
    'EMPLOYEE_STATUS' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_EMPLOYEE_STATUS', 
        'link' => false,
        'default' => true),    
	'DATE_ENTERED' => array (
	    'width' => '10',
	    'label' => 'LBL_DATE_ENTERED',
	    'default' => true),
);
?>
