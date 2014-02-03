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

$viewdefs['Contacts']['DetailView'] = array(
'templateMeta' => array('form' => array('buttons'=>array('EDIT', 'DUPLICATE', 'DELETE', 'FIND_DUPLICATES',
                                                         array('customCode'=>'<input type="submit" class="button" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>',
                                                             //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                                             'sugar_html' => array(
                                                                 'type' => 'submit',
                                                                 'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                                                                 'htmlOptions' => array(
                                                                     'class' => 'button',
                                                                     'id' => 'manage_subscriptions_button',
                                                                     'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                                                                     'onclick' => 'this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';',
                                                                     'name' => 'Manage Subscriptions',
                                                                 ),
                                                             ),

                                                         ),
                                                        ),
                                       ),
                        'maxColumns' => '2',
                        'useTabs' => true,
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'),
                                        array('label' => '10', 'field' => '30')
                                        ),

						'includes'=> array(
                            			array('file'=>'modules/Leads/Lead.js'),
                         				),
                        ),



    'panels' =>
    array (
      'lbl_contact_information' =>
      array (

        array (

          array (
            'name' => 'full_name',
            'label' => 'LBL_NAME',
            'displayParams' => 
              array (
                'enableConnectors' => true,
                'module' => 'Contacts',
                'connectors' => 
                array (
                  0 => 'ext_rest_twitter',
                ),
            ),
          ),

	      array (
	      	'name' => 'picture',
	        'label' => 'LBL_PICTURE_FILE',
	      ),
        ),

        array (

          array (
            'name' => 'title',
            'comment' => 'The title of the contact',
            'label' => 'LBL_TITLE',
          ),
          array (
            'name' => 'phone_work',
            'label' => 'LBL_OFFICE_PHONE',
          ),
        ),

        array (
          array (
                'name' => 'department',
                'label' => 'LBL_DEPARTMENT',
          ),
          array (
            'name' => 'phone_mobile',
            'label' => 'LBL_MOBILE_PHONE',
          ),
        ),

        array (
          array (
            'name' => 'account_name',
            'label' => 'LBL_ACCOUNT_NAME',
            'displayParams' =>
              array (
                'enableConnectors' => true,
                'module' => 'Contacts',
                'connectors' => 
                array (
                  //0 => 'ext_rest_linkedin',
                ),
            ),
          ),
          array (
            'name' => 'phone_fax',
            'label' => 'LBL_FAX_PHONE',
          ),
        ),

        array (

          array (
            'name' => 'primary_address_street',
            'label' => 'LBL_PRIMARY_ADDRESS',
            'type' => 'address',
            'displayParams' =>
            array (
              'key' => 'primary',
            ),
          ),

          array (
            'name' => 'alt_address_street',
            'label' => 'LBL_ALTERNATE_ADDRESS',
            'type' => 'address',
            'displayParams' =>
            array (
              'key' => 'alt',
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
            'comment' => 'Full text of the note',
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

		    array (
		      'name' => 'campaign_name',
		      'label' => 'LBL_CAMPAIGN',
		    ),

	  	),


      ),
      'LBL_PANEL_ASSIGNMENT' =>
      array (

        array (

          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),

          array (
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),

        array (
          'team_name',

          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),

        ),
      ),
     )
);
?>