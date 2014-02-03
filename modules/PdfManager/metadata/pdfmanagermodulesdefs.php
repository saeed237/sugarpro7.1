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



// For $bannedPdfManagerFieldsAndLinks, list of banned Fields and Links by module for PdfManager
/*
        $bannedPdfManagerFieldsAndLinks['moduleName'] = array(
            'fields' => array(
                'fieldName1',
                'fieldName2',
            ),
            'relationships' => array(
                'relationshipName1',
                'relationshipName2',
            ),
        );
*/

$bannedPdfManagerFieldsAndLinks['Accounts'] = array (
    'fields' => array(
        'billing_address_street_2',
        'billing_address_street_3',
        'billing_address_street_4',
        'shipping_address_street_2',
        'shipping_address_street_3',
        'shipping_address_street_4',
    ),
);
$bannedPdfManagerFieldsAndLinks['Contacts'] = array (
    'fields' => array(
        'accept_status_id',
        'accept_status_name',
        'alt_address_street_2',
        'alt_address_street_3',
        'email_and_name1',
        'primary_address_street_2',
        'primary_address_street_3',
    ),
);
$bannedPdfManagerFieldsAndLinks['Employees'] = array (
    'relationships' => array(
        'holidays',
        'oauth_tokens',
    ),
);
$bannedPdfManagerFieldsAndLinks['Leads'] = array (
    'fields' => array(
        'accept_status_id',
        'accept_status_name',
        'alt_address_street_2',
        'alt_address_street_3',
        'primary_address_street_2',
        'primary_address_street_3',
    ),
);
$bannedPdfManagerFieldsAndLinks['Opportunities'] = array (
    'relationships' => array(
        'campaign_link',
        'campaigns',
    ),
);
$bannedPdfManagerFieldsAndLinks['Prospects'] = array (
    'fields' => array(
        'accept_status_id',
        'accept_status_name',
        'alt_address_street_2',
        'alt_address_street_3',
        'primary_address_street_2',
        'primary_address_street_3',
    ),
);
$bannedPdfManagerFieldsAndLinks['Users'] = array (
    'fields' => array(
        'address_city',
        'address_country',
        'address_postalcode',
        'address_state',
        'address_street',
        'date_entered',
        'date_modified',
        'department',
        'description',
        'email1',
        'employee_status',
        'phone_fax',
        'phone_home',
        'messenger_id',
        'messenger_type',
        'phone_mobile',
        'phone_other',
        'status',
        'title',
        'phone_work',
    ),
);

// For $bannedPdfManagerModules, list of banned modules for PdfManager
$bannedPdfManagerModules[] = 'KBDocuments';
$bannedPdfManagerModules[] = 'Users';
$bannedPdfManagerModules[] = 'Employees';