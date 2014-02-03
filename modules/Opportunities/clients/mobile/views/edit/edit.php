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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
$fields = array(
    array(
        'name' => 'name',
        'displayParams' => array(
            'required' => true,
            'wireless_edit_only' => true,
        )
    ),
    'amount',
    'account_name',
    'date_closed',
    array(
        'name' => 'sales_status',
    ),
    'assigned_user_name',
    'team_name',
);

// here we add `sales_stage` for `pro` and `corporate` flavors
$fields = array(
    array(
        'name' => 'name',
        'displayParams' => array(
            'required' => true,
            'wireless_edit_only' => true,
        )
    ),
    'amount',
    'account_name',
    'date_closed',
    'sales_stage',
    'assigned_user_name',
    'team_name',
);

$viewdefs['Opportunities']['mobile']['view']['edit'] = array(
    'templateMeta' => array(
        'maxColumns' => '1',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => $fields
        )
    ),
);
?>