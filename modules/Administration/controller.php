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


require_once('include/MetaDataManager/MetaDataManager.php');

class AdministrationController extends SugarController
{
    public function action_savetabs()
    {
        require_once('include/SubPanel/SubPanelDefinitions.php');
        require_once('modules/MySettings/TabController.php');


        global $current_user, $app_strings;

        if (!is_admin($current_user)) {
            sugar_die($app_strings['ERR_NOT_ADMIN']);
        }

        // handle the tabs listing
        $toDecode = html_entity_decode($_REQUEST['enabled_tabs'], ENT_QUOTES);
        $enabled_tabs = json_decode($toDecode);
        // Add Home back in so that it always appears first in Sugar 7
        array_unshift($enabled_tabs, 'Home');
        $tabs = new TabController();
        $tabs->set_system_tabs($enabled_tabs);
        $tabs->set_users_can_edit(isset($_REQUEST['user_edit_tabs']) && $_REQUEST['user_edit_tabs'] == 1);

        // handle the subpanels
        if (isset($_REQUEST['disabled_tabs'])) {
            $disabledTabs = json_decode(html_entity_decode($_REQUEST['disabled_tabs'], ENT_QUOTES));
            $disabledTabsKeyArray = TabController::get_key_array($disabledTabs);
            SubPanelDefinitions::set_hidden_subpanels($disabledTabsKeyArray);
        }
        
        // BR-29 When changing module tabs the megamenu is not updated on the client
        MetaDataManager::clearAPICache();

        if (!headers_sent()) {
            header("Location: index.php?module=Administration&action=ConfigureTabs");
        }
    }

    public function action_savelanguages()
    {
        global $sugar_config;
        $toDecode = html_entity_decode  ($_REQUEST['disabled_langs'], ENT_QUOTES);
        $disabled_langs = json_decode($toDecode);
        $toDecode = html_entity_decode  ($_REQUEST['enabled_langs'], ENT_QUOTES);
        $enabled_langs = json_decode($toDecode);
        $cfg = new Configurator();
        $cfg->config['disabled_languages'] = join(',', $disabled_langs);
        // TODO: find way to enforce order
        $cfg->handleOverride();

        // Clear the metadata cache so changes to languages are picked up right away
        MetaDataManager::clearAPICache();
        
        header("Location: index.php?module=Administration&action=Languages");
    }

    public function action_updatewirelessenabledmodules()
    {
        require_once('modules/Administration/Forms.php');

        global $app_strings, $current_user, $moduleList;

        if (!is_admin($current_user)) sugar_die($app_strings['ERR_NOT_ADMIN']);

        require_once('modules/Configurator/Configurator.php');
        $configurator = new Configurator();
        $configurator->saveConfig();

        if ( isset( $_REQUEST['enabled_modules'] ) && ! empty ($_REQUEST['enabled_modules'] ))
        {
            $updated_enabled_modules = array () ;
            foreach ( explode (',', $_REQUEST['enabled_modules'] ) as $e )
            {
                $updated_enabled_modules [ $e ] = array () ;
            }

            // transfer across any pre-existing definitions for the enabled modules from the current module registry
            if (file_exists('include/MVC/Controller/wireless_module_registry.php'))
            {
                require('include/MVC/Controller/wireless_module_registry.php');
                if ( ! empty ( $wireless_module_registry ) )
                {
                    foreach ( $updated_enabled_modules as $e => $def )
                    {
                        if ( isset ( $wireless_module_registry [ $e ] ) )
                        {
                            $updated_enabled_modules [ $e ] = $wireless_module_registry [ $e ] ;
                        }

                    }
                }
            }

            $filename = create_custom_directory('include/MVC/Controller/wireless_module_registry.php');

            mkdir_recursive ( dirname ( $filename ) ) ;
            write_array_to_file ( 'wireless_module_registry', $updated_enabled_modules, $filename );
            foreach($moduleList as $mod){
                sugar_cache_clear("CONTROLLER_wireless_module_registry_$mod");
            }
            //Users doesn't appear in the normal module list, but its value is cached on login.
            sugar_cache_clear("CONTROLLER_wireless_module_registry_Users");
            sugar_cache_reset();
            
            // Bug 59121 - Clear the metadata cache
            MetaDataManager::clearAPICache();
        }

        echo "true";
    }

    /**
     * Save the FTS settings for the system and any modules that may be enabled/disabled
     * by the administrator.
     */
    public function action_ScheduleFTSIndex()
    {
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $host = !empty($_REQUEST['host']) ? $_REQUEST['host'] : '';
        $port = !empty($_REQUEST['port']) ? $_REQUEST['port'] : '';
        $clearData = !empty($_REQUEST['clearData']) ? $_REQUEST['clearData'] : FALSE;
        $modules = !empty($_REQUEST['modules']) ? explode(",", $_REQUEST['modules']) : array();
        $scheduleIndex = !empty($_REQUEST['sched']) ? TRUE : FALSE;

        $this->cfg = new Configurator();
        $this->cfg->config['full_text_engine'] = '';
        $this->cfg->saveConfig();
        $this->cfg->config['full_text_engine'] = array($type => array('host' => $host, 'port' => $port));
        $this->cfg->handleOverride();
        $scheduled = FALSE;
        if($scheduleIndex)
        {
            require_once('include/SugarSearchEngine/SugarSearchEngineFullIndexer.php');
            $indexer = new SugarSearchEngineFullIndexer();
            $indexer->initiateFTSIndexer($modules, (int) $clearData);
            $scheduled = TRUE;
        }
        echo json_encode(array('success' => $scheduled));
    }

    public function action_checkFTSConnection()
    {
        $type = !empty($_REQUEST['type']) ? urldecode($_REQUEST['type']) : '';
        $host = !empty($_REQUEST['host']) ? urldecode($_REQUEST['host']) : '';
        $port = !empty($_REQUEST['port']) ? urldecode($_REQUEST['port']) : '';

        if(!empty($type) && !empty($host) && !empty($port))
        {
            $config = array('port' => $port, 'host' => $host);
            require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
            $searchEngine = SugarSearchEngineFactory::getInstance($type, $config);
            $result = $searchEngine->getServerStatus();
            if($result['valid'])
                $result['status'] = $GLOBALS['mod_strings']['LBL_FTS_CONN_SUCCESS'];
            echo json_encode($result);
        }
        else
        {
            echo json_encode(array('valid' => FALSE));
        }
        sugar_cleanup(TRUE);
    }

    /**
     * action_saveglobalsearchsettings
     *
     * This method handles saving the selected modules to display in the Global Search Settings.
     * It instantiates an instance of UnifiedSearchAdvanced and then calls the saveGlobalSearchSettings
     * method.
     *
     */
    public function action_saveglobalsearchsettings()
    {
		 global $current_user, $app_strings;

		 if (!is_admin($current_user))
		 {
		     sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
		 }

    	 try
         {
	    	 require_once('modules/Home/UnifiedSearchAdvanced.php');
	    	 $unifiedSearchAdvanced = new UnifiedSearchAdvanced();
	    	 $unifiedSearchAdvanced->saveGlobalSearchSettings();
             //Save FTS Settings
             $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
             $host = !empty($_REQUEST['host']) ? $_REQUEST['host'] : '';
             $port = !empty($_REQUEST['port']) ? $_REQUEST['port'] : '';
             $this->cfg = new Configurator();
             $this->cfg->config['full_text_engine'] = '';
             $this->cfg->saveConfig();
             $ftsConnectionValid = TRUE;

             if( !empty($type) )
             {
                 //Check if the connection is valid on save:
                 $config = array('port' => $port, 'host' => $host);
                 require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
                 $searchEngine = SugarSearchEngineFactory::getInstance($type, $config);
                 $result = $searchEngine->getServerStatus();
                 if( !$result['valid'] )
                     $ftsConnectionValid = FALSE;

                 // bug 54274 -- only bother with an override if we have data to place there, empty string breaks Sugar On-Demand!
                 $this->cfg->config['full_text_engine'] = array($type => array('host' => $host, 'port' => $port, 'valid' => $ftsConnectionValid));
                 $this->cfg->handleOverride();
             }

             MetaDataManager::clearAPICache();
             
             if(!$ftsConnectionValid)
                 echo $GLOBALS['mod_strings']['LBL_FTS_CONNECTION_INVALID'];
             else
	    	    echo "true";
    	 }
         catch (Exception $ex)
         {
    	 	 echo "false";
    	 }
    }
/*
    public function action_UpdateAjaxUI()
    {
        // TODO check if we need to use this to update the bwc widget.
//        require_once('modules/Configurator/Configurator.php');
//        $cfg = new Configurator();
//        $disabled = json_decode(html_entity_decode  ($_REQUEST['disabled_modules'], ENT_QUOTES));
//        $cfg->config['addAjaxBannedModules'] = empty($disabled) ? FALSE : $disabled;
//        $cfg->handleOverride();
//        $this->view = "configureajaxui";
    }
*/

    /*
     * action_callRebuildSprites
     *
     * This method is responsible for actually running the SugarSpriteBuilder class to rebuild the sprites.
     * It is called from the ajax request issued by RebuildSprites.php.
     */
    public function action_callRebuildSprites()
    {
        global $current_user;
        $this->view = 'ajax';
        if(function_exists('imagecreatetruecolor'))
        {
            if(is_admin($current_user))
            {
                require_once('modules/UpgradeWizard/uw_utils.php');
                rebuildSprites(false);
            }
        } else {
            echo $mod_strings['LBL_SPRITES_NOT_SUPPORTED'];
            $GLOBALS['log']->error($mod_strings['LBL_SPRITES_NOT_SUPPORTED']);
        }
    }
}
