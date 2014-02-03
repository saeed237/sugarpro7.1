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

$viewdefs['Accounts']['base']['layout']['record-dashboard'] = array(
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
                                'name' => 'opportunity-metrics',
                                'label' => 'LBL_DASHLET_OPPORTUNITY_NAME',
                            ),
                            'width' => 12,
                        ),
                    ),
                    array(
                        array(
                            'view' =>
                            array(
                                'name' => 'casessummary',
                                'label' => 'LBL_DASHLET_CASES_SUMMARY_NAME',
                            ),
                            'width' => 12,
                        ),
                    ),
                    array(
                        array(
                            'view' =>
                            array(
                                'name' => 'news',
                                'label' => 'LBL_DASHLET_NEWS_FEED_NAME',
                            ),
                            'width' => 12,
                        ),
                    ),
                    array(
                        array(
                            'view' => array(
                                'name' => 'planned-activities',
                                'label' => 'LBL_PLANNED_ACTIVITIES_DASHLET',
                                'limit' => '10',
                                'date' => 'today',
                                'visibility' => 'user',
                            ),
                            'width' => 12,
                        ),
                    ),
                    array(
                        array(
                            'view' => array(
                                'name' => 'history',
                                'label' => 'LBL_HISTORY_DASHLET',
                                'filter' => '7',
                                'limit' => '10',
                                'visibility' => 'user',
                            ),
                            'width' => 12,
                        ),
                    ),
                ),
                'width' => 12,
            ),
        ),
    ),
    'name' => 'LBL_DEFAULT_DASHBOARD_TITLE',
);

