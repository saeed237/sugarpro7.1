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
$viewdefs[$module_name]['base']['view']['list'] = array(
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
                ),
                array(
                    'name' => 'title',
                    'width' => '15%', 
                    'label' => 'LBL_TITLE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'phone_work',
                    'width' => '15%', 
                    'label' => 'LBL_OFFICE_PHONE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'email',
                    'width' => '15%', 
                    'label' => 'LBL_EMAIL_ADDRESS',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'do_not_call',
                    'width' => '10', 
                    'label' => 'LBL_DO_NOT_CALL',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'phone_home',
                    'width' => '10', 
                    'label' => 'LBL_HOME_PHONE',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'phone_mobile',
                    'width' => '10', 
                    'label' => 'LBL_MOBILE_PHONE',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'phone_other',
                    'width' => '10', 
                    'label' => 'LBL_WORK_PHONE',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'phone_fax',
                    'width' => '10', 
                    'label' => 'LBL_FAX_PHONE',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'address_street',
                    'width' => '10', 
                    'label' => 'LBL_PRIMARY_ADDRESS_STREET',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'address_city',
                    'width' => '10', 
                    'label' => 'LBL_PRIMARY_ADDRESS_CITY',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'address_state',
                    'width' => '10', 
                    'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'address_postalcode',
                    'width' => '10', 
                    'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'date_entered',
                    'width' => '10', 
                    'label' => 'LBL_DATE_ENTERED',
                    'default' => false,
                    'enabled' => true,
                    'readonly' => true,
                ),
                
                array(
                    'name' => 'created_by_name',
                    'width' => '10', 
                    'label' => 'LBL_CREATED',
                    'default' => false,
                    'enabled' => true,
                    'readonly' => true,
                ),
                array(
                    'name' => 'team_name',
                    'label' => 'LBL_TEAM',
                    'width' => 10,
                    'default' => false,
                    'enabled' => true,
                ),
            ),
        ),
    ),
);