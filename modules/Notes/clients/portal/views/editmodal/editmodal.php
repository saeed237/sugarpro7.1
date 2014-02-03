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

$viewdefs['Notes']['portal']['view']['editmodal'] = array(
    'buttons' => array(
        array(
            'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'value' => 'cancel',
            'css_class' => 'btn-invisible btn-link',
        ), 
        array(
            'name' => 'save_button',
            'type' => 'button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'value' => 'save',
            'css_class' => 'btn-primary',
        ),
    ),
    'panels' => array(
        array(
            'label' => 'LBL_EDIT_BUTTON_LABEL',
            'fields' => array(
                0 =>
                array(
                    'name' => 'name',
                    'default' => true,
                    'enabled' => true,
                    'width' => 35,
                    'required' => true
                ),
                1 =>
                array(
                    'name' => 'description',
                    'default' => true,
                    'enabled' => true,
                    'width' => 35,
                    'required' => true,
                    'rows' => 5,
                ),
                2 =>
                array(
                    'name' => 'filename',
                    'default' => true,
                    'enabled' => true,
                    'sorting' => true,
                    'width' => 35,
                ),
            )
        )
    )
);
