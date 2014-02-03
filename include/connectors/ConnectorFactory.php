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

/**
 * Connector factory
 * @api
 */
class ConnectorFactory{

	static $source_map = array();

	public static function getInstance($source_name){
		if(empty(self::$source_map[$source_name])) {
			require_once('include/connectors/sources/SourceFactory.php');
			require_once('include/connectors/component.php');
			$source = SourceFactory::getSource($source_name);
			if(empty($source)) {
			    $GLOBALS['log']->fatal("Failed to load source $source_name");
			    return false;
			}
			$component = new component();
			$component->setSource($source);
			$component->init();
			self::$source_map[$source_name] = $component;
		}
		return self::$source_map[$source_name];
	}

	/**
	 * Split the class name by _ and go through the class name
	 * which represents the inheritance structure to load up all required parents.
	 * @param string $class the root class we want to load.
	 */
	public static function load($class, $type)
	{
		return self::loadClass($class, $type);
	}

	/**
	 * include a source class file.
	 * @param string $class a class file to include.
	 */
	public static function loadClass($class, $type)
	{
		$dir = str_replace('_','/',$class);
		$parts = explode("/", $dir);
		$file = "{$type}/{$dir}/".$parts[count($parts)-1] . '.php';
		if(!SugarAutoLoader::requireWithCustom("modules/Connectors/connectors/$file")) {
		    return SugarAutoLoader::requireWithCustom("connectors/$file");
		}
		return true;
	}
}
