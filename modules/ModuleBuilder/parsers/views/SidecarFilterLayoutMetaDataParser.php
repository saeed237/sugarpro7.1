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

require_once 'modules/ModuleBuilder/parsers/views/SidecarListLayoutMetaDataParser.php';
require_once 'include/MetaDataManager/MetaDataManager.php';

class SidecarFilterLayoutMetaDataParser extends SidecarListLayoutMetaDataParser
{
    /*
     * Constructor, builds the parent ListLayoutMetaDataParser then adds the
     * panel data to it
     *
     * @param string $moduleName     The name of the module to which this listview belongs
     * @param string $packageName    If not empty, the name of the package to which this listview belongs
     * @param string $client         The client making the request for this parser
     */
    public function __construct($moduleName, $packageName = '', $client = 'base')
    {
        $GLOBALS['log']->debug(get_class($this) . ": __construct()");

        if (empty($client)) {
            throw new \InvalidArgumentException("Client cannot be blank in SidecarFilterLayoutMetaDataParser");
        }

        // Set the client
        $this->client = $client;

        if (empty($packageName)) {
            require_once 'modules/ModuleBuilder/parsers/views/DeployedSidecarFilterImplementation.php';
            $this->implementation = new DeployedSidecarFilterImplementation($moduleName, $client);
        } else {
            require_once 'modules/ModuleBuilder/parsers/views/UndeployedSidecarFilterImplementation.php';
            $this->implementation = new UndeployedSidecarFilterImplementation($moduleName, $packageName, $client);
        }

        $this->_viewdefs = $this->implementation->getViewdefs();
        $this->_paneldefs = $this->_viewdefs;
        $this->_fielddefs = $this->implementation->getFieldDefs();
        $this->columns = array('LBL_DEFAULT' => 'getDefaultFields', 'LBL_HIDDEN' => 'getAvailableFields');
    }

    /**
     * Return a list of the default fields for a sidecar listview
     * @return array List of default fields as an array
     */
    public function getDefaultFields()
    {
        $defaultFields = array();
        foreach ($this->_viewdefs['fields'] as $name => $details) {
            $def = isset($this->_fielddefs[$name]) ? $this->_fielddefs[$name] : $details;
            if ($this->isValidField($name, $def)) {
                $defaultFields[$name] = $def;
            }
        }
        return $defaultFields;
    }

    /**
     * Checks to see if a field name is in any of the panels
     *
     * @access public
     * @param  string $name The name of the field to check
     * @param  array $src  The source array to scan
     * @return bool
     */
    public function panelHasField($name, $src = null)
    {
        return (!empty($this->_viewdefs['fields'][$name]));
    }

    /**
     * Gets a list of fields that are available to be added to the default fields
     * list
     *
     * @access public
     * @return array
     */
    public function getAvailableFields()
    {
        $availableFields = array();

        // Select available fields from the field definitions - don't need to worry about checking if ok to include as the Implementation has done that already in its constructor
        foreach ($this->_fielddefs as $key => $def) {
            if ($this->isValidField($key, $def) && !$this->panelHasField($key)) {
                $availableFields[$key] = self::_trimFieldDefs($this->_fielddefs[$key]);
            }
        }

        foreach ($this->_viewdefs['fields'] AS $name => $details) {
            if (empty($availableFields[$name])) {
                continue;
            }
            unset($availableFields[$name]);
        }

        return $availableFields;
    }

    /**
     * Populates the panel defs, and the view defs, from the request
     *
     * @return void
     */
    protected function _populateFromRequest()
    {
        $GLOBALS['log']->debug(
            get_class($this) . "->populateFromRequest() - fielddefs = " . print_r($this->_fielddefs, true)
        );
        // Transfer across any reserved fields, that is, any where studio !== true,
        // which are not editable but must be preserved
        $newPaneldefs = array();
        $newPaneldefIndex = 0;
        $newPanelFieldMonitor = array();

        if (!empty($this->_viewdefs['fields'])) {
            foreach ($this->_viewdefs['fields'] as $fieldName => $field) {
                // Build out the massive conditional structure
                $studio = isset($field['studio']);
                $studioa = $studio && is_array($field['studio']);
                $studioa = $studioa && isset($field['studio']['listview']) &&
                    ($field['studio']['listview'] === false || ($slv = strtolower(
                            $field['studio']['listview']
                        )) == 'false' || $slv == 'required');
                $studion = $studio && !is_array($field['studio']);
                $studion = $studion && ($field['studio'] === false || ($slv = strtolower(
                            $field['studio']
                        )) == 'false' || $slv == 'required');

                $studio = $studio && ($studioa || $studion);
                if (isset($fieldName) && $studio) {
                    $newPaneldefs[$fieldName] = $field;
                }
            }
        }

        $lastGroup = isset($this->columns['LBL_AVAILABLE']) ? 2 : 1;

        for ($i = 0; isset($_POST['group_' . $i]) && $i < $lastGroup; $i++) {
            foreach ($_POST['group_' . $i] as $fieldname) {
                $fieldname = strtolower($fieldname);
                //Check if the field was previously on the layout
                $newPaneldefs[$fieldname] = !empty($this->_viewdefs['fields'][$fieldname]) ? $this->_viewdefs['fields'][$fieldname] : array();
            }
        }

        $this->_viewdefs['fields'] = $newPaneldefs;
    }

    /**
     * Sidecar specific method that delegates validity checking to client specific
     * methods if they exists, otherwise passes through to the parent checker
     *
     * @param  string $key The field name
     * @param  array $def The field defs for key
     * @return bool
     */
    public function isValidField($key, $def)
    {
        if (parent::isValidField($key, $def)) {
            // Predefined filters are valid 'fields'
            if (!empty($def['predefined_filter'])) {
                return true;
            }
            
            // Ensure there is a type before checking that the type is in the
            // filters operator dropdown
            if (!empty($def['type']) && !empty($GLOBALS['app_list_strings']['filter_operators_dom'][$def['type']])) {
                return true;
            } 
        }

        return false;
    }
}
