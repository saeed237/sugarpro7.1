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
$viewdefs[$module_name]['base']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'document_name',
                    'width' => '40',
                    'label' => 'LBL_NAME',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'modified_by_name',
                    'width' => '10',
                    'label' => 'LBL_MODIFIED_USER',
                    'module' => 'Users',
                    'id' => 'USERS_ID',
                    'default' => false,
                    'sortable' => false,
                    'related_fields' => array('modified_user_id'),
                ),
                array(
                    'name' => 'category_id',
                    'width' => '40',
                    'label' => 'LBL_LIST_CATEGORY',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'subcategory_id',
                    'width' => '40',
                    'label' => 'LBL_LIST_SUBCATEGORY',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'team_name',
                    'width' => '2',
                    'label' => 'LBL_TEAM',
                    'sortable' => false,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'created_by_name',
                    'width' => '2',
                    'label' => 'LBL_LIST_LAST_REV_CREATOR',
                    'default' => true,
                    'sortable' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'active_date',
                    'width' => '10',
                    'label' => 'LBL_LIST_ACTIVE_DATE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'exp_date',
                    'width' => '10',
                    'label' => 'LBL_LIST_EXP_DATE',
                    'default' => true,
                    'enabled' => true,
                ),
            ),
        ),
    ),
);