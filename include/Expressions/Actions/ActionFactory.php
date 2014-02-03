<?php
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

require_once("include/Expressions/Actions/AbstractAction.php");

/**
 * SugarLogic action factory
 * @api
 */
class ActionFactory
{
	static $exclude_files = array("ActionFactory.php", "AbstractAction.php");
	static $action_directory = "include/Expressions/Actions";
	static $loaded_actions = array();

	static function loadFunctionList()
	{
	    $cachefile = sugar_cached("Expressions/actions_cache.php");
		if (!is_file($cachefile))
		{
		    ActionFactory::buildActionCache();
		} else
		{
			include $cachefile;
			ActionFactory::$loaded_actions = $actions;
		}
	}

	static function buildActionCache($silent = true)
	{
		if (!is_dir(ActionFactory::$action_directory))
            return false;

        // First get a list of all the files in this directory.
        $entries = array();
        $actions = array();
		$javascript = "";
		foreach(SugarAutoLoader::getFilesCustom(ActionFactory::$action_directory) as $path) {
		    $entry = basename($path);
		    if (strtolower(substr($entry, -4)) != ".php" || in_array($entry, ActionFactory::$exclude_files))
		    	continue;
		    require_once($path);

		    $className = substr($entry, 0, strlen($entry) - 4);
		    $actionName = call_user_func(array($className, "getActionName"));
		    $actions[$actionName] = array('class' => $className, 'file' => $path);
		    $javascript .= call_user_func(array($className, "getJavascriptClass"));
		    if (!$silent) echo "added action $actionName <br/>";
		}

		if (empty($actions)) return "";

		create_cache_directory("Expressions/actions_cache.php");
		write_array_to_file('actions', $actions, sugar_cached('Expressions/actions_cache.php'));

		ActionFactory::$loaded_actions = $actions;

		return $javascript;

	}

	static function getNewAction($name, $params) {
		if (empty(ActionFactory::$loaded_actions))
			ActionFactory::loadFunctionList();
		if (isset(ActionFactory::$loaded_actions[$name]))
		{
			require_once(ActionFactory::$loaded_actions[$name]['file']);
			$class = ActionFactory::$loaded_actions[$name]['class'];
			return new $class($params);
		}

		return false;
	}
}
?>