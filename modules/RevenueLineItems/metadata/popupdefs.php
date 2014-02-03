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

$popupMeta = array(
    'moduleMain' => 'RevenueLineItems',
    'varName' => 'RLI',
    'orderBy' => 'name',
    'whereClauses' => array(
        'name' => 'revenue_line_items.name',
        'account_name' => 'accounts.name',
        'opportunity_name' => 'opportunities.name',
    ),
    'searchInputs' => array('name', 'account_name', 'opportunity_name'),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '25',
            'label' => 'LBL_NAME',
            'link' => true,
            'default' => true
        ),
        'OPPORTUNITY_NAME' => array(
            'width' => '20',
            'label' => 'LBL_LIST_OPPORTUNITY_NAME',
            'id' => 'OPPORTUNITY_ID',
            'module' => 'Opportunities',
            'link' => true,
            'default' => true
        ),
        'ACCOUNT_NAME' => array(
            'width' => '20',
            'label' => 'LBL_LIST_ACCOUNT_NAME',
            'id' => 'ACCOUNT_ID',
            'module' => 'Accounts',
            'link' => true,
            'default' => true
        ),
        'LIKELY_CASE' => array(
            'width' => '10',
            'default' => true,
            'label' => 'LBL_LIKELY',
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '10',
            'label' => 'LBL_LIST_ASSIGNED_USER',
            'link' => false,
            'default' => true
        ),
    ),
    'searchdefs' => array(
        'name',
        array(
            'name' => 'account_name',
            'displayParams' => array('hideButtons' => 'true', 'size' => 30, 'class' => 'sqsEnabled sqsNoAutofill')
        ),
        array(
            'name' => 'opportunity_name',
            'displayParams' => array('hideButtons' => 'true', 'size' => 30, 'class' => 'sqsEnabled sqsNoAutofill')
        ),
        array(
            'name' => 'assigned_user_id',
            'type' => 'enum',
            'label' => 'LBL_ASSIGNED_TO',
            'function' => array('name' => 'get_user_array', 'params' => array(false))
        ),
    )
);
