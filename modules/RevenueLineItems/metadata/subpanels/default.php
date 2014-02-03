<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright 2004-2013 SugarCRM Inc. All rights reserved.
 */

$subpanel_layout = array(
    'top_buttons' => array(
        array('widget_class' => 'SubPanelTopCreateButton'),
        array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Accounts'),
    ),

    'where' => '',

    'fill_in_additional_fields'=>true,

    'list_fields' => array(
        'name' =>
        array (
            'vname' => 'LBL_LIST_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '10%',
            'sort_by' => 'products.name',
            'default' => true,
        ),
        'sales_stage' =>
        array (
            'type' => 'enum',
            'vname' => 'LBL_SALES_STAGE',
            'width' => '10%',
            'default' => true,
        ),
        'probability' =>
        array (
            'type' => 'int',
            'vname' => 'LBL_PROBABILITY',
            'width' => '10%',
            'default' => true,
        ),
        'date_closed' =>
        array (
            'type' => 'date',
            'related_fields' =>
            array (
                0 => 'date_closed_timestamp',
            ),
            'vname' => 'LBL_DATE_CLOSED',
            'width' => '10%',
            'default' => true,
        ),
        'commit_stage' =>
        array (
            'type' => 'enum',
            'default' => true,
            'vname' => 'LBL_COMMIT_STAGE_FORECAST',
            'width' => '10%',
        ),
        'quantity' =>
        array (
            'vname' => 'LBL_QUANTITY',
            'width' => '10%',
            'default' => true,
        ),
        'discount_usdollar' =>
        array (
            'usage' => 'query_only',
        ),
    ),
);
