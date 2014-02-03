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


require_once 'include/MetaDataManager/MetaDataManager.php';
require_once 'include/api/SugarApi.php';

// An API to let the user in to the metadata
class MetadataApi extends SugarApi
{

    /**
     * @var array List of metadata keys for values that should be overriden rather than
     * merged client side with existing metadata .
     */
    protected static $defaultOverrides = array(
        'fields',
        'module_list',
        'relationships',
        'currencies',
        'server_info',
        'module_tab_map',
        'hidden_subpanels',
        'config',
    );

    /**
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'getAllMetadata' => array(
                'reqType' => 'GET',
                'path' => array('metadata'),
                'pathVars' => array(''),
                'method' => 'getAllMetadata',
                'shortHelp' => 'This method will return all metadata for the system',
                'longHelp' => 'include/api/html/metadata_all_help.html',
                'noEtag' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'getAllMetadataPost' => array(
                'reqType' => 'POST',
                'path' => array('metadata'),
                'pathVars' => array(''),
                'method' => 'getAllMetadata',
                'shortHelp' => 'This method will return all metadata for the system, filtered by the array of hashes sent to the server',
                'longHelp' => 'include/api/html/metadata_all_help.html',
                'noEtag' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'getAllMetadataHashes' => array(
                'reqType' => 'GET',
                'path' => array('metadata','_hash'),
                'pathVars' => array(''),
                'method' => 'getAllMetadataHash',
                'shortHelp' => 'This method will return the hash of all metadata for the system',
                'longHelp' => 'include/api/html/metadata_all_help.html',
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'getPublicMetadata' =>  array(
                'reqType' => 'GET',
                'path' => array('metadata','public'),
                'pathVars'=> array(''),
                'method' => 'getPublicMetadata',
                'shortHelp' => 'This method will return the metadata needed when not logged in',
                'longHelp' => 'include/api/html/metadata_all_help.html',
                'noLoginRequired' => true,
                'noEtag' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'getLegacyMetadata' => array(
                'reqType' => 'GET',
                'path' =>array('metadata', 'legacy'),
                'pathVars' => array(''),
                'method' => 'getLegacyMetadata',
                'shortHelp' => 'This method will return the metadata for BWC modules',
            ),
            'getLanguage' => array(
                'reqType' => 'GET',
                'path' => array('lang', '?'),
                'pathVars' => array('', 'lang'),
                'method' => 'getLanguage',
                'shortHelp' => 'Returns the labels for the application',
                'longHelp' => 'include/api/html/metadata_all_help.html',
                'noLoginRequired' => true,
                'rawReply' => true,
                'noEtag' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'getPublicLanguage' => array(
                'reqType' => 'GET',
                'path' => array('lang', 'public', '?'),
                'pathVars' => array('', '', 'lang'),
                'method' => 'getPublicLanguage',
                'shortHelp' => 'Returns the public labels for the application',
                'longHelp' => 'include/api/html/metadata_all_help.html',
                'noLoginRequired' => true,
                'rawReply' => true,
                'noEtag' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
        );
    }

    protected function getMetadataManager( $public = false )
    {
        static $mm;
        if ( !isset($mm) ) {
            $mm = new MetaDataManager(null,$this->platforms, $public);
        }

        return $mm;
    }

    public function getAllMetadata(ServiceBase $api, array $args)
    {
        global $current_language, $app_strings, $app_list_strings, $current_user;

        $this->setPlatformList($api);

        // We need to see if we need to send any warnings down to the user
        $systemStatus = apiCheckSystemStatus();
        if ($systemStatus !== true) {
            // Something is up with the system status
            // We need to tack it on and refresh the hash
            $data = $this->loadPrivateMetadata($args, $this->platforms[0]);
            if ($this->getCachedMetadataHash() != $data['_hash']) {
                $this->cacheMetadataHash($data['_hash']);
            }
            $data['config']['system_status'] = $systemStatus;
            $data['_hash'] = md5($data['_hash'].serialize($systemStatus));
            $hash = $data['_hash'];
        } else {
            $hash = $this->getCachedMetadataHash();
        }

        if (!empty($hash) && $api->generateETagHeader($hash)) {
            return;
        }

        // asking for a specific language
        if (isset($args['lang']) && !empty($args['lang'])) {
            $current_language = $args['lang'];
            $app_strings = return_application_language($current_language);
            $app_list_strings = return_app_list_strings_language($current_language);

        }
        // Default the type filter to everything
        $this->typeFilter = array(
            'modules',
            'full_module_list',
            'fields',
            'labels',
            'module_list',
            'views',
            'layouts',
            'relationships',
            'currencies',
            'jssource',
            'server_info',
            'module_tab_map',
            'hidden_subpanels',
            'config',
            'languages',
        );

        if ( !empty($args['type_filter']) ) {
            // Explode is fine here, we control the list of types
            $types = explode(",", $args['type_filter']);
            if ($types != false) {
                $this->typeFilter = $types;
            }
        }

        $moduleFilter = array();
        if (!empty($args['module_filter'])) {
            if ( function_exists('str_getcsv') ) {
                // Use str_getcsv here so that commas can be escaped, I pity the fool that has commas in his module names.
                $modules = str_getcsv($args['module_filter'],',','');
            } else {
                $modules = explode(",", $args['module_filter']);
            }
            if ($modules != false) {
                $moduleFilter = $modules;
            }
        }

        $onlyHash = false;
        if (!empty($args['only_hash']) && ($args['only_hash'] == 'true' || $args['only_hash'] == '1')) {
            $onlyHash = true;
        }

        if (empty($data)) {
            $data = $this->loadPrivateMetadata($args, $this->platforms[0]);
        }

        if (empty($hash) || $hash != $data['_hash']) {
            $this->cacheMetadataHash($data['_hash']);
            if ($api->generateETagHeader($data['_hash'])) {
                return;
            }
        }

        $baseChunks = array(
            'fields',
            'labels',
            'module_list',
            'views',
            'layouts',
            'full_module_list',
            'relationships',
            'currencies',
            'jssource',
            'server_info',
            'module_tab_map',
            'hidden_subpanels',
            'config',
            'languages',
        );
        $perModuleChunks = array('modules');

        return $this->filterResults($args, $data, $onlyHash, $baseChunks, $perModuleChunks, $moduleFilter);
    }

    // This function loads the metadata from cache, or builds the cache if it doesn't exist
    protected function loadPrivateMetadata($args, $platform)
    {
        $data = $this->getMetadataCache($platform, false);

        //If we failed to load the metadata from cache, load it now the hard way.
        if (empty($data)) {
            ini_set('max_execution_time', 0);
            $data = $this->loadMetadata($args);

            // Bug 60345 - Default currency id of -99 was failing hard on 64bit 5.2.X
            // PHP builds. This was causing metadata to store a different value in the
            // cache than -99. The fix was to add a space arround the -99 to force it
            // to string. This trims that value prior to sending it to the client.
            $data = $this->normalizeCurrencyIds($data);

            $this->putMetadataCache($data, $platform, false);
        }

        return $data;
    }

    /**
     * Retrieves legacy (Sugar 6.x) metadata.
     * @deprecated Will be removed in SugarCRM 7.2 (or whenever all modules are
     * ported to Sidecar).
     * @param  ServiceBase $api
     * @param  array       $args
     * @return array
     */
    public function getLegacyMetadata(ServiceBase $api, array $args)
    {
        if (empty($args['type'])) {
            throw new SugarApiExceptionMissingParameter('Missing parameter "type".');
        }

        if (empty($args['module'])) {
            throw new SugarApiExceptionMissingParameter('Missing parameter "module".');
        }

        if (!isModuleBWC($args['module'])) {
            throw new SugarApiExceptionInvalidParameter('Module "' . $args['module'] . '" is not in backwards compatibility.');
        }

        $typeVariableMapping = array(
            // Add as needed (hopefully, we don't rely on BWC even more).
            'listviewdefs' => 'listViewDefs',
        );

        if (!isset($typeVariableMapping[$args['type']])) {
            throw new SugarApiExceptionInvalidParameter('Type "' . $args['module'] . '" is not in in the metadata-type whitelist.');
        }

        $file = SugarAutoLoader::loadWithMetafiles($args['module'], $args['type']);

        if (is_null($file)) {
            throw new SugarApiExceptionNotFound($args['type'] . ' metadata was not found for the ' . $args['module'] . ' module.');
        }

        require $file;

        return $$typeVariableMapping[$args['type']];
    }

    // this is the function for the endpoint of the public metadata api.
    public function getPublicMetadata($api, $args)
    {
        $configs = array();

        // right now we are getting the config only for the portal
        // Added an isset check for platform because with no platform set it was
        // erroring out. -- rgonzalez
        $this->setPlatformList($api);

        // Default the type filter to everything available to the public, no module info at this time
        $this->typeFilter = array('fields','labels','views', 'layouts', 'config', 'jssource');

        if ( !empty($args['type_filter']) ) {
            // Explode is fine here, we control the list of types
            $types = explode(",", $args['type_filter']);
            if ($types != false) {
                $this->typeFilter = $types;
            }
        }

        $onlyHash = false;

        if (!empty($args['only_hash']) && ($args['only_hash'] == 'true' || $args['only_hash'] == '1')) {
            $onlyHash = true;
        }

        // We need to see if we need to send any warnings down to the user
        $systemStatus = apiCheckSystemStatus();
        if ($systemStatus !== true) {
            // Something is up with the system status
            // We need to tack it on and refresh the hash
            $data = $this->loadPublicMetadata($args);
            $data['config']['system_status'] = $systemStatus;
            unset($data['_hash']);
            $data['_hash'] = md5(serialize($data));
            $hash = $data['_hash'];
        } else {
            $hash = $this->getCachedMetadataHash(true);
        }

        if (!empty($hash) && $api->generateETagHeader($hash)) {
            return;
        }

        if (!isset($data)) {
            $data = $this->loadPublicMetadata($args);
        }

        if (!empty($data['_hash']) && $api->generateETagHeader($data['_hash'])) {
            return;
        }

        $baseChunks = array('fields','labels','views', 'layouts', 'config', 'jssource');

        return $this->filterResults($args, $data, $onlyHash, $baseChunks);
    }

    /**
     * This function loads public metadata, either from cache, or from building it
     *
     * @return array A giant pile of metadata
     */
    protected function loadPublicMetadata($args)
    {
        $data = $this->getMetadataCache($this->platforms[0],true);

        if (empty($data)) {
            $themeObject = SugarThemeRegistry::current();
            // since this is a public metadata call pass true to the meta data manager to only get public/
            $mm = $this->getMetadataManager( true );

            // Start collecting data
            $data = array();

            $data['fields']   = $mm->getSugarFields();
            $data['views']    = $mm->getSugarViews();
            $data['layouts']  = $mm->getSugarLayouts();
            $data['labels']   = $this->getStringUrls($data,true);
            $data['modules']  = array("Login" => array("fields" => array()));
            $data['config']   = $this->getConfigs();
            $data['jssource'] = $this->buildJSFileFromMD($data, $this->platforms[0]);
            $data['_override_values'] = $this->getOverrides($data, $args);
            $data['logo_url'] = $themeObject->getImageURL('company_logo.png');
            $data["_hash"] = md5(serialize($data));

            $this->putMetadataCache($data, $this->platforms[0], true);
            $this->cacheMetadataHash($data['_hash'], true);
        }

        return $data;
    }

    protected function buildJSFileFromMD(&$data, $platform, $onlyReturnModuleComponents = false)
    {
        $js = "(function(app) {\n SUGAR.jssource = {";


        $compJS = $this->buildJSForComponents($data);
        if (!$onlyReturnModuleComponents) {
            $js .= $compJS;
        }

        if (!empty($data['modules'])) {
            if (!empty($compJS) && !$onlyReturnModuleComponents)
                $js .= ",";

            $js .= "\n\t\"modules\":{";

            $allModuleJS = '';
            foreach ($data['modules'] as $module => $def) {
                $moduleJS = $this->buildJSForComponents($def,true);
                if (!empty($moduleJS)) {
                    $allModuleJS .= ",\n\t\t\"$module\":{{$moduleJS}}";
                }
            }
            //Chop off the first comma in $allModuleJS
            $js .= substr($allModuleJS, 1);
            $js .= "\n\t}";
        }

        $js .= "}})(SUGAR.App);";
        $hash = md5($js);
        //If we are going to be using uglify to minify our JS, we should minify the entire file rather than each component separately.
        if (!inDeveloperMode() && SugarMin::isMinifyFast()) {
            $js = SugarMin::minify($js);
        }
        $path = "cache/javascript/$platform/components_$hash.js";
        if (!file_exists($path)) {
            mkdir_recursive(dirname($path));
            sugar_file_put_contents_atomic($path, $js);
        }

        return $this->getUrlForCacheFile($path);
    }

    protected function buildJSForComponents(&$data, $isModule = false)
    {
        $js = "";
        $platforms = array_reverse($this->platforms);

        $typeData = array();

        if ($isModule) {
            $types = array('fieldTemplates', 'views', 'layouts');
        } else {
            $types = array('fields', 'views', 'layouts');
        }

        foreach ($types as $mdType) {

            if (!empty($data[$mdType])) {
                $platControllers = array();

                foreach ($data[$mdType] as $name => $component) {
                    if ( !is_array($component) || !isset($component['controller']) ) {
                        continue;
                    }
                    $controllers = $component['controller'];

                    if (is_array($controllers) ) {
                        foreach ($platforms as $platform) {
                            if (!isset($controllers[$platform])) {
                                continue;
                            }
                            $controller = $controllers[$platform];
                            // remove additional symbols in end of js content - it will be included in content
                            $controller = trim(trim($controller), ",;");
                            $controller = $this->insertHeaderComment($controller, $mdType, $name, $platform);

                            if ( !isset($platControllers[$platform]) ) {
                                $platControllers[$platform] = array();
                            }
                            $platControllers[$platform][] = "\"$name\": {\"controller\": ".$controller." }";

                        }
                    }
                    unset($data[$mdType][$name]['controller']);
                }

                // We should have all of the controllers for this type, split up by platform
                $thisTypeStr = "\"$mdType\": {\n";

                foreach ($platforms as $platform) {
                    if ( isset($platControllers[$platform]) ) {
                        $thisTypeStr .= "\"$platform\": {\n".implode(",\n",$platControllers[$platform])."\n},\n";
                    }
                }

                $thisTypeStr = trim($thisTypeStr,"\n,")."}\n";
                $typeData[] = $thisTypeStr;
            }
        }

        $js = implode(",\n",$typeData)."\n";

        return $js;

    }

    // Helper to insert header comments for controllers
    protected function insertHeaderComment($controller, $mdType, $name, $platform)
    {
        $singularType = substr($mdType, 0, -1);
        $needle = '({';
        $headerComment = "\n\t// " . ucfirst($name) ." ". ucfirst($singularType) . " ($platform) \n";

        // Find position "after" needle
        $pos = (strpos($controller, $needle) + strlen($needle));

        // Insert our comment and return ammended controller
        return substr($controller, 0, $pos) . $headerComment . substr($controller, $pos);
    }

    protected function loadMetadata(array $args)
    {
        $themeObject = SugarThemeRegistry::current();

        // Start collecting data
        $data = $this->_populateModules(array());
        $mm = $this->getMetadataManager();

        // BR-29 Handle hidden subpanels - SubPanelDefinitons needs a bean at
        // construct time, so hand it an admin bean. This returns a list of
        // hidden subpanels in lowercase module name form:
        // array('accounts', 'bugs', 'contacts');
        $spd = new SubPanelDefinitions(BeanFactory::getBean('Administration'));
        $data['hidden_subpanels'] = array_values($spd->get_hidden_subpanels());

        // TODO:
        // Sadly, it's now unclear what our abstraction is here. It should be that this class
        // is just for API stuff and $mm is for any metadata data operations. However, since
        // we now have child classes like MetadataPortalApi overriding getModules, etc., I'm
        // tentative to push the following three calls out to $mm. I propose refactor to instead
        // inherit as MetadataPortalDataManager and put all accessors, etc., there.
        $data['currencies'] = $this->getSystemCurrencies();

        foreach ($data['modules'] as $moduleName => $moduleDef) {
            if (!array_key_exists($moduleName, $data['full_module_list']) && array_key_exists($moduleName, $data['modules'])) {
                unset($data['modules'][$moduleName]);
            }
        }

        $data['full_module_list']['_hash'] = md5(serialize($data['full_module_list']));

        $data['module_tab_map'] = $this->getModuleTabMap();
        $data['fields']  = $mm->getSugarFields();
        $data['views']   = $mm->getSugarViews();
        $data['layouts'] = $mm->getSugarLayouts();
        $data['labels'] = $this->getStringUrls($data, false);
        $data['relationships'] = $mm->getRelationshipData();
        $data['jssource'] = $this->buildJSFileFromMD($data, $this->platforms[0], true);
        $data['server_info'] = $mm->getServerInfo();
        $data['logo_url'] = $themeObject->getImageURL('company_logo.png');
        $data['config'] = $this->getConfigs();

        // BR-470 Handle languages
        $data['languages'] = $mm->getAllLanguages();
        $data['_override_values'] = $this->getOverrides($data, $args);
        $hash = md5(serialize($data));
        $data["_hash"] = $hash;

        return $data;
    }

    /*
     * Filters the results for Public and Private Metadata
     * @param array $args the Arguments from the Rest Request
     * @param array $data the data to be filtered
     * @param bool  $onlyHash check to return only hashes
     * @param array $baseChunks the chunks we want filtered
     * @param array $perModuleChunks the module chunks we want filtered
     * @param array $moduleFilter the specific modules we want
     */

    protected function filterResults($args, $data, $onlyHash = false, $baseChunks = array(), $perModuleChunks = array(), $moduleFilter = array())
    {
        if ($onlyHash) {
            // The client only wants hashes
            $hashesOnly = array();
            $hashesOnly['_hash'] = $data['_hash'];
            foreach ($baseChunks as $chunk) {
                if (in_array($chunk,$this->typeFilter) ) {
                    $hashesOnly[$chunk]['_hash'] = $data['_hash'];
                }
            }

            foreach ($perModuleChunks as $chunk) {
                if (in_array($chunk, $this->typeFilter)) {
                    // We want modules, let's filter by the requested modules and by which hashes match.
                    foreach ($data[$chunk] as $modName => &$modData) {
                        if (empty($moduleFilter) || in_array($modName,$moduleFilter)) {
                            $hashesOnly[$chunk][$modName]['_hash'] = $data[$chunk][$modName]['_hash'];
                        }
                    }
                }
            }

            $data = $hashesOnly;

        } else {
            // The client is being bossy and wants some data as well.
            foreach ($baseChunks as $chunk) {
                if (!in_array($chunk,$this->typeFilter)
                    || (isset($args[$chunk]) && $args[$chunk] == $data[$chunk]['_hash'])) {
                    unset($data[$chunk]);
                }
            }

            // Relationships are special, they are a baseChunk but also need to pay attention to modules
            if (!empty($moduleFilter) && isset($data['relationships']) ) {
                // We only want some modules, but we want the relationships
                foreach ($data['relationships'] as $relName => $relData) {
                    if ($relName == '_hash') {
                        continue;
                    }
                    if (!in_array($relData['rhs_module'],$moduleFilter)
                        && !in_array($relData['lhs_module'],$moduleFilter)) {
                        unset($data['relationships'][$relName]);
                    } else { $data['relationships'][$relName]['checked'] = 1; }
                }
            }

            foreach ($perModuleChunks as $chunk) {
                if (!in_array($chunk, $this->typeFilter)) {
                    unset($data[$chunk]);
                } else {
                    // We want modules, let's filter by the requested modules and by which hashes match.
                    foreach ($data[$chunk] as $modName => &$modData) {
                        if ((!empty($moduleFilter) && !in_array($modName,$moduleFilter))
                            || (isset($args[$chunk][$modName]) && $args[$chunk][$modName] == $modData['_hash'])) {
                            unset($data[$chunk][$modName]);
                            continue;
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Gets configs
     *
     * @return array
     */
    protected function getConfigs()
    {
        global $sugar_config;
        $administration = new Administration();
        $administration->retrieveSettings();
        // These configs are controlled via System Settings in Administration module
        $configs = array(
            'maxQueryResult' => $sugar_config['list_max_entries_per_page'],
            'maxSubpanelResult' => $sugar_config['list_max_entries_per_subpanel'],
        );

        if (isset($administration->settings['honeypot_on'])) {
            $configs['honeypot_on'] = true;
        }
        if (isset($GLOBALS['sugar_config']['passwordsetting']['forgotpasswordON'])) {
            if ($GLOBALS['sugar_config']['passwordsetting']['forgotpasswordON'] === '1' || $GLOBALS['sugar_config']['passwordsetting']['forgotpasswordON'] === true) {
                $configs['forgotpasswordON'] = true;
            } else {
                $configs['forgotpasswordON'] = false;
            }
        }
        $auth = AuthenticationController::getInstance();
        if($auth->isExternal()) {
            $configs['externalLogin'] = true;
        }

        return $configs;
    }

    /**
     * Creates the list of platforms to build the metadata from
     * the standard function does [ "yourPlatform", "base" ]
     * You can override it in your platform specific API class if you want a different order
     *
     * @param ServiceBase $api The calling API class
     */
    protected function setPlatformList(ServiceBase $api)
    {
        if ($api->platform != 'base') {
            $this->platforms = array(basename($api->platform),'base');
        } else {
            $this->platforms = array('base');
        }
    }

    /**
     * Fills in additional app list strings data as needed by the client
     *
     * @param  array $public Public app list strings
     * @param  array $main Core app list strings
     * @return array
     */
    protected function fillInAppListStrings(Array $public, Array $main)
    {
        return $public;
    }

    /**
     * Gets the list of modules for this client
     *
     * @return array
     */
    protected function getModules()
    {
        // Loading a standard module list
        $base = array_keys($GLOBALS['app_list_strings']['moduleList']);
        // TODO - need to make this more extensible through configuration
        return array_merge($base, array('Audit'));
    }

    /**
     * Gets the cleaned up list of modules for this client
     * @return array
     */
    public function getModuleList()
    {
        $moduleList = $this->getModules();
        $oldModuleList = $moduleList;
        $moduleList = array();
        foreach ($oldModuleList as $module) {
            $moduleList[$module] = $module;
        }

        $moduleList['_hash'] = md5(serialize($moduleList));

        return $moduleList;
    }

    /**
     * Gets full module list and data for each module.
     *
     * @param  array $data load metadata array
     * @return array
     */
    public function _populateModules($data)
    {
        $mm = $this->getMetadataManager();
        $data['full_module_list'] = $this->getModuleList();
        $data['modules'] = array();
        foreach ($data['full_module_list'] as $module) {
            $bean = BeanFactory::newBean($module);
            $data['modules'][$module] = $mm->getModuleData($module);
            $this->_relateFields($data, $module, $bean);
        }

        return $data;
    }

    /**
     * Loads relationships for relate and link type fields
     * @param  array $data load metadata array
     * @return array
     */
    protected function _relateFields($data, $module, $bean)
    {
        if (isset($data['modules'][$module]['fields'])) {
            $fields = $data['modules'][$module]['fields'];

            foreach ($fields as $fieldName => $fieldDef) {

                // Load and assign any relate or link type fields
                if (isset($fieldDef['type']) && ($fieldDef['type'] == 'relate')) {
                    if (isset($fieldDef['module']) && !in_array($fieldDef['module'], $data['full_module_list'])) {
                        $data['full_module_list'][$fieldDef['module']] = $fieldDef['module'];
                    }
                } elseif (isset($fieldDef['type']) && ($fieldDef['type'] == 'link')) {
                    $bean->load_relationship($fieldDef['name']);
                    if ( isset($bean->$fieldDef['name']) && method_exists($bean->$fieldDef['name'],'getRelatedModuleName') ) {
                        $otherSide = $bean->$fieldDef['name']->getRelatedModuleName();
                        $data['full_module_list'][$otherSide] = $otherSide;
                    }
                }
            }
        }
    }

    /**
     * Returns a list of URL's pointing to json-encoded versions of the strings
     *
     * @param  array $data The metadata array
     * @return array
     */
    public function getStringUrls(&$data, $isPublic = false)
    {
        $platform = $this->platforms[0];
        $languageList = array_keys(get_languages());
        sugar_mkdir(sugar_cached('api/metadata'), null, true);

        $fileList = array();
        foreach ($languageList as $language) {
            $fileList[$language] = $this->getLangUrl($platform, $language, $isPublic);
        }
        $urlList = array();
        foreach ($fileList as $lang => $file) {
            // Get the hash for this lang file so we can append it to the URL.
            // This fixes issues where lang strings or list strings change but
            // don't force a metadata refresh
            $hash = $this->getLanguageFileModified($lang);
            $urlList[$lang] = $this->getUrlForCacheFile($file) . '?v=' . $hash;
        }
        $urlList['default'] = $GLOBALS['sugar_config']['default_language'];

        return $urlList;
    }

    /**
     * Given a platform and language, returns the language JSON contents.
     * @param ServiceBase $api
     * @param array $args
     */
    public function getLanguage(ServiceBase $api, array $args, $public = false)
    {
        $this->setPlatformList($api);

        $hash = $this->getCachedLanguageHash($this->platforms[0], $args['lang'], $public);
        if (!empty($hash) && $api->generateETagHeader($hash)) {
            return;
        }

        $resp = $this->buildLanguageFile($this->platforms[0], $args['lang'], $this->getModuleList(), $public);
        if (empty($hash) || $hash != $resp['hash']) {
            $this->putCachedLanguageHash($this->platforms[0], $args['lang'], $resp['hash'], $public);
            if ($api->generateETagHeader($resp['hash'])) {
                return;
            }
        }

        return $resp['data'];
    }

    /**
     * Get the hash element of the language file properties for a language
     *
     * @param  string  $lang   The language to get data for
     * @return string  The date modifed of the language file
     */
    protected function getLanguageFileModified($lang)
    {
        $ret = "";
        $custAppPaths = array(
            "custom/application/Ext/Language/$lang.lang.ext.php",
            "custom/include/language/$lang.lang.php"
        );
        foreach($custAppPaths as $custFilePath) {
            if (SugarAutoLoader::fileExists($custFilePath)){
                $ret = max(filemtime($custFilePath), $ret);
            }
        }
        foreach($this->getModules() as $module) {
            $modPaths = array(
                'custom/modules/' . $module . '/Ext/Language/' . $lang . '.lang.ext.php',
                'custom/modules/' . $module . '/language/' . $lang . '.lang.php',
            );
            foreach($modPaths as $custFilePath) {
                if (SugarAutoLoader::fileExists($custFilePath)){
                    $ret = max(filemtime($custFilePath), $ret);
                }
            }
        }
        return $ret;
    }

    public function getPublicLanguage(ServiceBase $api, array $args)
    {
        return $this->getLanguage($api, $args, true);
    }

    protected function getLangUrl($platform, $language, $isPublic=false)
    {
        $public_key = $isPublic ? "_public" : "";

        return  sugar_cached("api/metadata/lang_{$language}_{$platform}{$public_key}.json");
    }

    /**
     * Builds the language javascript file if needed, else returns what is known
     *
     * @param string $platform The client for this file
     * @param string $language The language for this file
     * @param array $modules The module list
     * @param boolean $isPublic Flag that decides if this is a public or private file
     * @return array Array containing the language file contents and the hash for the data
     */
    protected function buildLanguageFile($platform, $language, $modules, $isPublic=false)
    {
        $mm = $this->getMetadataManager();
        sugar_mkdir(sugar_cached('api/metadata'), null, true);
        $filePath = $this->getLangUrl($platform, $language, $isPublic);
        if (SugarAutoLoader::fileExists($filePath)) {
            // Get the contents of the file so that we can get the hash
            $data = file_get_contents($filePath);

            // Decode the json and get the hash. The hash should be there but
            // check for it just in case something went wrong somewhere.
            $array = json_decode($data, true);
            $hash = isset($array['_hash']) ? $array['_hash'] : '';

            // Cleanup
            unset($array);

            // Return the same thing as would be returned if we had to build the
            // file for the first time
            return array('hash' => $hash, 'data' => $data);
        }

        $stringData = array();
        $stringData['app_list_strings'] = $mm->getAppListStrings($language);
        $stringData['app_strings'] = $mm->getAppStrings($language);
        if ($isPublic) {
            // Exception for the AppListStrings.
            $app_list_strings_public = array();
            $app_list_strings_public['available_language_dom'] = $stringData['app_list_strings']['available_language_dom'];

            // Let clients fill in any gaps that may need to be filled in
            $app_list_strings_public = $this->fillInAppListStrings($app_list_strings_public, $stringData['app_list_strings'],$language);
            $stringData['app_list_strings'] = $app_list_strings_public;

        } else {
            $modStrings = array();
            foreach ($modules as $modName => $moduleDef) {
                $modData = $mm->getModuleStrings($modName, $language);
                $modStrings[$modName] = $modData;
            }
            $stringData['mod_strings'] = $modStrings;
        }
        // cast the app list strings to objects to make integer key usage in them consistent for the clients
        foreach ($stringData['app_list_strings'] as $listIndex => $listArray) {
            if (is_array($listArray) && !array_key_exists('',$listArray)) {
                $stringData['app_list_strings'][$listIndex] = (object) $listArray;
            }
        }
        $stringData['_hash'] = md5(serialize($stringData));
        $data = json_encode($stringData);
        sugar_file_put_contents_atomic($filePath,$data);

        return array("hash" => $stringData['_hash'], "data" => $data);
    }

    public function getUrlForCacheFile($cacheFile)
    {
        // This is here so we can override it and have the cache files upload to a CDN
        // and return the CDN locations later.
        return $cacheFile;
    }

    /**
     * Gets currencies
     * @return array
     */
    public function getSystemCurrencies()
    {
        $currencies = array();
        require_once 'modules/Currencies/ListCurrency.php';
        $lcurrency = new ListCurrency();
        $lcurrency->lookupCurrencies(true);
        if (!empty($lcurrency->list)) {
            foreach ($lcurrency->list as $current) {
                $currency = array();
                $currency['name'] = $current->name;
                $currency['iso4217'] = $current->iso4217;
                $currency['status'] = $current->status;
                $currency['symbol'] = $current->symbol;
                $currency['conversion_rate'] = $current->conversion_rate;
                $currency['name'] = $current->name;
                $currency['date_entered'] = $current->date_entered;
                $currency['date_modified'] = $current->date_modified;

                // Bug 60345 - Default currency id of -99 was failing hard on 64bit 5.2.X
                // PHP builds when writing to the cache because of how PHP was
                // handling negative int array indexes. This was causing metadata
                // to store a different value in the cache than -99. The fix was
                // to add a space around the -99 to force it to string.
                $id = $current->id == -99 ? '-99 ': $current->id;
                $currencies[$id] = $currency;
            }
        }

        return $currencies;
    }

    protected function putMetadataCache($data, $platform, $isPublic)
    {
        if ($isPublic) {
            $type = 'public';
        } else {
            $type = 'private';
        }

        // Create the cache cirectory if need be
        // The is a fix for the cache/cache/api/metadata problem
        $cacheDir  = 'api/metadata';
        create_cache_directory($cacheDir);

        // Handle the cache file
        $cacheFile = sugar_cached($cacheDir . '/metadata_'.$platform.'_'.$type.'.php');
        $write =   "<?php\n" .
                   '// created: ' . date('Y-m-d H:i:s') . "\n" .
                   '$metadata = ' .
                    var_export_helper($data) . ';';

        // Write with atomic writing to prevent issues with simultaneous requests
        // for this file
        sugar_file_put_contents_atomic($cacheFile, $write);

        // Let the metadata manager know to not wipe out the cache on shutdown of
        // this request, in case it is asked to do that
        MetaDataManager::setCacheHasBeenCleared();
    }

    protected function getMetadataCache($platform, $isPublic)
    {
        if ( inDeveloperMode() ) {
            return null;
        }
        $metadata = array();
        if ($isPublic) {
            $type = 'public';
        } else {
            $type = 'private';
        }
        $cacheFile = sugar_cached('api/metadata/metadata_'.$platform.'_'.$type.'.php');
        if ( file_exists($cacheFile) ) {
            require $cacheFile;

            return $metadata;
        } else {
            return null;
        }
    }

    /**
     * Accessor to the metadata manager cache cleaner
     */
    public function clearMetadataCache()
    {
        MetaDataManager::clearAPICache();
    }

    /**
     * Bug 60345
     *
     * Normalizes the -99 currency id to remove the space added to the index prior
     * to storing in the cache.
     *
     * @param  array $data The metadata
     * @return array
     */
    protected function normalizeCurrencyIds($data)
    {
        if (isset($data['currencies']['-99 '])) {
            // Change the spaced index back to normal
            $data['currencies']['-99'] = $data['currencies']['-99 '];

            // Ditch the spaced index
            unset($data['currencies']['-99 ']);
        }

        return $data;
    }

    /**
     * @param Array $data data to be returned to the client
     * @param Array $args args passed to the API
     */
    protected function getOverrides($data, $args) {
        if (isset($args['override_values']) && is_array($args['override_values'])) {
            return $args['override_values'];
        }

        return array_intersect(array_keys($data), self::$defaultOverrides);
    }

    protected function cacheMetadataHash($hash, $isPublic = false)
    {
        $public = $isPublic ? "public_" : "";
        $key = "meta_hash_$public" . implode( "_", $this->platforms);

        return $this->addToHashCache($key, $hash);
    }

    protected function getCachedMetadataHash($isPublic = false)
    {
        $public = $isPublic ? "public_" : "";
        $key = "meta_hash_$public" . implode( "_", $this->platforms);

        return $this->getFromHashCache($key);
    }

    protected function putCachedLanguageHash($platform, $lang, $hash, $isPublic=false)
    {
        $key = $this->getLangUrl($platform, $lang, $isPublic);
        $this->addToHashCache($key, $hash);
    }

    protected function getCachedLanguageHash($platform, $lang, $isPublic=false)
    {
        $key = $this->getLangUrl($platform, $lang, $isPublic);

        return $this->getFromHashCache($key);
    }

    protected function addToHashCache($key, $hash)
    {
        $hashes = array();
        $path = sugar_cached("api/metadata/hashes.php");
        @include($path);
        $hashes[$key] = $hash;
        write_array_to_file("hashes", $hashes, $path);
        SugarAutoLoader::addToMap($path);
    }

    protected function getFromHashCache($key)
    {
        $hashes = array();
        $path = sugar_cached("api/metadata/hashes.php");
        @include($path);

        return !empty($hashes[$key]) ? $hashes[$key] : false;
    }

    /**
     * Gets the moduleTabMap array to allow clients to decide which menu element
     * a module should live in for non-module modules
     *
     * @return array
     */
    public function getModuleTabMap()
    {
        return $GLOBALS['moduleTabMap'];
    }
}
