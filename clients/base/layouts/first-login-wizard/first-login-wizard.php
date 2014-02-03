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


$viewdefs['base']['layout']['first-login-wizard'] = array(
    'type' => 'wizard',
    'buttons' => array(
        array(
            'name' => 'previous_button',
            'type' => 'button',
            'label' => 'LBL_BACK',
            'css_class' => 'btn-link btn-invisible',
        ),
        array(
            'name' => 'next_button',
            'type' => 'button',
            'label' => 'LNK_LIST_NEXT',
            'primary' => true,
        ),
        array(
            'name' => 'start_sugar_button',
            'type' => 'button',
            'label' => 'LBL_WIZ_START_SUGAR',
            'primary' => true,
        ),
    ),
    'components' => array(
        0 => array(
            'view' => 'user-wizard-page'
        ),
        1 => array(
            'view' => "user-locale-wizard-page"
        ),
        2 => array(
            'view' => 'setup-complete-wizard-page'
        )
    ),
);
