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

$viewdefs['Accounts']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'width' =>  49,
                    'link' => true,
                    'label' => 'LBL_LIST_ACCOUNT_NAME',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'billing_address_city',
                    'width' =>  13,
                    'label' => 'LBL_LIST_CITY',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'billing_address_country',
                    'width' =>  13,
                    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
                    'enabled' => true,
                    'default' => true,
                ),
                array (
                    'name' => 'phone_office',
                    'width' => '10%',
                    'label' => 'LBL_LIST_PHONE',
                    'enabled' => true,
                    'default' => true,
                ),
                array (
                    'name' => 'assigned_user_name',
                    'width' => '10%',
                    'label' => 'LBL_LIST_ASSIGNED_USER',
                    'id' => 'ASSIGNED_USER_ID',
                    'sortable' => false,
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'email',
                    'width' => '15%',
                    'label' => 'LBL_EMAIL_ADDRESS',
                    'sortable' => false,
                    'enabled' => true,
                    'default' => true,
                ),
                array (
                    'name' => 'date_entered',
                    'type' => 'datetime',
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'width' => 13,
                    'default' => true,
                    'readonly' => true,
                ),
            ),

        ),
    ),
);
