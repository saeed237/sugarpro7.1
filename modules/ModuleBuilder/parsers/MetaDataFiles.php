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

require_once 'modules/ModuleBuilder/Module/StudioModuleFactory.php';
require_once 'modules/ModuleBuilder/parsers/constants.php';
require_once 'include/Expressions/DependencyManager.php';
require_once 'jssource/jsmin.php';

class MetaDataFiles
{
    /**
     * Constants for this class, used for pathing metadata files
     */
    const PATHBASE    = '';
    const PATHCUSTOM  = 'custom/';
    const PATHWORKING = 'custom/working/';
    const PATHHISTORY = 'custom/history/';

    /**
     * Constant for component types... in our case, layouts and views
     */
    const COMPONENTVIEW   = 'view';
    const COMPONENTLAYOUT = 'layout';

    /**
     * Path prefixes for metadata files
     *
     * @var array
     * @access public
     * @static
     */
    public static $paths = array(
        MB_BASEMETADATALOCATION    => self::PATHBASE,
        MB_CUSTOMMETADATALOCATION  => self::PATHCUSTOM,
        MB_WORKINGMETADATALOCATION => self::PATHWORKING,
        MB_HISTORYMETADATALOCATION => self::PATHHISTORY,
    );

    /**
     * The types of metadata files that could be loaded and their directory
     * locations inside of the metadata directory
     *
     * @var array
     * @access public
     * @static
     */
    public static $clients = array(
        'base'    => 'base',
        'portal'  => 'portal',
        'mobile'  => 'mobile',
    );

    /**
     * Listing of clients as they relate to their respective views
     *
     * @var array
     * @access public
     * @static
     */
    public static $clientsByView = array(
        MB_WIRELESSDETAILVIEW => MB_WIRELESS,
        MB_WIRELESSEDITVIEW => MB_WIRELESS,
        MB_WIRELESSLISTVIEW => MB_WIRELESS,
        MB_WIRELESSADVANCEDSEARCH => MB_WIRELESS,
        MB_WIRELESSBASICSEARCH => MB_WIRELESS,
    );

    /**
     * Names of the files themselves
     *
     * @var array
     * @access public
     * @static
     */
    public static $names = array(
        MB_DASHLETSEARCH          => 'dashletviewdefs',
        MB_DASHLET                => 'dashletviewdefs',
        MB_POPUPSEARCH            => 'popupdefs',
        MB_POPUPLIST              => 'popupdefs',
        MB_LISTVIEW               => 'listviewdefs' ,
        MB_SIDECARLISTVIEW        => 'list' ,
        MB_BASICSEARCH            => 'searchdefs' ,
        MB_ADVANCEDSEARCH         => 'searchdefs' ,
        MB_EDITVIEW               => 'editviewdefs' ,
        MB_DETAILVIEW             => 'detailviewdefs' ,
        MB_QUICKCREATE            => 'quickcreatedefs',
        MB_RECORDVIEW             => 'record',
        MB_WIRELESSEDITVIEW       => 'edit' ,
        MB_WIRELESSDETAILVIEW     => 'detail' ,
        MB_WIRELESSLISTVIEW       => 'list' ,
        MB_WIRELESSBASICSEARCH    => 'search' ,
        MB_WIRELESSADVANCEDSEARCH => 'search' ,
    );

    /**
     * List of metadata def array vars
     *
     * @static
     * @access public
     * @var array
     */
    public static $viewDefVars = array(
        MB_EDITVIEW    => 'EditView' ,
        MB_DETAILVIEW  => 'DetailView' ,
        MB_QUICKCREATE => 'QuickCreate',
        MB_RECORDVIEW  => array('base', 'view', 'record'),

        MB_WIRELESSEDITVIEW => array('mobile','view','edit'),
        MB_WIRELESSDETAILVIEW => array('mobile','view','detail'),

    );

    /**
     * Listing of components, used in pathing
     * @var array
     */
    public static $components = array(
        self::COMPONENTVIEW   => self::COMPONENTVIEW,
        self::COMPONENTLAYOUT => self::COMPONENTLAYOUT,
    );

    /**
     * The path inside the $client directories to the views
     *
     * @var string
     * @access public
     * @static
     */
    public static $viewsPath = 'views/';

    /**
     * Listing of module name placeholders in SugarObject templates metadata
     *
     * @var array
     * @static
     */
    public static $moduleNamePlaceholders = array(
        '<object_name>', '<_object_name>', '<OBJECT_NAME>',
        '<module_name>', '<_module_name>', '<MODULE_NAME>',
    );

    /**
     * Listing of excluded client file paths. This tells {@see getClientFiles} not
     * to included files in these paths when getting the list of client files.
     *
     * The structure of this array should be
     *  - path/to/type/dir => array(files)
     *
     * At present, this will only exclude PHP files.
     *
     * @var array
     */
    public static $excludedClientFilePaths = array(
        'include/SugarObjects/templates/basic/clients/base/views/' => array(
            'edit',
            'detail',
        ),
    );

    /**
     * The compiled list of excluded client files. This is based off
     * excludedClientFilePaths.
     *
     * @var array
     */
    public static $excludedClientFiles = array();

    /**
     * Gets the file base names array
     *
     * @static
     * @return array
     */
    public static function getNames()
    {
        return self::$names;
    }

    /**
     * Gets the file/variable name for a given view
     *
     * @param  string $name The name of the view to get the variable/file name for
     * @return string The name of the file/variable
     */
    public static function getName($name)
    {
        return empty(self::$names[$name]) ? null : self::$names[$name];
    }

    /**
     * Gets the clients array
     *
     * @static
     * @return array
     */
    public static function getClients()
    {
        return self::$clients;
    }

    /**
     * Gets a particular client by name. $client should map to an index of the
     * clients array.
     *
     * @static
     * @param  string $client The client to get
     * @return string
     */
    public static function getClient($client)
    {
        return empty(self::$clients[$client]) ? '' : self::$clients[$client];
    }

    /**
     * Gets a view client for a known view
     *
     * @static
     * @param  string $view The view to get the client for
     * @return string
     */
    public static function getClientByView($view)
    {
        return empty($view) || empty(self::$clientsByView[$view]) ? '' : self::$clientsByView[$view];
    }

    /**
     * Gets the file paths array
     *
     * @static
     * @return array
     */
    public static function getPaths()
    {
        return self::$paths;
    }

    /**
     * Gets the view type of a client based on the requested view
     *
     * @static
     * @param  string $view The requested view
     * @return string
     */
    public static function getViewClient($view)
    {
        if (!empty($view)) {
            if (stripos($view, 'portal') !== false) {
                return 'portal';
            }

            if (stripos($view, 'wireless') !== false || stripos($view, 'mobile') !== false) {
                return 'mobile';
            }

            return 'base';
        }

        return '';
    }

    /**
     * Gets the listing of SugarObject template placeholders
     *
     * @static
     * @return array
     */
    public static function getModuleNamePlaceholders()
    {
        return self::$moduleNamePlaceholders;
    }

    /**
     * helper to give us a parameterized path to create viewdefs for saving to file
     * @param  string | array $path (path of keys to use for array)
     * @param  mixed          $data the data to place at that path
     * @return array          the data in the correct path
     */
    public static function mapPathToArray($path, $data)
    {
        if (!is_array($path)) {
            return array($path => $data);
        }

        $arr = $data;
        while ($key = array_pop($path)) {
            $arr = array($key => $arr);
        }

        return $arr;
    }

    /**
     * helper to give us a parameterized path find our data from our viewdefs
     * @param  string | array $path (path of keys to use for array)
     * @param  mixed          $arr  the array to search for the path
     * @return array|         null the data in the correct path or null if a key isn't found.
     */
    public static function mapArrayToPath($path, $arr)
    {
        if (!is_array($arr)) {
            return null;
        }

        if (!is_array($path)) {
            return (isset($arr[$path]) ? $arr[$path] : null);
        }

        // traverse the array for our path
        $out = &$arr;
        foreach ($path as $key) {
            if (!isset($out[$key])) {
                return null;
            }

            $out = $out[$key];
        }

        return $out;
    }



    /**
     * Gets the list of view def array variable names
     *
     * @static
     * @return array
     */
    public static function getViewDefVars()
    {
        return self::$viewDefVars;
    }

    /**
     * Gets a single view def variable name
     *
     * This checks the def vars array first then the file name arrays. This
     * fallback allows for the use of the more standard naming for sidecar stuff
     * without having to redefine a bunch of vars that are the exact same as their
     * filename counterparts
     *
     * @static
     * @param  string $view The name of the view to get the def var for
     * @return string The def variable name
     */
    public static function getViewDefVar($view)
    {
        // Try the view def var array first
        if (isset(self::$viewDefVars[$view])) {
            return self::$viewDefVars[$view];
        }

        // try the file name array second
        return self::getName($view);
    }

    public static function setViewDefVar($view, $defVar)
    {
    }

    /**
     * Gets a deployed metadata filename. This is generally called from a
     * DeployedMetaDataImplementation instance.
     *
     * @static
     * @param  string $view   The requested view type
     * @param  string $module The module for this metadata file
     * @param  string $type   The type of metadata file location (custom, working, etc)
     * @param  string $client The client type for this file
     * @return string
     */
    public static function getDeployedFileName($view, $module, $type = MB_CUSTOMMETADATALOCATION, $client = '')
    {
        $type = strtolower($type);
        $paths = self::getPaths();
        $names = self::getNames();

        //In a deployed module, we can check for a studio module with file name overrides.
        $sm = StudioModuleFactory::getStudioModule($module);
        foreach ($sm->sources as $file => $def) {
            if (!empty($def['view'])) {
                $names[$def['view']] = substr($file, 0, strlen($file) - 4);
            }
        }

        // BEGIN ASSERTIONS
        if (!isset($paths[$type])) {
            sugar_die("MetaDataFiles::getDeployedFileName(): Type $type is not recognized");
        }

        if (!isset($names[$view])) {
            sugar_die("MetaDataFiles::getDeployedFileName(): View $view is not recognized");
        }
        // END ASSERTIONS

        // Construct filename
        if (!empty($client)) {
            $viewPath = 'clients/' . $client . '/' . self::$viewsPath . $names[$view] . '/';
        } else {
            $viewPath = 'metadata/';
        }

        return $paths[$type] . 'modules/' . $module . '/' . $viewPath . $names[$view] . '.php';
    }

    /**
     * Gets an undeployed metadata filename. This is generally called from an
     * UndeployedMetaDataImplementation instance.
     *
     * @static
     * @param  string $view        The requested view
     * @param  string $module      The module for this metadata file
     * @param  string $packageName The package for this metadata file
     * @param  string $type        The type of metadata file to get (custom, working, etc)
     * @param  string $client      The client type for this file
     * @return string
     */
    public static function getUndeployedFileName($view, $module, $packageName, $type = MB_BASEMETADATALOCATION, $client = '')
    {
        $type = strtolower($type);

        // BEGIN ASSERTIONS
        if ($type != MB_BASEMETADATALOCATION && $type != MB_HISTORYMETADATALOCATION) {
            // just warn rather than die
            $GLOBALS['log']->warning("UndeployedMetaDataImplementation->getFileName(): view type $type is not recognized");
        }
        // END ASSERTIONS

        $names = self::getNames();

        // Get final filename path part
        if (!empty($client)) {
            $viewPath = 'clients/' . $client . '/' . self::$viewsPath . $names[$view] . '/';
        } else {
            $viewPath = 'metadata/';
        }

        switch ($type) {
            case MB_HISTORYMETADATALOCATION:
                return self::$paths[MB_WORKINGMETADATALOCATION] . 'modulebuilder/packages/' . $packageName . '/modules/' . $module . '/' . $viewPath . $names[$view] . '.php';
            default:
                // get the module again, all so we can call this method statically without relying on the module stored in the class variables
                require_once 'modules/ModuleBuilder/MB/ModuleBuilder.php';
                $mb = new ModuleBuilder();

                return $mb->getPackageModule($packageName, $module)->getModuleDir() . '/' . $viewPath . $names[$view] . '.php';
        }
    }

    /**
     * Gets a $deftype metadata file for a given module
     *
     * @static
     * @param  string      $module    The name of the module to get metadata for
     * @param  string      $deftype   The def type to get (list, detail, edit, search)
     * @param  string      $path      The path to the metadata (base path, custom path, working path, history path)
     * @param  string      $client    The client making this request
     * @param  string      $component Layout or view
     * @return null|string Null if the request is invalid, path if it is good
     */
    public static function getModuleFileName($module, $deftype, $path = MB_BASEMETADATALOCATION, $client = '', $component = self::COMPONENTVIEW)
    {
        $filedir = self::getModuleFileDir($module, $path);
        if ($filedir === null) {
            return null;
        }

        if ($client) {
            $metadataPath = 'clients/' . $client . '/' . $component . 's/' . $deftype . '/';
        } else {
            $metadataPath = 'metadata/';
        }

        $filename = $filedir . $metadataPath . $deftype . '.php';

        return $filename;
    }

    /**
     * Gets a metadata file path for a module from its SugarObject template type
     *
     * @static
     * @param  string $module    The name of the module to get metadata for
     * @param  string $deftype   The def type to get (list, detail, edit, search)
     * @param  string $client    The client making this request
     * @param  string $component Layout or view
     * @return string
     */
    public static function getSugarObjectFileName($module, $deftype, $client = '', $component = self::COMPONENTVIEW)
    {
        $filename =  self::getSugarObjectFileDir($module, $client, $component) . $deftype . '.php';

        return $filename;
    }

    /**
     * Gets a metadata directory for a given module and path (custom, history, etc)
     *
     * @static
     * @param string $module The name of the module to get metadata for
     * @param string $path The path to the metadata (base path, custom path, working path, history path)
     * @param string $client The client making this request
     * @param string $component Layout or view
     * @return null|string Null if the request is invalid, path if it is good
     */
    public static function getModuleFileDir($module, $path = MB_BASEMETADATALOCATION)
    {
        // Simple validation of path
        if (!isset(self::$paths[$path])) {
            return null;
        }

        // Now get to building
        $dirname = self::$paths[$path] . 'modules/' . $module . '/';

        return $dirname;
    }

    /**
     * Gets a metadata directory path for a module from its SugarObject template type
     *
     * @static
     * @param string $module The name of the module to get metadata for
     * @param string $client The client making this request
     * @param string $component Layout or view
     * @return string
     */
    public static function getSugarObjectFileDir($module, $client = '', $component = self::COMPONENTVIEW)
    {
        require_once 'modules/ModuleBuilder/Module/StudioModule.php';
        $sm = new StudioModule($module);

        $dirname = 'include/SugarObjects/templates/' . $sm->getType() . '/';
        if (!empty($client)) {
            $dirname .= 'clients/' . $client . '/' . $component . 's/';
        } else {
            $dirname .= 'metadata/';
        }

        return $dirname;
    }

    /**
     * Gets a metadata directory path for a module from the ext framework type
     *
     * @static
     * @param  string $module The name of the module to get metadata for
     * @param  string $client The client making this request
     * @param  string $component Layout or view
     * @return string
     */
    public static function getSugarExtensionFileDir($module, $client = '', $component = self::COMPONENTVIEW)
    {
        $dirname = "custom/modules/{$module}/Ext/clients/{$client}/{$component}s/";
        return $dirname;
    }

    /**
     * Gets SugarObjects type metadata for a module and cleans the defs up by
     * replacing variables with correct values based on the module
     *
     * @static
     * @param SugarBean|string $module Either a been or a string name of a module
     * @param array $defs The defs associated with this module
     * @return array Cleaned up metadata
     */
    public static function getModuleMetaDataDefsWithReplacements($module, $defs)
    {
        if (!$module instanceof SugarBean) {
            $module = BeanFactory::getBean($module);
        }
        $replacements = array(
            "<object_name>"  => $module->object_name,
            "<_object_name>" => strtolower($module->object_name),
            "<OBJECT_NAME>"  => strtoupper($module->object_name),
            "<module_name>"  => $module->module_dir,
            '<_module_name>' => strtolower($module->module_dir),
        );

        return self::recursiveVariableReplace($defs, $replacements);
    }

    /**
     * Does deep recursive variable replacement on an array
     *
     * @TODO Consider making a MetaDataUtils class and adding this to that class
     * @static
     * @param array $source The input array to work replacements on
     * @param array $replacements An array of replacements as $find => $replace pairs
     * @return array $source array with $replacements applied to them
     */
    public static function recursiveVariableReplace($source, $replacements)
    {
        $ret = array();
        foreach ($source as $key => $val) {
            if (is_array($val)) {
                $newkey = $key;
                $val = self::recursiveVariableReplace($val, $replacements);
                $newkey = str_replace(array_keys($replacements), $replacements, $newkey);
                $ret[$newkey] = $val;
            } else {
                $newkey = $key;
                $newval = $val;
                if (is_string($val)) {
                    $newkey = str_replace(array_keys($replacements), $replacements, $newkey);
                    $newval = str_replace(array_keys($replacements), $replacements, $newval);
                }
                $ret[$newkey] = $newval;
            }
        }

        return $ret;
    }

    /**
     * @param $view
     * @return mixed
     * hack for portal to use its own constants
     */
    public static function getMBConstantForView($view, $client = "base")
    {
        // Sometimes client is set to a defined null
        if (empty($client)) {
            $client = 'base';
        }

        $map = array(
            'mobile' => array(
                'edit' => MB_WIRELESSEDITVIEW,
                'detail' => MB_WIRELESSDETAILVIEW,
                'list' => MB_WIRELESSLISTVIEW
            ),
            "base" => array(
                'edit' => MB_EDITVIEW,
                'detail' => MB_DETAILVIEW,
                'advanced_search' => MB_ADVANCEDSEARCH,
                'basic_search' => MB_BASICSEARCH,
                'list' => MB_LISTVIEW,
            ),
        );

        // view variable sent to the factory has changed: remove 'view' suffix
        // in case of further change
        $view = strtolower($view);
        if (substr_compare($view,'view',-4) === 0) {
            $view = substr($view,0,-4);
        }

        return isset($map[$client][$view]) ? $map[$client][$view] : $view;
    }

    public static function clearModuleClientCache( $modules = array(), $type = '' )
    {
        if ( is_string($modules) ) {
            // They just want one module
            $modules = array($modules);
        } elseif ( count($modules) == 0 ) {
            // They want all of the modules, so get them if they are already set
            $modules = empty($GLOBALS['app_list_strings']['moduleList']) ? array() : array_keys($GLOBALS['app_list_strings']['moduleList']);
        }
        foreach ($modules as $module) {
            if ( empty($type) ) {
                $type = '*';
            }
            // Delete client cache files of all types
            foreach ( glob(sugar_cached('modules/'.$module.'/clients/*/'.$type.'.php')) as $cacheFile ) {
                unlink($cacheFile);
            }
        }
    }

    public static function getModuleClientCache( $platforms, $type, $module )
    {
        $clientCache = array();
        $cacheFile = sugar_cached('modules/'.$module.'/clients/'.$platforms[0].'/'.$type.'.php');
        if ( !file_exists($cacheFile) ) {
            self::buildModuleClientCache( $platforms, $type, $module );
        }
        $clientCache[$module][$platforms[0]][$type] = array();
        require $cacheFile;

        return $clientCache[$module][$platforms[0]][$type];
    }

    public static function buildModuleClientCache( $platforms, $type, $modules = array() )
    {
        if ( is_string($modules) ) {
            // They just want one module
            $modules = array($modules);
        } elseif ( count($modules) == 0 ) {
            // They want all of the modules
            $modules = array_keys($GLOBALS['app_list_strings']['moduleList']);
        }
        foreach ($modules as $module) {
            $seed = BeanFactory::getBean($module);
            $fileList = self::getClientFiles($platforms, $type, $module);
            $moduleResults = self::getClientFileContents($fileList, $type, $module);

            if ($type == "view") {
                foreach ($moduleResults as $view => $defs) {
                    if (!is_array($defs) || empty($seed) || empty($seed->field_defs)) {
                        continue;
                    }
                    $meta = !empty($defs['meta']) ? $defs['meta'] : array();
                    $deps = array_merge(
                        DependencyManager::getDependenciesForFields($seed->field_defs, ucfirst($view) . "View"),
                        DependencyManager::getDependenciesForView($meta, ucfirst($view) . "View", $module)
                        );
                    if (!empty($deps)) {
                        if (!isset($meta['dependencies']) || !is_array($meta['dependencies'])) {
                            $moduleResults[$view]['meta']['dependencies'] = array();
                        }
                        foreach ($deps as $dep) {
                            $moduleResults[$view]['meta']['dependencies'][] = $dep->getDefinition();
                        }
                    }
                }
            }



            $basePath = sugar_cached('modules/'.$module.'/clients/'.$platforms[0]);
            sugar_mkdir($basePath,null,true);

            $output = "<?php\n\$clientCache['".$module."']['".$platforms[0]."']['".$type."'] = ".var_export($moduleResults,true).";\n\n";
            sugar_file_put_contents_atomic($basePath.'/'.$type.'.php', $output);
        }
    }

    public static function getClientFiles( $platforms, $type, $module = '' )
    {
        $checkPaths = array();

        // First, build a list of paths to check
        if ($module == '') {
            foreach ($platforms as $platform) {
                // These are sorted in order of priority.
                // No templates for the non-module stuff
                $checkPaths['custom/clients/'.$platform.'/'.$type.'s'] = array('platform'=>$platform,'template'=>false);
                $checkPaths['clients/'.$platform.'/'.$type.'s'] = array('platform'=>$platform,'template'=>false);
            }
        } else {
            foreach ($platforms as $platform) {
                // These are sorted in order of priority.
                // The template flag is if that file needs to be "built" by the metadata loader so it
                // is no longer a template file, but a real file.
                $checkPaths['custom/modules/'.$module.'/clients/'.$platform.'/'.$type.'s'] = array('platform'=>$platform,'template'=>false);
                $checkPaths['modules/'.$module.'/clients/'.$platform.'/'.$type.'s'] = array('platform'=>$platform,'template'=>false);
                $baseTemplateDir = 'include/SugarObjects/templates/basic/clients/'.$platform.'/'.$type.'s';
                $nonBaseTemplateDir = self::getSugarObjectFileDir($module, $platform, $type);
                if (!empty($nonBaseTemplateDir) && $nonBaseTemplateDir != $baseTemplateDir ) {
                    $checkPaths['custom/'.$nonBaseTemplateDir] = array('platform'=>$platform,'template'=>true);
                    $checkPaths[$nonBaseTemplateDir] = array('platform'=>$platform, 'template'=>true);
                }
                $checkPaths['custom/'.$baseTemplateDir] = array('platform'=>$platform,'template'=>true);
                $checkPaths[$baseTemplateDir] = array('platform'=>$platform,'template'=>true);
                $checkPaths[self::getSugarExtensionFileDir($module, $platform, $type)] = array('platform' => $platform, 'template' => false);
            }
        }

        // Second, get a list of files in those directories, sorted by "relevance"
        $fileList = array();
        foreach ($checkPaths as $path => $pathInfo) {
            // Looks at /modules/Accounts/clients/base/views/*
            // So should pull up "record","list","preview"
            $dirsInPath = SugarAutoLoader::getDirFiles($path,true);

            foreach ($dirsInPath as $fullSubPath) {
                $subPath = basename($fullSubPath);
                // This should find the files in each view/layout
                // So it should pull up list.js, list.php, list.hbs
                $filesInDir = SugarAutoLoader::getDirFiles($fullSubPath,false);
                foreach ($filesInDir as $fullFile) {
                    // If this file is an excluded file, skip it
                    if (self::isExcludedClientFile($fullFile)) {
                        continue;
                    }

                    $file = basename($fullFile);
                    $fileIndex = $fullFile;
                    if ( !isset($fileList[$fileIndex]) ) {
                        $fileList[$fileIndex] = array('path'=>$fullFile, 'file'=>$file, 'subPath'=>$subPath, 'platform'=>$pathInfo['platform']);
                        if ( $pathInfo['template'] && (substr($file,-4)=='.php') ) {
                            $fileList[$fileIndex]['template'] = true;
                        } else {
                            $fileList[$fileIndex]['template'] = false;
                        }
                    }
                }
            }
        }
        return $fileList;
    }

    public static function getClientFileContents( $fileList, $type, $module = '' )
    {
        $results = array();

        foreach ($fileList as $fileIndex => $fileInfo) {
            $extension = substr($fileInfo['path'],-3);
            switch ($extension) {
                case '.js':
                    if ( isset($results[$fileInfo['subPath']]['controller'][$fileInfo['platform']]) ) {
                        continue;
                    }

                    $controller = file_get_contents($fileInfo['path']);
                    $results[$fileInfo['subPath']]['controller'][$fileInfo['platform']] = $controller;
                    break;
                case 'hbs':
                    $layoutName = substr($fileInfo['file'],0,-4);
                    if ( isset($results[$fileInfo['subPath']]['templates'][$layoutName]) ) {
                        continue;
                    }
                    $results[$fileInfo['subPath']]['templates'][$layoutName] = file_get_contents($fileInfo['path']);
                    break;
                case 'php':
                    $viewdefs = array();
                    if ( isset($results[$fileInfo['subPath']]['meta']) && !strstr($fileInfo['path'], '.ext')) {
                        continue;
                    }
                    if ($fileInfo['template']) {
                        // This is a template file, not a real one.
                        require $fileInfo['path'];
                        $bean = BeanFactory::getBean($module);
                        if ( !is_a($bean,'SugarBean') ) {
                            // I'm not sure what this is, but it's not something we can template
                            continue;
                        }
                        $viewdefs = self::getModuleMetaDataDefsWithReplacements($bean, $viewdefs);
                        if ( ! isset($viewdefs[$module][$fileInfo['platform']][$type][$fileInfo['subPath']]) ) {
                            $GLOBALS['log']->error('Could not generate a metadata file for module '.$module.', platform: '.$fileInfo['platform'].', type: '.$type);
                            continue;
                        }

                        $results[$fileInfo['subPath']]['meta'] = $viewdefs[$module][$fileInfo['platform']][$type][$fileInfo['subPath']];
                    } else {
                        require $fileInfo['path'];
                        if($fileInfo['subPath'] != 'subpanels') {
                            $extensionName = "sidecar{$type}{$fileInfo['platform']}{$fileInfo['subPath']}";
                            $extFile = SugarAutoLoader::loadExtension($extensionName, $module);
                            if ($extFile) {
                                include $extFile;
                            }
                        }
                        if ( empty($module) ) {
                            if ( !isset($viewdefs[$fileInfo['platform']][$type][$fileInfo['subPath']]) ) {
                                $GLOBALS['log']->error('No viewdefs for type: '.$type.' viewdefs @ '.$fileInfo['path']);
                            } else {
                                $results[$fileInfo['subPath']]['meta'] = $viewdefs[$fileInfo['platform']][$type][$fileInfo['subPath']];
                            }
                        } else {
                            if ( !isset($viewdefs[$module][$fileInfo['platform']][$type][$fileInfo['subPath']]) ) {
                                $GLOBALS['log']->error('No viewdefs for module: '.$module.' viewdefs @ '.$fileInfo['path']);
                            } else {
                                if(isset($results[$fileInfo['subPath']]['meta'])) {
                                    if($fileInfo['subPath'] == 'subpanels') {
                                        $results[$fileInfo['subPath']]['meta'] = self::mergeSubpanels($viewdefs[$module][$fileInfo['platform']][$type][$fileInfo['subPath']], $results[$fileInfo['subPath']]['meta']);
                                    }
                                } else {
                                    // For custom modules or if there is no subpanel
                                    // layout defined and edits are made, we
                                    // need to capture the changes that all live
                                    // in one file for subpanels
                                    if($fileInfo['subPath'] == 'subpanels') {
                                        $results[$fileInfo['subPath']]['meta'] = self::mergeSubpanels($viewdefs[$module][$fileInfo['platform']][$type][$fileInfo['subPath']], array('components' => array()));
                                    } else {
                                        $results[$fileInfo['subPath']]['meta'] = $viewdefs[$module][$fileInfo['platform']][$type][$fileInfo['subPath']];
                                    }
                                }
                            }
                        }
                        break;
                    }
            }
        }

        $results['_hash'] = md5(serialize($results));

        return $results;
    }

    /**
     * @param array $mergeDefs the defs to merge in
     * @param array $currentDefs the current defs that need the new stuff
     * @return array updated layoutdefs
     */
    public static function mergeSubpanels(array $mergeDefs, array $currentDefs)
    {
        $mergeComponents = $mergeDefs['components'];
        $currentComponents = &$currentDefs['components'];

        foreach($mergeComponents as $mergeComponent) {
            // if it is the only thing in the array its an override and it needs to be added to an existing component
            if(isset($mergeComponent['override_subpanel_list_view']) && count($mergeComponent) == 1) {
                $overrideView = $mergeComponent['override_subpanel_list_view']['view'];
                $mergeContext = $mergeComponent['override_subpanel_list_view']['link'];
                foreach($currentComponents as $key => $currentComponent) {
                    if(!empty($currentComponent['context']['link']) && $currentComponent['context']['link'] == $mergeContext) {
                        $currentDefs['components'][$key]['override_subpanel_list_view'] = $overrideView;
                        continue;
                    }
                }
            } else {
                $linkName = isset($mergeComponent['context']['link']) ? $mergeComponent['context']['link'] : '';
                $linkExists = false;
                foreach($currentComponents as $key => $currentComponent) {
                    if(!empty($currentComponent['context']['link']) && $currentComponent['context']['link'] == $linkName) {
                        $linkExists = true;
                    }
                }
                if(!$linkExists) {
                    $currentComponents[] = $mergeComponent;
                }
            }
        }

        return $currentDefs;
    }

    /**
     * Checks if a client file path should be excluded from the list of files to
     * be fetched when getting client files for a module
     *
     * @param string $filepath Full path to the file to check
     * @return boolean
     */
    public static function isExcludedClientFile($filepath)
    {
        // If the listing of excluded client files hasn't been built yet then
        // create it
        if (empty(self::$excludedClientFiles)) {
            self::buildExcludedClientFileList();
        }

        return !empty(self::$excludedClientFiles[$filepath]);
    }

    /**
     * Builds the listing of excluded client files.
     */
    public static function buildExcludedClientFileList()
    {
        foreach (self::$excludedClientFilePaths as $basePath => $files) {
            foreach ($files as $file) {
                // Set the path as an index for we can use isset()/empty()
                // instead of in_array()
                $path = $basePath . $file . '/' . $file . '.php';
                $customPath = 'custom/' . $path;
                self::$excludedClientFiles[$path] = true;
                self::$excludedClientFiles[$customPath] = true;
            }
        }
    }

    /**
     * Adds a path => array(files) to the excluded client file path array
     *
     * @param array $pathArray Array of files keyed on a base path
     */
    public static function addExcludedClientFilePath(array $pathArray)
    {
        self::$excludedClientFilePaths = array_merge(self::$excludedClientFilePaths, $pathArray);
    }

    /**
     * Adds an excluded file to a path in the excluded client file path array
     *
     * @param string $path The path to use as the index for the excluded file array
     * @param string $file the file basename to add
     */
    public static function addExcludedClientFileToPath($path, $file)
    {
        self::$excludedClientFilePaths[$path][] = $file;
    }

    /**
     * Loads a specific client file's contents
     *
     * @param string $type The type of the client data (view/layout/field)
     * @param string $name The name of the client data (record/history/list)
     * @param string $platform The platform to search for the client data (defaults to base)
     *
     * @return array Contents of the metadata file
     */
    public static function loadSingleClientMetadata($type, $name, $platform = 'base')
    {
        $fileList = array();
        $platforms = array();
        if ($platform != 'base') {
            $platforms[] = $platform;
        }
        $platforms[] = 'base';
        foreach ($platforms as $platform) {
            $fileToCheck = "clients/$platform/{$type}s/$name/$name.php";
            $fileList['custom/'.$fileToCheck] = $platform;
            $fileList[$fileToCheck] = $platform;
        }

        foreach ($fileList as $file => $platform) {
            if (SugarAutoLoader::existing($file)) {
                require $file;
                if (isset($viewdefs[$platform][$type][$name])) {
                    return $viewdefs[$platform][$type][$name];
                }
            }
        }

        return null;
    }
}
