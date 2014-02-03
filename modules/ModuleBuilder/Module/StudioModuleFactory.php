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

require_once 'modules/ModuleBuilder/Module/StudioModule.php' ;

class StudioModuleFactory
{
	protected static $loadedMods = array();

    public static function getStudioModule($module)
	{
		if (!empty(self::$loadedMods[$module]))
            return self::$loadedMods[$module];

        $studioModClass = "{$module}StudioModule";
		if (file_exists("custom/modules/{$module}/{$studioModClass}.php"))
		{
			require_once "custom/modules/{$module}/{$studioModClass}.php";
			$sm = new $studioModClass($module);

		} else if (file_exists("modules/{$module}/{$studioModClass}.php"))
		{
			require_once "modules/{$module}/{$studioModClass}.php";
			$sm = new $studioModClass($module);

		}
		else 
		{
			$sm = new StudioModule($module);
		}
        self::$loadedMods[$module] = $sm;
        return $sm;
	}
}
?>