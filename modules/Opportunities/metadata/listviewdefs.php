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




$listViewDefs['Opportunities'] = array(
	'NAME' => array(
		'width'   => '30',  
		'label'   => 'LBL_LIST_OPPORTUNITY_NAME', 
		'link'    => true,
        'default' => true),
	'ACCOUNT_NAME' => array(
		'width'   => '20', 
		'label'   => 'LBL_LIST_ACCOUNT_NAME', 
		'id'      => 'ACCOUNT_ID',
        'module'  => 'Accounts',
		'link'    => true,
        'default' => true,
        'sortable'=> true,
        'ACLTag' => 'ACCOUNT',
        'contextMenu' => array('objectType' => 'sugarAccount', 
                               'metaData' => array('return_module' => 'Contacts', 
                                                   'return_action' => 'ListView', 
                                                   'module' => 'Accounts',
                                                   'return_action' => 'ListView', 
                                                   'parent_id' => '{$ACCOUNT_ID}', 
                                                   'parent_name' => '{$ACCOUNT_NAME}', 
                                                   'account_id' => '{$ACCOUNT_ID}', 
                                                   'account_name' => '{$ACCOUNT_NAME}',
                                                   ),
                              ),
        'related_fields' => array('account_id')),
	'SALES_STAGE' => array(
		'width'   => '10',  
		'label'   => 'LBL_LIST_SALES_STAGE',
        'default' => true), 
	'AMOUNT_USDOLLAR' => array(
		'width'   => '10', 
		'label'   => 'LBL_LIST_AMOUNT_USDOLLAR',
        'align'   => 'right',
        'default' => true,
        'currency_format' => true,
	),  
    'OPPORTUNITY_TYPE' => array(
        'width' => '15', 
        'label' => 'LBL_TYPE'),
    'LEAD_SOURCE' => array(
        'width' => '15', 
        'label' => 'LBL_LEAD_SOURCE'),
    'NEXT_STEP' => array(
        'width' => '10', 
        'label' => 'LBL_NEXT_STEP'),
    'PROBABILITY' => array(
        'width' => '10', 
        'label' => 'LBL_PROBABILITY'),
	'DATE_CLOSED' => array(
		'width' => '10', 
		'label' => 'LBL_LIST_DATE_CLOSED',
        'default' => true),
    'CREATED_BY_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_CREATED'),
	'TEAM_NAME' => array(
		'width' => '5', 
		'label' => 'LBL_LIST_TEAM',
        'default' => false),
	'ASSIGNED_USER_NAME' => array(
		'width' => '5', 
		'label' => 'LBL_LIST_ASSIGNED_USER',
		'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true),
    'MODIFIED_BY_NAME' => array(
        'width' => '5', 
        'label' => 'LBL_MODIFIED'),
    'DATE_ENTERED' => array(
        'width' => '10', 
        'label' => 'LBL_DATE_ENTERED',
		'default' => true)
);

?>
