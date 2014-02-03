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

$viewdefs['Documents']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'document_name',
                    'label' => 'LBL_DOCUMENT_NAME',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                ),
                array(
                    'name' => 'filename',
                    'width' => '20%',
                    'label' => 'LBL_FILENAME',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                    'sortable' => false,
                ),
                array(
                    'name' => 'doc_type',
                    'width' => '5%',
                    'label' => 'LBL_DOC_TYPE',
                    'link' => false,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'category_id',
                    'width' => '10%',
                    'label' => 'LBL_LIST_CATEGORY',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'subcategory_id',
                    'width' => '15%',
                    'label' => 'LBL_LIST_SUBCATEGORY',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'team_name',
                    'width' => '2', 
                    'label' => 'LBL_LIST_TEAM',
                    'default' => false,
                    'enabled' => true,
                    'sortable' => false
                ),
                array(
                    'name' => 'last_rev_create_date',
                    'width' => '10%',
                    'label' => 'LBL_LIST_LAST_REV_DATE',
                    'default' => true,
                    'enabled' => true,
                    'sortable' => false,
                ),
                array(
                    'name' => 'exp_date',
                    'width' => '10%',
                    'label' => 'LBL_LIST_EXP_DATE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'width' => '10',
                    'label' => 'LBL_LIST_ASSIGNED_USER',
                    'module' => 'Employees',
                    'id' => 'ASSIGNED_USER_ID',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                ),
                array(
                    'name' => 'modified_by_name',
                    'width' => '10%',
                    'label' => 'LBL_MODIFIED_USER',
                    'module' => 'Users',
                    'id' => 'USERS_ID',
                    'default' => false,
                    'enabled' => true,
                    'sortable' => false,
                    'readonly' => true,
                ),
                array(
                    'name' => 'date_entered',
                    'width' => '10%',
                    'label' => 'LBL_DATE_ENTERED',
                    'default' => true,
                    'enabled' => true,
                    'readonly' => true,
                ),
            ),
        ),
    ),
);
