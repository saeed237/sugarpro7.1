<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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



$viewdefs['ProspectLists']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'width' => '25',
                    'label' => 'LBL_LIST_PROSPECT_LIST_NAME',
                    'link' => true,
                    'enabled' => true,
                    'default' => true
                ),
                array(
                    'name' => 'list_type',
                    'width' => '15',
                    'label' => 'LBL_LIST_TYPE_LIST_NAME',
                    'enabled' => true,
                    'default' => true
                ),
                array(
                    'name' => 'description',
                    'width' => '40',
                    'label' => 'LBL_LIST_DESCRIPTION',
                    'enabled' => true,
                    'default' => true
                ),
                array (
                    'name' => 'assigned_user_name',
                    'width' => '10%',
                    'label' => 'LBL_LIST_ASSIGNED_USER',
                    'id' => 'ASSIGNED_USER_ID',
                    'enabled' => true,
                    'default' => true,
                    'sortable' => false,
                ),
                array(
                    'name' => 'date_entered',
                    'type' => 'datetime',
                    'label' => 'LBL_DATE_ENTERED',
                    'width' => '10',
                    'enabled' => true,
                    'default' => true,
                    'readonly' => true,
                ),
            ),
        ),
    ),
);
