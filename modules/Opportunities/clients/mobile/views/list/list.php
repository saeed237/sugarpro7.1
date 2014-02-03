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

$viewdefs['Opportunities']['mobile']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'name',
                    'width' => '30',
                    'label' => 'LBL_LIST_OPPORTUNITY_NAME',
                    'link' => true,
                    'default' => true,
                    'enabled' => true
                ),
                array(
                    'name' => 'account_name',
                    'width' => '10',
                    'label' => 'LBL_LIST_ACCOUNT_NAME',
                    'default' => true,
                    'enabled' => true
                ),

// ENT/ULT should have sales status
                array(
                    'name' => 'opportunity_type',
                    'width' => '15',
                    'label' => 'LBL_TYPE',
                    'default' => false,
                ),
                array(
                    'name' => 'lead_source',
                    'width' => '15',
                    'label' => 'LBL_LEAD_SOURCE',
                    'default' => false,
                ),
                array(
                    'name' => 'next_step',
                    'width' => '10',
                    'label' => 'LBL_NEXT_STEP',
                    'default' => false,
                ),
                array(
                    'name' => 'probability',
                    'width' => '10',
                    'label' => 'LBL_PROBABILITY',
                    'default' => false,
                ),
                array(
                    'name' => 'date_closed',
                    'width' => '10',
                    'label' => 'LBL_LIST_DATE_CLOSED',
                    'default' => false,
                    'enabled' => true
                ),
                array(
                    'name' => 'date_entered',
                    'width' => '10',
                    'label' => 'LBL_DATE_ENTERED',
                    'default' => false,
                    'readonly' => true,
                ),
                array(
                    'name' => 'created_by_name',
                    'width' => '10',
                    'label' => 'LBL_CREATED',
                    'default' => false,
                    'readonly' => true,
                ),
// CORP/PRO should have sales stage
                array(
                    'name' => 'sales_stage',
                    'width' => '10',
                    'label' => 'LBL_SALES_STAGE',
                    'default' => false,
                    'enabled' => true,
                ),

                array(
                    'name' => 'team_name',
                    'width' => '5',
                    'label' => 'LBL_LIST_TEAM',
                    'default' => false,
                    'enabled' => true
                ),
                array(
                    'name' => 'assigned_user_name',
                    'width' => '5',
                    'label' => 'LBL_LIST_ASSIGNED_USER',
                    'default' => false,
                    'enabled' => true
                ),
                array(
                    'name' => 'modified_by_name',
                    'width' => '5',
                    'label' => 'LBL_MODIFIED',
                    'default' => false,
                    'readonly' => true,
                )
            )
        )
    )
);

?>
