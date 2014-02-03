<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 * Description:  Contains a variety of utility functions used to display UI
 * components such as form headers and footers.  Intended to be modified on a per
 * theme basis.
 ********************************************************************************/


require_once 'vendor/lessphp/lessc.inc.php';
require_once 'include/api/SugarApiException.php';

/**
 * Class that provides tools for working with a theme.
 * @api
 */
class SidecarTheme
{
    /**
     * @var string Client Name
     */
    private $myClient;

    /**
     * @var string Theme Name
     */
    private $myTheme;

    /**
     * @var array A set of useful paths
     */
    private $paths;

    /**
     * @var array Less variables of the theme
     */
    private $variables = array();

    /**
     * @var array Less files to compile
     */
    public $lessFilesToCompile = array('bootstrap', 'sugar');


    /**
     * @var lessc dependency
     */
    protected $compiler;

    /**
     * Constructor
     *
     * @param string $client Client Name
     * @param string $themeName Theme Name
     */
    public function __construct($client = 'base', $themeName = '')
    {
        // Get user theme if the themeName isn't defined
        if (empty($themeName)) {
            $themeName = $this->getUserTheme();
        }

        $this->myClient = $client;
        $this->myTheme = $themeName;
        $this->paths = $this->makePaths($client, $themeName);
        $this->compiler = new lessc;
    }

    /**
     * Retrieve CSS files from cache for this theme
     * Compile missing files if the theme has metadata definition
     * Compile default theme otherwise
     *
     * @return array Locations of CSS files for this theme
     */
    public function getCSSURL()
    {
        $filesInCache = $this->retrieveCssFilesInCache();

        //If we found css files in cache we can return css urls
        if (count($filesInCache) === count($this->lessFilesToCompile)) {
            return $this->returnFileLocations($filesInCache);
        }
        //Since we did not find css files in cache we have to compile the theme.
        //First check if the theme has metadata, otherwise compile the default theme instead
        if ($this->myTheme !== 'default' && !$this->isDefined()) {
            $clientDefaultTheme = new SidecarTheme($this->myClient, 'default');
            return $clientDefaultTheme->getCSSURL();
        }

        //Arrived here we are going to compile missing css files
        $missingFiles = array_diff($this->lessFilesToCompile, array_keys($filesInCache));
        foreach ($missingFiles as $lessFile) {
            $filesInCache[$lessFile] = $this->compileFile($lessFile);
        }

        return $this->returnFileLocations($filesInCache);
    }

    /**
     * Compile all the css files and save the file hashes
     *
     * @param bool $min True to minify the CSS
     *
     * @return array Generated file hashes
     */
    public function compileTheme($min = true)
    {
        $files = array();
        foreach ($this->lessFilesToCompile as $lessFile) {
            $files[$lessFile] = $this->compileFile($lessFile, $min);
        }

        //Cache the hash in sugar_cache so we don't have to hit the filesystem for etag comparisons
        sugar_cache_put($this->paths['hashKey'], $files);
        return $files;
    }

    /**
     * Compile all the css files but don't save
     *
     * @param bool $min True to minify the CSS, false otherwise
     *
     * @return string Plaintext CSS
     * @throws SugarApiExceptionError
     */
    public function previewCss($min = true)
    {
        try {
            $css = array();
            foreach ($this->lessFilesToCompile as $lessFile) {
                $css[$lessFile] = $this->compileFile($lessFile, $min, false);
            }
            return implode('', array_values($css));
        } catch (exception $e) {
            throw new SugarApiExceptionError('lessc fatal error:<br />' . $e->getMessage());
        }
    }

    /**
     * Compile a less file and save the output css file
     *
     * @param string $lessFile Name of Less file to compile
     * @param bool $min True to minify the CSS
     * @param bool $writeFile True to write the file on the file system
     *
     * @return mixed Plaintext CSS if writeFile is false, a hash otherwise
     * @throws SugarApiExceptionError
     */
    public function compileFile($lessFile, $min = true, $writeFile = true)
    {
        try {
            //Load and set variables
            $this->loadVariables();
            if (!isset($this->variables['baseUrl'])) {
                //Relative path from /cache/themes/clients/PLATFORM/THEMENAME/bootstrap.css
                //              to   /styleguide/assets/
                $this->setVariable('baseUrl', '"../../../../../styleguide/assets"');
            }
            $this->compiler->setVariables($this->loadVariables());

            if ($min) {
                $this->compiler->setFormatter('compressed');
            }
            $css = $this->compiler->compileFile($this->getLessFileLocation($lessFile));

            //If preview return css;
            if (!$writeFile) {
                return $css;
            }
            //Otherwise write file and return hash
            $hash = md5($css);
            // Write bootstrap.css on the file system
            sugar_mkdir($this->paths['cache'], null, true);
            sugar_file_put_contents($this->getCssFileLocation($lessFile, $hash), $css);
            return $hash;
        } catch (exception $e) {
            throw new SugarApiExceptionError('lessc fatal error:<br />' . $e->getMessage());
        }
    }

    /**
     * Determines if the theme exists
     *
     * @return bool True if able to retrieve theme definition file in the file system.
     */
    public function isDefined()
    {
        // We compile expected theme by if we found variables.less in the file system (in /custom/themes or /themes)
        $customThemeVars = $this->paths['custom'] . 'variables.less';
        $baseThemeVars = $this->paths['base'] . 'variables.less';
        return SugarAutoLoader::fileExists($customThemeVars) || SugarAutoLoader::fileExists($baseThemeVars);
    }

    /**
     * Parse the variables.less metadata files of the theme
     *
     * @return string Array of categorized variables
     */
    public function getThemeVariables()
    {
        $desiredTheme = $this->paths;
        $clientDefault = $this->makePaths($this->myClient, 'default');
        $baseDefault = $this->makePaths('base', 'default');

        // Crazy override from :
        // - the base/default base theme
        // - the base/default custom theme
        // - the client/default base theme
        // - the client/default custom theme
        // - the client/themeName base theme
        // - the client/themeName custom theme
        $variables = $this->parseFile($baseDefault['base'] . 'variables.less');

        $files = array(
            $baseDefault['custom'],
            $clientDefault['base'],
            $clientDefault['custom'],
            $desiredTheme['base'],
            $desiredTheme['custom']
        );

        foreach ($files as $file) {
            $file .= 'variables.less';
            if (file_exists($file)) {
                $variables = sugarArrayMerge($variables, $this->parseFile($file));
            }
        }
        return $variables;
    }

    /**
     * Write the theme metadata file. This method actually does:
     * - Read contents of base/default theme metadata file
     * - Override variables (if $resetBaseDefaultTheme is false)
     * - Save the file as the theme metadata file.
     *
     * @param bool $reset True if you want to reset the theme to the base default theme
     */
    public function saveThemeVariables($reset = false)
    {
        // take the contents from /themes/clients/base/default/variables.less
        $baseDefaultTheme = new SidecarTheme('base', 'default');
        $baseDefaultThemePaths = $baseDefaultTheme->getPaths();
        $contents = file_get_contents($baseDefaultThemePaths['base'] . 'variables.less');

        if (is_dir($this->paths['cache'])) {
            rmdir_recursive($this->paths['cache']);
        }

        if ($reset) {
            //In case of reset we just need to delete the theme files.
            if (is_dir($this->paths['custom'])) {
                rmdir_recursive($this->paths['custom']);
            }
        } else {
            //override the base variables with variables passed in arguments
            foreach ($this->variables as $lessVar => $lessValue) {
                // override the variables
                $lessValue = html_entity_decode($lessValue);
                $contents = preg_replace("/@$lessVar:(.*);/", "@$lessVar: $lessValue;", $contents);
            }
            $contents = str_replace('\n', '', $contents);

            // save the theme variables in /themes/clients/$client/$themeName/variables.less
            sugar_mkdir($this->paths['custom'], null, true);
            sugar_file_put_contents($this->paths['custom'] . 'variables.less', $contents);
        }
    }

    /**
     * Load the less variables of the theme. By default it prevents from parsing the metadata files twice.
     *
     * @param bool $force True if you want to force reloading the theme variables
     *
     * @return array Variables
     */
    public function loadVariables($force = false)
    {
        if (!empty($this->variables) && !$force) {
            return $this->variables;
        }
        foreach ($this->getThemeVariables() as $variables) {
            foreach ($variables as $lessVar => $lessValue) {
                $this->setVariable($lessVar, $lessValue);
            }
        }
        return $this->variables;
    }

    /**
     * Setter for private variables
     *
     * @param string $variable Variable name
     * @param string $value Variable value
     *
     * @throws InvalidArgumentException
     */
    public function setVariable($variable, $value)
    {
        if (empty($value) || !is_string($value)) {
            throw new \InvalidArgumentException('Invalid Less variable: ' . $variable);
        }
        $this->variables[$variable] = $value;
    }

    /**
     * Setter for private variables
     *
     * @param array $variables Array of variables
     */
    public function setVariables(array $variables)
    {
        foreach ($variables as $var => $value) {
            $this->setVariable($var, $value);
        }
    }

    /**
     * Getter for paths
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Get the user preferred theme
     *
     * @return string themeName
     */
    private function getUserTheme()
    {
        if (!empty($_COOKIE['sugar_user_theme'])) {
            return $_COOKIE['sugar_user_theme'];
        } elseif (!empty($_SESSION['authenticated_user_theme'])) {
            return $_SESSION['authenticated_user_theme'];
        } else {
            global $sugar_config;
            return $sugar_config['default_theme'];
        }
    }

    /**
     * Builds the paths attribute
     * 'base' : the path of the base theme
     * 'custom' : the path of the customized theme
     * 'cache' : the path of the cached theme
     * 'clients' : the clients path of less files to compile
     * 'hashKey' the theme hash key
     *
     * @param string $client Client Name
     * @param string $themeName Theme Name
     *
     * @return array Paths related to this client and theme
     */
    private function makePaths($client, $themeName)
    {
        return array(
            'base' => 'styleguide/themes/clients/' . $client . '/' . $themeName . '/',
            'custom' => 'custom/themes/clients/' . $client . '/' . $themeName . '/',
            'cache' => sugar_cached('themes/clients/' . $client . '/' . $themeName . '/'),
            'clients' => 'styleguide/less/clients/',
            'hashKey' => 'theme:' . $client . ':' . $themeName,
        );
    }

    /**
     * Does a preg_match_all on a less file to retrieve a type of less variables
     *
     * @param string $pattern Pattern to search
     * @param string $input Input string
     *
     * @return array Variables found
     */
    private function parseLessVars($pattern, $input)
    {
        $output = array();
        preg_match_all($pattern, $input, $match, PREG_PATTERN_ORDER);
        foreach ($match[1] as $key => $lessVar) {
            $output[$lessVar] = $match[3][$key];
        }
        return $output;
    }

    /**
     * Parse a less file to retrieve all types of less variables
     * - 'mixins' defs         @varName:      mixinName;
     * - 'hex' colors          @varName:      #aaaaaa;
     * - 'rgba' colors         @varName:      rgba(0,0,0,0);
     * - 'rel' related colors  @varName:      @relatedVar;
     * - 'bg'  backgrounds     @varNamePath:  "./path/to/img.jpg";
     *
     * @param string $file The file to parse
     *
     * @return array Variables found by type
     */
    private function parseFile($file)
    {
        $contents = file_get_contents($file);
        $output = array();
        $output['mixins'] = $this->parseLessVars("/@([^:|@]+):(\s+)([^\#|@|\(|\"]*?);/", $contents);
        $output['hex'] = $this->parseLessVars("/@([^:|@]+):(\s+)(\#.*?);/", $contents);
        $output['rgba'] = $this->parseLessVars("/@([^:|@]+):(\s+)(rgba\(.*?\));/", $contents);
        $output['rel'] = $this->parseLessVars("/@([^:|@]+):(\s+)(@.*?);/", $contents);
        $output['bg'] = $this->parseLessVars("/@([^:|@]+Path):(\s+)\"(.*?)\";/", $contents);
        return $output;
    }

    /**
     * Retrieve CSS files in cache. This method actually does:
     * - Get file hashes from the cache.
     * - If file hashes are found verify that the file exists.
     * - If file hashes are not found try to retrieve some css files from the file system
     *
     * @return array Css files found in cache
     */
    private function retrieveCssFilesInCache()
    {
        $filesInCache = array();

        //First check if the file hashes are cached so we don't have to load the metadata manually to calculate it
        $hashKey = $this->paths['hashKey'];
        $hashArray = sugar_cache_retrieve($hashKey);

        if (is_array($hashArray) && count($hashArray) === count($this->lessFilesToCompile)) {
            foreach ($hashArray as $lessFile => $hash) {
                $file = $this->getCssFileLocation($lessFile, $hash);
                if (file_exists($file)) {
                    $filesInCache[$lessFile] = $hash;
                }
            }
        } else {
            /**
             * Checks the filesystem for a generated css file
             * This is useful on systems without a php memory cache
             * or if the memory cache is filled
             */
            $files = glob($this->paths['cache'] . '*.css', GLOB_NOSORT);
            foreach ($files as $file) {
                $nameParts = explode('_', pathinfo($file, PATHINFO_FILENAME));
                $filesInCache[$nameParts[0]] = $nameParts[1];
            }
        }
        return $filesInCache;
    }

    /**
     * Get the location of a compiler less file
     *
     * @param string $lessFile
     *
     * @return string of less files to compile
     */
    private function getLessFileLocation($lessFile)
    {
        $file = $this->paths['clients'] . $this->myClient . '/' . $lessFile . '.less';
        $baseFile = $this->paths['clients'] . 'base' . '/' . $lessFile . '.less';
        return file_exists($file) ? $file : $baseFile;
    }

    /**
     * Get the location of a css file
     *
     * @param string $compilerName
     * @param string $hash
     *
     * @return string file location
     */
    private function getCssFileLocation($compilerName, $hash)
    {
        return $this->paths['cache'] . $compilerName . '_' . $hash . ".css";
    }

    /**
     * Save file hashes and format response
     *
     * @param array $filesArray File hashes
     *
     * @return array Array of css file locations
     */
    private function returnFileLocations(array $filesArray)
    {
        $urls = array();
        sugar_cache_put($this->paths['hashKey'], $filesArray);
        foreach ($this->lessFilesToCompile as $lessFile) {
            $urls[$lessFile] = $this->getCssFileLocation($lessFile, $filesArray[$lessFile]);
        }
        return $urls;
    }
}
