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



$subpanel_layout = array(
	'top_buttons' => array(
			array('widget_class' => 'SubPanelTopCreateButton'),
	),

	'where' => '',

	'list_fields' => array(
        'holiday_date'=>array(
		 	'vname' => 'LBL_HOLIDAY_DATE',
			'widget_class' => 'SubPanelDetailViewLink',
			'width' => '21%',
		),
		'description'=>array(
		 	'vname' => 'LBL_DESCRIPTION',
			'width' => '75%',
			'sortable'=>false,				
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			 'widget_class' => 'SubPanelEditButton',
			 'width' => '2%',
		),


	),
);

if ( isset($_REQUEST['record']) ) {
//remove the administrator edit button holiday for the user admin only
        global $current_user;
        $result = $GLOBALS['db']->query("SELECT is_admin FROM users WHERE id='".$GLOBALS['db']->quote($_REQUEST['record'])."'");
        $row = $GLOBALS['db']->fetchByAssoc($result);
        if(!is_admin($current_user)&& $current_user->isAdminForModule('Users')&& $row['is_admin']==1){
            unset($subpanel_layout['list_fields']['edit_button']);
        }
}
?>