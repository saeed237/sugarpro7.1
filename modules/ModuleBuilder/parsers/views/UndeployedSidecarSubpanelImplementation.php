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

class UndeployedSidecarSubpanelImplementation extends AbstractMetaDataImplementation implements MetaDataImplementationInterface
{

    const HISTORYFILENAME = 'restored.php';
    const HISTORYVARIABLENAME = 'viewdefs';

    /**
     * The constructor
     * @param string $subpanelName
     * @param string $moduleName
     * @param string $packageName
     * @param string $client
     */
    public function __construct($subpanelName, $moduleName, $packageName, $client = '')
    {
        $this->mdc = new MetaDataConverter();
        $this->_subpanelName = $subpanelName;
        $this->_moduleName = $moduleName;
        $this->client = (empty($client)) ? 'base' : $client;

        // TODO: history
        $this->historyPathname = "custom/history/modulebuilder/packages/{$packageName}/modules/{$moduleName}/metadata/" . self::HISTORYFILENAME;
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

        $template_subpanel_def = "include/SugarObjects/templates/{$template_def}/clients/{$this->client}/views/subpanel-list/subpanel-list.php";

        if (file_exists($template_subpanel_def)) {
            include $template_subpanel_def;
            if (isset($viewdefs['<module_name>'])) {
                $viewdefs[$this->module->key_name] = $viewdefs['<module_name>'];
                unset($viewdefs['<module_name>']);
            }
        }

        if ($subpanelName != 'default' && !stristr($subpanelName, 'for')) {
            $subpanelName = 'For' . ucfirst($subpanelName);
        }
        $this->sidecarSubpanelName = $this->mdc->fromLegacySubpanelName($subpanelName);

        $this->sidecarFile = "{$this->module->getModuleDir(
        )}/clients/{$client}/views/{$this->sidecarSubpanelName}/{$this->sidecarSubpanelName}.php";

        if (file_exists($this->sidecarFile)) {
            include $this->sidecarFile;
        }
        $viewdefs = empty($viewdefs) ? array() : $viewdefs;

        $this->_viewdefs = $this->getNewViewDefs($viewdefs);

        $this->_fielddefs = $this->getFieldDefs();
        $this->_paneldefs = isset($this->_viewdefs['panels']) ? $this->_viewdefs['panels'] : array();

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
        if (isset($viewDefs[$this->module->key_name][$this->client]['view'][$this->sidecarSubpanelName])) {
            return $viewDefs[$this->module->key_name][$this->client]['view'][$this->sidecarSubpanelName];
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
        if (!isset($this->_viewdefs['panels'])) {
            return $results;
        }
        foreach ($this->_viewdefs['panels'] as $panel) {
            if (!isset($panel['fields'])) {
                continue;
            }
            foreach ($panel['fields'] as $field) {
                if (!isset($this->module->field_defs[$field['name']])) {
                    continue;
                }
                $results[$field['name']] = $this->module->field_defs[$field['name']];
            }
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
     * Save a subpanel
     * @param array defs    Layout definition in the same format as received by the constructor
     */
    public function deploy($defs)
    {
        $outputDefs = $this->module->getAvailableSubpanelDef($this->_subpanelName);
        write_array_to_file(self::HISTORYVARIABLENAME, $outputDefs, $this->historyPathname);
        $this->_history->append($this->historyPathname);
        $this->_viewdefs = $defs;

        if (!is_dir(dirname($this->sidecarFile))) {
            if (!mkdir(dirname($this->sidecarFile), 0755, true)) {
                throw new Exception(sprintf("Cannot create directory %s", $this->sidecarFile));
            }
        }
        write_array_to_file(
            "viewdefs['{$this->_moduleName}']['{$this->_viewClient}']['view']['{$this->sidecarSubpanelName}']",
            $this->_viewdefs,
            $this->sidecarFile
        );
    }

}
