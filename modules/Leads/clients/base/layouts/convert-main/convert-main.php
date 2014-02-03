<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

/**
 * Convert Lead Metadata Definition
 * This file defines which modules are included in the lead conversion process.
 * Within each module we define the following properties:
 *  * module (string): module name (plural)
 *  * required (boolean): is the user required to create or associate an existing record for this module before converting
 *  * duplicateCheck (boolean): should duplicate check be performed for this module?
 *  * contactRelateField (string): field on the contact that links to this module (if set, relationship will be created to contact)
 *  * dependentModules (array): array of module names that this module is dependent on
 *                              if set, this module will be disabled until dependent modules are completed
 *  * fieldMapping (array): how should lead fields be mapped to this module left side is the module and right side is the lead
 */

$viewdefs['Leads']['base']['layout']['convert-main'] = array(
    'modules' =>
    array(
        array(
            'module' => 'Contacts',
            'required' => true,
            'duplicateCheckOnStart' => true,
            'fieldMapping' =>
            array(
                'salutation' => 'salutation',
                'first_name' => 'first_name',
                'last_name' => 'last_name',
                'title' => 'title',
                'department' => 'department',
                'description' => 'description',
                'team_name' => 'team_name',
                'do_not_call' => 'do_not_call',
                'phone_home' => 'phone_home',
                'phone_mobile' => 'phone_mobile',
                'phone_work' => 'phone_work',
                'phone_fax' => 'phone_fax',
                'primary_address_street' => 'primary_address_street',
                'primary_address_city' => 'primary_address_city',
                'primary_address_state' => 'primary_address_state',
                'primary_address_postalcode' => 'primary_address_postalcode',
                'primary_address_country' => 'primary_address_country',
                'campaign_id' => 'campaign_id',
                'campaign_name' => 'campaign_name',
                'email' => 'email',
            ),
            'hiddenFields' =>
            array(
                'account_name',
            ),
        ),
        array(
            'module' => 'Accounts',
            'required' => true,
            'duplicateCheckOnStart' => true,
            'duplicateCheckRequiredFields' =>
            array(
                'name',
            ),
            'contactRelateField' => 'account_name',
            'fieldMapping' =>
            array(
                'name' => 'account_name',
                'team_name' => 'team_name',
                'billing_address_street' => 'primary_address_street',
                'billing_address_city' => 'primary_address_city',
                'billing_address_state' => 'primary_address_state',
                'billing_address_postalcode' => 'primary_address_postalcode',
                'billing_address_country' => 'primary_address_country',
                'shipping_address_street' => 'primary_address_street',
                'shipping_address_city' => 'primary_address_city',
                'shipping_address_state' => 'primary_address_state',
                'shipping_address_postalcode' => 'primary_address_postalcode',
                'shipping_address_country' => 'primary_address_country',
                'campaign_id' => 'campaign_id',
                'campaign_name' => 'campaign_name',
                'email' => 'email',
                'phone_office' => 'phone_work',
                'phone_fax' => 'phone_fax',
            ),
        ),
        array(
            'module' => 'Opportunities',
            'required' => false,
            'duplicateCheckOnStart' => false,
            'duplicateCheckRequiredFields' =>
            array(
                'account_id',
            ),
            'fieldMapping' =>
            array(
                'name' => 'opportunity_name',
                'phone_work' => 'phone_office',
                'team_name' => 'team_name',
                'campaign_id' => 'campaign_id',
                'campaign_name' => 'campaign_name',
                'lead_source' => 'lead_source',
            ),
            'dependentModules' =>
            array(
                'Accounts' =>
                array(
                    'fieldMapping' =>
                    array(
                        'account_id' => 'id',
                    ),
                ),
            ),
            'hiddenFields' =>
            array(
                'account_name',
            ),
        ),
    ),
);

