<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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


require_once 'soap/SoapHelperFunctions.php';
require_once 'modules/ModuleBuilder/parsers/MetaDataFiles.php';
require_once 'include/SugarFields/SugarFieldHandler.php';
require_once 'include/SugarObjects/LanguageManager.php';
require_once 'modules/ActivityStream/Activities/ActivityQueueManager.php';

SugarAutoLoader::requireWithCustom('include/MetaDataManager/MetaDataHacks.php');
/**
 * This class is for access metadata for all sugarcrm modules in a read only
 * state.  This means that you can not modifiy any of the metadata using this
 * class currently.
 *
 *
 * @method Array getData getData() gets all meta data.
 *
 *
 *  "platform": is a bool value which lets you know if the data is for a mobile view, portal or not.
 *
 */
class MetaDataManager
{
    /**
     * The user bean for the logged in user
     *
     * @var User
     */
    protected $user;

    /**
     * Collection of fields in the user metadata that can trigger a reauth when
     * changed.
     *
     * Mapping is 'prefname' => 'metadataname'
     * @var array
     */
    protected $userPrefsToCache = array(
        'datef' => 'datepref',
        'timef' => 'timepref',
        'timezone' => 'timezone',
    );

    /**
     * The metadata hacks class
     * 
     * @var MetaDataHacks
     */
    protected $metaDataHacks;

    /**
     * Stack of flag that tells this class to clear the metadata cache on shutdown
     * of the request. The stack is keyed on whether a delete module client cache
     * was requested or not, so a cache clear will happen no more than twice (and 
     * more than likely will only happen once). 
     * 
     * @var array
     */
    protected static $clearCacheOnShutdown = array();

    /**
     * Indicates the state of the cleared metadata so that subsequent calls to
     * clear the cache in the same request are ignored
     * 
     * @var boolean
     */
    protected static $cacheHasBeenCleared = false;

    /**
     * The constructor for the class.
     *
     * @param User  $user      A User bean
     * @param array $platforms A list of clients
     * @param bool  $public    is this a public metadata grab
     */
    public function __construct ($user, $platforms = null, $public = false)
    {
        if ($platforms == null) {
            $platforms = array('base');
        }

        $this->user = $user;
        $this->platforms = $platforms;
        $className = SugarAutoLoader::customClass('MetaDataHacks');
        $this->metaDataHacks = new $className();
    }

    /**
     * For a specific module get any existing Subpanel Definitions it may have
     * @param string $moduleName
     * @return array
     */
    public function getSubpanelDefs($moduleName)
    {
        require_once 'include/SubPanel/SubPanelDefinitions.php';
        $parent_bean = BeanFactory::getBean($moduleName);
        //Hack to allow the SubPanelDefinitions class to check the correct module dir
        if (!$parent_bean) {
            $parent_bean = (object) array('module_dir' => $moduleName);
        }

        $spd = new SubPanelDefinitions($parent_bean, '', '', $this->platforms[0]);
        $layout_defs = $spd->layout_defs;

        if (is_array($layout_defs) && isset($layout_defs['subpanel_setup'])) {
            foreach ($layout_defs['subpanel_setup'] AS $name => $subpanel_info) {
                $aSubPanel = $spd->load_subpanel($name, '', $parent_bean);

                if (!$aSubPanel) {
                    continue;
                }

                if ($aSubPanel->isCollection()) {
                    $collection = array();
                    foreach ($aSubPanel->sub_subpanels AS $key => $subpanel) {
                        $collection[$key] = $subpanel->panel_definition;
                    }
                    $layout_defs['subpanel_setup'][$name]['panel_definition'] = $collection;
                } else {
                    $layout_defs['subpanel_setup'][$name]['panel_definition'] = $aSubPanel->panel_definition;
                }

            }
        }

        return $layout_defs;
    }

    /**
     * This method collects all view data for a modul
     *
     * @param $moduleName The name of the sugar module to collect info about.
     *
     * @return Array A hash of all of the view data.
     */
    public function getModuleViews($moduleName)
    {
        return $this->getModuleClientData('view',$moduleName);
    }

    /**
     * This method collects all view data for a modul
     *
     * @param $moduleName The name of the sugar module to collect info about.
     *
     * @return Array A hash of all of the view data.
     */
    public function getModuleMenu($moduleName)
    {
        return $this->getModuleClientData('menu',$moduleName);
    }

    /**
     * This method collects all view data for a module
     *
     * @param $moduleName The name of the sugar module to collect info about.
     *
     * @return Array A hash of all of the view data.
     */
    public function getModuleLayouts($moduleName)
    {
        return $this->getModuleClientData('layout', $moduleName);
    }

    /**
     * This method collects all field data for a module
     *
     * @param string $moduleName The name of the sugar module to collect info about.
     *
     * @return Array A hash of all of the view data.
     */
    public function getModuleFields($moduleName)
    {
        return $this->getModuleClientData('field', $moduleName);
    }

    /**
     * This method collects all filter data for a module
     *
     * @param string $moduleName The name of the sugar module to collect info about.
     *
     * @return Array A hash of all of the filter data.
     */
    public function getModuleFilters($moduleName)
    {
        return $this->getModuleClientData('filter', $moduleName);
    }

    /**
     * The collector method for modules.  Gets metadata for all of the module specific data
     *
     * @param $moduleName The name of the module to collect metadata about.
     * @return array An array of hashes containing the metadata.  Empty arrays are
     * returned in the case of no metadata.
     */
    public function getModuleData($moduleName)
    {
        require_once 'include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php';
        $vardefs = $this->getVarDef($moduleName);
        if (!empty($vardefs['fields']) && is_array($vardefs['fields'])) {
            require_once 'include/MassUpdate.php';
            $vardefs['fields'] = MassUpdate::setMassUpdateFielddefs($vardefs['fields'], $moduleName);
        }

        $data['fields'] = isset($vardefs['fields']) ? $vardefs['fields'] : array();
        $data['views'] = $this->getModuleViews($moduleName);
        $data['layouts'] = $this->getModuleLayouts($moduleName);
        $data['fieldTemplates'] = $this->getModuleFields($moduleName);
        $data['subpanels'] = $this->getSubpanelDefs($moduleName);
        $data['menu'] = $this->getModuleMenu($moduleName);
        $data['config'] = $this->getModuleConfig($moduleName);
        $data['filters'] = $this->getModuleFilters($moduleName);

        // Indicate whether Module Has duplicate checking enabled --- Rules must exist and Enabled flag must be set
        $data['dupCheckEnabled'] = isset($vardefs['duplicate_check']) && isset($vardefs['duplicate_check']['enabled']) && ($vardefs['duplicate_check']['enabled']===true);

        // Indicate whether a Module has activity stream enabled
        $data['activityStreamEnabled'] = ActivityQueueManager::isEnabledForModule($moduleName);
        $data['ftsEnabled'] = SugarSearchEngineMetadataHelper::isModuleFtsEnabled($moduleName);

        // TODO we need to have this kind of information on the module itself not hacked around on globals
        $data['isBwcEnabled'] = in_array($moduleName, $GLOBALS['bwcModules']);

        $seed = BeanFactory::newBean($moduleName);
        $data['globalSearchEnabled'] = $this->getGlobalSearchEnabled($seed, $vardefs, $this->platforms[0]);

        if (!empty($seed)) {
            $favoritesEnabled = ($seed->isFavoritesEnabled() !== false) ? true : false;
            $data['favoritesEnabled'] = $favoritesEnabled;
        }

        $data["_hash"] = md5(serialize($data));

        return $data;
    }

    /**
     * Helper to determine if vardef for module has global search enabled or not.
     * @param  array   $seed     the new bean created from module name passed to BeanFactory::newBean
     * @param  array   $vardefs  The vardefs
     * @param  string  $platform The platform
     * @return boolean indicating whether or not global search is enabled
     */
    public function getGlobalSearchEnabled($seed, $vardefs, $platform = null)
    {
        if (empty($platform)) {
            $platform = $this->platforms[0];
        }
        // Is the argument set for this module
        if (isset($vardefs['globalSearchEnabled'])) {
            // Is it an array of platforms or a simple boolean
            if (is_array($vardefs['globalSearchEnabled'])) {
                // if the platform is set use that value; otherwise check if set in 'base'; lastly, fallback to true
                if (isset($vardefs['globalSearchEnabled'][$platform])) {
                    return $vardefs['globalSearchEnabled'][$platform];
                } else {
                    // Check if global search enabled set on the base platform. If so, and not set for platform at all, we've decided that we should fall back to base's value
                    return isset($vardefs['globalSearchEnabled']['base']) ? $vardefs['globalSearchEnabled']['base'] : true;
                }
            } else {
                // If a simple boolean we return that as it defines whether search enabled globally across all platforms
                return $vardefs['globalSearchEnabled'];
            }
        }
        // If globalSearchEnabled property not set, we check if valid bean (all "real" beans are, by default, global search enabled)
        return !empty($seed);
    }

    /**
     * Get the config for a specific module from the Administration Layer
     *
     * @param  string $moduleName The Module we want the data back for.
     * @return array
     */
    public function getModuleConfig($moduleName)
    {
        /* @var $admin Administration */
        $admin = BeanFactory::getBean('Administration');

        return $admin->getConfigForModule($moduleName, $this->platforms[0]);
    }

    /**
     * The collector method for relationships.
     *
     * @return array An array of relationships, indexed by the relationship name
     */
    public function getRelationshipData()
    {
        $relFactory = SugarRelationshipFactory::getInstance();

        $data = $relFactory->getRelationshipDefs();
        foreach ($data as $relKey => $relData) {
            unset($data[$relKey]['table']);
            unset($data[$relKey]['fields']);
            unset($data[$relKey]['indices']);
            unset($data[$relKey]['relationships']);
        }

        $data["_hash"] = md5(serialize($data));

        return $data;
    }

    /**
     * Gets vardef info for a given module.
     *
     * @param $moduleName The name of the module to collect vardef information about.
     * @return array The vardef's $dictonary array.
     */
    public function getVarDef($moduleName)
    {
        require_once 'data/BeanFactory.php';
        $obj = BeanFactory::getObjectName($moduleName);

        if ($obj) {
            require_once 'include/SugarObjects/VardefManager.php';
            global $dictionary;
            VardefManager::loadVardef($moduleName, $obj);
            if (isset($dictionary[$obj])) {
                $data = $dictionary[$obj];
            }

            // vardefs are missing something, for consistency let's populate some arrays
            if (!isset($data['fields'])) {
                $data['fields'] = array();
            }
            if (!isset($data['relationships'])) {
                $data['relationships'] = array();
            }
            if(!isset($data['fields'])) {
                $data['fields'] = array();
            }
        }

        // Bug 56505 - multiselect fields default value wrapped in '^' character
        if (!empty($data['fields'])) {
            $data['fields'] = $this->metaDataHacks->normalizeFieldDefs($data['fields']);
        }

        if (!isset($data['relationships'])) {
            $data['relationships'] = array();
        }

        return $data;
    }

    /**
     * Gets the ACL's for the module, will also expand them so the client side of the ACL's don't have to do as many checks.
     *
     * @param  string $module     The module we want to fetch the ACL for
     * @param  object $userObject The user object for the ACL's we are retrieving.
     * @param  object|bool $bean       The SugarBean for getting specific ACL's for a module
     * @param bool $showYes Do not unset Yes Results
     * @return array       Array of ACL's, first the action ACL's (access, create, edit, delete) then an array of the field level acl's
     */
    public function getAclForModule($module, $userObject, $bean = false, $showYes = false)
    {
        $outputAcl = array('fields' => array());
        $outputAcl['admin'] = ($userObject->isAdminForModule($module)) ? 'yes' : 'no';
        $outputAcl['developer'] = ($userObject->isDeveloperForModule($module)) ? 'yes' : 'no';

        if (!SugarACL::moduleSupportsACL($module)) {
            foreach (array('access', 'view', 'list', 'edit', 'delete', 'import', 'export', 'massupdate') as $action) {
                $outputAcl[$action] = 'yes';
            }
        } else {
            $context = array(
                'user' => $userObject,
            );
            if ($bean instanceof SugarBean) {
                $context['bean'] = $bean;
            }

            // if the bean is not set, or a new bean.. set the owner override
            // this will allow fields marked Owner to pass through ok.
            if ($bean == false || empty($bean->id) || (isset($bean->new_with_id) && $bean->new_with_id == true)) {
                $context['owner_override'] = true;
            }

            $moduleAcls = SugarACL::getUserAccess($module, array(), $context);

            // Bug56391 - Use the SugarACL class to determine access to different actions within the module
            foreach (SugarACL::$all_access as $action => $bool) {
                $outputAcl[$action] = ($moduleAcls[$action] == true || !isset($moduleAcls[$action])) ? 'yes' : 'no';
            }

            // Only loop through the fields if we have a reason to, admins give full access on everything, no access gives no access to anything
            if ($outputAcl['access'] == 'yes') {
                // Currently create just uses the edit permission, but there is probably a need for a separate permission for create
                $outputAcl['create'] = $outputAcl['edit'];

                if ($bean === false) {
                    $bean = BeanFactory::newBean($module);
                }

                // we cannot use ACLField::getAvailableFields because it limits the fieldset we return.  We need all fields
                // for instance assigned_user_id is skipped in getAvailableFields, thus making the acl's look odd if Assigned User has ACL's
                // only assigned_user_name is returned which is a derived ["fake"] field.  We really need assigned_user_id to return as well.
                if (empty($GLOBALS['dictionary'][$bean->object_name]['fields'])) {
                    if (empty($bean->acl_fields)) {
                        $fieldsAcl = array();
                    } else {
                        $fieldsAcl = $bean->field_defs;
                    }
                } else {
                    $fieldsAcl = $GLOBALS['dictionary'][$bean->object_name]['fields'];
                    if (isset($GLOBALS['dictionary'][$bean->object_name]['acl_fields']) && $GLOBALS['dictionary'][$bean->object_name] === false) {
                        $fieldsAcl = array();
                    }
                }
                // get the field names

                SugarACL::listFilter($module, $fieldsAcl, $context, array('add_acl' => true));
                $fieldsAcl = $this->metaDataHacks->fixAcls($fieldsAcl);
                foreach ($fieldsAcl as $field => $fieldAcl) {
                    switch ($fieldAcl['acl']) {
                        case SugarACL::ACL_READ_WRITE:
                            // Default, don't need to send anything down
                            break;
                        case SugarACL::ACL_READ_ONLY:
                            $outputAcl['fields'][$field]['write'] = 'no';
                            $outputAcl['fields'][$field]['create'] = 'no';
                            break;
                        case 2:
                            $outputAcl['fields'][$field]['read'] = 'no';
                            break;
                        case SugarACL::ACL_NO_ACCESS:
                        default:
                            $outputAcl['fields'][$field]['read'] = 'no';
                            $outputAcl['fields'][$field]['write'] = 'no';
                            $outputAcl['fields'][$field]['create'] = 'no';
                            break;
                    }
                }
            }
        }
        // there are times when we need the yes results, for instance comparing access for a record
        if ($showYes === false) {
            // for brevity, filter out 'yes' fields since UI assumes 'yes'
            foreach ($outputAcl as $k => $v) {
                if ($v == 'yes') {
                    unset($outputAcl[$k]);
                }
            }
        }
        $outputAcl['_hash'] = md5(serialize($outputAcl));

        return $outputAcl;
    }

    /**
     * Fields accessor, gets sugar fields
     *
     * @return array array of sugarfields with a hash
     */
    public function getSugarFields()
    {
        return $this->getSystemClientData('field');
    }

    /**
     * Views accessor Gets client views
     *
     * @return array
     */
    public function getSugarViews()
    {
        return $this->getSystemClientData('view');
    }

    /**
     * Gets client layouts, similar to module specific layouts except used on a
     * global level by the clients consuming this data
     *
     * @return array
     */
    public function getSugarLayouts()
    {
        return $this->getSystemClientData('layout');
    }

    /**
     * Gets client files of type $type (view, layout, field) for a module or for the system
     *
     * @param  string $type   The type of files to get
     * @param  string $module Module name (leave blank to get the system wide files)
     * @return array
     */
    public function getSystemClientData($type)
    {
        // This is a semi-complicated multi-step process, so we're going to try and make this as easy as possible.
        // This should get us a list of the client files for the system
        $fileList = MetaDataFiles::getClientFiles($this->platforms, $type);

        // And this should get us the contents of those files, properly sorted and everything.
        $results = MetaDataFiles::getClientFileContents($fileList, $type);

        return $results;
    }

    public function getModuleClientData($type, $module)
    {
        return MetaDataFiles::getModuleClientCache($this->platforms, $type, $module);
    }

    /**
     * The collector method for the module strings
     *
     * @param  string $moduleName The name of the module
     * @param  string $language   The language for the translations
     * @return array  The module strings for the requested language
     */
    public function getModuleStrings( $moduleName, $language = 'en_us' )
    {
        // Bug 58174 - Escaped labels are sent to the client escaped
        // TODO: SC-751, fix the way languages merge
        $strings = return_module_language($language,$moduleName);
        if (is_array($strings)) {
            foreach ($strings as $k => $v) {
                $strings[$k] = $this->decodeStrings($v);
            }
        }

        return $strings;
    }

    /**
     * The collector method for the app strings
     *
     * @param  string $lang The language you wish to fetch the app strings for
     * @return array  The app strings for the requested language
     */
    public function getAppStrings($lang = 'en_us' )
    {
        $strings = return_application_language($lang);
        if (is_array($strings)) {
            foreach ($strings as $k => $v) {
                $strings[$k] = $this->decodeStrings($v);
            }
        }

        return $strings;
    }

    /**
     * The collector method for the app strings
     *
     * @param  string $lang The language you wish to fetch the app list strings for
     * @return array  The app list strings for the requested language
     */
    public function getAppListStrings($lang = 'en_us')
    {
        $strings = return_app_list_strings_language($lang);
        if (is_array($strings)) {
            foreach ($strings as $k => $v) {
                $strings[$k] = $this->decodeStrings($v);
            }
        }

        return $strings;
    }


    public static function getPlatformList()
    {
        $platforms = array();
        // remove ones with _
        foreach (SugarAutoLoader::getFilesCustom("clients", true) as $dir) {
            $dir = basename($dir);
            if ($dir[0] == '_') {
                continue;
            }
            $platforms[$dir] = true;
        }

        return array_keys($platforms);
    }

    /**
     * Recursive decoder that handles decoding of HTML entities in metadata strings
     * before returning them to a client
     *
     * @param  mixed        $source
     * @return array|string
     */
    protected function decodeStrings($source)
    {
        if (is_string($source)) {
            return html_entity_decode($source, ENT_QUOTES, 'UTF-8');
        } else {
            if (is_array($source)) {
                foreach ($source as $k => $v) {
                    $source[$k] = $this->decodeStrings($v);
                }
            }

            return $source;
        }
    }

    /**
     * Registers the API metadata cache to be cleared at shutdown
     *
     * @param bool $deleteModuleClientCache Should we also delete the client file cache of the modules
     * @static
     */
    public static function clearAPICache( $deleteModuleClientCache = true )
    {
        // True/false stack for handling both client cache cases
        $key = $deleteModuleClientCache ? 1 : 0;

        // If we are in unit tests we need to fire this off right away
        if (defined('SUGAR_PHPUNIT_RUNNER') && SUGAR_PHPUNIT_RUNNER === true) {
            self::clearAPICacheOnShutdown($deleteModuleClientCache);
        } elseif (($key === 0 && empty(self::$clearCacheOnShutdown)) || !isset(self::$clearCacheOnShutdown[$key])) {
            // Will only clear cache if 
            //  - A) delete module cache is false and there is no stack of clears, OR
            //  - B) delete module cache is true and it hasn't already been called with true
            // 
            // This prevents calling this once each for true and false when a true
            // would handle what a false would anyway
            register_shutdown_function(array('MetaDataManager', 'clearAPICacheOnShutdown'), $deleteModuleClientCache, getcwd());
            self::$clearCacheOnShutdown[$key] = true;
        }
    }
    
    /**
     * Clears the API metadata cache of all cache files
     *
     * @param bool $deleteModuleClientCache Should we also delete the client file cache of the modules
     * @param string $workingDirectory directory to chdir into before starting the clears
     * @static
     */
    public static function clearAPICacheOnShutdown($deleteModuleClientCache = true, $workingDirectory = "")
    {
        if (!self::getCacheHasBeenCleared()) {
            //shutdown functions are not always called from the same working directory as the script that registered it
            //Need to chdir to ensure we can find the correct files
            if (!empty($workingDirectory)) {
                chdir($workingDirectory);
            }
    
    
            if ($deleteModuleClientCache) {
                // Delete this first so there is no race condition between deleting a metadata cache
                // and the module client cache being stale.
                MetaDataFiles::clearModuleClientCache();
            }

            // Wipe out any files from the metadata cache directory
            $metadataFiles = glob(sugar_cached('api/metadata/').'*');
            if ( is_array($metadataFiles) ) {
                foreach ($metadataFiles as $metadataFile) {
                    // This removes the file and the reference from the map. This does
                    // NOT save the file map since that would be expensive in a loop
                    // of many deletes.
                    unlink($metadataFile);
                }
            }

            // clear the platform cache from sugar_cache to avoid out of date data as well as platform component files
            $platforms = self::getPlatformList();
            foreach ($platforms as $platform) {
                $platformKey = $platform == "base" ?  "base" : implode(",", array($platform, "base"));
                $hashKey = "metadata:$platformKey:hash";
                sugar_cache_clear($hashKey);
                $jsFiles = glob(sugar_cached("javascript/{$platform}/").'*');
                if (is_array($jsFiles) ) {
                    foreach ($jsFiles as $jsFile) {
                        unlink($jsFile);
                    }
                }
            }
        }
    }

    /**
     * Gets server information
     *
     * @return array of ServerInfo
     */
    public function getServerInfo()
    {
        global $system_config;
        $data['flavor'] = $GLOBALS['sugar_flavor'];
        $data['version'] = $GLOBALS['sugar_version'];
        $data['build'] = $GLOBALS['sugar_build'];
        // Product Name for Professional edition.
        $data['product_name'] = "SugarCRM Professional";
        if (file_exists('custom/version.php')) {
            include 'custom/version.php';
            $data['custom_version'] = $custom_version;
        }

        if(isset($system_config->settings['system_skypeout_on']) && $system_config->settings['system_skypeout_on'] == 1){
            $data['system_skypeout_on'] = true;
        }
        $fts_enabled = SugarSearchEngineFactory::getFTSEngineNameFromConfig();
        if (!empty($fts_enabled) && $fts_enabled != 'SugarSearchEngine') {
            $data['fts'] = array(
                'enabled' => true,
                'type' => $fts_enabled,
            );
        } else {
            $data['fts'] = array(
                'enabled' => false,
            );
        }


        return $data;
    }

    /**
     * Checks the validity of the current session metadata hash value. Since the
     * only time the session value is set is after a metadata fetch has been made
     * a non-existent session value is valid. However if there is a session value
     * then there either has to be a metadata cache of hashes to check against
     * or the session value has to be false (meaning the session value was set
     * before the metadata cache was built) in order to pass the validity check.
     *
     * @param string   $hash Metadata hash to validate against the cache.
     * @param  string  $platform The platform to check the metadata hash against
     *
     * @return boolean
     */
    public function isMetadataHashValid($hash, $platform = null)
    {
        // Get the current platform if one wasn't presented
        if (empty($platform)) {
            $platform = is_array($this->platforms) ? $this->platforms[0] : $this->platforms;
        }

        //Merge the current platform with base
        if ($platform != "base") {
            $platform = "{$platform}_base";
        }

        // Is there a current metadata hash sent in the request (empty string is not a valid hash)
        if (!empty($hash)) {
            // See if there is a hash cache. If there is, see if the hash cache
            // for this platform matches what's in the session, ensuring that the
            // session value isn't false (the default value when setting from
            // cache)

            //Using @include for speed reasons since this will occur on every request
            //and the file will almost always exist
            @include sugar_cached("api/metadata/hashes.php");
            if (!empty($hashes)) {
                // Valid is either a platform hash that matches the session hash
                // OR no platform hash and no session hash
                $platformHash = empty($hashes['meta_hash_' . $platform]) ? null : $hashes['meta_hash_' . $platform];
                if (!empty($platformHash)) {
                    // The system status hash is caculated so we only need
                    // the old hash and the system status
                    $systemStatus = apiCheckSystemStatus();
                    if ($systemStatus !== true) {
                        $platformHash = md5($platformHash.serialize($systemStatus));
                    }
                }

                return ($platformHash && $platformHash == $hash);
            } else {
                //If the cache file doesn't exist, we have no way to know if the current hash is correct
                //and most likely the cache file was nuked due to a metadata change so the cleint
                //needs to hit the metadata api anyhow.
                return false;
            }
        }

        // There is no session var so we say we're good so as not to get stuck in
        // a continual logout loop
        return true;
    }

    /**
     * Tells the app the user preference metadata has changed.
     * 
     * For now this will be done by simply changing the date_modified on the User
     * record and using that as the metadata hash value. This could change in the
     * future.
     *
     * @param Person $user The user that is changing preferences
     */
    public function setUserMetadataHasChanged($user)
    {
        $user->update_date_modified = true;
        $user->save();
    }

    /**
     * Checks the state of changed metadata for a user
     *
     * @param Person $user The user that is changing preferences
     * @param string $hash The user preference data hash to compare
     *
     * @return bool
     */
    public function hasUserMetadataChanged($user, $hash)
    {
       return $user->getUserMDHash() != $hash;
    }

    /**
     * Gets all enabled and disabled languages. Wraps the util function to allow
     * for manipulation of the return in the future.
     * 
     * @return array Array of enabled and disabled languages
     */
    public function getAllLanguages()
    {
        $languages = LanguageManager::getEnabledAndDisabledLanguages();

        return array(
            'enabled' => $this->getLanguageKeys($languages['enabled']), 
            'disabled' => $this->getLanguageKeys($languages['disabled']),
        );
    }

    /**
     * Gets language keys only. Used by the API in conjunction with language indexes
     * from app_list_strings.
     * 
     * @param array $language An enabled or disabled language array
     * @return array
     */
    protected function getLanguageKeys($language)
    {
        $return = array();
        foreach ($language as $lang) {
            $return[] = $lang['module'];
        }
        return $return;
    }

    /**
     * Sets the flag that lets the metadata manager know NOT to clear the cache 
     * again. Used in cases where the cache was nuked for some reason and the 
     * metadata endpoint was hit, rebuilding certain caches which destroy the 
     * metadata again.
     */
    public static function setCacheHasBeenCleared()
    {
        self::$cacheHasBeenCleared = true;
    }

    /**
     * Gets the flag that indicates whether the metadata manager has cleared the
     * cache on this request.
     * 
     * @return bool
     */
    public static function getCacheHasBeenCleared() 
    {
        return self::$cacheHasBeenCleared;
    }
}
