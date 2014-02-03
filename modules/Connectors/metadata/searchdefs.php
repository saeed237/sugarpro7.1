<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA") which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$searchdefs = array(
    'ext_rest_zoominfocompany' => array(
        'Leads' => array(
            'companyname',
            'state',
            'countrycode'
        ),
        'Accounts' => array(
            'companyname',
            'state',
            'countrycode'
        ),
        'Contacts' => array(
            'companyname',
            'state',
            'countrycode'
        )
    ),

    'ext_rest_zoominfoperson' => array(
        'Leads' => array(
            'firstname',
            'lastname',
            'email',
            'companyname'
        ),
        'Accounts' => array(
            'email',
            'companyname'
        ),
        'Contacts' => array(
            'firstname',
            'lastname',
            'email',
            'companyname'
        )
    ),
);
