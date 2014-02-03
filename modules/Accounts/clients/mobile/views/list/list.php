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
$viewdefs['Accounts']['mobile']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                    'width' => '10%',
                ),
                array(
                    'name' => 'billing_address_city',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'website',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                    'width' => '10%',
                ),
                array(
                    'name' => 'phone_office',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'email',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'billing_address_street',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'billing_address_state',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'billing_address_postalcode',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'billing_address_country',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'shipping_address_street',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'shipping_address_city',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'shipping_address_state',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'shipping_address_postalcode',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'shipping_address_country',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'team_name',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
            ),
        ),
    ),
);
