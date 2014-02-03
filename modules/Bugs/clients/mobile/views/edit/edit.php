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


$viewdefs['Bugs']['mobile']['view']['edit'] = array(
    'templateMeta' => array('maxColumns' => '1',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
    ),

    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array('name' => 'bug_number', 'displayParams' => array('required' => false, 'wireless_detail_only' => true,)),
                'priority',
                'status',
                array(
                    'name' => 'name',
                    'label' => 'LBL_SUBJECT',
                ),
                'description',
                'resolution',
                'assigned_user_name',
                'team_name',
            )
        )
    )
);
?>