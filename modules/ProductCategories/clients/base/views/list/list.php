<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
$viewdefs['ProductCategories']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'enabled' => true,
                    'default' => true,
                    'link' => true,
                ),
                array(
                    'name' => 'parent_name',
                    'enabled' => true,
                    'default' => true,
                    'related_fields' => array(
                        'parent_id'
                    ),
                    'id' => 'parent_id',
                    'label' => 'LBL_PARENT_CATEGORY',
                ),
                array(
                    'name' => 'description',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'list_order',
                    'enabled' => true,
                    'default' => true,
                ),
            )
        )
    )
);
