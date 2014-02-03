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

$dictionary['Meeting'] = array('table' => 'meetings','activity_enabled'=>true,
	'unified_search' => true, 'full_text_search' => true, 'unified_search_default_enabled' => true,
	'comment' => 'Meeting activities'
                               ,'fields' => array (
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_SUBJECT',
    'required' => true,
    'type' => 'name',
    'dbType' => 'varchar',
	'unified_search' => true,
	'full_text_search' => array('boost' => 3),
    'len' => '50',
    'comment' => 'Meeting name',
    'importable' => 'required',
  ),
  'accept_status' => array (
    'name' => 'accept_status',
    'vname' => 'LBL_ACCEPT_STATUS',
    'type' => 'varchar',
    'dbType' => 'varchar',
    'len' => '20',
    'source'=>'non-db',
  ),
  //bug 39559 
  'set_accept_links' => array (
    'name' => 'accept_status',
    'vname' => 'LBL_ACCEPT_LINK',
    'type' => 'varchar',
    'dbType' => 'varchar',
    'len' => '20',
    'source'=>'non-db',
  ),
  'location' =>
  array (
    'name' => 'location',
    'vname' => 'LBL_LOCATION',
    'type' => 'varchar',
    'len' => '50',
    'comment' => 'Meeting location'
  ),
  'password' =>
  array (
    'name' => 'password',
    'vname' => 'LBL_PASSWORD',
    'type' => 'varchar',
    'len' => '50',
    'comment' => 'Meeting password',
    'studio' => array('wirelesseditview'=>false, 'wirelessdetailview'=>false, 'wirelesslistview'=>false, 'wireless_basic_search'=>false),
    'dependency' => 'isInEnum($type,getDD("extapi_meeting_password"))',
  ),
  'join_url' =>
  array (
    'name' => 'join_url',
    'vname' => 'LBL_URL',
    'type' => 'varchar',
    'len' => '200',
    'comment' => 'Join URL',
    'studio' => 'false',
    'reportable' => false,
  ),
  'host_url' =>
  array (
    'name' => 'host_url',
    'vname' => 'LBL_HOST_URL',
    'type' => 'varchar',
    'len' => '400',
    'comment' => 'Host URL',
    'studio' => 'false',
    'reportable' => false,
  ),
  'displayed_url' =>
  array (
    'name' => 'displayed_url',
    'vname' => 'LBL_DISPLAYED_URL',
    'type' => 'url',
    'len' => '400',
    'comment' => 'Meeting URL',
    'studio' => array('wirelesseditview'=>false, 'wirelessdetailview'=>false, 'wirelesslistview'=>false, 'wireless_basic_search'=>false),
    'dependency' => 'and(isAlpha($type),not(equal($type,"Sugar")))',
  ),
  'creator' =>
  array (
    'name' => 'creator',
    'vname' => 'LBL_CREATOR',
    'type' => 'varchar',
    'len' => '50',
    'comment' => 'Meeting creator',
    'studio' => 'false',
  ),
  'external_id' =>
  array (
    'name' => 'external_id',
    'vname' => 'LBL_EXTERNALID',
    'type' => 'varchar',
    'len' => '50',
    'comment' => 'Meeting ID for external app API',
    'studio' => 'false',
   ),
  'duration_hours' =>
  array (
    'name' => 'duration_hours',
    'vname' => 'LBL_DURATION_HOURS',
    'type' => 'int',
    'group'=>'duration',
    'len' => '3',
    'comment' => 'Duration (hours)',
    'importable' => 'required',
    'required' => true,
    'studio' => array('wirelesseditview'=>false, 'wirelessdetailview'=>false, 'wirelesslistview'=>false, 'wireless_basic_search'=>false),
  ),
  'duration_minutes' =>
  array (
    'name' => 'duration_minutes',
    'vname' => 'LBL_DURATION_MINUTES',
    'type' => 'enum',
    'options' => 'duration_intervals',    
    'group'=>'duration',
    'len' => '2',
    'comment' => 'Duration (minutes)',
    'studio' => array('wirelesseditview'=>false, 'wirelessdetailview'=>false, 'wirelesslistview'=>false, 'wireless_basic_search'=>false),
    'required' => true,
  ),
  'date_start' =>
  array (
    'name' => 'date_start',
    'vname' => 'LBL_DATE',
    'type' => 'datetimecombo',
    'dbType' => 'datetime',
    'comment' => 'Date of start of meeting',
    'importable' => 'required',
    'required' => true,
    'full_text_search' => array(),
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
    'validation' => array('type' => 'isbefore', 'compareto' => 'date_end', 'blank' => false),
  ),

  'date_end' =>
  array (
    'name' => 'date_end',
    'vname' => 'LBL_DATE_END',
    'type' => 'datetimecombo',
    'dbType' => 'datetime',
    'massupdate'=>false,
    'full_text_search' => array(),
    'comment' => 'Date meeting ends',
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
    'studio' => array('wirelesseditview'=>false), // date_end is computed by the server from date_start and duration
  ),
  'parent_type' =>
  array (
    'name' => 'parent_type',
    'vname'=>'LBL_PARENT_TYPE',
    'type' =>'parent_type',
    'dbType' => 'varchar',
    'group'=>'parent_name',
    'options'=> 'parent_type_display',
    'len' => 100,
    'comment' => 'Module meeting is associated with',
    'studio' => array('searchview'=>false, 'wirelesslistview'=>false),
  ),
  'status' =>
  array (
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'len' => 100,
    'options' => 'meeting_status_dom',
    'comment' => 'Meeting status (ex: Planned, Held, Not held)',
    'default' => 'Planned',
  ),
  'type' =>
   array (
     'name' => 'type',
     'vname' => 'LBL_TYPE',
     'type' => 'enum',
     'len' => 255,
     'function' => 'getMeetingsExternalApiDropDown',
     'comment' => 'Meeting type (ex: WebEx, Other)',
     'options' => 'eapm_list',
     'default'	=> 'Sugar',
     'massupdate' => false,
   	 'studio' => array('wireless_basic_search'=>false),
   ),
  // Bug 24170 - Added only to allow the sidequickcreate form to work correctly
  'direction' =>
  array (
    'name' => 'direction',
    'vname' => 'LBL_DIRECTION',
    'type' => 'enum',
    'len' => 100,
    'options' => 'call_direction_dom',
    'comment' => 'Indicates whether call is inbound or outbound',
    'source' => 'non-db',
    'importable' => 'false',
    'massupdate'=>false,
    'reportable'=>false,
	'studio' => 'false',
  ),
  'parent_id' =>
  array (
    'name' => 'parent_id',
    'vname'=>'LBL_PARENT_ID',
    'type' => 'id',
    'group'=>'parent_name',
    'reportable'=>false,
    'comment' => 'ID of item indicated by parent_type',
    'studio' => array('searchview'=>false),
  ),
  'reminder_checked' => array(
    'name' => 'reminder_checked',
    'vname' => 'LBL_REMINDER',
    'type' => 'bool',
    'source' => 'non-db',
    'comment' => 'checkbox indicating whether or not the reminder value is set (Meta-data only)',
    'massupdate' => false,
    'studio' => array('wirelesseditview'=>false),
   ),
  'reminder_time' =>
  array (
    'name' => 'reminder_time',
    'vname' => 'LBL_REMINDER_TIME',
    'type' => 'enum',
    'dbType' => 'int',
    'options' => 'reminder_time_options',
    'reportable' => false,
    'massupdate' => false,
    'default'=> -1,
    'comment' => 'Specifies when a reminder alert should be issued; -1 means no alert; otherwise the number of seconds prior to the start',
    'studio' => array('wirelesseditview'=>false),
  ),  
  'email_reminder_checked' => array(
    'name' => 'email_reminder_checked',
    'vname' => 'LBL_EMAIL_REMINDER',
    'type' => 'bool',
    'source' => 'non-db',
    'comment' => 'checkbox indicating whether or not the email reminder value is set (Meta-data only)',
    'massupdate' => false,
    'studio' => array('wirelesseditview'=>false),
   ),  
  'email_reminder_time' =>
  array (
    'name' => 'email_reminder_time',
    'vname' => 'LBL_EMAIL_REMINDER_TIME',
    'type' => 'enum',
    'dbType' => 'int',
    'options' => 'reminder_time_options',
    'reportable' => false,
    'massupdate' => false,
    'default'=> -1,
    'comment' => 'Specifies when a email reminder alert should be issued; -1 means no alert; otherwise the number of seconds prior to the start',
    'studio' => array('wirelesseditview'=>false),
  ),  
  'email_reminder_sent' => array( 
    'name' => 'email_reminder_sent',
    'vname' => 'LBL_EMAIL_REMINDER_SENT',
    'default' => 0,
    'type' => 'bool',
    'comment' => 'Whether email reminder is already sent',
    'studio' => false,
    'massupdate'=> false,
   ), 
   'outlook_id' =>
  array (
    'name' => 'outlook_id',
    'vname' => 'LBL_OUTLOOK_ID',
    'type' => 'varchar',
    'len' => '255',
    'reportable' => false,
    'comment' => 'When the Sugar Plug-in for Microsoft Outlook syncs an Outlook appointment, this is the Outlook appointment item ID'
  ),
   'sequence' =>
  array (
    'name' => 'sequence',
    'vname' => 'LBL_SEQUENCE',
    'type' => 'int',
    'len' => '11',
    'reportable' => false,
    'default'=>0,
    'comment' => 'Meeting update sequence for meetings as per iCalendar standards',
      'studio' => array(
          'related' => false,
          'formula' => false,
          'rollup' => false,
      ),
  ),

  'contact_name' =>
  array (
    'name' => 'contact_name',
    'rname' => 'last_name',
    'db_concat_fields'=> array(0=>'first_name', 1=>'last_name'),
    'id_name' => 'contact_id',
    'massupdate' => false,
    'vname' => 'LBL_CONTACT_NAME',
    'type' => 'relate',
    'link'=>'contacts',
    'table' => 'contacts',
    'isnull' => 'true',
    'module' => 'Contacts',
    'join_name' => 'contacts',
    'dbType' => 'varchar',
    'source'=>'non-db',
    'len' => 36,
    'studio' => array('required' => false, 'listview'=>true, 'visible' => false),
	),

  'contacts' =>
  array (
  	'name' => 'contacts',
    'type' => 'link',
    'relationship' => 'meetings_contacts',
    'source'=>'non-db',
		'vname'=>'LBL_CONTACTS',
  ),
   'parent_name'=>
 	array(
		'name'=> 'parent_name',
		'parent_type'=>'record_type_display' ,
		'type_name'=>'parent_type',
		'id_name'=>'parent_id',
		'vname'=>'LBL_LIST_RELATED_TO',
		'type'=>'parent',
		'group'=>'parent_name',
		'source'=>'non-db',
		'options'=> 'parent_type_display',
    'studio' => true,
		),
  'users' =>
  array (
  	'name' => 'users',
    'type' => 'link',
    'relationship' => 'meetings_users',
    'source'=>'non-db',
		'vname'=>'LBL_USERS',
  ),
  'accept_status_users' => array(
      'massupdate' => false,
      'name' => 'accept_status_users',
      'type' => 'enum',
      'studio' => 'false',
      'source' => 'non-db',
      'vname' => 'LBL_ACCEPT_STATUS',
      'options' => 'dom_meeting_accept_status',
      'importable' => 'false',
      'link' => 'users',
      'rname_link' => 'accept_status',
  ),
  'accounts' =>
  array (
  	'name' => 'accounts',
    'type' => 'link',
    'relationship' => 'account_meetings',
    'source'=>'non-db',
		'vname'=>'LBL_ACCOUNT',
  ),
    'bugs' =>
    array (
        'name' => 'bugs',
        'type' => 'link',
        'relationship' => 'bug_meetings',
        'source'=>'non-db',
        'vname'=>'LBL_BUGS',
        'module'=>'Bugs',
    ),
  'leads' =>
  array (
    'name' => 'leads',
    'type' => 'link',
    'relationship' => 'meetings_leads',
    'source'=>'non-db',
        'vname'=>'LBL_LEADS',
  ),
  'opportunity' =>
  array (
  	'name' => 'opportunity',
    'type' => 'link',
    'relationship' => 'opportunity_meetings',
    'source'=>'non-db',
		'vname'=>'LBL_OPPORTUNITY',
  ),
  'prospects' =>
  array(
      'name'         => 'prospects',
      'type'         => 'link',
      'relationship' => 'prospect_meetings',
      'source'       => 'non-db',
      'vname'        => 'LBL_PROSPECTS',
      'module'       => 'Prospects',
  ),
  'quotes' =>
  array(
      'name' => 'quotes',
      'type' => 'link',
      'relationship' => 'quote_meetings',
      'source'=>'non-db',
      'vname'=>'LBL_QUOTES',
  ),    
  'cases' =>
  array (
  	'name' => 'cases',
    'type' => 'link',
    'relationship' => 'case_meetings',
    'source'=>'non-db',
		'vname'=>'LBL_CASE',
  ),
    'notes' =>
  array (
  	'name' => 'notes',
    'type' => 'link',
    'relationship' => 'meetings_notes',
    'module'=>'Notes',
    'bean_name'=>'Note',
    'source'=>'non-db',
		'vname'=>'LBL_NOTES',
  ),
	'contact_id' => array(
		'name' => 'contact_id',
		'type' => 'id',
		'source' => 'non-db',
	),
	'repeat_type' =>
	array(
		'name' => 'repeat_type',
		'vname' => 'LBL_REPEAT_TYPE',
		'type' => 'enum',
		'len' => 36,
		'options' => 'repeat_type_dom',
		'comment' => 'Type of recurrence',
		'importable' => 'false',
		'massupdate' => false,
		'reportable' => false,
		'studio' => 'false',
	),	
	'repeat_interval' =>
	array(
		'name' => 'repeat_interval',
		'vname' => 'LBL_REPEAT_INTERVAL',
		'type' => 'int',
		'len' => 3,
		'default' => 1,
		'comment' => 'Interval of recurrence',
		'importable' => 'false',
		'massupdate' => false,
		'reportable' => false,
		'studio' => 'false',
	),	
	'repeat_dow' =>
	array(
		'name' => 'repeat_dow',
		'vname' => 'LBL_REPEAT_DOW',
		'type' => 'varchar',
		'len' => 7,
		'comment' => 'Days of week in recurrence',
		'importable' => 'false',
		'massupdate' => false,
		'reportable' => false,
		'studio' => 'false',
	),	
	'repeat_until' =>
	array(
		'name' => 'repeat_until',
		'vname' => 'LBL_REPEAT_UNTIL',
		'type' => 'date',
		'comment' => 'Repeat until specified date',
		'importable' => 'false',
		'massupdate' => false,
		'reportable' => false,
		'studio' => 'false',
	),	
	'repeat_count' =>
	array(
		'name' => 'repeat_count',
		'vname' => 'LBL_REPEAT_COUNT',
		'type' => 'int',
		'len' => 7,
		'comment' => 'Number of recurrence',
		'importable' => 'false',
		'massupdate' => false,
		'reportable' => false,
		'studio' => 'false',
	),
	'repeat_parent_id' =>
	array(
		'name' => 'repeat_parent_id',
		'vname' => 'LBL_REPEAT_PARENT_ID',
		'type' => 'id',
		'len' => 36,
		'comment' => 'Id of the first element of recurring records',
		'importable' => 'false',
		'massupdate' => false,
		'reportable' => false,
		'studio' => 'false',
	),
	'recurring_source' =>
	array(
		'name' => 'recurring_source',
		'vname' => 'LBL_RECURRING_SOURCE',
		'type' => 'varchar',
		'len' => 36,
		'comment' => 'Source of recurring meeting',
		'importable' => false,
		'massupdate' => false,
		'reportable' => false,
		'studio' => false,
	),
	'duration' =>
	array(
		'name' => 'duration',
		'vname' => 'LBL_DURATION',
		'type' => 'enum',
		'options' => 'duration_dom',
		'source' => 'non-db',
		'comment' => 'Duration handler dropdown',
		'massupdate' => false,
		'reportable' => false,
		'importable' => false,
	),
  'send_invites' => array(
    'name' => 'send_invites',
    'vname' => 'LBL_SEND_INVITES',
    'type' => 'bool',
    'source' => 'non-db',
    'comment' => 'checkbox indicating whether or not to send out invites (Meta-data only)',
    'massupdate' => false,
   ),
),
 'relationships' => array (
	  'meetings_assigned_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'Meetings', 'rhs_table'=> 'meetings', 'rhs_key' => 'assigned_user_id',
   'relationship_type'=>'one-to-many')

   ,'meetings_modified_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'Meetings', 'rhs_table'=> 'meetings', 'rhs_key' => 'modified_user_id',
   'relationship_type'=>'one-to-many')

   ,'meetings_created_by' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'Meetings', 'rhs_table'=> 'meetings', 'rhs_key' => 'created_by',
   'relationship_type'=>'one-to-many')

	,'meetings_notes' => array('lhs_module'=> 'Meetings', 'lhs_table'=> 'meetings', 'lhs_key' => 'id',
							  'rhs_module'=> 'Notes', 'rhs_table'=> 'notes', 'rhs_key' => 'parent_id',
							  'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
							  'relationship_role_column_value'=>'Meetings')
	),
    'acls' => array('SugarACLOpi' => true, 'SugarACLStatic' => true),


    'indices' => array (
       array('name' =>'idx_mtg_name', 'type'=>'index', 'fields'=>array('name')),
       array('name' =>'idx_meet_par_del', 'type'=>'index', 'fields'=>array('parent_id','parent_type','deleted')),
       array('name' => 'idx_meet_stat_del', 'type' => 'index', 'fields'=> array('assigned_user_id', 'status', 'deleted')),
       array('name' => 'idx_meet_date_start', 'type' => 'index', 'fields'=> array('date_start')),
       // due to pulls from client side to check if there are reminders to handle.
       array('name' => 'idx_meet_date_start_reminder', 'type' => 'index', 'fields'=> array('date_start', 'reminder_time')),

                                                   )
//This enables optimistic locking for Saves From EditView
	,'optimistic_locking'=>true,
                            );

VardefManager::createVardef('Meetings','Meeting', array('default', 'assignable',
'team_security',
));
?>
