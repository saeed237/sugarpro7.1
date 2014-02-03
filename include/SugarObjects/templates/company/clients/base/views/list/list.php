<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$module_name = '<module_name>';
$_module_name = '<_module_name>';
$viewdefs[$module_name]['base']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_ACCOUNT_NAME',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                    'width' => '40',
                ),
                array(
                    'name' => 'billing_address_city',
                    'label' => 'LBL_CITY',
                    'default' => true,
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'phone_office',
                    'label' => 'LBL_PHONE',
                    'default' => true,
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => $_module_name . '_type',
                    'label' => 'LBL_TYPE',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'industry',
                    'label' => 'LBL_INDUSTRY',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'annual_revenue',
                    'label' => 'LBL_ANNUAL_REVENUE',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'phone_fax',
                    'label' => 'LBL_PHONE_FAX',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'billing_address_street',
                    'label' => 'LBL_BILLING_ADDRESS_STREET',
                    'enabled' => true,
                    'width' => '15',
                ),
                array(
                    'name' => 'billing_address_state',
                    'label' => 'LBL_BILLING_ADDRESS_STATE',
                    'enabled' => true,
                    'width' => '7',
                ),
                array(
                    'name' => 'billing_address_postalcode',
                    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'billing_address_country',
                    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'shipping_address_street',
                    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
                    'enabled' => true,
                    'width' => '15',
                ),
                array(
                    'name' => 'shipping_address_city',
                    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'shipping_address_state',
                    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
                    'enabled' => true,
                    'width' => '7',
                ),
                array(
                    'name' => 'shipping_address_postalcode',
                    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'shipping_address_country',
                    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'phone_alternate',
                    'label' => 'LBL_PHONE_ALT',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'website',
                    'label' => 'LBL_WEBSITE',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'ownership',
                    'label' => 'LBL_OWNERSHIP',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'employees',
                    'label' => 'LBL_EMPLOYEES',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'ticker_symbol',
                    'label' => 'LBL_TICKER_SYMBOL',
                    'enabled' => true,
                    'width' => '10',
                ),
                array(
                    'name' => 'email1',
                    'width' => '15%', 
                    'label' => 'LBL_EMAIL_ADDRESS',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'team_name',
                    'label' => 'LBL_TEAM',
                    'default' => true,
                    'enabled' => true,
                    'width' => '2',
                ),
                array(
                    'name' => 'assigned_user_name',
                    'label' => 'LBL_ASSIGNED_TO_NAME',
                    'default' => true,
                    'enabled' => true,
                    'width' => '2',
                ),
            ),
        ),
    ),
);