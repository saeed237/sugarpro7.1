<?php
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

$viewdefs['Contacts']['EditView'] = array(
    'templateMeta' => array('form'=>array('hidden'=>array('<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
    											          '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
    											          '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
    											          '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
    											          '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">')),
							'maxColumns' => '2',
							'useTabs' => true,
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30'),
                                        ),
),


    'panels' =>
    array (
      'lbl_contact_information' =>
      array (
        array (
          array (
            'name' => 'first_name',
            'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}' 
	      . '&nbsp;<input name="first_name"  id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
	      ),
          
	      'picture',

        ),
        array (
          array (
            'name' => 'last_name',
          ),
          array (
            'name' => 'phone_work',
            'comment' => 'Work phone number of the contact',
            'label' => 'LBL_OFFICE_PHONE',
          ),
        ),

        array (

          array (
            'name' => 'title',
            'comment' => 'The title of the contact',
            'label' => 'LBL_TITLE',
          ),
          array (
            'name' => 'phone_mobile',
            'comment' => 'Mobile phone number of the contact',
            'label' => 'LBL_MOBILE_PHONE',
          ),

        ),

        array (
          'department',
          array (
            'name' => 'phone_fax',
            'comment' => 'Contact fax number',
            'label' => 'LBL_FAX_PHONE',
          ),
        ),
        array(
          array (
            'name' => 'account_name',
            'displayParams' =>
            array (
              'key' => 'billing',
              'copy' => 'primary',
              'billingKey' => 'primary',
              'additionalFields' =>
              array (
                'phone_office' => 'phone_work',
              ),
            ),
          ),
        ),

        array (

          array (
            'name' => 'primary_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' =>
            array (
              'key' => 'primary',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),

          array (
            'name' => 'alt_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' =>
            array (
              'key' => 'alt',
              'copy' => 'primary',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
        ),

        array (

          array (
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL_ADDRESS',
          ),
        ),

        array (

          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),


      'LBL_PANEL_ADVANCED' =>
      array (

        array (

          array (
            'name' => 'report_to_name',
            'label' => 'LBL_REPORTS_TO',
          ),

          array (
            'name' => 'sync_contact',
            'comment' => 'Synch to outlook?  (Meta-Data only)',
            'label' => 'LBL_SYNC_CONTACT',
          ),
        ),

        array (

          array (
            'name' => 'lead_source',
            'comment' => 'How did the contact come about',
            'label' => 'LBL_LEAD_SOURCE',
          ),

          array (
            'name' => 'do_not_call',
            'comment' => 'An indicator of whether contact can be called',
            'label' => 'LBL_DO_NOT_CALL',
          ),
        ),

        array (
	      'campaign_name',
        ),
      ),



      'LBL_PANEL_ASSIGNMENT' =>
      array (
        array (
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
	      'team_name',
        ),
      ),
    )
);
?>