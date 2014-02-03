<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


// PRO/CORP only fields
$fields = array(
    array(
        'name' => 'name',
        'width' =>  30,
        'link' => true,
        'label' => 'LBL_LIST_OPPORTUNITY_NAME',
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'account_name',
        'width' =>  20,
        'link'    => true,
        'label' => 'LBL_LIST_ACCOUNT_NAME',
        'enabled' => true,
        'default' => true,
        'sortable' => false,
    ),
    array(
        'name' => 'sales_stage',
        'width' => 10,
        'label' => 'LBL_LIST_SALES_STAGE',
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'amount',
        'type' => 'currency',
        'label' => 'LBL_LIKELY',
        'related_fields' => array(
            'amount',
            'currency_id',
            'base_rate',
        ),
        'currency_field' => 'currency_id',
        'base_rate_field' => 'base_rate',
        'width' => 10,
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'opportunity_type',
        'width' => 15,
        'label' => 'LBL_TYPE',
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'lead_source',
        'width' => 15,
        'label' => 'LBL_LEAD_SOURCE',
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'next_step',
        'width' => 10,
        'label' => 'LBL_NEXT_STEP',
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'probability',
        'width' => 10,
        'label' => 'LBL_PROBABILITY',
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'date_closed',
        'width' => 10,
        'label' => 'LBL_LIST_DATE_CLOSED',
        'enabled' => true,
        'default' => true,
    ),
    array(
        'name' => 'created_by_name',
        'width' => 10,
        'label' => 'LBL_CREATED',
        'sortable' => false,
        'enabled' => true,
        'default' => true,
        'readonly' => true
    ),
    array(
        'name' => 'team_name',
        'type' => 'teamset',
        'width' => 5,
        'label' => 'LBL_LIST_TEAM',
        'enabled' => true,
        'default' => false,
        'sortable' => false,
    ),
    array (
        'name' => 'assigned_user_name',
        'width' => 5,
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'id' => 'ASSIGNED_USER_ID',
        'enabled' => true,
        'default' => true,
        'sortable' => false,
    ),
    array(
        'name' => 'modified_by_name',
        'width' => 5,
        'label' => 'LBL_MODIFIED',
        'sortable' => false,
        'enabled' => true,
        'default' => true,
        'readonly' => true,
    ),
    array(
        'name' => 'date_entered',
        'width' => 10,
        'label' => 'LBL_DATE_ENTERED',
        'enabled' => true,
        'default' => true,
        'readonly' => true,
    ),
);



$viewdefs['Opportunities']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => $fields,
        ),
    ),
);
