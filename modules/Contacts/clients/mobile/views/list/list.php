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

$viewdefs['Contacts']['mobile']['view']['list'] = array(
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
                    'related_fields' => array('first_name', 'last_name', 'salutation'),
                    'width' => '10%',
                ),
                array(
                    'name' => 'title',
                    'label' => 'LBL_TITLE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'email1',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'phone_work',
                    'label' => 'LBL_OFFICE_PHONE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'phone_mobile',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'phone_home',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array (
                    'name' => 'picture',
                    'label' => 'LBL_PICTURE_FILE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'primary_address_street',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'primary_address_city',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'primary_address_state',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'primary_address_postalcode',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'primary_address_country',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'alt_address_street',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'alt_address_city',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'alt_address_state',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'alt_address_postalcode',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'alt_address_country',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
            ),
        ),
    ),
);
