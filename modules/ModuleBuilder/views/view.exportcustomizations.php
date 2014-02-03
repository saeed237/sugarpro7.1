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
class ViewExportcustomizations extends SugarView
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

	function display()
	{
 		global $current_user, $mod_strings;
 		$smarty = new Sugar_Smarty();
 		$mb = new MBPackage("packageCustom");
 		$mod=$mb->getCustomModules();
 		foreach($mod as $key => $value){
 		    $modules[]=$key;
 		    $custom[]=$value;
 		}
 		$nb_mod = count($modules);
 		$smarty->assign('mod_strings', $mod_strings);
 		$smarty->assign('modules', $mod);
 		$smarty->assign('custom', $custom);
 		$smarty->assign('nb_mod', $nb_mod);
 		$smarty->assign('defaultHelp', 'exportHelp');
 		$smarty->assign('moduleList',$GLOBALS['app_list_strings']['moduleList']);  
 		$smarty->assign('moduleList',$GLOBALS['app_list_strings']['moduleList']);  
		$ajax = new AjaxCompose();
		$ajax->addCrumb($mod_strings['LBL_STUDIO'], 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard")');
		$ajax->addSection('center', $mod_strings['LBL_EC_TITLE'],$smarty->fetch($this->getCustomFilePathIfExists('modules/ModuleBuilder/tpls/exportcustomizations.tpl')));
		echo $ajax->getJavascript();
 	}
}