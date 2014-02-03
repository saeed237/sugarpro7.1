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
 * Formatter factory
 * @api
 */
class FormatterFactory {

	static $formatter_map = array();

	/**
	 * getInstance
	 * This method returns a formatter instance for the given source name and
	 * formatter name.  If no formatter name is specified, the default formatter
	 * for the source is used.
	 *
	 * @param $source_name The data source name to retreive formatter for
	 * @param $formatter_name Optional formatter name to use
	 * @param $wrapper_name Optional wrapper name to use
	 * @return $instance The formatter instance
	 */
	public static function getInstance($source_name, $formatter_name=''){
		require_once('include/connectors/formatters/default/formatter.php');
		$key = $source_name . $formatter_name;
		if(empty(self::$formatter_map[$key])) {

			if(empty($formatter_name)){
			   $formatter_name = $source_name;
			}

			$dir = str_replace('_','/',$formatter_name);
			$parts = explode("/", $dir);
			$file = array_pop($parts);

			if(ConnectorFactory::load($formatter_name, 'formatters')) {
				$formatter_name .= '_formatter';
			} else {
				//if there is no override wrapper, use the default.
				$formatter_name = 'default_formatter';
			}

			$component = ConnectorFactory::getInstance($source_name);
			$formatter = new $formatter_name();
			$formatter->setComponent($component);

			$tpl = SugarAutoLoader::existingCustomOne("modules/Connectors/connectors/formatters/{$dir}/tpls/{$file}.tpl");
			if(!empty($tpl)) {
			    $formatter->setTplFileName($tpl);
			}
			self::$formatter_map[$key] = $formatter;
		} //if
		return self::$formatter_map[$key];
	}

}
?>