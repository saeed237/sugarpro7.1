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
 * Chart factory
 * @api
 */
class SugarChartFactory
{
    /**
	 * Returns a reference to the ChartEngine object for instance $chartEngine, or the default
     * instance if one is not specified
     *
     * @param string $chartEngine optional, name of the chart engine from $sugar_config['chartEngine']
     * @param string $module optional, name of module extension for chart engine (see JitReports or SugarFlashReports)
     * @return object ChartEngine instance
     */
	public static function getInstance(
        $chartEngine = '',
        $module = ''
        )
    {
        global $sugar_config;
		$defaultEngine = "Jit";
        //fall back to the default Js Engine if config is not defined
        if(empty($sugar_config['chartEngine'])){
        	$sugar_config['chartEngine'] = $defaultEngine;
        }

        if(empty($chartEngine)){
        	$chartEngine = $sugar_config['chartEngine'];
        }

        if(!SugarAutoLoader::requireWithCustom("include/SugarCharts/{$chartEngine}/{$chartEngine}{$module}.php")) {
          $GLOBALS['log']->debug("using default engine include/SugarCharts/{$defaultEngine}/{$defaultEngine}{$module}.php");
          require_once("include/SugarCharts/{$defaultEngine}/{$defaultEngine}{$module}.php");
          $chartEngine = $defaultEngine;
        }

        $className = $chartEngine.$module;
        return new $className();

    }

}

?>
