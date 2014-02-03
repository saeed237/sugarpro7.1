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


require_once('include/connectors/ConnectorFactory.php');
/**
 * Provides a factory to loading a connector along with any key->value options to initialize on the
 * source.  The name of the class to be loaded, corresponds to the path on the file system. For example a source
 * with the name ext_soap_hoovers would be ext/soap/hoovers.php
 * @api
 */
class SourceFactory{

	/**
	 * Given a source param, load the correct source and return the object
	 * @param string $source string representing the source to load
	 * @return source
	 */
	public static function getSource($class, $call_init = true)
	{
		$dir = str_replace('_','/',$class);
		$parts = explode("/", $dir);
		$file = $parts[count($parts)-1];
		$pos = strrpos($file, '/');
		require_once('include/connectors/sources/default/source.php');
		if(ConnectorFactory::load($class, 'sources')) {
			if (!class_exists($class)) {
            	return null;
            }
            try {
		        $instance = new $class();
			    if($call_init) {
			        $instance->init();
			    }
				return $instance;
			} catch(Exception $ex) {
				return null;
			}
		}

		return null;
	}

}
?>
