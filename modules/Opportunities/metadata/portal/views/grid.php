<?php
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


$viewdefs['Opportunities']['portal']['view']['grid'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'name',
                    'label' => 'Name',
                    'default' => true,
                    'enabled' => true,
                ),
                1 =>
                array(
                    'name' => 'amount',
                    'label' => 'Opportunity Amount',
                    'default' => true,
                    'enabled' => true,
                    'type' => 'clickToEdit',
                    'cteclass' => 'cteopp',
                ),
                2 =>
                array(
                    'name' => 'opportunity_type',
                    'label' => 'Opp. Type',
                    'default' => true,
                    'enabled' => true,
                ),
                3 =>
                array(
                    'name' => 'lead_source',
                    'label' => 'Lead Source',
                    'default' => true,
                    'enabled' => true,
                    'type' => 'clickToEdit',
                    'cteclass' => 'ctels',
                    'ctetype' => 'chosen',
                ),
                4 =>
                array(
                    'name' => 'assigned_user_id',
                    'label' => 'Assigned User',
                    'default' => true,
                    'enabled' => true,
                ),
            ),
        ),
    ),
);
