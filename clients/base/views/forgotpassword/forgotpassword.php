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


$viewdefs['base']['view']['forgotpassword'] = array(
    'action' => 'list',
    'buttons' =>
    array(
        array(
            'name' => 'forgotPassword_button',
            'type' => 'button',
            'label' => 'LBL_REQUEST_PASSWORD',
            'primary' => true,
        ),
        array(
            'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_LOGIN_BUTTON_LABEL',
            'css_class' => 'pull-left',
        ),
    ),
    'panels' =>
    array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' =>
            array(
                array(
                    'name' => 'username',
                    'type' => 'varchar',
                    'placeholder' => "LBL_LIST_USER_NAME",
                    'required' => true,
                ),
                array(
                    'name' => 'email',
                    'type' => 'email',
                    'placeholder' => "LBL_EMAIL_BUTTON",
                    'required' => true,
                ),
                array(
                    'name' => 'first_name',
                    'type' => 'text',
                    'css_class' => 'hp',
                    'placeholder' => "LBL_HONEYPOT",
                ),
            ),
        ),
    ),
);
