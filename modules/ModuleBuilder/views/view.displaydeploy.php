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

class ViewDisplaydeploy extends SugarView 
{
	function ViewDisplaydeploy()
	{
		$smarty = new Sugar_Smarty();
 		$smarty->assign('package', $_REQUEST['name']);
		$smarty->assign('message', $GLOBALS['mod_strings']['LBL_DEPLOY_IN_PROGRESS']);
		$ajax = new AjaxCompose();
		$ajax->addCrumb($GLOBALS['mod_strings']['LBL_MODULEBUILDER'], 'ModuleBuilder.main("mb")');
		$ajax->addCrumb($_REQUEST['name'],'ModuleBuilder.getContent("module=ModuleBuilder&action=package&package='.$_REQUEST['name'].'")');
		$ajax->addCrumb(translate('LBL_SECTION_DEPLOY', 'ModuleBuilder'), '');
		$ajax->addSection('center', translate('LBL_SECTION_DEPLOY', 'ModuleBuilder'), $smarty->fetch('modules/ModuleBuilder/tpls/MBPackage/deploy.tpl'));
		echo $ajax->getJavascript();
	}
	
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
}
