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



require_once('include/MVC/View/SugarView.php');
require_once('include/connectors/sources/SourceFactory.php');

class ViewModifySearch extends SugarView 
{   
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
    	   "<a href='index.php?module=Connectors&action=ConnectorSettings'>".$mod_strings['LBL_ADMINISTRATION_MAIN']."</a>",
    	   $mod_strings['LBL_MODIFY_SEARCH_TITLE']
    	   );
    }
    
    /**
	 * @see SugarView::_getModuleTab()
	 */
	protected function _getModuleTab()
    {
        return 'Administration';
    }
    
    /**
	 * @see SugarView::display()
	 */
	public function display() 
	{	
		require_once('include/connectors/utils/ConnectorUtils.php');
		global $mod_strings, $app_strings;
		$sugar_smarty	= new Sugar_Smarty();
		$this->ss->assign('mod', $mod_strings);
		$this->ss->assign('APP', $app_strings);
		$connectors = ConnectorUtils::getConnectors();
		foreach($connectors as $id=>$source) {
            $s = SourceFactory::getSource($id);
            if(!$s->isEnabledInAdminSearch() || !$s->isEnabledInWizard())
            {
               unset($connectors[$id]);
            }
		}		

		$this->ss->assign('SOURCES', $connectors);
	    echo $this->getModuleTitle(false);
		$this->ss->display($this->getCustomFilePathIfExists('modules/Connectors/tpls/modify_search.tpl'));
    }
}