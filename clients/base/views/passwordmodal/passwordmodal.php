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


$viewdefs['base']['view']['passwordmodal'] = array(
    'buttons' =>
        array(
            array(
                'name' => 'save_button',
                'type' => 'button',
                'label' => 'LBL_SAVE_BUTTON_LABEL',
                'value' => 'save',
                'css_class' => 'btn-primary save-profile',
            ),
            array(
                'name' => 'cancel_button',
                'type' => 'button',
                'label' => 'LBL_CANCEL_BUTTON_LABEL',
                'value' => 'cancel',
                'css_class' => 'btn-invisible btn-link',
            ),
        ),
    'panels' =>
        array(
            array(
                'label' => 'LBL_PANEL_DEFAULT',
                'fields' =>
                array(
                    array(
                        'name' => 'current_password',
                        'type' => 'password',
                        'label' => 'LBL_OLD_PASSWORD',
                        'displayParams' =>
                        array(
                            'colspan' => 2,
                        ),
                    ),
                    array(
                        'name' => 'new_password',
                        'type' => 'password',
                        'label' => 'LBL_NEW_PASSWORD',
                        'displayParams' =>
                        array(
                            'colspan' => 2,
                        ),
                    ),
                    array(
                        'name' => 'confirm_password',
                        'type' => 'password',
                        'label' => 'LBL_NEW_PASSWORD2',
                        'displayParams' =>
                        array(
                            'colspan' => 2,
                        ),
                    ),
                ),
            ),
        ),
);
