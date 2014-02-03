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

$viewdefs['Styleguide']['base']['view']['field'] = array(
    'template_values' => array(

        // email widget mock data
        'email' => array(
            array(
                'email_address' => 'kid.phone.sugar@example.info',
                'primary_address' => '0',
                'opt_out' => '0',
                'invalid_email' => '0',
            ),
            array(
                'email_address' => 'kid.phone.sugar@example.info',
                'primary_address' => '1',
                'opt_out' => '0',
                'invalid_email' => '0',
            ),
            array(
                'email_address' => 'kid.phone.sugar@example.info',
                'primary_address' => '0',
                'opt_out' => '1',
                'invalid_email' => '0',
            ),
            array(
                'email_address' => 'kid.phone.sugar@example.info',
                'primary_address' => '0',
                'opt_out' => '0',
                'invalid_email' => '1',
            ),
        ),

        // datetimecombo field mock data
        'datetimecombo' => '2013-05-06T22:47:00+00:00',

        // date field mock data
        'date' => '2013-05-06T22:47:00+00:00',

        // currency field mock data
        'currency' => array(
            'list_price' => 12345.7,
            'currency_id' => -99,
            'list_price_ERROR' => 'xyc',
        ),

        // date field mock data
        'bool' => array(
            'do_not_call' => 1,
            'do_not_call_ERROR' => 0,
        ),

        // date field mock data
        'text' => array(
            'description' => 'This is a description of the styleguide module.',
            'description_ERROR' => 'This description is too long.',
        ),
    ),
);
