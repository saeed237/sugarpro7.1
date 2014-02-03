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

require_once 'include/MVC/Controller/SugarController.php';
/**
 * MVC Controller Factory
 * @api
 */
class ControllerFactory
{
	/**
	 * Obtain an instance of the correct controller.
	 *
	 * @return an instance of SugarController
	 */
	function getController($module)
	{
		if(SugarAutoLoader::requireWithCustom("modules/{$module}/controller.php")) {
		    $class = SugarAutoLoader::customClass(ucfirst($module).'Controller');
		} else {
		    SugarAutoLoader::requireWithCustom('include/MVC/Controller/SugarController.php');
		    $class = SugarAutoLoader::customClass('SugarController');
		}
		if(class_exists($class, false)) {
			$controller = new $class();
		}

		if(empty($controller)) {
		    $controller = new SugarController();
		}
		//setup the controller
		$controller->setup($module);
		return $controller;
	}
}