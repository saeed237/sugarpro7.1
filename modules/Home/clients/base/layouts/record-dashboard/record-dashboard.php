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
$viewdefs['Home']['base']['layout']['record-dashboard'] = array(
    'metadata' =>
    array(
        'components' =>
        array(
            array(
                'rows' =>
                array(
                    array(
                        array(
                            'view' =>
                            array(
                                'name' => 'twitter',
                                'label' => 'LBL_DASHLET_RECENT_TWEETS_SUGARCRM_NAME',
                                'twitter' => 'sugarcrm',
                                'limit' => 20,
                            ),
                            'width' => 12,
                        ),
                    ),
                    array(
                        array(
                            'view' =>
                            array(
                                'name' => 'dashablelist',
                                'label' => 'TPL_DASHLET_MY_MODULE',
                                'display_columns' =>
                                array(
                                    'full_name',
                                    'account_name',
                                    'phone_work',
                                    'title',
                                ),
                                'limit' => 15,
                            ),
                            'context' =>
                            array(
                                'module' => 'Contacts',
                            ),
                            'width' => 12,
                        ),
                    ),
                ),
                'width' => 4,
            ),
            array(
                'rows' =>
                array(
                    array(
                        array(
                            'view' =>
                            array(
                                'name' => 'forecast-pipeline',
                                'label' => 'LBL_DASHLET_PIPLINE_NAME',
                                'display_type' => 'self',
                            ),
                            'context' =>
                            array(
                                'module' => 'Forecasts',
                            ),
                            'width' => 12,
                        ),
                    ),
                    array(
                        array(
                            'view' =>
                            array(
                                'name' => 'bubblechart',
                                'label' => 'LBL_DASHLET_TOP10_SALES_OPPORTUNITIES_NAME',
                                'filter_duration' => 0,
                                'filter_assigned' => 'my',
                            ),
                            'width' => 12,
                        ),
                    ),
                ),
                'width' => 8,
            ),
        ),
    ),
    'name' => 'LBL_DEFAULT_DASHBOARD_TITLE',
);
