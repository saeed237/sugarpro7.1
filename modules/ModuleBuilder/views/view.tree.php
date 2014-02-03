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


require_once('modules/ModuleBuilder/MB/AjaxCompose.php');
require_once('modules/ModuleBuilder/Module/StudioModule.php');
require_once('modules/ModuleBuilder/Module/StudioBrowser.php') ;
require_once('vendor/ytree/ExtNode.php') ;

class ViewHistory extends SugarView 
{
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   translate('LBL_MODULE_NAME','Administration'),
    	   ModuleBuilderController::getModuleTitle(),
    	   );
    }

	//STUDIO LABELS ONLY//
 	//TODO Bundle Studio and ModuleBuilder label handling to increase maintainability.
 	function display()
 	{
		$root = new ExtNode('root', 'root', true);
		$sb = new StudioBrowser();
		$sb->loadModules();
		foreach($sb->modules as $name => $studioMod) {
			$root->add_node($this->buildStudioNode($studioMod));
		}
		$json = getJSONobj();
		echo($json->encode($root));
 	}
	
	/**
	 * 
	 * @return ExtNode built from the passed StudioModule
	 * @param $module StudioModule
	 */
	function buildStudioNode($module) {
		
	}

}
