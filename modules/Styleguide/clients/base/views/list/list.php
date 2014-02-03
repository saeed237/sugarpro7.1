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



$viewdefs['Styleguide']['base']['view']['list'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'full_name',
                    'type' => 'fullname',
                    'fields' => array(
                        'salutation',
                        'first_name',
                        'last_name',
                    ),
                    'link' => true,
                    'css_class' => 'full-name',
                    'width' =>  49,
                    'label' => 'fullname',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'title',
                    'label' => 'base',
                ),
                array(
                    'name' => 'do_not_call',
                    'label' => 'bool',
                ),
                array(
                    'name' => 'parent_name',
                    'label' => 'parent',
                    'sortable' => false,
                ),
                array(
                    'name' => 'email',
                    'label' => 'email',
                    'sortable' => false,
                ),
                array (
                    'name' => 'assigned_user_name',
                    'width' => '10%',
                    'label' => 'relate',
                    'id' => 'ASSIGNED_USER_ID',
                    'default' => true,
                    'sortable' => false,
                ),
                array(
                    'name' => 'filename',
                    'label' => 'file',
                ),
                array(
                    'name' => 'list_price',
                    'label' => 'currency',
                ),
                array(
                    'name' => 'date_entered',
                    'label' => 'datetimecombo',
                    'sortable' => false,
                ),
            ),
        ),
    ),
);

