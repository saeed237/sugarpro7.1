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


 


$layout_defs['Tasks'] = array(
	// sets up which panels to show, in which order, and with what linked_fields
	'subpanel_setup' => array(
		'history' => array(
			'order' => 40,
			'title_key' => 'LBL_HISTORY_SUBPANEL_TITLE',
			'type' => 'collection',
			'subpanel_name' => 'history',   //this values is not associated with a physical file.
			'sort_order' => 'desc',
			'sort_by' => 'date_entered',
			'header_definition_from_subpanel'=> 'calls',
			'module'=>'History',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateNoteButton'),
			),	
			'collection_list' => array(		
				'notes' => array(
					'module' => 'Notes',
					'subpanel_name' => 'ForTasks',
					'get_subpanel_data' => 'notes',
				),		
			),
		), /* end history subpanel def */
	),
);
?>
