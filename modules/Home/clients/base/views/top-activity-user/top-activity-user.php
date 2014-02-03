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


$viewdefs['Home']['base']['view']['top-activity-user'] = array(
    'dashlets' => array(
        array(
            'name' => 'LBL_MOST_ACTIVE_COLLEAGUES',
            'description' => 'LBL_MOST_ACTIVE_COLLEAGUES_DESC',
            'config' => array(
                'filter_duration' => '7',
                'module' => 'Home'
            ),
            'preview' => array(
                'filter_duration' => '7',
                'module' => 'Home'
            ),
            'filter' => array(
                'module' => array(
                    'Home',
                ),
                'view' => 'record',
            ),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 1,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'filter_duration',
                    'label' => 'Filter',
                    'type' => 'enum',
                    'options' => 'activity_user_options'
                ),
            ),
        ),
    ),
    'buttons' => array(
        array(
            'name' => 'filter_duration',
            'label' => 'Filter',
            'type' => 'enum',
            'options' => 'activity_user_options'
        ),
    ),
);
