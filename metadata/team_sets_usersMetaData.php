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

$dictionary['team_sets_users'] = array('table' => 'team_sets_users'
                               ,'fields' => array (
	  'team_set_id' => 
	  array (
	    'name' => 'team_set_id',
	    'type' => 'id',
	    'required' => true,
	  ),
	   'user_id' => 
	  array (
	    'name' => 'user_id',
	    'type' => 'id',
	    'required' => true,
	  ),       
	), 'indices' => array (
		array(
            'name' => 'idx_tmst_user',
            'type' => 'index',
            'fields' => array(
                'team_set_id',
				'user_id'
            )
        ) ,
        array(
            'name' => 'idx_user_tmst',
            'type' => 'index',
            'fields' => array(
                'user_id',
				'team_set_id'
            )
        ),
         array(
            'name' => 'idx_user_id',
            'type' => 'index',
            'fields' => array(
                'user_id',
            )
        )
	)
);
?>
