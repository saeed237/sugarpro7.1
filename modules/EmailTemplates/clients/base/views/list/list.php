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


$viewdefs['EmailTemplates']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array (
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'link' => true,
                    'default' => true,
                ),
                array (
                    'name'  => 'type',
                    'label' => 'LBL_TYPE',
                    'link' => false,
                    'default' => true
                ),
                array(
                    'name' => 'description',
                    'default' => true,
                    'sortable' => false,
                    'label' => 'LBL_DESCRIPTION'
                ),
                array (
                    'name'  => 'assigned_user_name',
                    'label' => 'LBL_LIST_ASSIGNED_USER',
                    'default' => true,
                ),
                array(
                    'name' => 'date_modified',
                    'label' => 'LBL_DATE_MODIFIED',
                    'default' => true,
                    'readonly' => true,
                ),
                array (
                    'name'  => 'date_entered',
                    'label' => 'LBL_DATE_ENTERED',
                    'default' => true,
                    'readonly' => true,
                ),
            ),
        ),
    ),
);
