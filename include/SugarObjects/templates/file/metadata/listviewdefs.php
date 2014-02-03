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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
 $module_name = '<module_name>';
$OBJECT_NAME = '<OBJECT_NAME>';
 $listViewDefs[$module_name] = array(

	'DOCUMENT_NAME' => array(
		'width' => '40',
		'label' => 'LBL_NAME',
		'link' => true,
        'default' => true),
    'MODIFIED_BY_NAME' => array(
        'width' => '10',
        'label' => 'LBL_MODIFIED_USER',
        'module' => 'Users',
        'id' => 'USERS_ID',
        'default' => false,
        'sortable' => false,
        'related_fields' => array('modified_user_id')),
    'CATEGORY_ID' => array(
        'width' => '40',
        'label' => 'LBL_LIST_CATEGORY',
        'default' => true),
    'SUBCATEGORY_ID' => array(
        'width' => '40',
        'label' => 'LBL_LIST_SUBCATEGORY',
        'default' => true),
    'TEAM_NAME' => array(
        'width' => '2',
        'label' => 'LBL_LIST_TEAM',
        'default' => false,
        'sortable' => false),
    'CREATED_BY_NAME' => array(
        'width' => '2',
        'label' => 'LBL_LIST_LAST_REV_CREATOR',
        'default' => true,
        'sortable' => false),

    'ACTIVE_DATE' => array(
        'width' => '10',
        'label' => 'LBL_LIST_ACTIVE_DATE',
        'default' => true),
    'EXP_DATE' => array(
        'width' => '10',
        'label' => 'LBL_LIST_EXP_DATE',
        'default' => true),
        );
