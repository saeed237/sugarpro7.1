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
 * SidecarView.php
 *
 * This class extends SugarView to provide sidecar framework specific support.  Modules
 * that may wish to use the sidecar framework may extend this class to provide module
 * specific support.
 *
 */

require_once('include/MVC/View/SugarView.php');
require_once('include/SugarTheme/SidecarTheme.php');
require_once 'ModuleInstall/ModuleInstaller.php';

class SidecarView extends SugarView
{
    protected $configFileName = "config.js";
    protected $configFile;
    
    public function __construct()
    {
        $this->configFile = sugar_cached($this->configFileName);
        parent::SugarView();
    }

    /**
     * Authorization token to integrate into the view
     * @var array
     */
    protected $authorization;

    /**
     * This method checks to see if the configuration file exists and, if not, creates one by default
     *
     */
    public function preDisplay()
    {
        global $app_strings;

        //Rebuild config file if it doesn't exist
        if(!file_exists($this->configFile)) {
           ModuleInstaller::handleBaseConfig();
        }
        $this->ss->assign("configFile", $this->configFile);
        $config = ModuleInstaller::getBaseConfig();
        $this->ss->assign('configHash', md5(serialize($config)));

        require_once("jssource/minify_utils.php");
        $minifyUtils = new SugarMinifyUtils();
        $sugarSidecarPath = ensureCache($minifyUtils, ".");
        $this->ss->assign("sugarSidecarPath", $sugarSidecarPath);

        // TODO: come up with a better way to deal with the various JS files
        // littered in sidecar.tpl.
        $voodooFile = 'custom/include/javascript/voodoo.js';
        if (SugarAutoLoader::fileExists($voodooFile)) {
            $this->ss->assign('voodooFile', $voodooFile);
        }

        //Load sidecar theme css
        $theme = new SidecarTheme();
        $this->ss->assign("css_url", $theme->getCSSURL());
        $this->ss->assign("developerMode", inDeveloperMode());

        //Loading label
        $this->ss->assign('LBL_LOADING', $app_strings['LBL_ALERT_TITLE_LOADING']);

        $slFunctionsPath = inDeveloperMode() ? "cache/Expressions/functions_cache_debug.js" : "cache/Expressions/functions_cache.js";
        if (!is_file($slFunctionsPath)) {
            $GLOBALS['updateSilent'] = true;
            include("include/Expressions/updatecache.php");
        }
        $this->ss->assign("SLFunctionsPath", $slFunctionsPath);
        if(!empty($this->authorization)) {
            $this->ss->assign('appPrefix', $config['env'].":".$config['appId'].":");
            $this->ss->assign('authorization', $this->authorization);
        }
    }

    /**
     * This method sets the config file to use and renders the template
     *
     */
    public function display()
    {
        $this->ss->display(SugarAutoLoader::existingCustomOne('include/MVC/View/tpls/sidecar.tpl'));
    }

    /**
     * This method returns the theme specific CSS code to be used for the view
     *
     * @return string HTML formatted string of the CSS stylesheet files to use for view
     */
    public function getThemeCss()
    {
        // this is left empty since we are generating the CSS via the API
    }

    protected function _initSmarty()
    {
        $this->ss = new Sugar_Smarty();
        // no app_strings and mod_strings needed for sidecar
    }
}
