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


$vardefs = array(
  'visibility' => array('TeamSecurity' => true),
  'fields' => array(
	'team_id' =>
		array (
			'name' => 'team_id',
			'vname' => 'LBL_TEAM_ID',
			'group'=>'team_name',
			'reportable'=>false,
			'dbType' => 'id',
			'type' => 'team_list',
			'audited'=>true,
			/*
			'source' => 'non-db',
			*/
            'duplicate_on_record_copy' => 'always',
            'comment' => 'Team ID for the account'
		),
		'team_set_id' =>
		array (
			'name' => 'team_set_id',
			'rname' => 'id',
			'id_name' => 'team_set_id',
			'vname' => 'LBL_TEAM_SET_ID',
			'type' => 'id',
		    'audited' => true,
		    'studio' => 'false',
			'dbType' => 'id',
            'duplicate_on_record_copy' => 'always',

        ),
		'team_count' =>
		array (
			'name' => 'team_count',
			'rname' => 'team_count',
			'id_name' => 'team_id',
			'vname' => 'LBL_TEAMS',
			'join_name'=>'ts1',
			'table' => 'team_sets',
			'type' => 'relate',
            'required' => 'true',
			'table' => 'teams',
			'isnull' => 'true',
			'module' => 'Teams',
			'link' => 'team_count_link',
			'massupdate' => false,
			'dbType' => 'int',
			'source' => 'non-db',
			'importable' => 'false',
			'reportable'=>false,
		    'duplicate_merge' => 'disabled',
            'duplicate_on_record_copy' => 'always',
            'studio' => 'false',
		    'hideacl' => true,
		),
		'team_name' =>
		array (
			'name' => 'team_name',
			'db_concat_fields'=> array(0=>'name', 1=>'name_2'),
		    'sort_on' => 'tj.name',
		    'join_name' => 'tj',
			'rname' => 'name',
			'id_name' => 'team_id',
			'vname' => 'LBL_TEAMS',
			'type' => 'relate',
            'required' => 'true',
			'table' => 'teams',
			'isnull' => 'true',
			'module' => 'Teams',
			'link' => 'team_link',
			'massupdate' => false,
			'dbType' => 'varchar',
			'source' => 'non-db',
			'len' => 36,
			'custom_type' => 'teamset',
            'studio' => array(
                   // Bug 56832 - Exclude list/detail/edit view from portal
                   'portallistview' => false,
                   'portalrecordview' => false,
               ), // don't show in studio fields list
            'duplicate_on_record_copy' => 'always',
        ),
		'team_link' =>
	    array (
	      'name' => 'team_link',
	      'type' => 'link',
	      'relationship' => strtolower($module). '_team',
	      'vname' => 'LBL_TEAMS_LINK',
	      'link_type' => 'one',
	      'module' => 'Teams',
	      'bean_name' => 'Team',
	      'source' => 'non-db',
	      'duplicate_merge' => 'disabled',
	      'studio' => 'false',
        ),
	    'team_count_link' =>
  			array (
  			'name' => 'team_count_link',
    		'type' => 'link',
    		'relationship' => strtolower($module).'_team_count_relationship',
            'link_type' => 'one',
		    'module' => 'Teams',
		    'bean_name' => 'TeamSet',
		    'source' => 'non-db',
		    'duplicate_merge' => 'disabled',
  			'reportable'=>false,
  			'studio' => 'false',
            ),
  		'teams' =>
		array (
		'name' => 'teams',
        'type' => 'link',
		'relationship' => strtolower($module).'_teams',
		'bean_filter_field' => 'team_set_id',
		'rhs_key_override' => true,
        'source' => 'non-db',
		'vname' => 'LBL_TEAMS',
		'link_class' => 'TeamSetLink',
		'link_file' => 'modules/Teams/TeamSetLink.php',
		'studio' => 'false',
		'reportable'=>false,
        ),
),

'relationships'=>array(
	strtolower($module).'_team_count_relationship' =>
		 array(
		 	'lhs_module'=> 'Teams',
		 	'lhs_table'=> 'team_sets',
		 	'lhs_key' => 'id',
    		'rhs_module'=> $module,
    		'rhs_table'=> $table_name,
    		'rhs_key' => 'team_set_id',
   			'relationship_type'=>'one-to-many'
		 ),
	strtolower($module).'_teams' =>
		array (
			'lhs_module'        => $module,
            'lhs_table'         => $table_name,
            'lhs_key'           => 'team_set_id',
            'rhs_module'        => 'Teams',
            'rhs_table'         => 'teams',
            'rhs_key'           => 'id',
            'relationship_type' => 'many-to-many',
            'join_table'        => 'team_sets_teams',
            'join_key_lhs'      => 'team_set_id',
            'join_key_rhs'      => 'team_id',
		),
   strtolower($module). '_team' =>
   array('lhs_module'=> 'Teams', 'lhs_table'=> 'teams', 'lhs_key' => 'id',
    'rhs_module'=> $module, 'rhs_table'=> $table_name, 'rhs_key' => 'team_id',
   'relationship_type'=>'one-to-many'),
),
'indices' => array(
		'team_set_'.strtolower($table_name) => array(
			'name' => 'idx_'.strtolower($table_name).'_tmst_id',
			'type' => 'index',
			'fields' => array('team_set_id')
		),
	)
);
?>
