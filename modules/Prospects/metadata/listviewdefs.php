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




$listViewDefs['Prospects'] = array(
	'FULL_NAME' => array(
		'width' => '20', 
		'label' => 'LBL_LIST_NAME', 
		'link' => true,
        'related_fields' => array('first_name', 'last_name'),
        'orderBy' => 'last_name',
        'default' => true),
    'TITLE' => array(
        'width' => '20', 
        'label' => 'LBL_LIST_TITLE', 
        'link' => false,
        'default' => true),   
    'EMAIL1' => array(
        'width' => '20', 
        'label' => 'LBL_LIST_EMAIL_ADDRESS',
        'sortable' => false, 
        'link' => false,
        'default' => true),           
    'PHONE_WORK' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_PHONE', 
        'link' => false,
        'default' => true), 
	'DATE_ENTERED' => array (
	    'type' => 'datetime',
	    'label' => 'LBL_DATE_ENTERED',
	    'width' => '10',
	    'default' => true,
	  ),  
);
?>
