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

class ViewDropdowns extends SugarView
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
		$ajax = new AjaxCompose();
		$smarty = new Sugar_Smarty();
		
 		if (isset($_REQUEST['refreshTree']))
		{
			require_once ('modules/ModuleBuilder/Module/DropDownTree.php');
			$mbt = new DropDownTree();
			$ajax->addSection('west', $mbt->getName(), $mbt->fetchNodes());
			$smarty->assign('refreshTree',true);
		}
                
        global $mod_strings;
        $ajax->addCrumb($mod_strings['LBL_DROPDOWNEDITOR'], 'ModuleBuilder.main("dropdowns")');
        
        require_once('modules/ModuleBuilder/Module/DropDownBrowser.php');
        $dd = new DropDownBrowser();
        
        $smarty->assign('LBL_BTN_ADDDROPDOWN',translate('LBL_BTN_ADDDROPDOWN'));
        $smarty->assign('dropdowns', $dd->getNodes());
		$smarty->assign('deleteImage', SugarThemeRegistry::current()->getImage( 'delete_inline', '',null,null,'.gif',$mod_strings['LBL_MB_DELETE']));
		$smarty->assign('editImage', SugarThemeRegistry::current()->getImage( 'edit_inline', '',null,null,'.gif',$mod_strings['LBL_EDIT']));
		$smarty->assign('action', 'savedropdown');
		

		$ajax->addSection('center', $GLOBALS['mod_strings']['LBL_DROPDOWNEDITOR'], $smarty->fetch('modules/ModuleBuilder/tpls/MBModule/dropdowns.tpl') );
 		echo $ajax->getJavascript();
 	}
}