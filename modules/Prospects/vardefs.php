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

$dictionary['Prospect'] = array(

	'table' => 'prospects',
	'unified_search' => true,
	'fields' => array (
	 'tracker_key' => array (
		'name' => 'tracker_key',
		'vname' => 'LBL_TRACKER_KEY',
		'type' => 'int',
		'len' => '11',
		'required'=>true,
		'auto_increment' => true,
        'readonly' => true,
		'importable' => 'false',
		'studio' => array('editview' => false),
		),
	  'birthdate' =>
	  array (
	    'name' => 'birthdate',
	    'vname' => 'LBL_BIRTHDATE',
	    'massupdate' => false,
	    'type' => 'date',
	  ),
	  'do_not_call' =>
	  array (
	    'name' => 'do_not_call',
	    'vname' => 'LBL_DO_NOT_CALL',
	    'type'=>'bool',
	    'default' =>'0',
	  ),
	  'lead_id' =>
	  array (
		'name' => 'lead_id',
		'type' => 'id',
		'reportable'=>false,
		'vname'=>'LBL_LEAD_ID',
	  ),
	  'account_name' =>
	  array (
    	'name' => 'account_name',
    	'vname' => 'LBL_ACCOUNT_NAME',
    	'type' => 'varchar',
    	'len' => '150',
  	),
     'campaign_id' =>
      array (
            'name' => 'campaign_id',
        'comment' => 'Campaign that generated lead',
        'vname'=>'LBL_CAMPAIGN_ID',
        'rname' => 'id',
        'id_name' => 'campaign_id',
        'type' => 'id',
        'table' => 'campaigns',
        'isnull' => 'true',
        'module' => 'Campaigns',
        //'dbType' => 'char',
        'reportable'=>false,
        'massupdate' => false,
            'duplicate_merge'=> 'disabled',
      ),
	'email_addresses' =>
	array (
		'name' => 'email_addresses',
        'type' => 'link',
		'relationship' => 'prospects_email_addresses',
        'source' => 'non-db',
		'vname' => 'LBL_EMAIL_ADDRESSES',
		'reportable'=>false,
        'rel_fields' => array('primary_address' => array('type'=>'bool')),
	),
	'email_addresses_primary' =>
	array (
		'name' => 'email_addresses_primary',
        'type' => 'link',
		'relationship' => 'prospects_email_addresses_primary',
        'source' => 'non-db',
		'vname' => 'LBL_EMAIL_ADDRESS_PRIMARY',
		'duplicate_merge'=> 'disabled',
	),
	  'campaigns' =>
	  array (
  		'name' => 'campaigns',
    	'type' => 'link',
    	'relationship' => 'prospect_campaign_log',
    	'module'=>'CampaignLog',
    	'bean_name'=>'CampaignLog',
    	'source'=>'non-db',
		'vname'=>'LBL_CAMPAIGNLOG',
	  ),
      'prospect_lists' =>
      array (
        'name' => 'prospect_lists',
        'type' => 'link',
        'relationship' => 'prospect_list_prospects',
        'module'=>'ProspectLists',
        'source'=>'non-db',
        'vname'=>'LBL_PROSPECT_LIST',
      ),
      'calls' =>
      array(
          'name'         => 'calls',
          'type'         => 'link',
          'relationship' => 'prospect_calls',
          'source'       => 'non-db',
          'vname'        => 'LBL_CALLS',
          'module'       => 'Calls',
      ),
      'meetings' =>
      array(
          'name'         => 'meetings',
          'type'         => 'link',
          'relationship' => 'prospect_meetings',
          'source'       => 'non-db',
          'vname'        => 'LBL_MEETINGS',
          'module'       => 'Meetings',
      ),
      'notes'=>
		array (
			'name' => 'notes',
			'type' => 'link',
			'relationship' => 'prospect_notes',
			'source' => 'non-db',
			'vname' => 'LBL_NOTES',
		),
      'tasks'=>
		array (
			'name' => 'tasks',
			'type' => 'link',
			'relationship' => 'prospect_tasks',
			'source' => 'non-db',
			'vname' => 'LBL_TASKS',
		),
      'emails'=>
		array (
			'name' => 'emails',
			'type' => 'link',
			'relationship' => 'emails_prospects_rel',
			'source' => 'non-db',
			'vname' => 'LBL_EMAILS',
		),
    'archived_emails' => array(
        'name' => 'archived_emails',
        'type' => 'link',
        'link_file' => 'modules/Emails/ArchivedEmailsLink.php',
        'link_class' => 'ArchivedEmailsLink',
        'source' => 'non-db',
        'vname' => 'LBL_EMAILS',
        'module' => 'Emails',
        'link_type' => 'many',
        'relationship' => '',
        'hideacl' => true,
    ),
  
	),

	'indices' =>
			array (
				array(
						'name' => 'prospect_auto_tracker_key' ,
						'type'=>'index' ,
						'fields'=>array('tracker_key')
				),
       			array(	'name' 	=>	'idx_prospects_last_first',
						'type' 	=>	'index',
						'fields'=>	array(
										'last_name',
										'first_name',
										'deleted'
									)
				),
       			array(
						'name' =>	'idx_prospecs_del_last',
						'type' =>	'index',
						'fields'=>	array(
										'last_name',
										'deleted'
										)
				),
               array('name' =>'idx_prospects_id_del', 'type'=>'index', 'fields'=>array('id','deleted')),
               array('name' =>'idx_prospects_assigned', 'type'=>'index', 'fields'=>array('assigned_user_id')),

    		),

	'relationships' => array (
    'prospect_tasks' => array('lhs_module'=> 'Prospects', 'lhs_table'=> 'prospects', 'lhs_key' => 'id',
                              'rhs_module'=> 'Tasks', 'rhs_table'=> 'tasks', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'Prospects'),
    'prospect_notes' => array('lhs_module'=> 'Prospects', 'lhs_table'=> 'prospects', 'lhs_key' => 'id',
                              'rhs_module'=> 'Notes', 'rhs_table'=> 'notes', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'Prospects'),
    'prospect_meetings' => array(
        'lhs_module'                     => 'Prospects',
        'lhs_table'                      => 'prospects',
        'lhs_key'                        => 'id',
        'rhs_module'                     => 'Meetings',
        'rhs_table'                      => 'meetings',
        'rhs_key'                        => 'parent_id',
        'relationship_type'              => 'one-to-many',
        'relationship_role_column'       => 'parent_type',
        'relationship_role_column_value' => 'Prospects'
    ),
    'prospect_calls'    => array(
        'lhs_module'                     => 'Prospects',
        'lhs_table'                      => 'prospects',
        'lhs_key'                        => 'id',
        'rhs_module'                     => 'Calls',
        'rhs_table'                      => 'calls',
        'rhs_key'                        => 'parent_id',
        'relationship_type'              => 'one-to-many',
        'relationship_role_column'       => 'parent_type',
        'relationship_role_column_value' => 'Prospects'
    ),
    'prospect_emails' => array('lhs_module'=> 'Prospects', 'lhs_table'=> 'prospects', 'lhs_key' => 'id',
                              'rhs_module'=> 'Emails', 'rhs_table'=> 'emails', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'Prospects'),
    'prospect_campaign_log' => array(
									'lhs_module'		=>	'Prospects',
									'lhs_table'			=>	'prospects',
									'lhs_key' 			=> 	'id',
						  			'rhs_module'		=>	'CampaignLog',
									'rhs_table'			=>	'campaign_log',
									'rhs_key' 			=> 	'target_id',
						  			'relationship_type'	=>'one-to-many'
						  		),

	),

    'duplicate_check' => array(
        'enabled' => true,
        'FilterDuplicateCheck' => array(
            'filter_template' => array(
                array('$or' => array(
                    array('$and' => array(
                        array('first_name' => array('$starts' => '$first_name')),
                        array('last_name' => array('$starts' => '$last_name')),
                        array('account_name' => array('$starts' => '$account_name')),
                    )),
                    array('phone_work' => array('$equals' => '$phone_work'))
                ))
            ),
            'ranking_fields' => array(
                array('in_field_name' => 'phone_work', 'dupe_field_name' => 'phone_work'),
                array('in_field_name' => 'account_name', 'dupe_field_name' => 'account_name'),
                array('in_field_name' => 'last_name', 'dupe_field_name' => 'last_name'),
                array('in_field_name' => 'first_name', 'dupe_field_name' => 'first_name'),
            )
        )
    )
);
VardefManager::createVardef('Prospects','Prospect', array('default', 'assignable',
'team_security',
'person'));

