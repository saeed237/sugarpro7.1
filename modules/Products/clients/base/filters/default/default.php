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


$viewdefs['Products']['base']['filter']['default'] = array(
    'default_filter' => 'all_records',
    'fields' => array(
        'name' => array(),
        'contact_name' => array(
            'dbFields' => array(
                'contact_link.first_name',
                'contact_link.last_name',
            ),
            'type' => 'text',
            'vname' => 'LBL_CONTACT_NAME',
        ),
        'status' => array(),
        'type_name' => array(),
        'category_name' => array(),
        'manufacturer_name' => array(),
        'mft_part_num' => array(),
        'vendor_part_num' => array(),
        'tax_class'=> array(),
        'support_term'=> array(),
        'date_entered' => array(),
        'date_modified' => array(),
        '$favorite' => array(
            'predefined_filter' => true,
            'vname' => 'LBL_FAVORITES_FILTER',
        ),
    ),
);
