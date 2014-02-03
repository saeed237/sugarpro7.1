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
'fields'=> array(
	'assigned_user_id' =>
		array (
			'name' => 'assigned_user_id',
			'rname' => 'user_name',
			'id_name' => 'assigned_user_id',
			'vname' => 'LBL_ASSIGNED_TO_ID',
			'group'=>'assigned_user_name',
			'type' => 'relate',
			'table' => 'users',
			'module' => 'Users',
			'reportable'=>true,
			'isnull' => 'false',
			'dbType' => 'id',
			'audited'=>true,
            'duplicate_on_record_copy' => 'always',
			'comment' => 'User ID assigned to record',
            'duplicate_merge'=>'disabled'
		),
	 'assigned_user_name' =>
	 array (
		    'name' => 'assigned_user_name',
		    'link'=>'assigned_user_link' ,
		    'vname' => 'LBL_ASSIGNED_TO_NAME',
		    'rname' => 'full_name',
		    'type' => 'relate',
		    'reportable'=>false,
		    'source'=>'non-db',
		    'table' => 'users',
		    'id_name' => 'assigned_user_id',
		    'module'=>'Users',
		    'duplicate_merge'=>'disabled',
            'duplicate_on_record_copy' => 'always',
     ),
		      'assigned_user_link' =>
  array (
        'name' => 'assigned_user_link',
    'type' => 'link',
    'relationship' => strtolower($module).'_assigned_user',
    'vname' => 'LBL_ASSIGNED_TO_USER',
    'link_type' => 'one',
    'module'=>'Users',
    'bean_name'=>'User',
    'source'=>'non-db',
    'duplicate_merge'=>'enabled',
    'rname' => 'user_name',
    'id_name' => 'assigned_user_id',
    'table' => 'users',
  ),
),
'relationships'=>array(
	  strtolower($module).'_assigned_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> $module , 'rhs_table'=> strtolower($table_name), 'rhs_key' => 'assigned_user_id',
   'relationship_type'=>'one-to-many')
));
?>
