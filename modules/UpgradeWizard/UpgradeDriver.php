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

/**
 * Upgrader main driver class
 * @api
 */
abstract class UpgradeDriver
{
    const STATE_FILE = "upgrade_state";

    /**
     * If upgrade is successful
     * @var bool
     */
    public $success = true;
    /**
     * Execution context
     * zip - ZIP file
     * temp_dir - temporary directory
     * source_dir - Sugar source dir
     * new_source_dir - directory where new Sugar source files are stored
     * admin - Admin user
     * log - Log file
     * state_file - file where upgrade state is stored (usually cache/upgrades/upgrade_state)
     * CLI:
     * php - PHP binary
     * Shadow:
     * pre_template - old template
     * post_template - new template
     * @var array
     */
    public $context;

    /**
     * Upgrade manifest
     * @var array
     */
    public $manifest;

    /**
     * Loaded $sugar_config
     * @var array
     */
    public $config;

    /**
     * Version being upgraded
     * @var sring
     */
    public $from_version;
    /**
     * Flavor being upgraded
     * @var sring
     */
    public $from_flavor;
    /**
     * Version to which we upgrade
     * @var sring
     */
    public $to_version;
    /**
     * Flavor to which we upgrade
     * @var sring
     */
    public $to_flavor;

    /**
     * Upgrade state
     * - old_version - Old version & flavor
     * - old_modules - Pre-upgrade module list
     * - stages - Stages success
     * - scripts - Scripts execution status
     * - files_to_delete - Files that upgrade scripts requested to be deleted
     * @var array
     */
    public $state = array();

    /**
     * Current stage
     * @var string
     */
    public $current_stage;

    /**
     * Did we already run Sugar init?
     * @var bool
     */
    public $sugar_initialized = false;

    /**
     * Publicly visible error message
     * @var string
     */
    public $error;

    /**
     * Was upgrader initialized?
     * @var bool
     */
    public $initialized;

    /**
     * Launches the next stage
     * @param string $stage
     */
    abstract public function runStage($stage);

    /**
     * Which scripts will be executed
     * @var int
     */
    protected $script_mask = UpgradeScript::UPGRADE_ALL;

    /**
     * Version number
     * @var string
     */
    public static $version = '1.0.0-dev';
    /**
     * Build number
     * @var string
     */
    public static $build = '999';

    /**
     * Copy data files
     */
    protected function commit()
    {
    	$this->manifest = $this->dataInclude("{$this->context['temp_dir']}/manifest.php", 'manifest');
        if(empty($this->manifest['copy_files']['from_dir'])) {
            return false;
        }
        $zip_from_dir = $this->context['temp_dir']."/".$this->manifest['copy_files']['from_dir'];
        $target_dir = $this->context['source_dir'];
        $files = $this->findFiles($zip_from_dir);
        foreach($files as $file) {
            $this->log("Copying $file");
            $this->ensureDir(dirname("$target_dir/$file"));
            if(!copy("$zip_from_dir/$file", "$target_dir/$file")) {
                return $this->error("Failed to copy: $file");
            }
        }
        return true;
    }

    /**
     * Load stored state
     */
    protected function loadState()
    {
        if(file_exists($this->context['state_file'])) {
            $state = array();
            include $this->context['state_file'];
            $this->state = $state;
        }
    }

    /**
     * Clean state & save it
     */
    public function cleanState()
    {
        $this->state = array();
        $this->saveState();
    }

    /**
     * Save stored state
     */
    protected function saveState()
    {
        $data = "<?php \$state = ".var_export($this->state, true).";";
        file_put_contents($this->context['state_file'], $data);
    }

    /**
     * Clean Sugar cache directories:
     * Rebuild autoloader cache
     * Clean smarty cache
     * modules cache
     * themes cache
     * jsLanguage cache
     */
    public function cleanCaches()
    {
        $this->log("Cleaning cache");
        if(is_callable(array('SugarAutoLoader', 'buildCache'))) {
            SugarAutoLoader::buildCache();
        } else {
            // delete dangerous files manually
            @unlink("cache/file_map.php");
            @unlink("cache/class_map.php");
        }
        $this->cleanDir($this->cacheDir("smarty"));
        $this->cleanDir($this->cacheDir("modules"));
        $this->cleanDir($this->cacheDir("jsLanguage"));
        $this->cleanDir($this->cacheDir("Expressions"));
        $this->cleanDir($this->cacheDir("themes"));
        $this->cleanDir($this->cacheDir("include/api"));
        $this->cleanDir($this->cacheDir("api/metadata"));
        $this->log("Cache cleaned");
    }

    /**
     * This function prebuilds the metadata cache
     *
     * The cache is prebuilt only for en_us and base platform for now.
     */
    public function prewarmCache()
    {
        //Now that installation is complete, we need to set this to false to have the caches build correctly
        $GLOBALS['installing'] = false;
        $this->log("Populating metadata cache");
        if(empty($GLOBALS['app_list_strings'])) {
            $GLOBALS['app_list_strings'] = return_app_list_strings_language('en_us');
        }
        require_once 'include/api/RestService.php';
        require_once 'clients/base/api/MetadataApi.php';
        $rest = new RestService();
        $rest->platform = 'base';
        $api = new MetadataApi();
        $api->getAllMetadata($rest, array());
        $api->getLanguage($rest, array('lang' => 'en_us'));
        $api->getPublicMetadata($rest, array());
        $api->getPublicLanguage($rest, array('lang' => 'en_us'));
        $this->log("Metadata cache populated");
    }

    /**
     * Execution will start here
     * This function must form context, create a class and run it
     */
    static public function start()
    {
        die("Must override this function in a driver");
    }

    public function __construct()
    {
        // empty ctor, init() does actual initialization
    }

    /**
     * Separate init function - to be able to verify args before init
     */
    public function init()
    {
        chdir($this->context['source_dir']);
        $this->loadConfig();
    	$this->context['temp_dir'] = $this->cacheDir("upgrades/temp");
        $this->ensureDir($this->context['temp_dir']);
        $this->context['state_file'] = $this->cacheDir('upgrades/').self::STATE_FILE;
        $this->loadState();
        $this->context['backup_dir'] = $this->config['upload_dir']."/upgrades/backup/".pathinfo($this->context['zip'], PATHINFO_FILENAME) . "-restore";
        if(isset($this->context['script_mask'])) {
            $this->script_mask &= $this->context['script_mask'];
        }
        $this->initialized = true;
    }

    /**
     * Display error
     * @param string $msg
     * @param bool $setError Set public error message to this error?
     * @return false Always returns false, so you can use this function to error out from other methods
     */
    public function error($msg, $setError = false)
    {
        $this->log("ERROR: $msg");
        if($setError) {
            $this->error = $msg;
        }
        $this->fail();
        return false;
    }

    /**
     * Log message
     * @param string $msg
     */
    public function log($msg)
    {
        if(empty($this->fp)) {
            $this->fp = @fopen($this->context['log'], 'a+');
        }
        if(empty($this->fp)) {
            die("Cannot open logfile: {$this->context['log']}");
        }

        fwrite($this->fp, date('r').' [Upgrader] - '.$msg."\n");
    }

    /**
     * Ensure directory exists
     * @param string $dir
     * @throws Exception
     */
    public function ensureDir($dir)
    {
        $mode = 0770;
        if(!empty($this->config['default_permissions']['dir_mode'])) {
            $mode = $this->config['default_permissions']['dir_mode'];
        }
        if(!is_dir($dir)) {
            mkdir($dir, $mode, true);
        }
        if(!is_dir($dir)) {
            throw new Exception("Unable to create directory: $dir");
        }
    }

    /**
     * Remove all files in the directory
     * @param string $dir
     */
    public function cleanDir($dir)
    {
        $files = $this->findFiles($dir);
        foreach($files as $file) {
            unlink("$dir/$file");
        }
    }

    /**
     * Copy directory to directory
     * @param string $path
     * @param string $pathto
     * @return boolean
     */
    public function copyDir($path, $pathto)
    {
        if(!is_dir($path)) {
            return copy($path, $pathto);
        } else {
            $this->ensureDir($pathto);
            $status = true;
            $d = dir( $path );
            if($d === false) {
                return false;
            }
            while(false !== ($f = $d->read())) {
                if( $f == "." || $f == ".." ) {
                    continue;
                }
                $status &= $this->copyDir( "$path/$f", "$pathto/$f" );
            }
            $d->close();
            return $status;
        }
    }

    /**
     * Remove directory with all files in it
     * @param string $path
     * @return boolean
     */
    public function removeDir($path)
    {
        if(is_file( $path)) {
        	return unlink($path);
        }
        if(!is_dir($path)){
            $this->log("Directory does not exist: $path, ignoring delete request");
        	return false;
        }

        $status = true;

        $d = dir($path);

        while(($f = $d->read()) !== false){
        	if( $f == "." || $f == ".." ){
        		continue;
        	}
        	if(is_file("$path/$f")) {
        	    unlink("$path/$f");
        	} else {
        	    $status &= $this->removeDir("$path/$f");
        	}
        	if(!$status) {
        	    return false;
        	}
        }
        $d->close();
        if(@rmdir($path) === FALSE){
        	$this->log("Failed to remove directory: $path");
        	return false;
        }
        return $status;
    }

    /**
     * Load sugar config
     */
    protected function loadConfig()
    {
        $sugar_config = array();
        if(!is_readable($this->context['source_dir']."/config.php")) {
            $this->error("{$this->context['source_dir']}/config.php can not be loaded!", true);
            return;
        }
        include($this->context['source_dir']."/config.php");
        if(is_readable($this->context['source_dir']."/config_override.php")) {
            include($this->context['source_dir']."/config_override.php");
        }
        $GLOBALS['sugar_config'] = $sugar_config;
        // by-ref so we can modify it
        $this->config =& $GLOBALS['sugar_config'];
    }

    /**
     * Load version file from path
     * @return array
     */
    protected function loadVersion()
    {
        if(!defined('sugarEntry')) define('sugarEntry', true);
        include "sugar_version.php";
        $sugar_flavor = strtolower($sugar_flavor);
        return array($sugar_version, $sugar_flavor);
    }

    /**
     * Return path in cache directory
     * @param string $dir
     * @return string
     */
    public function cacheDir($dir)
    {
        return rtrim($this->config['cache_dir'], '/')."/".$dir;
    }

    /**
     * Error reporting with localization, for user reporting.
     *
     * Since it requires translation, can not be used by pre-init scripts.
     * @param string $msg
     * @param array $args
     * @return bool
     */
    protected function errorPrint($msg, $args = null)
    {
        $msg = $this->translate($msg);
        if(!empty($args)) {
            array_unshift($args, $msg);
            $msg = call_user_func_array('sprintf', $args);
        }
        return $this->error($msg, true);
    }

    /**
     * Preflight check for PHP version
     */
    protected function preflightPHP()
    {
        if(version_compare(PHP_VERSION, "5.3.0", '<')) {
            return $this->error("PHP versions below 5.3.0 are not supported!", true);
        }
        return true;
    }

    /**
     * Preflight check for PHP version
     * @return boolean
     */
    protected function preflightPHPSettings()
    {
        if(ini_get("zend.ze1_compatibility_mode")) {
            return $this->error('PHP Backward Compatibility mode is turned on. Set zend.ze1_compatibility_mode to Off for proceeding further.', true);
        }
        if(ini_get('magic_quotes_gpc') || ini_get('magic_quotes_runtime')
            || (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
            || (function_exists('get_magic_quotes_runtime') && get_magic_quotes_runtime())
        ) {
            return $this->error("Magic quotes are deprecated and not supported in SugarCRM. Please read: http://www.php.net/manual/en/security.magicquotes.php", true);
        }
        return true;
    }

    /**
     * Check IIS settings
     * @return boolean
     */
    protected function preflightIIS()
    {
        if(empty($_SERVER['SERVER_SOFTWARE'])) {
            return true;
        }
        $server_software = $_SERVER['SERVER_SOFTWARE'];
        if(strpos($server_software,'Microsoft-IIS') !== false && preg_match_all('/^.*\/(\d+\.?\d*)$/',  $server_software, $out)) {
            $iis_version = $out[1][0];
        }
        if(empty($iis_version)) {
            return true;
        }
        if(version_compare($iis_version, "6.0", '<')) {
            return $this->error($this->translate('ERR_CHECKSYS_IIS_INVALID_VER')." ".$iis_version, true);
        }
        if(ini_get('fastcgi.logging')) {
            return $this->error($this->translate('ERR_CHECKSYS_FASTCGI_LOGGING'), true);
        }
        return true;
    }

    /**
     * Array or required modules - module => function
     */
    protected $requiredModules = array(
        "XML" => "xml_parser_create",
        "bcmath" => "bcadd",
        "zip" => "zip_open",
        "mbstring" => "mb_strlen",
    );

    /**
     * Check PHP modules
     * @return bool
     */
    protected function preflightPHPModules()
    {
        foreach($this->requiredModules as $module => $func) {
            if(!function_exists($func)) {
                return $this->error("Module $module does not exist (function $func checked)", true);
            }
        }
        return true;
    }

    /**
     * Check that temp directory is writable
     * @return bool
     */
    protected function preflightWriteUnzip()
    {
        if(!is_writable($this->context["temp_dir"])) {
            return $this->error("{$this->context["temp_dir"]} is not writable", true);
        }
        return true;
    }

    /**
     * Check that Sugar directory is writable
     * @return bool
     */
    protected function preflightWriteSugar()
    {
        if(!is_writable("config.php")) {
            return $this->error("config.php is not writable!", true);
        }

        if(!is_writable("config_override.php")) {
            return $this->error("config_override.php is not writable!", true);
        }
        return true;
    }

    /**
     * Check that custom directory is writable
     * @return bool
     */
    protected function preflightWriteCustom()
    {
        if(!is_writable("custom/")) {
            return $this->error("Custom directory not writable!", true);
        }
        $test = uniqid();
        file_put_contents("custom/upgradetest.$test", $test);
        $test2 = file_get_contents("custom/upgradetest.$test");
        @unlink("custom/upgradetest.$test");
        if($test != $test2) {
            return $this->error("Custom directory write test failed!", true);
        }
        return true;
    }

    /**
     * Check that DB settings are fine
     * @return bool
     */
    protected function preflightDB()
    {
        $check = $this->db->canInstall();
        if($check !== true) {
            $error = array_shift($check);
            array_unshift($check, $this->translate($error));
            return $this->error(call_user_func_array('sprintf', $check), true);
        }
        $tablename = "uptest".uniqid();
        if(!$this->db->query("CREATE TABLE $tablename(a int, b int)")) {
            $fail = "Table creation";
        } elseif(!$this->db->query("INSERT INTO $tablename(a,b) VALUES(1,2)")) {
            $fail = "Insertion";
        } elseif(!$this->db->query("UPDATE $tablename SET a=2 WHERE a=1")) {
            $fail = "Update";
        } elseif(!$this->db->query("DELETE FROM $tablename WHERE a=2")) {
            $fail = "Deletion";
        }
        if($this->db->tableExists($tablename)) {
            if(!$this->db->query("DROP TABLE $tablename") && empty($fail)) {
                $fail = "Table deletion";
            }
        }
        if(!empty($fail)) {
            return $this->error("$fail test failed, please check DB permissions.", true);
        }
        return true;
    }

    /**
     * Check if Sugar files are accessible
     * @return bool
     */
    protected function preflightSugarFiles()
    {
        if(!is_readable("config.php")) {
            return $this->error("Can not read config.php", true);
        }
        if(!is_readable("include/entryPoint.php")) {
            return $this->error("Can not read include/entryPoint.php", true);
        }
        if(empty($this->config)) {
            return $this->error('Failed to read Sugar configs.', true);
        }
        return true;
    }

    /**
     * List of preflight check functions
     * @var array
     */
    protected $preflightChecksBeforeInit = array(
        "PHP" => true, // check php version
        "SugarFiles" => true, // check if Sugar dirs are accessible
    );

    protected $preflightChecksAfterInit = array(
            "IIS" => true, // check IIS version
            "PHPModules" => true, // check PHP modules
            "PHPSettings" => true, // check php settings
            "WriteUnzip" => true, // check if zip dir is writeable
            "WriteSugar" => true, // check if Sugar directory is writable
            "WriteCustom" => true, // check if Sugar custom directory is writable
            "DB" => true, // check DB permissions
    );

    /**
     * Preflight checks for Sugar upgrade
     * TODO: enable preflights to use translated strings.
     * @param array $checks Checks list
     */
    public function preflight($checks)
    {
        foreach($checks as $check => $enabled) {
            if(!$enabled) continue;
            $checkfunc = "preflight$check";
            if(is_callable(array($this, $checkfunc))) {
                $this->log("Checking preflight: $check");
                if(!$this->$checkfunc()) {
                    return $this->error("Preflight check $check failed!");
                }
            } else {
                $this->log("Skipped check $check - no callback");
            }
        }
        return true;
    }

    /**
     * Verify upgrade package
     * @param string $zip ZIP filename
     * @param string $dir Temp dir to use for zip files
     */
    protected function verify($zip, $dir)
    {
        // Execute preflight checks before Sugar
        if(!$this->preflight($this->preflightChecksBeforeInit)) {
            return false;
        }
        $this->initSugar();
        // Execute preflight checks after Sugar
        if(!$this->preflight($this->preflightChecksAfterInit)) {
            return false;
        }
        // Check the user
        if(empty($GLOBALS['current_user']) || empty($GLOBALS['current_user']->id) || !$GLOBALS['current_user']->isAdmin()) {
            return $this->error("{$this->context['admin']} is not a valid admin user");
        }

        // Create target dir
        $unzip_dir = realpath($this->context['temp_dir']);
        $this->cleanDir($unzip_dir);
        // unzip file
        $zip = new ZipArchive;
        $res = $zip->open($this->context['zip']);
        if($res !== true) {
            return $this->error(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $this->context['zip'], $unzip_dir));
        }
        $this->log("Starting extracting {$this->context['zip']} to $unzip_dir");
        $res = $zip->extractTo($unzip_dir);
        if($res !== true) {
        	return $this->error(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $this->context['zip'], $unzip_dir));
        }
        unset($zip);

        // load manifest
        if(!file_exists("$unzip_dir/manifest.php")) {
            $this->cleanDir($unzip_dir);
            return $this->error("Package does not contain manifest.php");
        }
        // validate manifest
        list($this->from_version, $this->from_flavor) = $this->loadVersion();
        $res = $this->validateManifest("$unzip_dir/manifest.php");
        if($res !== true) {
            return $this->error($res);
        }
        $this->log("**** Upgrade checks passed");
        return true;
    }

    /**
     * Check if the data file does not have some prohibited constructs
     * @param string $file Filename
     */
    public function checkDataFile($file)
    {
        $tokens = @token_get_all(file_get_contents($file));
        $checkFunction = false;
        foreach($tokens as $index=>$token) {
            if(is_string($token)) {
                if($token == "`") {
                    return $this->error("Backtick is not allowed");
                }
                if($checkFunction && $token == '(') {
                    return $this->error("Functions are not allowed");
                }
                if($token == '$' && !empty($tokens[$index+1][0]) &&  $tokens[$index+1][0] == T_VARIABLE) {
                    return $this->error("Variable vars are not allowed");
                }
            } else {
                switch($token[0]) {
                    case T_WHITESPACE: continue;
                    case T_EVAL:
                    case T_EXIT:
                        return $this->error("{$token[1]}() is not allowed");
                    case T_STRING:
                    case T_VARIABLE:
                        $checkFunction = true;
                        break;
                    case T_OBJECT_OPERATOR:
                    case T_DOUBLE_COLON:
                        return $this->error("Object access is not allowed");
                    case T_REQUIRE_ONCE:
                    case T_REQUIRE:
                    case T_INCLUDE_ONCE:
                    case T_INCLUDE:
                        return $this->error("Includes are not allowed");
                    default:
                        $checkFunction = false;
                }
            }
        }
        return true;
    }

    /**
     * Include file with data
     * @param string $file
     * @param string $name name of the data array
     */
    protected function dataInclude($file, $name)
    {
        $this->log("Loading file $file");
        if(!$this->checkDataFile($file)) {
            return $this->error("Bad data file: $file");
        }
        include $file;
        return $$name;
    }

    /**
     * Translate message string
     * @param string $msg
     * @return string
     */
    protected function translate($msg)
    {
        if(isset($this->mod_strings[$msg])) {
            return $this->mod_strings[$msg];
        }
        return $msg;
    }

    protected function loadLangFile($langdir, $lang)
    {
        $mod_strings = array();
        $this->log("Loading language $lang from $langdir");
        $langfile = "$langdir/$lang.lang.php";
        if(!file_exists($langfile)) {
            $langfile = "$langdir/en_us.lang.php";
        }
        if(!file_exists($langfile)) {
            $this->log("Failed to find the language file");
            // fail, can't find file
            return $mod_strings;
        }
        $this->log("Loading language file from $langfile");
        include $langfile;
        if(file_exists("custom/$langfile")) {
            $this->log("Loading custom language file from custom/$langfile");
            include "custom/$langfile";
        }
        return $mod_strings;
    }

    /**
     * Load language strings
     * @return array
     */
    protected function loadStrings()
    {
        if(isset($this->config['default_language'])) {
            $lang = $this->config['default_language'];
        } else {
            $lang = 'en_us';
        }
        $this->mod_strings = $GLOBALS['mod_strings'] = $mod_strings = array();

        if(!empty($this->context['new_source_dir'])) {
            // add install strings if they are available, since some DB routines rely on it
            $langdirs[] = $this->context['new_source_dir']."/install/language";
            $langdirs[] = $this->context['new_source_dir']."/modules/UpgradeWizard/language";
        } elseif(!empty($this->context['source_dir'])) {
            $langdirs[] = $this->context['source_dir']."/install/language";
            $langdirs[] = $this->context['source_dir']."/modules/UpgradeWizard/language";
        }
        $langdirs[] = dirname(__FILE__)."/language";

        foreach($langdirs as $langdir) {
            if(!file_exists($langdir)) continue;

            $mod_strings = array_merge($mod_strings, $this->loadLangFile($langdir, $lang));
        }

        if(empty($mod_strings)) {
            // no language, bad
            $this->log("ERROR: Failed to find the language files, expect error messages to be broken");
            return array();
        }

        $this->mod_strings = $GLOBALS['mod_strings'] = $mod_strings;
        return $mod_strings;
    }

    protected function validateManifest($file)
    {
        // takes a manifest.php manifest array and validates contents
        $this->log('validating manifest.php file');
        $manifest = $this->dataInclude($file, 'manifest');

        if(!isset($manifest['type'])) {
        	return $this->mod_strings['ERROR_MANIFEST_TYPE'];
        }

        if($manifest['type'] != 'patch') {
        	return sprintf($this->mod_strings['ERROR_PACKAGE_TYPE'], $manifest['type']);
        }

        if(isset($manifest['acceptable_sugar_versions'])) {
        	$version_ok = false;
        	$matches_empty = true;
        	if(!empty($manifest['acceptable_sugar_versions']['exact_matches'])) {
        		$matches_empty = false;
        		foreach($manifest['acceptable_sugar_versions']['exact_matches'] as $match) {
        			if($match == $this->from_version) {
        				$version_ok = true;
        				break;
        			}
        		}
        	}
        	if(!$version_ok && !empty($manifest['acceptable_sugar_versions']['regex_matches'])) {
        		$matches_empty = false;
        		foreach($manifest['acceptable_sugar_versions']['regex_matches'] as $match) {
        			if(preg_match("/$match/i", $this->from_version)) {
        				$version_ok = true;
        				break;
        			}
        		}
        	}

        	if(!$matches_empty && !$version_ok) {
        		return sprintf($this->mod_strings['ERROR_VERSION_INCOMPATIBLE'], $this->from_version);
        	}
        }

        if(!empty($manifest['acceptable_sugar_flavors'])) {
        	$flavor_ok = false;
        	foreach($manifest['acceptable_sugar_flavors'] as $match) {
        		if(strtolower($match) == $this->from_flavor) {
        			$flavor_ok = true;
        			break;
        		}
        	}
        	if(!$flavor_ok) {
        		return sprintf($this->mod_strings['ERROR_FLAVOR_INCOMPATIBLE'], $this->from_flavor);
        	}
        }

        return true;
    }

    /**
     * Fail current stage
     * @returns false Always returns false, so you can use this function to error out from other methods
     */
    public function fail()
    {
        $this->success = false;
        if(!empty($this->current_stage)) {
            $this->state['stage'][$this->current_stage] = 'failed';
            $this->saveState();
        }
        return false;
    }

    /**
     * Initialize Sugar environment
     */
    protected function initSugar()
    {
        if($this->sugar_initialized) {
            return;
        }

        // BR-385 - This fixes the issues around SugarThemeRegistry fatals.  The cache needs rebuild on stage-post init of sugar
        if ($this->current_stage == 'post') {
            $this->cleanCaches();
        }

        if(!defined('sugarEntry')) define('sugarEntry', true);
        $this->log("Initializig SugarCRM environment");
        global $beanFiles, $beanList, $objectList, $timedate, $moduleList, $modInvisList, $sugar_config, $locale,
            $sugar_version, $sugar_flavor, $sugar_build, $sugar_db_version, $sugar_timestamp, $db, $locale, $installing, $bwcModules, $app_list_strings;
        $installing = true;
        include('include/entryPoint.php');
        $GLOBALS['current_language'] = $this->config['default_language'];
        if(empty($GLOBALS['current_language'])) {
            $GLOBALS['current_language'] = 'en_us';
        }
        $GLOBALS['log']	= LoggerManager::getLogger('SugarCRM');
        $this->db = $GLOBALS['db'] = DBManagerFactory::getInstance();
        SugarApplication::preLoadLanguages();
        $timedate = TimeDate::getInstance();
        $locale = new Localization();
        if (!isset ($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = '';
        }

        // Load user
        $GLOBALS['current_user'] = new User();
        $user_id = $this->db->getOne("select id from users where user_name = " . $this->db->quoted($this->context['admin']), false);
        $GLOBALS['current_user']->retrieve($user_id);
        // Prepare DB
        if($this->config['dbconfig']['db_type'] == 'mysql'){
        	//Change the db wait_timeout for this session
        	$now_timeout = $this->db->getOne("select @@wait_timeout");
        	$this->db->query("set wait_timeout=28800");
        	$now_timeout = $this->db->getOne("select @@wait_timeout");
        	$this->log("DB timeout set to $now_timeout");
        }
        // stop trackers
		$trackerManager = TrackerManager::getInstance();
        $trackerManager->pause();
        $trackerManager->unsetMonitors();
        $this->sugar_initialized = true;
        $this->loadStrings();
        $GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);
        $this->log("Done initializig SugarCRM environment");
    }

    /**
     * Sorting function for scripts order
     * @param int $a
     * @param int $b
     * @return number
     */
    public function sortByOrder($a, $b)
    {
        return $a->order - $b->order;
    }

    /**
     * Get files to be executed on this stage
     * The sources are:
     * - upgrade/scripts/
     * - custom/upgrade/scripts/
     * - modules/MODULENAME/upgrade/scripts/
     * - custom/modules/MODULENAME/upgrade/scripts/
     * @param string $dir Sugar directory
     * @param string $stage
     * @return array
     */
    protected function getScripts($dir, $stage)
    {
        $dirs = array("$dir/upgrade/scripts/", "$dir/custom/upgrade/scripts/");
        foreach(array("$dir/modules/", "$dir/custom/modules/") as $moduledir) {
            if(!is_dir($moduledir)) continue;
            try {
                foreach (new FilesystemIterator($moduledir, FilesystemIterator::KEY_AS_FILENAME|FilesystemIterator::SKIP_DOTS) as $filename => $fileInfo) {
                    if(!$fileInfo->isDir()) continue;
                    if(file_exists($moduledir.$filename."/upgrade/scripts/")) {
                        $dirs[] = $moduledir.$filename."/upgrade/scripts/";
                    }
                }
            } catch(Exception $e) {
                // ignore Iterator exceptions
                $this->log("FilesystemIterator: ".$e->getMessage());
            }
        }
        $results = array();
        $this->log("Checking for scripts: ".var_export($dirs, true));
        foreach($dirs as $dirname) {
            if(!file_exists($dirname.$stage)) continue;
            try {
                foreach(new FilesystemIterator($dirname.$stage, FilesystemIterator::SKIP_DOTS) as $fileInfo) {
                    if(!$fileInfo->isFile() || $fileInfo->getExtension() != "php") continue;

                    include_once $fileInfo->getPathName();
                    $scriptname = $fileInfo->getBasename(".php");
                    $classname = "SugarUpgrade".preg_replace('/^\d+_/', "", $scriptname); // strip numeric prefix, add SugarUpgrade
                    if(!class_exists($classname)) continue;
                     $newscript = new $classname($this);
                     if($newscript->type & $this->script_mask) {
                         // add class to results if it fits current mask
                         $results[$scriptname] = $newscript;
                     } else {
                         $this->log("Bypassing script $scriptname due to script mask");
                     }
                }
            } catch(Exception $e) {
                // ignore Iterator exceptions
                $this->log("FilesystemIterator: ".$e->getMessage());
            }
        }
        $cnt = count($results);
        $this->log("Found $cnt scripts");
        uasort($results, array($this, "sortByOrder"));
        return $results;
    }

    /**
     * Find files in directory
     * @param string $dir
     * @return array filenames in the directory
     */
    public function findFiles($dir)
    {
        if(!file_exists($dir)) {
            return array();
        }
        $dirlen = strlen(rtrim($dir, '/'))+1;
        $names = array();
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir,
                FilesystemIterator::SKIP_DOTS)) as $pathname => $fileInfo) {
            if(!$fileInfo->isFile()) continue;
            // strip dir/ from the name
            $names[] = substr($pathname, $dirlen);
        }
        return $names;
    }

    /**
     * Are we running in Windows?
     * @return boolean
     */
    public function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) == 'WIN';
    }

    /**
     * Create file and assign default permissions
     * @param string $path
     * @return boolean
     */
    public function createFile($path)
    {
        touch($path);
        if(!file_exists($path)) {
            $this->error("Could not create file: $path");
            return false;
        }
        if($this->isWindows()) {
            return true;
        }
        if(!empty($this->config['default_permissions']['file_mode'])){
        	chmod($path, $this->config['default_permissions']['file_mode']);
        }
        if(!empty($this->config['default_permissions']['user'])){
        	chown($path, $this->config['default_permissions']['user']);
        }
        if(!empty($this->config['default_permissions']['group'])){
        	chgrp($path, $this->config['default_permissions']['group']);
        }
        return true;
    }

    /**
     * Create file and put data into it
     * @param string $filename
     * @param mixed $data
     * @return boolean
     */
    public function putFile($filename, $data)
    {
        $this->createFile($filename);
        return file_put_contents($filename, $data);
    }

/**
 * Implodes some parts of version with specified delimiter, beta & rc parts are removed all time
 *
 * @example ('6.5.6') returns 656
 * @example ('6.5.6beta2') returns 656
 * @example ('6.5.6rc3') returns 656
 * @example ('6.6.0.1') returns 6601
 * @example ('6.5.6', 3, 'x') returns 65x
 * @example ('6', 3, '', '.') returns 6.0.0
 *
 * @param string $version like 6, 6.2, 6.5.0beta1, 6.6.0rc1, 6.5.7 (separated by dot)
 * @param int $size number of the first parts of version which are requested
 * @param string $lastSymbol replace last part of version by some string
 * @param string $delimiter delimiter for result
 * @return string
 */
    public function implodeVersion($version, $size = 0, $lastSymbol = '', $delimiter = '')
    {
        preg_match('/^\d+(\.\d+)*/', $version, $parsedVersion);
        if (empty($parsedVersion)) {
            return '';
        }

        $parsedVersion = $parsedVersion[0];
        $parsedVersion = explode('.', $parsedVersion);

        if ($size == 0) {
            $size = count($parsedVersion);
        }

        $parsedVersion = array_pad($parsedVersion, $size, 0);
        $parsedVersion = array_slice($parsedVersion, 0, $size);
        if ($lastSymbol !== '') {
            array_pop($parsedVersion);
            array_push($parsedVersion, $lastSymbol);
        }

        return implode($delimiter, $parsedVersion);
    }

    public function fileToDelete($file)
    {
        if(!isset($this->state['files_to_delete'])) {
            $this->state['files_to_delete'] = array();
        }
        if(is_array($file)) {
            $this->state['files_to_delete'] = array_merge($this->state['files_to_delete'], $file);
        } else {
            $this->state['files_to_delete'][] = $file;
        }
    }

    /**
     * Get package manifest
     * @return array
     */
    protected function getManifest()
    {
        return $this->dataInclude("{$this->context['temp_dir']}/manifest.php", 'manifest');
    }

    /**
     * PHP error handler for upgrade scripts, to log PHP errors
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @param array $errcontext
     */
    public function scriptErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        $this->log("PHP: [$errno] $errstr in $errfile at $errline");
    }

    /**
     * Run individual upgrade script
     * @param UpgradeScript $script
     */
    protected function runScript(UpgradeScript $script)
    {
        set_error_handler(array($this, 'scriptErrorHandler'), E_ALL & ~E_STRICT & ~E_DEPRECATED);
        ob_start();
        try {
            $script->run($this);
        } catch(Exception $e) {
            $this->error("Exception: ".$e->getMessage());
        }
        $out = ob_get_clean();
        if($out) {
            $this->log("OUTPUT: $out");
        }
        restore_error_handler();
    }

    /**
     * Run set of scripts
     * @param string $stage
     * @return boolean
     */
    protected function runScripts($stage)
    {
    	$this->manifest = $this->getManifest();
    	if(!empty($this->manifest['copy_files']['from_dir'])) {
    	    $this->context['new_source_dir'] = $this->context['temp_dir']."/".$this->manifest['copy_files']['from_dir'];
    	}
    	$scripts = $this->getScripts($this->context['new_source_dir'], $stage);
    	$this->to_version = $this->manifest['version'];
    	if(!empty($this->manifest['flavor'])) {
    	    $this->to_flavor = $this->manifest['flavor'];
    	} else {
    	    $this->to_flavor = $this->from_flavor;
    	}

    	foreach($scripts as $name => $script) {
    	    if(!empty($this->state['scripts'][$name]) && $this->state['scripts'][$name] == 'done') {
    	        $this->log("Skipping script $name - already done");
    	        continue;
    	    }
    	    $this->log("Starting script $name");
    	    $this->state['scripts'][$name] = 'started';
    	    $this->saveState();
    	    $this->runScript($script);
    	    $this->log("Finished script $name");
    	    // Just in case some script did something wrong, go back to proper dir
    	    chdir($this->context['source_dir']);
    		if(!$this->success) {
        	    // script called $this->fail
    		    $this->state['scripts'][$name] = 'failed';
    		    $this->saveState();
    		    return false;
    		} else {
    		    $this->state['scripts'][$name] = 'done';
    		    $this->saveState();
    		}
    	}
    	return true;
    }

    /**
     * Check if $is flavor is of flavor $flav or above
     * @param string $is
     * @param string $flav
     * @return boolean
     */
    protected function isFlavor($is, $flav)
    {
        switch($flav) {
            case 'pro':
                if($is == 'pro') {
                    return true;
                }
            case 'corp':
                if($is == 'corp') {
                    return true;
                }
            case 'ent':
                if($is == 'ent') {
                    return true;
                }
            case 'ult':
                if($is == 'ult') {
                    return true;
                }
                return false;
        }
        return true;
    }

    /**
     * Check if we're upgrading to certain flavor or up
     * @param string $flav
     * @return boolean
     */
    public function toFlavor($flav)
    {
        return $this->isFlavor($this->to_flavor, $flav);
    }

    /**
     * Check if we're upgrading from certain flavor or up
     * @param string $flav
     * @return boolean
     */
    public function fromFlavor($flav)
    {
        return $this->isFlavor($this->from_flavor, $flav);
    }

    /**
     * Save config.php
     */
    public function saveConfig()
    {
        ksort($this->config);
        write_array_to_file("sugar_config", $this->config, $this->context['source_dir']."/config.php");
    }

    protected $stages = array('unpack', 'pre', 'commit', 'post', 'cleanup');

    /**
     * Run one step in the upgrade
     * @param string $stage
     * @return boolean|string true if done, false if error, otherwise next step
     */
    protected function runStep(&$stage)
    {
        if($stage == 'continue') {
            if(!empty($this->state['stage'])) {
                foreach($this->stages as $stage) {
                    if(empty($this->state['stage'][$stage]) ||  $this->state['stage'][$stage] != 'done') {
                        break;
                    }
                }
                if(!empty($this->state['stage'][$stage]) && $this->state['stage'][$stage] == 'done') {
                    // everything is done
                    $this->log("Nothing to continue, everything is done.");
                    return true;
                }
                $this->log("Continuing from $stage");
            }
        }

        if($stage) {
        	$stage_num = array_search($stage, $this->stages);
        } else {
        	$stage = $this->stages[0];
        	$stage_num = 0;
        }
        if($stage_num === false) {
        	return false;
        }
        if(!$this->runStage($stage)) {
            return false;
        }
        if(++$stage_num >= count($this->stages)) {
            return true;
        } else {
            return $this->stages[$stage_num];
        }
    }

    /**
     * Run given stage
     * @param string $stage stage on which we're running
     * @return boolean
     */
    public function run($stage)
    {
        ini_set('memory_limit',-1);
        ini_set('error_reporting', E_ALL & ~E_STRICT & ~E_DEPRECATED);
        $this->log("Stage $stage staring");
        try {
            $this->current_stage = $stage;
            $this->state['stage'][$stage] = 'started';
            $this->saveState();
            switch($stage) {
                case "unpack":
                    // Verify package
                    if(!$this->verify($this->context['zip'], $this->context['temp_dir'])) {
                        $this->error("Package verificaition failed");
                        return false;
                    }
                    break;
                case "pre":
                    // Run pre-upgrade
                    // TODO: pre-script are currently taken from old envt.
                    // We need to consider how to take them from new envt instead.
    	            $this->initSugar();
                    list($this->from_version, $this->from_flavor) = $this->loadVersion();
                    $this->state['old_version'] = array($this->from_version, $this->from_flavor);
                    $this->saveState();
                    if(!$this->runScripts("pre")) {
                        $this->error("Pre-upgrade stage failed!");
                        return false;
                    }
                    break;
                case "commit":
                    // Run copy files
                    if(!$this->commit()) {
                        $this->error("Commit stage failed!");
                        return false;
                    }
                    break;
                case "post":
                    // Run post-upgrade
    	            $this->initSugar();
                    $this->cleanCaches();
    	            list($this->from_version, $this->from_flavor) = $this->state['old_version'];
                    if(!$this->runScripts("post")) {
                        $this->error("Post-upgrade stage failed!");
                        return false;
                    }
                    $this->saveConfig();
                    $this->cleanCaches();
                    break;
                case "cleanup":
                    // do it on cleanup so that caches from post won't interfere
                    $this->initSugar();
                    $this->prewarmCache();
                    // Remove temp files
                    $this->removeTempFiles();
                    break;
                default:
                    $this->error("Wrong stage: $stage");
                    return false;
            }
        } catch(Exception $e) {
            $this->error("Exception: ".$e->getMessage());
            return false;
        }
        $this->state['stage'][$stage] = 'done';
        $this->saveState();
        $this->log("Stage $stage done");
        return true;
    }

    /**
     * Remove temp files for upgrader
     */
    public function removeTempFiles()
    {
        $this->removeDir($this->context['temp_dir']);
    }

    /**
     * Backup the file
     * @param string $file
     * @return boolean
     */
    public function backupFile($file)
    {
        if(!file_exists($file)) {
            // no point to backup file that isn't there
            return true;
        }
        if(isset($this->context['backup']) && !$this->context['backup']) {
            // backup disabled by option
            return true;
        }
        $target = $this->context['backup_dir']  . '/'. $file;
        $path = pathinfo($target, PATHINFO_DIRNAME);
        if(!empty($path)) {
            $this->ensureDir($path);
        }
        $this->log("Backing up $file");
        if(is_dir($file)) {
            return $this->copyDir($file, $target);
        } else {
            return copy($file, $target);
        }

    }

    const VERSION_FILE = 'upgrader_version.json';

    /**
     * Get version and build number for this package
     * @return array($version, $build)
     */
    public static function getVersion()
    {
        $version = self::$version;
        $build = self::$build;
        if(file_exists(self::VERSION_FILE)) {
            $data = json_decode(file_get_contents(self::VERSION_FILE), true);
            if(empty($data)) {
                return array($version, $build);
            }
            if(!empty($data['upgrader_version'])) {
                $version = $data['upgrader_version'];
            }
            if(!empty($data['sugar_build'])) {
                $build = $data['sugar_build'];
            }
        }
        return array($version, $build);
    }
}

/**
 * Base class for upgrade scripts
 */
abstract class UpgradeScript
{
    /**
     * Script updates core files
     * Should not be run on db-only updates
     */
    const UPGRADE_CORE = 1;
    /**
     * Script updates DB data
     * Should be run on all updates
     */
    const UPGRADE_DB = 2;
    /**
     * Script updates customization or config files
     * Should not be run on db-only updates, but should be run on shadow upgrades
     */
    const UPGRADE_CUSTOM = 4;
    /**
     * Script does unknown updates
     * Should always be run
     */
    const UPGRADE_ALL = 0xFF;

    /**
     * Sorting order, lower is first
     * @var int
     */
    public $order = 9999;

    /**
     * Version where this script appears
     * @var string
     */
    public $version = "6.7.0";
    public $type = self::UPGRADE_ALL;
    /**
     * Upgrade driver
     * @var UpgradeDriver
     */
    public $upgrader;

    public function __construct($upgrader)
    {
        $this->upgrader = $upgrader;
    }

    abstract public function run();

    public function __get($name)
    {
        return $this->upgrader->$name;
    }

    public function __call($name, $args)
    {
        if(is_callable(array($this->upgrader, $name))) {
            return call_user_func_array(array($this->upgrader, $name), $args);
        }
        throw new Exception("Can not call unknown method $name");
    }
}

