<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once 'modules/ModuleBuilder/parsers/views/MetaDataImplementationInterface.php';
require_once 'modules/ModuleBuilder/parsers/views/AbstractMetaDataImplementation.php';
require_once 'modules/ModuleBuilder/parsers/constants.php';
require_once 'include/MetaDataManager/MetaDataConverter.php';

class UndeployedSidecarFilterImplementation extends AbstractMetaDataImplementation implements MetaDataImplementationInterface
{

    const HISTORYFILENAME = 'restored.php';
    const HISTORYVARIABLENAME = 'viewdefs';

    /**
     * The constructor
     * @param string $moduleName
     * @param string $packageName
     * @param string $client
     */
    public function __construct($moduleName, $packageName, $client = '')
    {
        $this->_moduleName = $moduleName;
        $this->client = (empty($client)) ? 'base' : $client;

        // TODO: history
        $this->historyPathname = "custom/history/modulebuilder/packages/{$packageName}/modules/{$moduleName}/clients/{$client}/filters/default/" . self::HISTORYFILENAME;
        $this->_history = new History($this->historyPathname);

        //get the bean from ModuleBuilder
        $mb = new ModuleBuilder();
        $this->module = $mb->getPackageModule($packageName, $moduleName);
        $this->module->mbvardefs->updateVardefs();

        $templates = $this->module->config['templates'];
        $template_def = "";
        foreach ($templates as $template => $a) {
            if ($a === 1) {
                $template_def = $template;
            }
        }

        $template_filter_def = "include/SugarObjects/templates/{$template_def}/clients/{$this->client}/filters/default/default.php";

        if (file_exists($template_filter_def)) {
            include $template_filter_def;
        }

        $this->sidecarFile = "{$this->module->getModuleDir()}/clients/{$client}/filters/default/default.php";

        if (file_exists($this->sidecarFile)) {
            include $this->sidecarFile;
        }
        $viewdefs = empty($viewdefs) ? array('fields' => array()) : $viewdefs;

        $this->_viewdefs = $this->getNewViewDefs($viewdefs);

        $this->_fielddefs = $this->getFieldDefs();
        $this->_paneldefs = $this->_viewdefs;

        // Set the global mod_strings directly as Sugar does not automatically load the
        // language files for undeployed modules (how could it?)
        $selected_lang = 'en_us';
        if (isset($GLOBALS['current_language']) && !empty($GLOBALS['current_language'])) {
            $selected_lang = $GLOBALS['current_language'];
        }
        $GLOBALS ['mod_strings'] = array_merge($GLOBALS['mod_strings'], $this->module->getModStrings($selected_lang));
    }

    /**
     * Get the new listview defs in viewdefs
     * @param array $viewDefs the viewdefs array
     * @return array the listviewDefs
     */
    public function getNewViewDefs(array $viewDefs)
    {
        if (isset($viewDefs[$this->_moduleName][$this->_viewClient]['filter']['default'])) {
            return $viewDefs[$this->_moduleName][$this->_viewClient]['filter']['default'];
        }

        return array();
    }

    /**
     * Get the Fielddefs
     * @return array
     */
    public function getFieldDefs()
    {
        $results = array();
        if (!isset($this->_viewdefs['fields'])) {
            return $results;
        }
        foreach ($this->_viewdefs['fields'] as $field => $def) {
            if (!isset($this->module->field_defs[$field])) {
                continue;
            }
            $results[$field] = $this->module->field_defs[$field['name']];
        }
        return $results;
    }

    /**
     * Get the language
     * @return string
     */
    public function getLanguage()
    {
        return ""; // '' is the signal to translate() to use the global mod_strings
    }

    /*
     * Save a filter def
     * @param array defs    Layout definition in the same format as received by the constructor
     */
    public function deploy($defs)
    {
        $this->_viewdefs = $defs;

        if (!is_dir(dirname($this->sidecarFile))) {
            if (!sugar_mkdir(dirname($this->sidecarFile), null, true)) {
                throw new Exception(sprintf("Cannot create directory %s", $this->sidecarFile));
            }
        }
        write_array_to_file(
            "viewdefs['{$this->_moduleName}']['{$this->_viewClient}']['filter']['default']",
            $this->_viewdefs,
            $this->sidecarFile
        );
    }

}
