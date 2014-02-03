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
require_once 'include/MetaDataManager/MetaDataManager.php';
require_once 'include/SubPanel/SubPanelDefinitions.php';

class DeployedSidecarSubpanelImplementation extends AbstractMetaDataImplementation implements MetaDataImplementationInterface
{

    const HISTORYFILENAME = 'restored.php';
    const HISTORYVARIABLENAME = 'viewdefs';

    /**
     * The constructor
     * @param string $linkName
     * @param string $loadedModule - Accounts
     * @param string $client - base
     */
    public function __construct($linkName, $loadedModule, $client = 'base')
    {
        $GLOBALS['log']->debug(get_class($this) . "->__construct($linkName , $loadedModule)");

        $this->mdc = new MetaDataConverter();
        $this->loadedModule = $loadedModule;
        $this->linkName = $linkName;
        $this->legacySubpanelName = 'For' . $loadedModule;
        // get the link and the related module name as the module we need the subpanel from
        $bean = BeanFactory::getBean($loadedModule);
        $link = new Link2($linkName, $bean);
        $moduleName = $link->getRelatedModuleName();

        $this->_moduleName = $moduleName;
        $this->bean = BeanFactory::getBean($moduleName);
        $this->setViewClient($client);

        // Handle validation up front that will throw exceptions
        if (empty($this->bean) && !$this->fixUpSubpanel()) {
            throw new Exception("No valid parent bean found for {$this->linkName} on {$this->loadedModule}");
        }

        $this->setUpSubpanelViewDefFileInfo();

        include $this->loadedSubpanelFileName;

        // Prepare to load the history file. This will be available in cases when
        // a layout is restored.
        $this->historyPathname = 'custom/history/modules/' . $moduleName . '/clients/' . $this->getViewClient(
            ) . '/views/' . $this->sidecarSubpanelName. '/' . self::HISTORYFILENAME;
        $this->_history = new History($this->historyPathname);

        if (file_exists($this->historyPathname)) {
            // load in the subpanelDefOverride from the history file
            $GLOBALS['log']->debug(get_class($this) . ": loading from history");
            require $this->historyPathname;
        }

        $this->_viewdefs = !empty($viewdefs) ? $this->getNewViewDefs($viewdefs) : array();
        $this->_fielddefs = $this->bean->field_defs;
        $this->_language = '';
        // don't attempt to access the template_instance property if our subpanel represents a collection, as it won't be there - the sub-sub-panels get this value instead
        if (isset($this->_viewdefs['type']) && $this->_viewdefs['type'] != 'collection') {
            $this->_language = $this->bean->module_dir;
        }
        // Make sure the paneldefs are proper if there are any
        $this->_paneldefs = isset($this->_viewdefs['panels']) ? $this->_viewdefs['panels'] : array();
    }

    /**
     * If a subpanel cannot be found in sidecar, try to find it in legacy
     * and convert it
     * @return bool
     */
    protected function fixUpSubpanel()
    {
        // getting here usually means that the link passed in is from an oldschool layoutdef
        // get the name, get the key, get the link, then we work the magic
        $spd = new SubPanelDefinitions(BeanFactory::getBean($this->loadedModule));
        if (! empty ( $spd->layout_defs )) {
            if (array_key_exists(strtolower($this->linkName), $spd->layout_defs ['subpanel_setup'])) {
                $aSubPanelObject = $spd->load_subpanel($this->linkName);
                $this->_moduleName = $aSubPanelObject->get_module_name();
                $this->bean = BeanFactory::getBean($this->_moduleName);
                // convert the old viewdef on the fly
                $this->convertLegacyViewDef($aSubPanelObject->get_list_fields());
                return true;
            }
        }

        return false;
    }

    /**
     * Convert the legacy viewdefs to sidecar viewdefs
     * @param array $listFields list of fields on teh subpanel
     * @return bool
     */
    protected function convertLegacyViewDef($listFields)
    {
        $this->sidecarSubpanelName = $this->mdc->fromLegacySubpanelName($this->legacySubpanelName);
        $this->sidecarFile = "custom/modules/{$this->_moduleName}/clients/" . $this->getViewClient(
            ) . "/views/{$this->sidecarSubpanelName}/{$this->sidecarSubpanelName}.php";
        if (!file_exists($this->sidecarFile)) {
            $viewDefs = $this->mdc->fromLegacySubpanelsViewDefs(array('list_fields' => $listFields), $this->_moduleName);
            $this->deploy($viewDefs);
        }
        return true;
    }

    /**
     * Sets up the class vars for the file information
     * @return bool
     * @throws Exception
     */
    protected function setupSubpanelViewDefFileInfo()
    {
        $this->sidecarSubpanelName = $this->mdc->fromLegacySubpanelName($this->legacySubpanelName);

        // check if there is an override
        $layoutFiles = array(
            "modules/{$this->loadedModule}/clients/" . $this->getViewClient() . "/layouts/subpanels/subpanels.php",
        );
        $layoutExtensionName = array(
            "sidecarsubpanel" . $this->getViewClient() . "layout",
        );

        if ($this->getViewClient() !== 'base') {
            $layoutFiles[] = "modules/{$this->loadedModule}/clients/base/layouts/subpanels/subpanels.php";
            $layoutExtensionName[] = "sidecarsubpanelbaselayout";
        }
        foreach ($layoutFiles as $file) {
            @include $file;
        }
        foreach ($layoutExtensionName as $extension) {
            $file = SugarAutoLoader::loadExtension($extension, $this->loadedModule);
            if ($file !== false) {
                @include $file;
            }
        }

        if(!empty($viewdefs[$this->loadedModule]['base']['layout']['subpanels']['components'])) {

            $components = $viewdefs[$this->loadedModule]['base']['layout']['subpanels']['components'];

            foreach ($components as $key => $component) {
                if (empty($component['override_subpanel_list_view'])) {
                    continue;
                }
                if (is_array($component['override_subpanel_list_view']) && $component['override_subpanel_list_view']['link'] == $this->linkName) {
                    if ($this->legacySubpanelName == "default") {
                        $this->sidecarSubpanelName = "subpanel-for-{$this->loadedModule}-{$this->linkName}";
                    }
                    $this->loadedSubpanelName = $component['override_subpanel_list_view']['view'];
                    $this->loadedSubpanelFileName = file_exists("custom/modules/{$this->_moduleName}/clients/" . $this->getViewClient() . "/views/{$this->loadedSubpanelName}/{$this->loadedSubpanelName}.php") ?
                        "custom/modules/{$this->_moduleName}/clients/" . $this->getViewClient() . "/views/{$this->loadedSubpanelName}/{$this->loadedSubpanelName}.php"
                        : "modules/{$this->_moduleName}/clients/" . $this->getViewClient() . "/views/{$this->loadedSubpanelName}/{$this->loadedSubpanelName}.php";
                    $this->sidecarFile = "custom/modules/{$this->_moduleName}/clients/" . $this->getViewClient() . "/views/{$this->sidecarSubpanelName}/{$this->sidecarSubpanelName}.php";
                    $this->overrideArrayKey = $key;
                    return true;
                }
            }
        }

        $subpanelFile = "modules/{$this->_moduleName}/clients/" . $this->getViewClient(
            ) . "/views/{$this->sidecarSubpanelName}/{$this->sidecarSubpanelName}.php";

        $defaultSubpanelFile = "modules/{$this->_moduleName}/clients/base/views/subpanel-list/subpanel-list.php";
        $this->loadedSubpanelName = $this->sidecarSubpanelName;

        $studioModule = new StudioModule($this->_moduleName);
        $defaultTemplate = $studioModule->getType();
        $defaultTemplateSubpanelFile = "include/SugarObjects/templates/{$defaultTemplate}/clients/base/views/subpanel-list/subpanel-list.php";

        $baseTemplateSubpanelFile = "include/SugarObjects/templates/basic/clients/base/views/subpanel-list/subpanel-list.php";

        // using includes because require_once causes an empty array
        if (file_exists('custom/' . $subpanelFile)) {
            $this->loadedSubpanelFileName = 'custom/' . $subpanelFile;
        } elseif (file_exists($subpanelFile)) {
            $this->loadedSubpanelFileName = $subpanelFile;
        } elseif (file_exists($defaultSubpanelFile)) {
            $this->loadedSubpanelFileName = $defaultSubpanelFile;
            $this->loadedSubpanelName = 'subpanel-list';
        } elseif (file_exists($defaultTemplateSubpanelFile)) {
            $this->loadedSubpanelFileName = $defaultTemplateSubpanelFile;
            $this->loadedSubpanelName = 'subpanel-list';
        } elseif (file_exists($baseTemplateSubpanelFile)) {
            $this->loadedSubpanelFileName = $baseTemplateSubpanelFile;
            $this->loadedSubpanelName = 'subpanel-list';
        } else {
            throw new Exception("No metadata file found for subpanel: {$this->loadedSubpanelName}");
        }
        $this->sidecarFile = "custom/" . $subpanelFile;
    }

    /**
     * Get the correct viewdefs from the array in the file
     * @param array $viewDefs
     * @return array
     */
    public function getNewViewDefs(array $viewDefs)
    {
        if (isset($viewDefs[$this->_moduleName][$this->_viewClient]['view'][$this->loadedSubpanelName])) {
            return $viewDefs[$this->_moduleName][$this->_viewClient]['view'][$this->loadedSubpanelName];
        }

        return array();
    }

    /**
     * Getter for the fielddefs
     * @return array
     */
    public function getFieldDefs()
    {
        return $this->_fielddefs;
    }

    /**
     * Gets the appropriate module name for use in translation of labels in
     * studio
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->_moduleName;
    }

    /*
     * Save a definition that will be used to display a subpanel for $this->_moduleName
     * @param array defs Layout definition in the same format as received by the constructor
     */

    public function deploy($defs)
    {
        // Make a viewdefs variable for saving
        $varname = "viewdefs['{$this->_moduleName}']['{$this->_viewClient}']['view']['{$this->sidecarSubpanelName}']";
        if (!empty($this->historyPathname)) {
            // first sort out the historical record...
            write_array_to_file($varname, $this->_viewdefs, $this->historyPathname);
            $this->_history->append($this->historyPathname);
        }
        $this->_viewdefs = $defs;

        // Now move on to the viewdefs proper
        if (!is_dir(dirname($this->sidecarFile))) {
            if (!mkdir(dirname($this->sidecarFile), 0755, true)) {
                throw new Exception(sprintf("Cannot create directory %s", $this->sidecarFile));
            }
        }

        // always set the type to subpanel-list for the client
        if (strpos($this->sidecarSubpanelName, 'subpanel-for-') !== false) {
            $this->_viewdefs['type'] = 'subpanel-list';
        }
        // TODO: remove this when we have BWC modules converted
        $this->stripUnwantedBWCKeys();

        write_array_to_file(
            $varname,
            $this->_viewdefs,
            $this->sidecarFile
        );
        // clear the cache
        MetaDataManager::clearAPICache();
    }

    /**
     * Temporary method to remove BWC keys for sidecar subpanels
     */
    public function stripUnwantedBWCKeys()
    {
        static $unwantedKeys = array(
            'width',
        );
        foreach ($this->_viewdefs['panels'] as &$panel) {
            if (empty($panel['fields']) || !is_array($panel['fields'])) {
                continue;
            }
            foreach ($panel['fields'] as &$field) {
                foreach ($unwantedKeys as $unwantedKey) {
                    if (empty($field[$unwantedKey])) {
                        continue;
                    }
                    unset($field[$unwantedKey]);
                }
            }
        }
    }
}
