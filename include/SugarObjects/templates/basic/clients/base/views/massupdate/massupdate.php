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

$module_name = '<module_name>';
$viewdefs[$module_name]['base']['view']['massupdate'] = array(
    'buttons' => array(
        array(
            'name' => 'update_button',
            'type' => 'button',
            'label' => 'Update',
            'acl_action' => 'massupdate',
            'css_class' => 'btn-primary',
            'primary' => true,
        ),
        array(
            'type' => 'button',
            'value' => 'cancel',
            'css_class' => 'btn-invisible cancel_button',
            'icon' => 'icon-remove',
            'primary' => false,
        ),
    ),
    'panels' =>
    array(
        array(
            'fields' => array(
            )
        )
    )
);
