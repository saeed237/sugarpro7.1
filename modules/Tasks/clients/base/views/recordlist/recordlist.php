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

$viewdefs['Tasks']['base']['view']['recordlist']['rowactions']['actions'] = array(
    array(
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'icon-eye-open',
        'acl_action' => 'view',
    ),
    array(
        'type' => 'rowaction',
        'name' => 'edit_button',
        'icon' => 'icon-pencil',
        'label' => 'LBL_EDIT_BUTTON',
        'event' => 'list:editrow:fire',
        'acl_action' => 'edit',
    ),
    array(
        'type' => 'follow',
        'name' => 'follow_button',
        'event' => 'list:follow:fire',
        'acl_action' => 'view',
    ),
    array(
        'type' => 'closebutton',
        'name' => 'record-close',
        'label' => 'LBL_CLOSE_BUTTON_TITLE',
        'acl_action' => 'edit',
    ),
    array(
        'type' => 'rowaction',
        'icon' => 'icon-trash',
        'event' => 'list:deleterow:fire',
        'label' => 'LBL_DELETE_BUTTON',
        'acl_action' => 'delete',
    ),
);
