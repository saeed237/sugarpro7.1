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


class ViewMain extends SugarView
{ 	
 	function ViewMain(){
		$this->options['show_footer'] = false;
 		parent::SugarView();
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
    
 	function display()
 	{
		global $app_strings, $current_user, $mod_strings, $theme;

 		$smarty = new Sugar_Smarty();
 		$type = (!empty($_REQUEST['type']))?$_REQUEST['type']:'main';
 		$mbt = false;
 		$admin = false;
 		$mb = strtolower($type);
 		$smarty->assign('TYPE', $type);
 		$smarty->assign('app_strings', $app_strings);
 		$smarty->assign('mod', $mod_strings);
 		//Replaced by javascript function "setMode"
 		switch($type){
 			case 'studio':
 				//$smarty->assign('ONLOAD','ModuleBuilder.getContent("module=ModuleBuilder&action=wizard")');
 				require_once('modules/ModuleBuilder/Module/StudioTree.php');
				$mbt = new StudioTree();
				break;
 			case 'mb':
 				//$smarty->assign('ONLOAD','ModuleBuilder.getContent("module=ModuleBuilder&action=package&package=")');
 				require_once('modules/ModuleBuilder/MB/MBPackageTree.php');
				$mbt = new MBPackageTree();
				break;
 			case 'dropdowns':
 			   // $admin = is_admin($current_user);
 			    require_once('modules/ModuleBuilder/Module/DropDownTree.php');
 			    $mbt = new DropDownTree();
 			    break;
 			default:
 				//$smarty->assign('ONLOAD','ModuleBuilder.getContent("module=ModuleBuilder&action=home")');	
				require_once('modules/ModuleBuilder/Module/MainTree.php');
				$mbt = new MainTree();
 		}
 		$smarty->assign('TEST_STUDIO', displayStudioForCurrentUser());
 		$smarty->assign('ADMIN', is_admin($current_user));
 		$smarty->display('modules/ModuleBuilder/tpls/includes.tpl');
		if($mbt)
		{
			$smarty->assign('TREE',$mbt->fetch());
			$smarty->assign('TREElabel', $mbt->getName());
		}
		$userPref = $current_user->getPreference('mb_assist', 'Assistant');
		if(!$userPref) $userPref="na"; 
		$smarty->assign('userPref',$userPref);
		
		///////////////////////////////////
	    require_once('include/SugarTinyMCE.php');
	    $tiny = new SugarTinyMCE();
	    $tiny->defaultConfig['width']=300;
	    $tiny->defaultConfig['height']=300;
	    $tiny->buttonConfig = "code,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,
	                         justifyfull,separator,forecolor,backcolor,
	                         ";
	    $tiny->buttonConfig2 = "pastetext,pasteword,fontselect,fontsizeselect,";
	    $tiny->buttonConfig3 = "";
	    $ed = $tiny->getInstance();
	    $smarty->assign("tiny", $ed);
		
		$smarty->display('modules/ModuleBuilder/tpls/index.tpl');
		
 	}
}