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


$listViewDefs['Calls'] = array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'TEAM_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_TEAM',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'default' => true,
    ),
    'PARENT_NAME' => array(
        'width' => '20%',
        'label' => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => false,
        'sortable' => false,
        'ACLTag' => 'PARENT',
        'related_fields' => array(
            'parent_id',
            'parent_type',
        ),
    ),
);
