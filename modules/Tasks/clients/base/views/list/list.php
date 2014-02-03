<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$viewdefs['Tasks']['base']['view']['list'] = array(
    'panels' =>
    array(
        array(
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'name' => 'name',
                    'width' => 40,
                    'link' => true,
                    'label' => 'LBL_LIST_SUBJECT',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'contact_name',
                    'width' => '20',
                    'label' => 'LBL_LIST_CONTACT',
                    'link' => true,
                    'id' => 'CONTACT_ID',
                    'module' => 'Contacts',
                    'enabled' => true,
                    'default' => true,
                    'ACLTag' => 'CONTACT',
                    'related_fields' => array('contact_id'),
                    'sortable' => false,
                ),
                array(
                    'name' => 'parent_name',
                    'width' => '20',
                    'label' => 'LBL_LIST_RELATED_TO',
                    'dynamic_module' => 'PARENT_TYPE',
                    'id' => 'PARENT_ID',
                    'link' => true,
                    'enabled' => true,
                    'default' => true,
                    'sortable' => false,
                    'ACLTag' => 'PARENT',
                    'related_fields' => array('parent_id', 'parent_type'),
                ),
                array(
                    'name' => 'date_due',
                    'width' => '15',
                    'label' => 'LBL_LIST_DUE_DATE',
                    'link' => false,
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'team_name',
                    'width' => '2',
                    'label' => 'LBL_LIST_TEAM',
                    'enabled' => true,
                    'default' => false,
                    'sortable' => false,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'width' => '2',
                    'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
                    'id' => 'ASSIGNED_USER_ID',
                    'enabled' => true,
                    'default' => true,
                    'sortable' => false,
                ),
                array(
                    'name' => 'date_start',
                    'width' => '5',
                    'label' => 'LBL_LIST_START_DATE',
                    'link' => false,
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'status',
                    'width' => '10',
                    'label' => 'LBL_LIST_STATUS',
                    'link' => false,
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'date_entered',
                    'width' => '10',
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'default' => true,
                    'readonly' => true,
                ),
            ),
        ),
    ),
);
