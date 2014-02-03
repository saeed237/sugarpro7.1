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




$listViewDefs['Contacts'] = array(
	'NAME' => array(
		'width' => '20%', 		
		'label' => 'LBL_LIST_NAME', 
		'link' => true,
        'contextMenu' => array('objectType' => 'sugarPerson', 
                               'metaData' => array('contact_id' => '{$ID}', 
                                                   'module' => 'Contacts',
                                                   'return_action' => 'ListView', 
                                                   'contact_name' => '{$FULL_NAME}', 
                                                   'parent_id' => '{$ACCOUNT_ID}',
                                                   'parent_name' => '{$ACCOUNT_NAME}',
                                                   'return_module' => 'Contacts', 
                                                   'return_action' => 'ListView', 
                                                   'parent_type' => 'Account', 
                                                   'notes_parent_type' => 'Account')
                              ),
		'orderBy' => 'name',
        'default' => true,
        'related_fields' => array('first_name', 'last_name', 'salutation', 'account_name', 'account_id'),
		), 
	'TITLE' => array(
		'width' => '15%', 
		'label' => 'LBL_LIST_TITLE',
        'default' => true), 
	'ACCOUNT_NAME' => array(
		'width' => '34%', 
		'label' => 'LBL_LIST_ACCOUNT_NAME', 
		'module' => 'Accounts',
		'id' => 'ACCOUNT_ID',
		'link' => true,
        'contextMenu' => array('objectType' => 'sugarAccount', 
                               'metaData' => array('return_module' => 'Contacts', 
                                                   'return_action' => 'ListView', 
                                                   'module' => 'Accounts',
                                                   'return_action' => 'ListView', 
                                                   'parent_id' => '{$ACCOUNT_ID}', 
                                                   'parent_name' => '{$ACCOUNT_NAME}', 
                                                   'account_id' => '{$ACCOUNT_ID}', 
                                                   'account_name' => '{$ACCOUNT_NAME}'),
                              ),
        'default' => true,
        'sortable'=> true,
        'ACLTag' => 'ACCOUNT',
        'related_fields' => array('account_id')),
	'EMAIL1' => array(
		'width' => '15%', 
		'label' => 'LBL_LIST_EMAIL_ADDRESS',
		'sortable' => false,
		'link' => true,
		'customCode' => '{$EMAIL1_LINK}{$EMAIL1}</a>',
        'default' => true
		),  
	'PHONE_WORK' => array(
		'width' => '15%', 
		'label' => 'LBL_OFFICE_PHONE',
        'default' => true),
    'DEPARTMENT' => array(
        'width' => '10', 
        'label' => 'LBL_DEPARTMENT'),
    'DO_NOT_CALL' => array(
        'width' => '10', 
        'label' => 'LBL_DO_NOT_CALL'),
    'PHONE_HOME' => array(
        'width' => '10', 
        'label' => 'LBL_HOME_PHONE'),
    'PHONE_MOBILE' => array(
        'width' => '10', 
        'label' => 'LBL_MOBILE_PHONE'),
    'PHONE_OTHER' => array(
        'width' => '10', 
        'label' => 'LBL_OTHER_PHONE'),
    'PHONE_FAX' => array(
        'width' => '10', 
        'label' => 'LBL_FAX_PHONE'),
    'EMAIL2' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_EMAIL_ADDRESS',
        'sortable' => false,
        'customCode' => '{$EMAIL2_LINK}{$EMAIL2}</a>'),  
    'EMAIL_OPT_OUT' => array(
        'width' => '10', 
        
        'label' => 'LBL_EMAIL_OPT_OUT'),
    'PRIMARY_ADDRESS_STREET' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_STREET'),
    'PRIMARY_ADDRESS_CITY' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_CITY'),
    'PRIMARY_ADDRESS_STATE' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_STATE'),
    'PRIMARY_ADDRESS_POSTALCODE' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE'),
    'PRIMARY_ADDRESS_COUNTRY' => array(
        'width' => '10', 
        'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY'),
    'ALT_ADDRESS_STREET' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_STREET'),
    'ALT_ADDRESS_CITY' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_CITY'),
    'ALT_ADDRESS_STATE' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_STATE'),
    'ALT_ADDRESS_POSTALCODE' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_POSTALCODE'),
    'ALT_ADDRESS_COUNTRY' => array(
        'width' => '10', 
        'label' => 'LBL_ALT_ADDRESS_COUNTRY'),
    'CREATED_BY_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_CREATED'),
    'TEAM_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_TEAM',
        'default' => false),
    'ASSIGNED_USER_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true),
    'MODIFIED_BY_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_MODIFIED'),
    'SYNC_CONTACT' => array (
        'type' => 'bool',
        'label' => 'LBL_SYNC_CONTACT',
        'width' => '10%',
        'default' => false,
        'sortable' => false,
        ),
    'DATE_ENTERED' => array(
        'width' => '10', 
        'label' => 'LBL_DATE_ENTERED',
		'default' => true)       
);
?>
