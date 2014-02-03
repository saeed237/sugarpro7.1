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

class DeployedSidecarFilterImplementation extends AbstractMetaDataImplementation implements MetaDataImplementationInterface
{

    const HISTORYFILENAME = 'restored.php';
    const HISTORYVARIABLENAME = 'viewdefs';

    /**
     * The constructor
     * @param string $linkName
     * @param string $loadedModule - Accounts
     * @param string $client - base
     */
    public function __construct($loadedModule, $client = 'base')
    {
        $this->sidecarFile = "custom/modules/{$loadedModule}/clients/{$client}/filters/default/default.php";
        $this->bean = BeanFactory::getBean($loadedModule);
        $this->_moduleName = $loadedModule;
        $this->setViewClient($client);

        if (empty($this->bean)) {
            throw new Exception("Bean was not provided");
        }

        $this->historyPathname = 'custom/history/modules/' . $loadedModule . '/clients/' . $this->getViewClient() . '/filters/default/' . self::HISTORYFILENAME;
        $this->_history = new History($this->historyPathname);

        $this->loadedViewClient = $client;
        if (file_exists($this->historyPathname)) {
            $GLOBALS['log']->debug(get_class($this) . ": loading from history");
            require $this->historyPathname;
        }

        $studioModule = new StudioModule($this->_moduleName);
        $defaultTemplate = $studioModule->getType();
        $defaultTemplateFilterFile = "include/SugarObjects/templates/{$defaultTemplate}/clients/base/filters/default/default.php";

        $baseTemplateFilterFile = "include/SugarObjects/templates/basic/clients/base/filters/default/default.php";

        if(file_exists("custom/modules/{$loadedModule}/clients/{$client}/filters/default/default.php")) {
            include "custom/modules/{$loadedModule}/clients/{$client}/filters/default/default.php";
        } elseif(file_exists("modules/{$loadedModule}/clients/{$client}/filters/default/default.php")) {
            include "modules/{$loadedModule}/clients/{$client}/filters/default/default.php";
        } else {
            if ($client != 'base' && file_exists("modules/{$loadedModule}/clients/base/filters/default/default.php")) {
                include "modules/{$loadedModule}/clients/base/filters/default/default.php";
                $this->loadedViewClient='base';
            } elseif (file_exists($defaultTemplateFilterFile)) {
                include $defaultTemplateFilterFile;
                $this->loadedViewClient = 'base';
            } elseif (file_exists($baseTemplateFilterFile)) {
                include $baseTemplateFilterFile;
                $this->loadedViewClient = 'base';
            } else {
                throw new Exception("Could not find a filter file for {$loadedModule}");
            }
        }
        $this->_viewdefs = !empty($viewdefs) ? $this->getNewViewDefs($viewdefs) : array('fields' => array());
        $this->_fielddefs = $this->bean->field_defs;

        // Make sure the paneldefs are proper if there are any
        $this->_paneldefs = isset($this->_viewdefs) ? $this->_viewdefs : array();
    }

    /**
     * Get the correct viewdefs from the array in the file
     * @param array $viewDefs
     * @return array
     */
    public function getNewViewDefs(array $viewDefs)
    {
        if (isset($viewDefs[$this->_moduleName][$this->loadedViewClient]['filter']['default'])) {
            return $viewDefs[$this->_moduleName][$this->loadedViewClient]['filter']['default'];
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
     * Getter for the language
     * @return string
     */
    public function getLanguage()
    {
        return $this->_moduleName;
    }

    /*
     * Save a definition that will be used to display a filter for $this->_moduleName
     * @param array defs Layout definition in the same format as received by the constructor
     */

    public function deploy($defs)
    {
        // first sort out the historical record...
        write_array_to_file(self::HISTORYVARIABLENAME, $this->_viewdefs, $this->historyPathname);
        $this->_history->append($this->historyPathname);
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

        // clear the cache
        MetaDataManager::clearAPICache();
    }
}
