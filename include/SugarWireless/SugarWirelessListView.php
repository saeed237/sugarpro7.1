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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once 'include/SugarWireless/SugarWirelessView.php';

/**
 *
 * SugarWirelessListView extends SugarWirelessView and is the base class for wireless list views.
 *
 * This class contains elements that are specific to list views, including loading the list view metadata
 * and establishing filter fields.
 *
 * TODO: complete refactoring of SugarWirelessView to move all listview specific methods into this class
 */

class SugarWirelessListView extends SugarWirelessView{

	protected $displayColumns;

    /**
     * Override the default init() method; load the wireless list view metadata
     *
     * @param $bean
     * @param $view_object_map
     */
    public function init($bean = null, $view_object_map = array())
    {
        $defs = $this->getMetaDataViewDefs();
        foreach ($defs as $name => $field) {
            if(!empty($field['default'])) {
                $this->displayColumns[strtoupper($name)] = $field;
            }
        }

        parent::init($bean, $view_object_map);
    }

    /**
     * Gets the default fields from the view defs from the parser
     *
     * @return array
     */
    public function getMetaDataViewDefs() {
        require_once 'modules/ModuleBuilder/parsers/constants.php';
        require_once 'modules/ModuleBuilder/parsers/views/SidecarListLayoutMetaDataParser.php';
        $parser = new SidecarListLayoutMetaDataParser(MB_WIRELESSLISTVIEW, $GLOBALS['module'], null, MB_WIRELESS);
        $defs = $parser->getDefaultFields();
        return $defs;
    }

    /**
     * Retrieve the listview defs for this view.
     *
     * DEPRECATED FOR NOW
     *
     * @param none
     * @return array Listview defs
     */
    public function getMetaDataFile(){
        // load the wireless list view metadata
        
    	require_once 'modules/ModuleBuilder/parsers/constants.php';
		require $this->wl_get_metadata_location( MB_WIRELESSLISTVIEW );
        $module = $GLOBALS['module'];
        // Check for viewdefs first
        if (isset($viewdefs)) {
            if (isset($viewdefs[$module])) {
                return $viewdefs[$module]['mobile']['view']['list'];
            }

            if (isset($viewdefs['<module_name>']) || isset($viewdefs['<_module_name>']) || isset($viewdefs['<MODULE_NAME>'])) {
                $viewdefs = MetaDataFiles::getModuleMetaDataDefsWithReplacements($module, $viewdefs);
                return $viewdefs[$module]['mobile']['view']['list'];
            }
        }

        // Get our module from the globals array
        $module = $GLOBALS['module'];
        // Handle new format
        if (isset($viewdefs)) {
            if (isset($viewdefs[$module])) {
                return $viewdefs[$module]['mobile']['view']['list'];
            } else {
                if (isset($viewdefs['<module_name>'])) {
                    return $viewdefs['<module_name>']['mobile']['view']['list'];
                }
            }
        }

		// if we loaded the metadata from a SugarObjects template, then switch the template modulename to this module
		//if ( !isset ( $listViewDefs [ $GLOBALS['module'] ] ) &&  isset ( $listViewDefs [ '<module_name>' ] ) ) {
            //$listViewDefs [ $GLOBALS['module'] ] = $listViewDefs [ '<module_name>' ] ;
        //}
        if (!isset($listViewDefs[$module]) && isset($listViewDefs['<module_name>'])) {
            $listViewDefs[$module] = $listViewDefs['<module_name>'];
        }

        return $listViewDefs[$module];
    }

    /**
     * Protected function that returns the filter_fields based on the module's
     * list view metadata.
     *
     * @see ListViewDisplay::setupFilterFields()
     */
    protected function get_filter_fields($module)
    {
        $filter_fields = array();
        foreach ($this->displayColumns as $columnName => $def) {
            $filter_fields[strtolower($columnName)] = true;

            if (!empty($def['type']) &&
                strtolower($def['type']) == 'currency' &&
                isset($this->bean->field_defs['currency_id'])
            ) {
                $filter_fields['currency_id'] = true;
            }

            if (!empty($def['related_fields'])) {
                foreach ($def['related_fields'] as $field) {
                    //id column is added by query construction function. This addition creates duplicates
                    //and causes issues in oracle. #10165
                    if ($field != 'id') {
                        $filter_fields[$field] = true;
                    }
                }
            }
        }
        return $filter_fields;
    }

}
?>
