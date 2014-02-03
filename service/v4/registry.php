<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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


require_once('service/v3_1/registry.php');

class registry_v4 extends registry_v3_1 {

	/**
	 * This method registers all the functions on the service class
	 *
	 */
	protected function registerFunction()
	{
		$GLOBALS['log']->info('Begin: registry->registerFunction');
		parent::registerFunction();

		$this->serviceClass->registerFunction(
		    'search_by_module',
	        array('session'=>'xsd:string','search_string'=>'xsd:string', 'modules'=>'tns:select_fields', 'offset'=>'xsd:int', 'max_results'=>'xsd:int','assigned_user_id' => 'xsd:string', 'select_fields'=>'tns:select_fields', 'unified_search_only'=>'xsd:boolean', 'favorites'=>'xsd:boolean'),
	        array('return'=>'tns:return_search_result'));

	}

	/**
	 * This method registers all the complex types
	 *
	 */
	protected function registerTypes()
	{
	    parent::registerTypes();

	    $this->serviceClass->registerType(
		   	 'return_search_result',
		   	 'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
			array(
				'entry_list' => array('name' =>'entry_list', 'type'=>'tns:search_link_list'),
			)
		);

		$this->serviceClass->registerType(
		    'search_link_list',
			'complexType',
		   	 'array',
		   	 '',
		  	  'SOAP-ENC:Array',
			array(),
		    array(
		        array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'tns:search_link_name_value[]')
		    ),
			'tns:search_link_name_value'
		);

		$this->serviceClass->registerType(
		    'search_link_name_value',
			'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
				array(
		        	'name'=>array('name'=>'name', 'type'=>'xsd:string'),
					'records'=>array('name'=>'records', 'type'=>'tns:search_link_array_list'),
				)
		);

		$this->serviceClass->registerType(
		    'search_link_array_list',
			'complexType',
		   	 'array',
		   	 '',
		  	  'SOAP-ENC:Array',
			array(),
		    array(
		        array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'tns:link_value[]')
		    ),
			'tns:link_value'
		);

		$this->serviceClass->registerType(
		    'module_list_entry',
			'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
				array(
					'module_key'=>array('name'=>'module_key', 'type'=>'xsd:string'),
					'module_label'=>array('name'=>'module_label', 'type'=>'xsd:string'),
					'favorite_enabled'=>array('name'=>'favorite_enabled', 'type'=>'xsd:boolean'),
					'acls'=>array('name'=>'acls', 'type'=>'tns:acl_list'),
				)
		);

		$this->serviceClass->registerType(
		    'new_module_fields',
			'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
				array(
		        	'module_name'=>array('name'=>'module_name', 'type'=>'xsd:string'),
		        	'table_name'=>array('name'=>'table_name', 'type'=>'xsd:string'),
					'module_fields'=>array('name'=>'module_fields', 'type'=>'tns:field_list'),
					'link_fields'=>array('name'=>'link_fields', 'type'=>'tns:link_field_list'),
				)
		);
	}
}