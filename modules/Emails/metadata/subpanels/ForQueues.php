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




//$layout_defs['ForQueues'] = array(
//	'top_buttons' => array(
//			array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Queues'),
//		),
//);


$subpanel_layout = array(
	'top_buttons' => array(
			array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Queues'),
	),
	'where' => "",

	'fill_in_additional_fields'=>true,
	'list_fields' => array(
/*		'mass_update' => array (
			
		),
*/		'object_image'=>array(
			'widget_class' => 'SubPanelIcon',
 		 	'width' => '2%',
		),
		'name'=>array(
			 'vname' => 'LBL_LIST_SUBJECT',
			 'widget_class' => 'SubPanelDetailViewLink',
			 'width' => '68%',
		),
		'case_name'=>array(
			 'widget_class' => 'SubPanelDetailViewLink',
			 'target_record_key' => 'case_id',
			 'target_module' => 'Cases',
			 'module' => 'Cases',
			 'vname' => 'LBL_LIST_CASE',
			 'width' => '20%',
			 'force_exists'=>true,
			 'sortable'=>false,
		),
		'contact_id'=>array(
			'usage'=>'query_only',
			'force_exists'=>true,
		)	,
/*		'parent_name'=>array(
			 'vname' => 'LBL_LIST_RELATED_TO',		
			 'width' => '22%',
			 'target_record_key' => 'parent_id',
			 'target_module_key'=>'parent_type',
			 'widget_class' => 'SubPanelDetailViewLink',
			  'sortable'=>false,	
		),*/
		'date_modified'=>array(
			'vname' => 'LBL_DATE_MODIFIED',
			 'width' => '10%',
		),
/*		'edit_button'=>array(
			 'widget_class' => 'SubPanelEditButton',
			 'width' => '2%',
		),
		'remove_button'=>array(
			 'widget_class' => 'SubPanelRemoveButton',
			 'width' => '2%',
		),
		'parent_id'=>array(
			'usage'=>'query_only',
		),
		'parent_type'=>array(
			'usage'=>'query_only',
		),
		'filename'=>array(
			'usage'=>'query_only',
			'force_exists'=>true
			),		
*/		
	),
);		

?>