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
 * Filter factory
 * @api
 */
class FilterFactory
{
	static $filter_map = array();

	public static function getInstance($source_name, $filter_name='')
	{
		require_once('include/connectors/filters/default/filter.php');
		$key = $source_name . $filter_name;
		if(empty(self::$filter_map[$key])) {

			if(empty($filter_name)){
			   $filter_name = $source_name;
			}

			if(ConnectorFactory::load($filter_name, 'filters')) {
		        $filter_name .= '_filter';
			} else {
				//if there is no override wrapper, use the default.
				$filter_name = 'default_filter';
			}

			$component = ConnectorFactory::getInstance($source_name);
			$filter = new $filter_name();
			$filter->setComponent($component);
			self::$filter_map[$key] = $filter;
		} //if
		return self::$filter_map[$key];
	}
}
