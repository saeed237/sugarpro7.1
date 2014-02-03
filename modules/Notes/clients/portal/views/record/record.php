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

$viewdefs['Notes']['portal']['view']['record'] = array(
    'panels' => array(
        array(
            'label' => 'Details',
            'fields' => array(
                array(
                    'name'          => 'picture',
                    'type'          => 'avatar',
                    'width'         => 42,
                    'height'        => 42,
                    'dismiss_label' => true,
                    'readonly'      => true,
                ),
                array(
                    'name' => 'name',
                    'default' => true,
                    'enabled' => true,
                    'width' => 35
                ),
                array(
                    'name' => 'description',
                    'default' => true,
                    'enabled' => true,
                    'width' => 35
                ),
                array(
                    'name' => 'date_entered',
                    'default' => true,
                    'enabled' => true,
                    'width' => 35
                ),
                array(
                    'name' => 'created_by_name',
                    'default' => true,
                    'enabled' => true,
                    'width' => 35
                ),
                array(
                    'name' => 'filename',
                    'default' => true,
                    'enabled' => true,
                    'sorting' => true,
                    'width' => 35
                ),
            )
        )
    )
);
