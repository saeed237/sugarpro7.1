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

require_once('include/SugarSearchEngine/SugarSearchEngineFullIndexer.php');
require_once('include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php');
require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
require_once('modules/Administration/Administration.php');

class AdministrationViewGlobalsearchsettings extends SugarView
{
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;

    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
    	   $mod_strings['LBL_GLOBAL_SEARCH_SETTINGS']
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
    	require_once('modules/Home/UnifiedSearchAdvanced.php');
		$usa = new UnifiedSearchAdvanced();
        global $mod_strings, $app_strings, $app_list_strings;

        $sugar_smarty = new Sugar_Smarty();
        $sugar_smarty->assign('APP', $app_strings);
        $sugar_smarty->assign('MOD', $mod_strings);
        $sugar_smarty->assign('moduleTitle', $this->getModuleTitle(false));

        $modules = $usa->retrieveEnabledAndDisabledModules();

        $sugar_smarty->assign('enabled_modules', json_encode($modules['enabled']));
        $sugar_smarty->assign('disabled_modules', json_encode($modules['disabled']));
        //FTS Options
        $schedulerID = SugarSearchEngineFullIndexer::isFTSIndexScheduled();

        $defaultEngine = SugarSearchEngineFactory::getFTSEngineNameFromConfig();
        $config = $GLOBALS['sugar_config']['full_text_engine'][$defaultEngine];

        $justRequestedAScheduledIndex = !empty($_REQUEST['sched']) ? TRUE : FALSE;

        $schedulerID = SugarSearchEngineFullIndexer::isFTSIndexScheduled();
        $schedulerCompleted = SugarSearchEngineFullIndexer::isFTSIndexScheduleCompleted($schedulerID);
        $hide_fts_config = isset( $GLOBALS['sugar_config']['hide_full_text_engine_config'] ) ? $GLOBALS['sugar_config']['hide_full_text_engine_config'] : FALSE;

        $showSchedButton = ($defaultEngine != '' && $this->isFTSConnectionValid()) ? TRUE : FALSE;

        $sugar_smarty->assign("showSchedButton", $showSchedButton);
        $sugar_smarty->assign("hide_fts_config", $hide_fts_config);
        $sugar_smarty->assign("fts_type", get_select_options_with_id($app_list_strings['fts_type'], $defaultEngine));
        $sugar_smarty->assign("fts_host", $config['host']);
        $sugar_smarty->assign("fts_port", $config['port']);
        $sugar_smarty->assign("fts_scheduled", !empty($schedulerID) && !$schedulerCompleted);
        $sugar_smarty->assign('justRequestedAScheduledIndex', $justRequestedAScheduledIndex);
        //End FTS
        echo $sugar_smarty->fetch(SugarAutoLoader::existingCustomOne('modules/Administration/templates/GlobalSearchSettings.tpl'));

    }

    protected function isFTSConnectionValid()
    {
        $searchEngine = SugarSearchEngineFactory::getInstance();
        $result = $searchEngine->getServerStatus();
        if($result['valid']) {
            $this->setFTSUp();
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * This method sets the full text search to available when a scheduled FTS Index occurs.  
     * An indexing can only occur with a valid connection
     * 
     * TODO: XXX Fix this to use admin settings not config options
     * @return bool
     */
    protected function setFTSUp() {
        $cfg = new Configurator();
        $cfg->config['fts_disable_notification'] = false;
        $cfg->handleOverride();
        // set it up
        SugarSearchEngineAbstractBase::markSearchEngineStatus(false);
        $admin = BeanFactory::newBean('Administration');
        $admin->retrieveSettings(FALSE, TRUE);
        return TRUE;
    }
}
