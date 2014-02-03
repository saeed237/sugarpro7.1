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

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/

class TrackersViewTrackersettings extends SugarView 
{	
    /**
	 * @see SugarView::_getModuleTab()
	 */
	protected function _getModuleTab()
    {
        return 'Administration';
    }
 	
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
    	   translate('LBL_TRACKER_SETTINGS','Administration'),
    	   );
    }
    
 	/** 
     * @see SugarView::display()
     */
 	public function display()
    {
        global $mod_strings, $app_strings;
        
        $admin = Administration::getSettings();
        
        require('modules/Trackers/config.php');
        
        ///////////////////////////////////////////////////////////////////////////////
        ////	HANDLE CHANGES
        if(isset($_POST['process'])) {
           if($_POST['process'] == 'true') {
               foreach($tracker_config as $entry) {
                  if(isset($entry['bean'])) {
                      //If checkbox is unchecked, we add the entry into the config table; otherwise delete it
                      if(empty($_POST[$entry['name']])) {
                        $admin->saveSetting('tracker', $entry['name'], 1);
                      }	else {
                        $db = DBManagerFactory::getInstance();
                        $db->query("DELETE FROM config WHERE category = 'tracker' and name = '" . $entry['name'] . "'");
                      }
                  }
               } //foreach
               
               //save the tracker prune interval
               if(!empty($_POST['tracker_prune_interval'])) {
                  $admin->saveSetting('tracker', 'prune_interval', $_POST['tracker_prune_interval']);
               }
               
               //save log slow queries and slow query interval
               $configurator = new Configurator();
               $configurator->saveConfig();
           } //if
           header('Location: index.php?module=Administration&action=index');
        }
        
        echo getClassicModuleTitle(
                "Administration", 
                array(
                    "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
                    translate('LBL_TRACKER_SETTINGS','Administration'),
                    ), 
                false
                );
        
        $trackerManager = TrackerManager::getInstance();
        $disabledMonitors = $trackerManager->getDisabledMonitors();
        $trackerEntries = array();
        foreach($tracker_config as $entry) {
           if(isset($entry['bean'])) {
              $disabled = !empty($disabledMonitors[$entry['name']]);
              $trackerEntries[$entry['name']] = array('label'=> $mod_strings['LBL_' . strtoupper($entry['name']) . '_DESC'], 'helpLabel'=> $mod_strings['LBL_' . strtoupper($entry['name']) . '_HELP'], 'disabled'=>$disabled);
           }
        }
        
        $configurator = new Configurator();
        $this->ss->assign('config', $configurator->config);
        
        $config_strings = return_module_language($GLOBALS['current_language'], 'Configurator');
        $mod_strings['LOG_SLOW_QUERIES'] = $config_strings['LOG_SLOW_QUERIES'];
        $mod_strings['SLOW_QUERY_TIME_MSEC'] = $config_strings['SLOW_QUERY_TIME_MSEC'];
        
        $this->ss->assign('mod', $mod_strings);
        $this->ss->assign('app', $app_strings);
        $this->ss->assign('trackerEntries', $trackerEntries);
        $this->ss->assign('tracker_prune_interval', !empty($admin->settings['tracker_prune_interval']) ? $admin->settings['tracker_prune_interval'] : 30);
        $this->ss->display('modules/Trackers/tpls/TrackerSettings.tpl');
    }
}