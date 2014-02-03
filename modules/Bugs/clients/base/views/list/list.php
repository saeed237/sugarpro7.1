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

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs['Bugs']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name'=>  'bug_number',
                    'enabled' => true,
                    'default'=>true,
                ),
                array(
                    'name'=>  'name',
                    'enabled' => true,
                    'default'=>true,
                ),
                array(
                    'name'=>  'status',
                    'enabled' => true,
                    'default'=>true,
                ),
                array(
                    'name'=>  'type',
                    'enabled' => true,
                    'default'=>true
                ),
                array(
                    'name'=>  'priority',
                    'enabled' => true,
                    'default'=>true,
                ),
                array(
                    'name'=>  'fixed_in_release_name',
                    'enabled' => true,
                    'default'=>true,
                    'link' => false,
                ),
                array(
                    'name'=>  'assigned_user_name',
                    'enabled' => true,
                    'default'=>true,
                    'sortable' => false,
                ),
                array(
                    'name'=>  'release_name',
                    'enabled' => true,
                    'default' => false,
                    'link' => false,
                ),
                array(
                    'name'=>  'resolution',
                    'enabled' => true,
                    'default'=>false,
                ),
                array(
                    'name'=>  'team_name',
                    'enabled' => true,
                    'default'=>false,
                    'sortable' => false,
                ),
            ),

        ),
    ),
);
