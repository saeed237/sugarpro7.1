<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (\“MSA\”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
$viewdefs['CampaignLog']['base']['view']['subpanel-list'] = array(
    'favorite' => false,
    'selection' => array(),
    'rowactions' => array(),
    'panels' =>
    array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'label' => 'LBL_LIST_CAMPAIGN_NAME',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'campaign_name1',
                ),
                array(
                    'label' => 'LBL_ACTIVITY_TYPE',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'activity_type',
                ),
                array(
                    'label' => 'LBL_ACTIVITY_DATE',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'activity_date',
                ),
                array(
                    'label' => 'LBL_RELATED',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'related_name',
                    'type' => 'parent',
                    'related_fields' => array(
                        'parent_id',
                        'parent_type',
                    ),
                ),
            ),
        ),
    ),
);
