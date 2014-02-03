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

$viewdefs['base']['view']['bubblechart'] = array(
    'dashlets' => array(
        array(
            'name' => 'LBL_DASHLET_TOP10_SALES_OPPORTUNITIES_NAME',
            'description' => 'LBL_TOP10_OPPORTUNITIES_CHART_DESC',
            'config' => array(),
            'preview' => array(),
            'filter' => array(
                'module' => array(
                    'Home',
                    'Accounts',
                    'Contacts',
                    'Leads',
                    'Opportunities',
                    'RevenueLineItems',
                ),
                'view' => array(
                    'record',
                    'records',
                ),
            ),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'filter_duration',
                    'label' => 'LBL_TOP10_OPPORTUNITIES_FILTER_DURATIONS',
                    'type' => 'enum',
                    'options' => 'top10_opportunities_duration_options',
                    'enum_width' => 'auto',
                ),
                array(
                    'name' => 'filter_assigned',
                    'label' => 'LBL_TOP10_OPPORTUNITIES_DEFAULT_DATASET',
                    'type' => 'enum',
                    'options' => 'top10_opportunities_filter_assigned_options',
                    'enum_width' => 'auto',
                ),
            ),
        ),
    ),
    'filter_duration' => array(
        array(
            'name' => 'filter_duration',
            'label' => 'LBL_TOP10_OPPORTUNITIES_FILTER_DURATIONS',
            'type' => 'enum',
            'options' => 'top10_opportunities_duration_options',
            'enum_width' => 'auto',
        ),
    ),
);
