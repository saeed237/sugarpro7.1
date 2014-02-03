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


require_once('include/DashletContainer/Containers/DCAbstract.php');

/**
 * The Dashlet Container Factory (DCF) provides a facility for loading the appropriate Dashlet Container.
 * It will make the decision based on what container is requested as well as system and user settings.
 * @author mitani
 * @api
 */
class DCFactory
{
	static $defaultContainer = 'DCList';

	/**
	 * Prevent Instantiation of DCFactory it should only be used statically
	 *
	 */
	private function __construct()
	{
	}

	/**
	 * This function will make the decision for which container to load.
	 *
	 * If container is not specified
	 * 1. check if user has a default container they prefer load
	 *
	 * @param string $dashletMetaDataFile - file path to the meta-data specificying the Dashlets used in this container
	 * @param string $container  - name of the Dashlet Container to use if not specified it will use the system default
	 * @static
	 * @return DashletContainer
	 */
	public static function getContainer($dashletMetaDataFile, $container = null)
	{
		if($container == null)
			$container = self::$defaultContainer;

		if(!SugarAutoLoader::requireWithCustom('include/DashletContainer/Containers/' . $container .'.php'))
		    return false;

		$class = SugarAutoLoader::customClass($container);

		if ( !class_exists($class) )
		    return false;

        return new $class($dashletMetaDataFile);
	}
}