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


//Used in rebuildExtensions
require_once 'ModuleInstall/ModuleInstaller.php';

// Used in clearExternalAPICache
require_once 'include/externalAPI/ExternalAPIFactory.php';

// Used in clearPDFFontCache
require_once 'include/Sugarpdf/FontManager.php';

// Used in clearAdditionalCaches
require_once 'include/api/ServiceDictionary.php';

//clear out the api metadata cache
require_once "include/MetaDataManager/MetaDataManager.php";

/**
 * Class for handling repairing of the sugar installation and rebuilding of caches
 */
class RepairAndClear
{
    public $module_list = array();
    public $show_output;
    protected $actions;
    public $execute;
    protected $module_list_from_cache;

    public function repairAndClearAll($selected_actions, $modules, $autoexecute=false, $show_output=true)
    {
        global $mod_strings;
        $this->module_list= $modules;
        $this->show_output = $show_output;
        $this->actions = $selected_actions;
        $this->actions[] = 'repairDatabase';
        $this->execute=$autoexecute;

        //clear vardefs always..
        // Since this is called here it should not be in the actions
        $this->clearVardefs();
        //first  clear the language cache.
        $this->clearLanguageCache();
        foreach ($this->actions as $current_action)
        switch($current_action)
        {
            case 'repairDatabase':
                if(in_array($mod_strings['LBL_ALL_MODULES'], $this->module_list))
                    $this->repairDatabase();
                else
                    $this->repairDatabaseSelectModules();
                break;
            case 'rebuildExtensions':
                $this->rebuildExtensions();
                break;
            case 'clearTpls':
                $this->clearTpls();
                break;
            case 'clearJsFiles':
                $this->clearJsFiles();
                break;
            case 'clearDashlets':
                $this->clearDashlets();
                break;
            case 'clearThemeCache':
                $this->clearThemeCache();
                break;
            case 'clearJsLangFiles':
                $this->clearJsLangFiles();
                break;
            case 'rebuildAuditTables':
                $this->rebuildAuditTables();
                break;
            case 'clearSearchCache':
                $this->clearSearchCache();
                break;
            case 'clearAdditionalCaches':
                $this->clearAdditionalCaches();
                break;
            case 'clearMetadataAPICache':
                $this->clearMetadataAPICache();
                break;
            case 'clearPDFFontCache':
                $this->clearPDFFontCache();
                break;
            case 'clearAll':
                $this->clearTpls();
                $this->clearJsFiles();
                $this->clearVardefs();
                $this->clearJsLangFiles();
                $this->clearLanguageCache();
                $this->clearDashlets();
                $this->clearSmarty();
                $this->clearThemeCache();
                $this->clearXMLfiles();
                $this->clearSearchCache();
                $this->clearExternalAPICache();
                $this->clearAdditionalCaches();
                $this->clearPDFFontCache();
                $this->rebuildExtensions();
                $this->rebuildFileMap();     
                $this->rebuildAuditTables();
                $this->repairDatabase();
                break;
        }
    }

	/////////////OLD


	public function repairDatabase()
	{
		global $dictionary, $mod_strings;
		if(false == $this->show_output)
			$_REQUEST['repair_silent']='1';
		$_REQUEST['execute']=$this->execute;
        $GLOBALS['reload_vardefs'] = true;
        $hideModuleMenu = true;
		include_once('modules/Administration/repairDatabase.php');
	}


	public function repairDatabaseSelectModules()
	{
		global $current_user, $mod_strings, $dictionary;
		set_time_limit(3600);

		include('include/modules.php'); //bug 15661
		$db = DBManagerFactory::getInstance();

		if (is_admin($current_user) || is_admin_for_any_module($current_user))
		{
			$export = false;
    		if($this->show_output) echo getClassicModuleTitle($mod_strings['LBL_REPAIR_DATABASE'], array($mod_strings['LBL_REPAIR_DATABASE']), false);
            if($this->show_output) {
                echo "<h1 id=\"rdloading\">{$mod_strings['LBL_REPAIR_DATABASE_PROCESSING']}</h1>";
                ob_flush();
            }
	    	$sql = '';
			if($this->module_list && !in_array($mod_strings['LBL_ALL_MODULES'],$this->module_list))
			{
				$repair_related_modules = array_keys($dictionary);
				//repair DB
				$dm = inDeveloperMode();
				$GLOBALS['sugar_config']['developerMode'] = true;
				$GLOBALS['reload_vardefs'] = true;
				foreach($this->module_list as $bean_name)
				{
				    $focus = BeanFactory::newBean($bean_name);
					if (!empty($focus))
					{
						#30273
						if(empty($focus->disable_vardefs)) {
							include('modules/' . $focus->module_dir . '/vardefs.php');
							if($this->show_output)
								print_r("<p>" .$mod_strings['LBL_REPAIR_DB_FOR'].' '. $bean_name . "</p>");
							$sql .= $db->repairTable($focus, $this->execute);
						}
					}
				}

				$GLOBALS['sugar_config']['developerMode'] = $dm;

		        if ($this->show_output) echo "<script type=\"text/javascript\">document.getElementById('rdloading').style.display = \"none\";</script>";
	    		if (isset ($sql) && !empty ($sql))
	    		{
					$qry_str = "";
					foreach (explode("\n", $sql) as $line) {
						if (!empty ($line) && substr($line, -2) != "*/") {
							$line .= ";";
						}

						$qry_str .= $line . "\n";
					}
					if ($this->show_output){
						echo "<h3>{$mod_strings['LBL_REPAIR_DATABASE_DIFFERENCES']}</h3>";
						echo "<p>{$mod_strings['LBL_REPAIR_DATABASE_TEXT']}</p>";

						echo "<form method=\"post\" action=\"index.php?module=Administration&amp;action=repairDatabase\">";
						echo "<textarea name=\"sql\" rows=\"24\" cols=\"150\" id=\"repairsql\">$qry_str</textarea>";
						echo "<br /><input type=\"submit\" value=\"".$mod_strings['LBL_REPAIR_DATABASE_EXECUTE']."\" name=\"raction\" /> <input type=\"submit\" name=\"raction\" value=\"".$mod_strings['LBL_REPAIR_DATABASE_EXPORT']."\" />";
					}
				}
				else
					if ($this->show_output) echo "<h3>{$mod_strings['LBL_REPAIR_DATABASE_SYNCED']}</h3>";
			}

		}
		else {
			sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
		}
	}

	public function rebuildExtensions()
	{
		global $mod_strings;
		if($this->show_output) echo $mod_strings['LBL_QR_REBUILDEXT'];
		global $current_user;
		
		$mi = new ModuleInstaller();
		$mi->rebuild_all(!$this->show_output);

		// Remove the "Rebuild Extensions" red text message on admin logins

        if($this->show_output) echo $mod_strings['LBL_REBUILD_REL_UPD_WARNING'];

        // clear the database row if it exists (just to be sure)
        $query = "DELETE FROM versions WHERE name='Rebuild Extensions'";
        $GLOBALS['log']->info($query);
        $GLOBALS['db']->query($query);

        // insert a new database row to show the rebuild extensions is done
        $id = create_guid();
        $gmdate = gmdate('Y-m-d H:i:s');
        $date_entered = db_convert("'$gmdate'", 'datetime');
        $query = 'INSERT INTO versions (id, deleted, date_entered, date_modified, modified_user_id, created_by, name, file_version, db_version) '
            . "VALUES ('$id', '0', $date_entered, $date_entered, '1', '1', 'Rebuild Extensions', '4.0.0', '4.0.0')";
        $GLOBALS['log']->info($query);
        $GLOBALS['db']->query($query);

        // unset the session variable so it is not picked up in DisplayWarnings.php
        if(isset($_SESSION['rebuild_extensions'])) {
            unset($_SESSION['rebuild_extensions']);
        }
	}

     /**
     * rebuild mapping file
     */
    public function rebuildFileMap()
    {
        global $mod_strings;
        if ($this->show_output) {
            echo "<h3>{$mod_strings['LBL_QR_REBUILDFILEMAP']}</h3>";
        }
        SugarAutoLoader::buildCache();
    }

	//Cache Clear Methods
	public function clearSmarty()
	{
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARSMARTY']}</h3>";
		$this->_clearCache(sugar_cached('smarty/templates_c'), '.tpl.php');
	}
	public function clearXMLfiles()
	{
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_XMLFILES']}</h3>";
		$this->_clearCache(sugar_cached("xml"), '.xml');

		include('modules/Versions/ExpectedVersions.php');

        global $expect_versions;

        if (isset($expect_versions['Chart Data Cache'])) {
            $version = BeanFactory::getBean('Versions');
            $version->retrieve_by_string_fields(array('name'=>'Chart Data Cache'));

            $version->name = $expect_versions['Chart Data Cache']['name'];
            $version->file_version = $expect_versions['Chart Data Cache']['file_version'];
            $version->db_version = $expect_versions['Chart Data Cache']['db_version'];
            $version->save();
        }
	}
	public function clearDashlets()
	{
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARDASHLET']}</h3>";
		$this->_clearCache(sugar_cached('dashlets'), '.php');
	}
    public function clearThemeCache()
    {
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARTHEMECACHE']}</h3>";
		SugarThemeRegistry::clearAllCaches();

        //Clear Sidecar Themes CSS files
        $this->_clearCache(sugar_cached('themes/clients/'), '.css');
	}
	public function clearTpls()
	{
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARTEMPLATE']}</h3>";
		if(!in_array( translate('LBL_ALL_MODULES'),$this->module_list) && !empty($this->module_list))
		{
			foreach($this->module_list as $module_name_singular )
				$this->_clearCache(sugar_cached('modules/').$this->_getModuleNamePlural($module_name_singular), '.tpl');
		}
		else
			$this->_clearCache(sugar_cached('modules/'), '.tpl');
	}
	public function clearVardefs()
	{
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARVADEFS']}</h3>";
		if(!empty($this->module_list) && is_array($this->module_list) && !in_array( translate('LBL_ALL_MODULES'),$this->module_list))
		{
			foreach($this->module_list as $module_name_singular )
				$this->_clearCache(sugar_cached('modules/').$this->_getModuleNamePlural($module_name_singular), 'vardefs.php');
		}
		else
			$this->_clearCache(sugar_cached('modules/'), 'vardefs.php');
	}
	public function clearJsFiles()
	{
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARJS']}</h3>";

		if(!in_array( translate('LBL_ALL_MODULES'),$this->module_list) && !empty($this->module_list))
		{
			foreach($this->module_list as $module_name_singular )
				$this->_clearCache(sugar_cached('modules/').$this->_getModuleNamePlural($module_name_singular), '.js');
		}
		else {
            $this->_clearCache(sugar_cached('modules/'), '.js');
        }


	}
	public function clearJsLangFiles()
	{
		global $mod_strings;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARJSLANG']}</h3>";
		if(!in_array(translate('LBL_ALL_MODULES'),$this->module_list ) && !empty($this->module_list))
		{
			foreach($this->module_list as $module_name_singular )
				$this->_clearCache(sugar_cached('jsLanguage/').$this->_getModuleNamePlural($module_name_singular), '.js');
		}
		else
			$this->_clearCache(sugar_cached('jsLanguage'), '.js');
	}
	/**
	 * Remove the language cache files from cache/modules/<module>/language
	 */
	public function clearLanguageCache()
	{
		global $mod_strings;

		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARLANG']}</h3>";
		//clear cache using the list $module_list_from_cache
		if ( !empty($this->module_list) && is_array($this->module_list) ) {
            if( in_array(translate('LBL_ALL_MODULES'), $this->module_list))
            {
                LanguageManager::clearLanguageCache();
            }
            else { //use the modules selected thrut the select list.
                foreach($this->module_list as $module_name)
                    LanguageManager::clearLanguageCache($module_name);
            }
        }
        // Clear app* cache values too
        if(!empty($GLOBALS['sugar_config']['languages'])) {
            $languages = $GLOBALS['sugar_config']['languages'];
        } else {
            $languages = array($GLOBALS['current_language'] => $GLOBALS['current_language']);
        }
        foreach(array_keys($languages) as $language) {
        	sugar_cache_clear('app_strings.'.$language);
        	sugar_cache_clear('app_list_strings.'.$language);
        }

	}

	/**
	 * Remove the cached unified_search_modules.php file
	 */
    public function clearSearchCache() {
        global $mod_strings, $sugar_config;
        if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARSEARCH']}</h3>";
        $search_dir=sugar_cached('');
        $src_file = $search_dir . 'modules/unified_search_modules.php';
        if(file_exists($src_file)) {
            unlink( "$src_file" );
        }
    }
    public function clearExternalAPICache()
	{
        global $mod_strings, $sugar_config;
        if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEAR_EXT_API']}</h3>";
        
        ExternalAPIFactory::clearCache();
    }
    public function clearPDFFontCache()
	{
        global $mod_strings, $sugar_config;
        if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEARPDFFONT']}</h3>";
        
        $fontManager = new FontManager();
        $fontManager->clearCachedFile();
    }

    /*
     * Catch all function to clear out any misc. caches we may have
     */

    public function clearAdditionalCaches() {
        global $mod_strings, $sugar_config;
		if($this->show_output) echo "<h3>{$mod_strings['LBL_QR_CLEAR_ADD_CACHE']}</h3>";
        // clear out the API Cache
        
        $sd = new ServiceDictionary();
        $sd->clearCache();
        
        // Moving this out so it is accessible without the need to wipe out the 
        // API service dictionary cache 
        $this->clearMetadataAPICache();

        //Remove cached js component files
        $this->_clearCache(sugar_cached('include/javascript/'), '.js');
    }

    /**
     * Clears out the metadata file cache and memory caches
     * 
     * Bug 55141 - Clear the metadata API cache
     */
    public function clearMetadataAPICache() {
        // Bug 55141: Metadata Cache is a Smart cache so we can delete everything from the cache dir
        MetaDataManager::clearAPICache();
        if (empty($this->module_list)) {
            return;
        }
        foreach($this->module_list as $module_name_singular ) {
            $this->_clearCache(sugar_cached('modules/').$this->_getModuleNamePlural($module_name_singular).'/clients', '.php');
        }
    }


	//////////////////////////////////////////////////////////////
	/////REPAIR AUDIT TABLES
	public function rebuildAuditTables()
	{
		global $mod_strings;
		include('include/modules.php');	//bug 15661
		if($this->show_output) echo "<h3> {$mod_strings['LBL_QR_REBUILDAUDIT']}</h3>";

		if(!in_array( translate('LBL_ALL_MODULES'), $this->module_list) && !empty($this->module_list))
		{
			foreach ($this->module_list as $bean_name){
			    $bean = BeanFactory::getBean($bean_name);
				if(!empty($bean)) {
				    $this->_rebuildAuditTablesHelper($bean);
				}
			}
		} else if(in_array(translate('LBL_ALL_MODULES'), $this->module_list)) {
			foreach ($beanFiles as $bean => $file){
			    $bean_instance = BeanFactory::newBeanByName($bean);
				if(!empty($bean_instance)) {
				    $this->_rebuildAuditTablesHelper($bean_instance);
				}
			}
		}
		if($this->show_output) echo $mod_strings['LBL_DONE'];
	}

	private function _rebuildAuditTablesHelper($focus)
	{
		global $mod_strings;

		// skip if not a SugarBean object
		if ( !($focus instanceOf SugarBean) )
		    return;

		if ($focus->is_AuditEnabled()) {
			if (!$focus->db->tableExists($focus->get_audit_table_name())) {
				if($this->show_output) echo $mod_strings['LBL_QR_CREATING_TABLE']." ".$focus->get_audit_table_name().' '.$mod_strings['LBL_FOR'].' '. $focus->object_name.'.<br/>';
				$focus->create_audit_table();
			} else {
				if($this->show_output){
					$echo=str_replace('%1$',$focus->object_name,$mod_strings['LBL_REBUILD_AUDIT_SKIP']);
					echo $echo;
				}
			}
		}else
			if($this->show_output) echo $focus->object_name.$mod_strings['LBL_QR_NOT_AUDIT_ENABLED'];
	}

	///////////////////////////////////////////////////////////////
	////END REPAIR AUDIT TABLES


	///////////////////////////////////////////////////////////////
	//// Recursively unlink all files of the given $extension in the given $thedir.
	//
	private function _clearCache($thedir, $extension)
	{
        if ($current = @opendir($thedir)) {
            while (false !== ($children = readdir($current))) {
                if ($children != "." && $children != "..") {
                    if (is_dir($thedir . "/" . $children)) {
                        $this->_clearCache($thedir . "/" . $children, $extension);
                    }
                    elseif (is_file($thedir . "/" . $children) && (substr_count($children, $extension))) {
                        unlink($thedir . "/" . $children);
                    }
                }
            }
        }
	}
	/////////////////////////////////////////////////////////////
	////////
	private function _getModuleNamePlural($module_name_singular)
	{
		global $beanList;
		while ($curr_module = current($beanList))
		{
			if ($curr_module == $module_name_singular)
				return key($beanList); //name of the module, plural.
			next($beanList);
		}
	}
}
