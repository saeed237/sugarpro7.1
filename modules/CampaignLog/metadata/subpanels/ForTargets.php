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
	),

	'where' => '',


	'list_fields' => array(
		'campaign_name1'=>array(
			'vname' => 'LBL_LIST_CAMPAIGN_NAME',
			'width' => '20%',
			'widget_class' => 'SubPanelDetailViewLink',
			'target_record_key' => 'campaign_id',
			'target_module' => 'Campaigns',			
		),
		'activity_type' => array(
			'vname' => 'LBL_ACTIVITY_TYPE',
			'width' => '10%',
		),
		'activity_date' => array(
			'vname' => 'LBL_ACTIVITY_DATE',
			'width' => '10%',
		),
		'related_name' => array(
			'widget_class' => 'SubPanelDetailViewLink',
			'target_record_key' => 'related_id',
			'target_module_key' => 'related_type',	
            'parent_id' =>'target_id',
            'parent_module'=>'target_type',         
			'vname' => 'LBL_RELATED',
			'width' => '60%',
			'sortable'=>false,			
		),
		'related_id'=>array(
			'usage' =>'query_only',
		),
		'related_type'=>array(
			'usage' =>'query_only',
		),
		'target_id'=>array(
			'usage' =>'query_only',
		),
		'target_type'=>array(
			'usage' =>'query_only',
		),		
	),
);			
?>