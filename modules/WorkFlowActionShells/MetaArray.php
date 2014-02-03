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



$process_dictionary['ActionsCreateStep1'] = Array('action' => 'CreateStep1',
'elements' => array(

'update' => 
	Array(
		'trigger_type' => 'all',
		'top' => Array(
			'type' => 'radio',
			'name' => 'action_type',
			'value' => 'update',	
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_UPDATE_TITLE'),
			//end top options
			),
		//end top
		),
		'bottom' => Array(
			'type' => 'text',
			'value' => 'update',
			'related' => '0',
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_UPDATE_TITLE', 'text_type' => 'static'),
			//end bottom options
			),
		//end bottom
		),
//end update array
),	
'update_rel' => 
	Array(
		'trigger_type' => 'all',
		'top' => Array(
			'type' => 'radio',
			'name' => 'action_type',
			'value' => 'update_rel',	
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_UPDATE_REL_TITLE'),
			//end top options
			),
		//end top
		),
		'bottom' => Array(
			'type' => 'text',
			'value' => 'update_rel',
			'related' => Array('count' => '1', 'rel1_field' => 'rel_module'),
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_UPDATE_REL', 'text_type' => 'static'),
				'2' => Array(
						'vname' => 'LBL_RECORD', 
						'default' => 'on',
						'text_type' => 'dynamic',
						'type'=> 'href',
						'value' => 'rel_module',
						'value_type' => 'relrel_module',
						'jscript_function' => 'get_single_selector',
						'jscript_content' => array('self', 'rel_module', 'field' ,'rel_filter')
						),	
			//end bottom options
			),
		//end bottom
		),
//end update_rel array	
),
'new' => 
	Array(
		'trigger_type' => 'all',
		'top' => Array(
			'type' => 'radio',
			'name' => 'action_type',
			'value' => 'new',	
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_NEW_TITLE'),
			//end top options
			),
		//end top
		),
		'bottom' => Array(
			'type' => 'text',
			'value' => 'new',
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_NEW', 'text_type' => 'static'),
				'2' => Array(
						'vname' => 'LBL_RECORD', 
						'default' => 'on',
						'text_type' => 'dynamic',
						'type'=> 'href',
						'value' => 'action_module',
						'value_type' => 'module',
						'jscript_function' => 'get_single_selector',
						'jscript_content' => array('self', 'action_module', 'module_list' ,'singular')
						),	
			//end bottom options
			),
		//end bottom
		),
//end new array	
),
'new_rel' => 
	Array(
		'trigger_type' => 'all',
		'top' => Array(
			'type' => 'radio',
			'name' => 'action_type',
			'value' => 'new_rel',	
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_NEW_REL_TITLE'),
			//end top options
			),
		//end top
		),
		'bottom' => Array(
			'type' => 'text',
			'value' => 'new_rel',
			'related' => Array('count' => '1', 'rel1_field' => 'rel_module'),
			'options' => Array(
				'1' => Array('vname' => 'LBL_ACTION_NEW_REL', 'text_type' => 'static'),
				'2' => Array(
						'vname' => 'LBL_RELATED_RECORD', 
						'default' => 'on',
						'text_type' => 'dynamic',
						'type'=> 'href',
						'value' => 'rel_module',
						'value2' => 'action_module',
						'value_type' => 'relrel_module',
						'jscript_function' => 'get_rel_selector',
						'jscript_content' => array('self')
						),							
			//end bottom options
			),
		//end bottom
		),
//end new_rel array	
),
),

'hide_others' => array(
					'target_field' => 'action_type',
					'target_element' => array(''),	
					
				),
//End process dictionary ActionsCreateStep1
);

?>