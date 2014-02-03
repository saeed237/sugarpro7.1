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


$viewdefs['base']['view']['user-wizard-page'] = array(
    'title' => 'LBL_WIZ_USER_PROFILE_TITLE',
    'message' => 'LBL_SETUP_USER_INFO',
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'first_name',
                    'label' => "LBL_WIZ_FIRST_NAME",
                ),
                array(
                    'name' => 'last_name',
                    'label' => "LBL_WIZ_LAST_NAME",
                    'required' => true,
                ),
                array(
                    'name' => 'email',
                    'type' => 'email-text',
                    'label' => "LBL_WIZ_EMAIL",
                    'required' => true,
                ),
                array(
                    'name' => 'phone_work',
                    'type' => 'phone',
                    'label' => 'LBL_LIST_PHONE',
                ),
            ),
        ),
    ),
);
