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


$viewdefs['base']['view']['login'] = array(
    'action' => 'edit',
    'buttons' => array(
            array(
                'name' => 'login_button',
                'type' => 'button',
                'label' => 'LBL_LOGIN_BUTTON_LABEL',
                'primary' => true
            ),
        ),
    'panels' => array(
            array(
                'label' => 'LBL_PANEL_DEFAULT',
                'fields' =>
                array(
                    array(
                        'name' => 'username',
                        'type' => 'text',
                        'placeholder' => "LBL_LIST_USER_NAME", //LBL_LOGIN_USERNAME not translating properly across languages so using this for 6.x parity
                        'no_required_placeholder' => true,
                        'required' => true,
                    ),
                    array(
                        'name' => 'password',
                        'type' => 'password',
                        'placeholder' => "LBL_PASSWORD",
                        'no_required_placeholder' => true,
                        'required' => true,
                    ),
                ),
            ),
        ),
);
