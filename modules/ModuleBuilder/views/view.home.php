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
class ViewHome extends SugarView
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
		global $current_user;
		global $mod_strings;
		$smarty = new Sugar_Smarty();
		$smarty->assign('title' , $mod_strings['LBL_DEVELOPER_TOOLS']);
		$smarty->assign('question', $mod_strings['LBL_QUESTION_EDITOR']);
		$smarty->assign('defaultHelp', 'mainHelp');
		$this->generateHomeButtons();
		$smarty->assign('buttons', $this->buttons);
		$assistant=array('group'=>'main', 'key'=>'welcome');
		$smarty->assign('assistant',$assistant);
		//initialize Assistant's display property.
		$userPref = $current_user->getPreference('mb_assist', 'Assistant');
		if(!$userPref) $userPref="na";
		$smarty->assign('userPref',$userPref);
		$ajax = new AjaxCompose();
		$ajax->addSection('center', $mod_strings['LBL_HOME'],$smarty->fetch('modules/ModuleBuilder/tpls/wizard.tpl'));
		echo $ajax->getJavascript();
	}


	function generateHomeButtons() 
	{
	    global $current_user;
        if(displayStudioForCurrentUser() == true) {
		//$this->buttons['Application'] = array ('action' => '', 'imageTitle' => 'Application', 'size' => '128', 'help'=>'appBtn');
		$this->buttons[$GLOBALS['mod_strings']['LBL_STUDIO']] = array ('action' => 'javascript:ModuleBuilder.main("studio")', 'imageTitle' => 'Studio', 'size' => '128', 'help'=>'studioBtn');
        }
        if(is_admin($current_user)) {
		$this->buttons[$GLOBALS['mod_strings']['LBL_MODULEBUILDER']] = array ('action' => 'javascript:ModuleBuilder.main("mb")', 'imageTitle' => 'ModuleBuilder', 'size' => '128', 'help'=>'mbBtn');
        }
		$this->buttons[$GLOBALS['mod_strings']['LBL_DROPDOWNEDITOR']] = array ('action' => 'javascript:ModuleBuilder.main("dropdowns")', 'imageTitle' => $GLOBALS['mod_strings']['LBL_HOME_EDIT_DROPDOWNS'], 'imageName' => 'DropDownEditor', 'size' => '128', 'help'=>'dropDownEditorBtn');
	}
}