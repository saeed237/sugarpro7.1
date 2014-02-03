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

$dictionary['team_sets_teams'] = array ( 'table' => 'team_sets_teams'
                                  , 'fields' => array (
    	'id' => array(
			'name'		=> 'id',
			'vname'		=> 'LBL_ID',
			'type'		=> 'id',
			'required'	=> true,
		),
       array('name' =>'team_set_id', 'type' =>'id')
      , array('name' =>'team_id', 'type' =>'id')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'', 'default'=>'0')
                                                      ) 
                                 , 'indices' => array (
       array('name' =>'idx_ud_id', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_ud_set_id', 'type' =>'index', 'fields'=>array('team_set_id', 'team_id')),
       array('name' =>'idx_ud_team_id', 'type' =>'index', 'fields'=>array('team_id')),
       array('name' =>'idx_ud_team_set_id', 'type' =>'index', 'fields'=>array('team_set_id')),                                   
                                                      ),
       'relationships' => array ('team_sets_teams' => array('lhs_module'=> 'TeamSets', 'lhs_table'=> 'team_sets', 'lhs_key' => 'id',
							  'rhs_module'=> 'Teams', 'rhs_table'=> 'teams', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'team_sets_teams', 'join_key_lhs'=>'team_set_id', 'join_key_rhs'=>'team_id'))
                                  )
?>
