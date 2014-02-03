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

// Get the meta data files handler for the new setup
require_once 'modules/ModuleBuilder/parsers/MetaDataFiles.php';
require_once 'include/MetaDataManager/MetaDataConverter.php';

abstract class SidecarAbstractMetaDataUpgrader
{
    /**
     * The upgrader that triggers the upgrade process
     *
     * @var SidecarMetaDataUpgrader
     */
    protected $upgrader;

    /**
     * File path to the file
     *
     * @var string
     */
    protected $filepath;

    /**
     * The name of the module that this object will be getting view defs for
     *
     * @var string
     */
    protected $module;

    /**
     * The view client to work on (portal|wireless)
     *
     * @var string
     */
    protected $client;

    /**
     * The type of file this is (working, custom, history
     *
     * @var string
     */
    protected $type;

    /**
     * The base name of the file
     *
     * @var sring
     */
    protected $basename;

    /**
     * The name of the file
     *
     * @var string
     */
    protected $filename;

    /**
     * The timestamp of the save for history types
     *
     * @var string
     */
    protected $timestamp;

    /**
     * The fullpath to the filename
     *
     * @var string
     */
    protected $fullpath;

    /**
     * The name of the package that this module belongs to for custom modules
     *
     * @var string
     */
    protected $package;

    /**
     * The type of view we are working on (list, edit, detail, search)
     * @var
     */
    protected $viewtype;

    /**
     * Is the legacy view sidecar-type view too?
     * @var bool
     */
    protected $sidecar;

    /**
     * The legacy style view defs
     *
     * @var array
     */
    protected $legacyViewdefs = array();

    /**
     * The sidecar style view defs
     *
     * @var array
     */
    protected $sidecarViewdefs = array();

    /**
     * Deployed state of the module. This has an effect on how the filenaming is
     * handled
     *
     * @var bool
     */
    protected $deployed = true;

    /**
     * Should we delete pre-upgrade files?
     * @var bool
     */
    public $deleteOld = true;

    /**
     * Mapping of viewdef vars for a client and viewtype
     * @var array
     */
    protected $variableMap = array(
        'wireless' => array(
            'list'   => 'listViewDefs',
            'edit'   => 'viewdefs',
            'detail' => 'viewdefs',
        ),
        'base' => array(
            'list'   => 'listViewDefs',
            'edit'   => 'viewdefs',
            'detail' => 'viewdefs',
            'filter' => 'searchdefs',
            'subpanel' => 'subpanel_layout'
        ),
    );

    /**
     * Names of the views that this object will work on
     *
     * @var array
     */
    protected $views = array(
        'wirelessedit'   => MB_WIRELESSEDITVIEW,
        'wirelessdetail' => MB_WIRELESSDETAILVIEW,
        'wirelesslist'   => MB_WIRELESSLISTVIEW,
        'wirelesssearch' => MB_WIRELESSBASICSEARCH,
        'baselist'        => MB_SIDECARLISTVIEW,
        'baserecordview'  => MB_RECORDVIEW,
        'basefilter'      => MB_SEARCHVIEW,
    );

    /**
     * The indexes within the old viewdefs after the module name for each client
     * ex. $viewdefs['Bugs']['EditView']
     *
     * @var array
     */
    protected $vardefIndexes = array(
        'wirelessedit'   => 'EditView',
        'wirelesslist'   => '',
        'wirelessdetail' => 'DetailView',
        'baselist'       => '',
        'baseedit'       => 'EditView',
        'basedetail'     => 'DetailView',
        'basefilter'     => '',
    );

    /**
     * Metadata converted instance
     * @var MetaDataConverter
     */
    protected $metaDataConverter;

    /**
     * The actual legacy defs converter. For search this will do nothing as search
     * is really just a file move and rename.
     */
    abstract function convertLegacyViewDefsToSidecar();

    /**
     * Object constructor, simply sets required information into the object
     *
     * @param SidecarMetaDataUpgrader $upgrader The original entry into the upgrade process
     * @param array $file Information related to the file being worked on. There should be
     *                    an index for each property in this object.
     */
    public function __construct(SidecarMetaDataUpgrader $upgrader, Array $file) {
        $this->upgrader = $upgrader;

        foreach ($file as $prop => $val) {
            $this->$prop = $val;
        }

        if (!empty($this->fullpath)) {
            $this->filename = basename($this->fullpath);
        }
        $this->metaDataConverter = new MetaDataConverter();
    }

    /**
     * Check if we actually want to upgrade this file
     * @return boolean
     */
    public function upgradeCheck()
    {
        // by default, it's always OK
        return true;
    }

    /**
     * Handles the actual upgrading for list metadata
     *
     * THIS WILL BE REDEFINED FOR SEARCH
     *
     * @return boolean
     */
    public function upgrade() {
        if(!$this->upgradeCheck()) {
            $this->logUpgradeStatus("Upgrade declined for $this->fullpath, returning");
            return true;
        }
        // Get our legacy view defs
        $this->logUpgradeStatus("setting {$this->client}[{$this->type}] legacy viewdefs for {$this->module}:{$this->viewtype}");
        $this->setLegacyViewdefs();

        // Convert them
        $this->logUpgradeStatus("converting {$this->client}[{$this->type}] legacy viewdefs for {$this->module}:{$this->viewtype} to Sugar 7 format");
        $this->convertLegacyViewDefsToSidecar();

        // Save the new file and report it
        return $this->handleSave();
    }

    /**
     * Handles the actual setting of the new file name and the creating of the
     * file contents
     *
     * @return int
     */
    public function handleSave() {
        // Get what we need to make our new files
        $viewname = $this->views[$this->client . $this->viewtype];
        $newname = $this->getNewFileName($viewname);
        $content = $this->getNewFileContents($viewname);
        // Make the new file
        $this->logUpgradeStatus("Saving new {$this->client} {$this->type} viewdefs for {$this->module}:{$this->viewtype}");
        if(empty($content)) {
            $this->logUpgradeStatus("No content for {$this->client} {$this->type} viewdefs for {$this->module}:{$this->viewtype}");
            return false;
        }
        return $this->save($newname, $content);
        //return true;
    }

    /**
     * Simpler handleSave, which just saves array to path with write_array_to_file
     * @param unknown_type $path
     * @return boolean
     */
    public function handleSaveArray($name, $path)
    {
        if(empty($this->sidecarViewdefs)) {
            return true;
        }
        $this->logUpgradeStatus("Saving new {$this->client} {$this->type} viewdefs for {$this->module}:{$this->viewtype} into $path");
        $newDirName = dirname($path);

        if (!sugar_mkdir($newDirName, null, true)) {
            $this->logUpgradeStatus("Cannot create '$newDirName'.");
            return false;
        }
        return write_array_to_file($name, $this->sidecarViewdefs, $path);
    }


    /**
     * Sets the necessary legacy field defs for use in converting
     */
    public function setLegacyViewdefs()
    {
        // This check is probably not necessary, but seems like it is a good idea anyway
        if (file_exists($this->fullpath)) {
            $this->logUpgradeStatus("legacy file being read: {$this->fullpath}");
            include $this->fullpath;

            // There is an odd case where custom modules are pathed without the
            // package name prefix but still use it in the module name for the
            // viewdefs. This handles that case. Also sets a prop that lets the
            // rest of the process know that the module is named differently
            if (isset($module_name)) {
                $this->modulename = $module = $module_name;
            } else {
                $module = $this->module;
            }

            $var = $this->variableMap[$this->client][$this->viewtype];
            if (isset($$var)) {
                $defs = $$var;
                if (isset($this->vardefIndexes[$this->client.$this->viewtype])) {
                    $index = $this->vardefIndexes[$this->client.$this->viewtype];
                    $this->legacyViewdefs = empty($index) ? $defs[$module] : $defs[$module][$index];
                }
            }
        }
    }

    /**
     * Saves the contents of a file to the specified path
     *
     * @param string $path The path to the file to save
     * @param string $content The content of the file to save
     * @return int The number of bytes written to the file or false on failure
     */
    public function save($path, $content) {
        // If this directory doesn't exist yet, create it
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir_recursive($dir);
        }

        // Save the contents to the file
        return sugar_file_put_contents($path, $content);
    }

    /**
     * Gets the new path and filename for this view
     *
     * @param string $view The view name to get the filename for
     * @return string
     */
    public function getNewFileName($view) {
        // Clean up client to mobile for wireless clients
        $client = $this->client == 'wireless' ? 'mobile' : $this->client;

        if ($this->deployed) {
            // Deployed will always use the full key_module name for custom modules
            $module = $this->getNormalizedModuleName();
            $newname = MetaDataFiles::getDeployedFileName($view, $module, $this->type, $client);
        } else {
            $newname = MetaDataFiles::getUndeployedFileName($view, $this->module, $this->package, $this->type, $client);
        }

        // If this is a history file then add the timestamp back on
        if ($this->timestamp) {
            $newname .= '_' . $this->timestamp;
        }

        return $newname;
    }

    /**
     * Creates the stringified rendition of the vardefs that will be written to
     * the new file. Works very similar to the write method in the metadata
     * implementations, but without all the extra processing that goes in with
     * them. This is overwritten for search as search is just a content move.
     *
     * @param string $viewname Target view name
     * @return string
     */
    public function getNewFileContents($viewname)
    {
        $module = $this->getNormalizedModuleName();
        $viewname = MetaDataFiles::getName($viewname);
        $client = $this->client == 'wireless' ? 'mobile' : $this->client;
        if(empty($this->sidecarViewdefs[$module][$client]['view'][$viewname])) {
            return '';
        }
        $out  = "<?php\n\$viewdefs['{$module}']['{$client}']['view']['{$viewname}'] = " . var_export($this->sidecarViewdefs[$module][$client]['view'][$viewname], true) . ";\n";
        return $out;
    }

    /**
     * For custom modules, gets the module name as it is represented to the app.
     * Deployed module names will be PackageKey_ModuleName. Undeployed will just
     * be ModuleName.
     *
     * @return string
     */
    public function getNormalizedModuleName() {
        return isset($this->modulename) && !in_array($this->modulename, MetaDataFiles::getModuleNamePlaceholders()) ? $this->modulename : $this->module;
    }

    /**
     * Sets a message into the upgrade log
     *
     * @param $message
     */
    protected function logUpgradeStatus($message) {
        $this->upgrader->logUpgradeStatus($message);
    }
}