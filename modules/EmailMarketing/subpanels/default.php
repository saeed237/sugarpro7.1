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


    'list_fields'=> array(
        'name' => array(
	 		'vname' => 'LBL_LIST_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'width' => '40%',
		),
		'date_start'=>array(
			'widget_class' => 'SubPanelConcat',
	 		'vname' => 'LBL_LIST_DATE_START',
		 	'width' => '20%',
		 	'source'=> array('date_start',' ','time_start'),
		),
		'status'=>array(
	 		'vname' => 'LBL_LIST_STATUS',
		 	'width' => '15%',
		),
		'template_name'=>array(
	 		'vname' => 'LBL_LIST_TEMPLATE_NAME',
		 	'width' => '15%',
			'widget_class' => 'SubPanelDetailViewLink',
		  	'target_record_key' => 'template_id',
		 	'target_module' => 'EmailTemplates',
		 
		),
		'edit_button'=>array(
			'widget_class' => 'SubPanelEditButton',
		 	'module' => 'EmailMarketing',
			'width' => '5%',
		),
		'remove_button'=>array(
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'EmailMarketing',
			'width' => '5%',
		),
	 	'time_start'=>array(
	 		'usage'=>'query_only'
 		),
	),
);

?>