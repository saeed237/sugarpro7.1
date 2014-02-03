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


$viewdefs['Home']['base']['view']['webpage'] = array(
    'dashlets' => array(
        array(
            'name' => 'LBL_DASHLET_WEBPAGE_NAME',
            'description' => 'LBL_DASHLET_WEBPAGE_DESC',
            'config' => array(
                'url' => 'http://www.sugarcrm.com',
                'module' => 'Home',
                'limit' => 3,
            ),
            'preview' => array(
                'title' => 'LBL_DASHLET_WEBPAGE_NAME',
                'url' => 'www.sugarcrm.com',
                'limit' => '3',
                'module' => 'Home',
            ),
        ),
    ),
    'config' => array(
        'fields' => array(
            array(
                'type' => 'iframe',
                'name' => 'url',
                'label' => "URL",
            ),
            array(
                'name' => 'limit',
                'label' => 'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS',
                'type' => 'enum',
                'options' => 'dashlet_webpage_limit_options',
            ),
        ),
    ),
    'view_panel' => array(
        array(
            'type' => 'iframe',
            'name' => 'url',
            'label' => "URL",
            'width' => '100%',

        ),
    ),
);
