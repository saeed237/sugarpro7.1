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
$module_name = '<module_name>';
$viewdefs[$module_name]['base']['view']['twitter'] = array(
    'dashlets' => array(
        array(
            'name' => 'LBL_TWITTER_NAME',
            'description' => 'LBL_TWITTER_DESCRIPTION',
            'config' => array(
                'limit' => '20',
            ),
            'preview' => array(
                'title' => 'LBL_TWITTER_MY_ACCOUNT',
                'twitter' => 'sugarcrm',
                'limit' => '3',
            ),
        ),
    ),
    'config' => array(
        'fields' => array(
            array(
                'name' => 'limit',
                'label' => 'LBL_TWITTER_DISPLAY_ROWS',
                'type' => 'enum',
                'options' => array(
                    5 => 5,
                    10 => 10,
                    15 => 15,
                    20 => 20,
                    50 => 50,
                ),
            ),
        ),
    ),
);
