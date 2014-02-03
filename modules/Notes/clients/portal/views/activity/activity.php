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

$viewdefs['Notes']['portal']['view']['activity'] = array(
    'buttons' =>
    array(
        0 =>
        array(
            'name' => 'show_more_button',
            'type' => 'button',
            'label' => 'Show More',
            'class' => 'loading wide'
        ),
    ),
    'panels' =>
    array(
        0 =>
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'name',
                    'default' => true,
                    'enabled' => true,
                    'width' =>  8
                ),
                1 =>
                array(
                    'name' => 'description',
                    'default' => true,
                    'enabled' => true,
                    'width' => 13
                ),
                2 =>
                array(
                    'name' => 'date_entered',
                    'default' => true,
                    'enabled' => true,
                    'width' => 13
                ),
                3 =>
                array(
                    'name' => 'created_by_name',
                    'default' => true,
                    'enabled' => true,
                    'width' => 13
                ),
                4 =>
                array(
                    'name' => 'filename',
                    'default' => true,
                    'enabled' => true,
                    'sorting' => true,
                    'width' => 35
                ),
            ),
        ),
    ),
);
