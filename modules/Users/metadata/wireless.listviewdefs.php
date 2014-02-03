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



$listViewDefs['Users'] = array(
	'NAME' => array(
		'width' => '20%', 		
		'label' => 'LBL_NAME', 
		'link' => true,
		'orderBy' => 'last_name',
        'default' => true,
        'related_fields' => array('first_name', 'last_name', 'salutation'),
		), 
	'TITLE' => array(
		'width' => '15%', 
		'label' => 'LBL_TITLE',
        'default' => true), 
	'EMAIL1' => array(
		'width' => '15%', 
		'label' => 'LBL_EMAIL',
		'sortable' => false,
		'link' => true,
		'customCode' => '{$EMAIL1_LINK}{$EMAIL1}</a>',
        'default' => true
		),  
	'PHONE_WORK' => array(
		'width' => '15%', 
		'label' => 'LBL_OFFICE_PHONE',
        'default' => true),
    'PHONE_HOME' => array(
        'width' => '10', 
        'label' => 'LBL_HOME_PHONE'),
    'PHONE_MOBILE' => array(
        'width' => '10', 
        'label' => 'LBL_MOBILE_PHONE'),
    'PHONE_OTHER' => array(
        'width' => '10', 
        'label' => 'LBL_WORK_PHONE'),
    'PHONE_FAX' => array(
        'width' => '10', 
        'label' => 'LBL_FAX_PHONE'),
    'ADDRESS_STREET' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_STREET'),
    'ADDRESS_CITY' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_CITY'),
    'ADDRESS_STATE' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_STATE'),
    'ADDRESS_POSTALCODE' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE'),
    'DATE_ENTERED' => array(
        'width' => '10', 
        'label' => 'LBL_DATE_ENTERED'),
    'TEAM_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_TEAM',
        'default' => true),
);
?>
