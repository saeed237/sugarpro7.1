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
       array('widget_class'=>'SubPanelTopCreateButton'),
			array('widget_class'=>'SubPanelTopSelectButton', 'popup_module' => 'ProspectLists', 'create'=>"true",'mode'=>'MultiSelect'),
		),

	'where' => '',


    'list_fields'=> array(
        'name' => array(
		 	'vname' => 'LBL_LIST_PROSPECT_LIST_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
			'width' => '37%',
		),
		'description' => array(
		 	'vname' => 'LBL_LIST_DESCRIPTION',
			'width' => '35%',
			'sortable'=>false,
		),
		'list_type' => array(
		 	'vname' => 'LBL_LIST_TYPE_NO',
			'width' => '10%',
		),
		'entry_count' => array(
		 	'vname' => 'LBL_LIST_ENTRIES',
			'width' => '8%',
			'sortable'=>false,
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			'widget_class' => 'SubPanelEditButton',
		 	'module' => 'ProspectLists',
			'width' => '5%',
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'ProspectLists',
			'width' => '5%',
		),
	),
);
?>