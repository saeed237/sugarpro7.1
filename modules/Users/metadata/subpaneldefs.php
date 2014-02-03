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




$layout_defs['Users'] = array(
	// default subpanel provided by this SugarBean
	'subpanel_setup' => array(
	    'holidays' => array(
			'order' => 30,
			'sort_by' => 'holiday_date',
			'sort_order' => 'asc',
			'module' => 'Holidays',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'holidays',
			'refresh_page'=>1,
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopButtonQuickCreate', 'view' => 'UsersQuickCreate',),
			),
			'title_key' => 'LBL_USER_HOLIDAY_SUBPANEL_TITLE',
		),
	),
	'default_subpanel_define' => array(
		'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
		'sort_by' => 'name',
		'sort_order' => 'asc',
		'top_buttons' => array(
			array('widget_class' => 'SubPanelTopCreateButton'),
			array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Users', 'mode' => 'MultiSelect'),
		),
		'list_fields' => array(
			'Users' => array(
				'columns' => array(
					array(
						'name' => 'first_name',
			 		 	'usage' => 'query_only',
					),
					array(
						'name' => 'last_name',
			 		 	'usage' => 'query_only',
					),
					array(
						'name' => 'name',
						'vname' => 'LBL_LIST_NAME',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'module' => 'Users',
		 		 		'width' => '25%',
					),
					array(
						'name' => 'user_name',
						'vname' => 'LBL_LIST_USER_NAME',
						'width' => '25%',
					),
					array(
						'name'=>'email1',
						'vname' => 'LBL_LIST_EMAIL',
						'width' => '25%',
					),
					array (
						'name' => 'phone_work',
						'vname' => 'LBL_LIST_PHONE',
						'width' => '21%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelRemoveButton',
			 		 	'module' => 'Users',
						'width' => '4%',
						'linked_field' => 'users',
					),
				),
			),
		),
	),
);
$layout_defs['UserRoles'] = array(
	// sets up which panels to show, in which order, and with what linked_fields
	'subpanel_setup' => array(
        'aclroles' => array(
			'top_buttons' => array(array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'ACLRoles', 'mode' => 'MultiSelect'),),
			'order' => 20,
			'sort_by' => 'name',
			'sort_order' => 'asc',
			'module' => 'ACLRoles',
			'refresh_page'=>1,
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'aclroles',
			'add_subpanel_data' => 'role_id',
			'title_key' => 'LBL_ROLES_SUBPANEL_TITLE',
		),
	),
	);
global $current_user;
if($current_user->isAdminForModule('Users')){
	$layout_defs['UserRoles']['subpanel_setup']['aclroles']['subpanel_name'] = 'admin';
}else{
	$layout_defs['UserRoles']['subpanel_setup']['aclroles']['top_buttons'] = array();
}

$layout_defs['UserEAPM'] = array(
	'subpanel_setup' => array(
        'eapm' => array(
			'order' => 30,
			'module' => 'EAPM',
			'sort_order' => 'asc',
			'sort_by' => 'name',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'eapm',
			'add_subpanel_data' => 'assigned_user_id',
			'title_key' => 'LBL_EAPM_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
			),
		),

    ),
);
$layout_defs['UsersHolidays']['subpanel_setup']['holidays'] = $layout_defs['Users']['subpanel_setup']['holidays'];

//remove the administrator create button holiday for the user admin only
if ( !empty($_REQUEST['record']) ) {
    $result = $GLOBALS['db']->query("SELECT is_admin FROM users WHERE id='{$_REQUEST['record']}'");
$row = $GLOBALS['db']->fetchByAssoc($result);
if(!is_admin($current_user)&& $current_user->isAdminForModule('Users')&& $row['is_admin']==1){
	$layout_defs['Users']['subpanel_setup']['holidays']['top_buttons']= array();
}
}
