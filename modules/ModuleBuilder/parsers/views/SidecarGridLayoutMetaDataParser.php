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

require_once 'modules/ModuleBuilder/parsers/views/GridLayoutMetaDataParser.php';
require_once 'modules/ModuleBuilder/parsers/constants.php';
require_once 'include/MetaDataManager/MetaDataManager.php';

class SidecarGridLayoutMetaDataParser extends GridLayoutMetaDataParser {
    /**
     * Invalid field types for various sidecar clients. Format can be either
     * $client => array('type', 'type') or
     * $client => array('edit' => array('type', 'type'), 'detail' => array('type', 'type'))
     *
     * @var array
     * @protected
     */
    protected $invalidTypes = array(
    );

    protected $extraPanelMeta = array();

    protected $headerPanelMeta = array();

    protected $maxSpan = 12;

    protected $defaultColumns = 2;

    /**
     * Array of named panels for record views. If a panel does not have a label
     * but does have a name and the name is an index of this array, the corresponding
     * label will be used. If a panel has a label the label will be used.
     *
     * @var array
     */
    protected $panelLabels = array(
        'panel_header' => 'LBL_RECORD_HEADER',
        'panel_body' => 'LBL_RECORD_BODY',
        'panel_hidden' => 'LBL_RECORD_SHOWMORE',
    );

    /**
     * Checks for the existence of the view variable for portal metadata
     *
     * @param array $viewdefs The viewdef array
     * @param string $view The view to check for
     * @return bool
     */
    public function hasViewVariable($viewdefs, $view) {
        return $this->getNestedDefs($viewdefs, $view, true);
    }

    /**
     * Gets the viewdefs for portal from the entire viewdef array
     *
     * @param array $viewdefs The full viewdef collection below $viewdefs[$module]
     * @param string $view The view to fetch the defs for
     * @return array
     */
    public function getDefsFromArray($viewdefs, $view) {
        return $this->getNestedDefs($viewdefs, $view);
    }

    protected function getNestedDefs($viewdefs, $view, $validateOnly = false) {
        // Get the view variable, or in Sidecar's case, the path
        $var = MetaDataFiles::getViewDefVar($view);

        // Sidecar should always be an array of metadata path elements
        if (is_array($var)) {
            $levels = count($var); // For example, 3 - portal -> view -> edit
            $checks = 0;

            for ($i = 0; $i < $levels; $i++) {
                if (isset($viewdefs[$var[$i]])) {
                    $checks++;
                    $viewdefs = $viewdefs[$var[$i]];
                }
            }

            $valid = $checks == $levels;

            return $validateOnly ? $valid : $viewdefs;
        }

        return $validateOnly ? false : array();
    }

    /**
     * Gets panel defs from the viewdef array
     * @param array $viewdef The viewdef array
     * @return array
     */
    protected function getPanelsFromViewDef($viewdef) {
        $defs = $this->getDefsFromArray($viewdef, $this->_view);
        if (isset($defs['panels'])) {
            return $defs['panels'];
        }

        return array();
    }

    /**
     * Checks for necessary elements of the metadata array and fails the request
     * if not found
     *
     * @param array $viewdefs The view defs being requested
     * @return void
     */
    public function validateMetaData($viewdefs) {
        if (!isset($viewdefs['panels'])) {
            sugar_die(get_class($this) . ': missing panels section in layout definition (case sensitive)');
        }
    }

    /**
     * Validates a field
     *
     * @param string $key The name of the field
     * @param array $def The defs for this field
     * @return bool
     */
    public function isValidField($key, $def) {
        if (!empty($this->client)) {
            $method = 'isValidField' . ucfirst(strtolower($this->client));
            if (method_exists($this, $method)) {
                return $this->$method($key, $def);
            }
        }

        return parent::isValidField($key, $def);
    }


    /**
     * helper to pack a row with $cols members of [empty]
     * @param $row
     * @param $cols
     * @return void
     *
     */
    protected function _packRowWithEmpty(&$row, $cols)
    {
        for ($i=0; $i<$cols; $i++) {
            $row[] = $this->_addInternalCell(MBConstants::$EMPTY);
        }
    }

    /**
     * Helper to add a field (name) to the internal formatted row
     * used in case internal format goes to wanting arrays
     * @param $field
     * @return string value to add
     */
    protected function _addInternalCell($field) {
        // Handle combination data field defs
        if (!is_array($field)) {
            return $field;
        }

        if (isset($field['name'])) {
            return $field['name'];
        }

        if (isset($field['type'])) {
            return $field['type'];
        }

        return $this->FILLER;
    }


    /*
     * helper methods for doing field comparisons
     */
    protected function isFiller($field)
    {
        if (is_array($field))  {
            return ($field == MBConstants::$FILLER);
        }

        return ($field == $this->FILLER['name']);
    }

    protected function isEmpty($field)
    {
        if (is_array($field))  {
            return ($field == MBConstants::$EMPTY);
        }

        return ($field == MBConstants::$EMPTY['name']);
    }

    /**
     * Manipulates the amount of space a field takes up in studio based on colspan
     *
     * Returns an array of cells to be appended to the fieldlist. Default span
     * units to 6 or half of a 12 unit space with 2 columns
     *
     * @param string|array $field The field to calculate space for
     * @param integer $colspan The colspan for the field
     * @param integer $singleSpanUnit The size of a single field span
     */
    protected function _addCell($field, $colspan, $singleSpanUnit = 6)
    {
        // for fillers, if we ever have a 'filler' with colspan = n, just sub n 'fillers'
        if ($field === '')
        {
            return array_fill(0,$colspan,'');
        }

        // add the displayParam field if necessary
        if ($colspan > 1) {
            if (!is_array($field)) {
                $field = array('name' => $field);
            }

            $field['span'] = $colspan * $singleSpanUnit;
        }
        return array($field);
    }

    /**
     * here we convert from internal metadata format to file (canonical) metadata
     * @param $panels
     * @param $fielddefs
     * @return array - viewdefs in canonical file format
     */
    protected function _convertToCanonicalForm($panels , $fielddefs)
    {
        //$previousViewDef = $this->getFieldsFromLayout($this->implementation->getViewDefs());
        //$currentFields = $this->getFieldsFromLayout($panels);

        $canonicalPanels = array();

        // reset any span info already in the fields, we're going to figure it out again
        foreach ($this->_originalViewDef as $originalKey => $originalFieldDef ) {
            if (is_array($originalFieldDef)) {
                unset($this->_originalViewDef[$originalKey]['span']);
            }
        }

        // Set up the panel index so we know where the header panel meta needs to
        // be injected if there is header panel meta to be injected
        $panelIndex = 0;
        foreach ($panels as $pName => $panel) {
            // This will only happen for record views at the moment. The header
            // panel index is set in _convertFromCanonicalForm.
            if (isset($this->headerPanelIndex) && !empty($this->headerPanelMeta) && $panelIndex == $this->headerPanelIndex) {
                // Inject the header panel where it belongs and increment the panel
                // index so that the other panels are added where they need to be
                $canonicalPanels[$panelIndex] = $this->headerPanelMeta;
                $panelIndex++;
            }

            $fields = array();
            // get number of panel columns default to 2
            $panelColumns = 2;
            if (!empty($this->extraPanelMeta[$pName]['columns'])) {
                $panelColumns = $this->extraPanelMeta[$pName]['columns'];
            }
            $singleSpanUnit = $this->maxSpan/$panelColumns;
            foreach ($panel as $row) {
                $offset = 1; // reset
                $lastField = null; // holder for the field to put in
                foreach ($row as $cellIndex=>$cell) {
                    // empty => get rid of it, and assign to previous field as colspan
                    if ($this->isEmpty($cell)) {
                        $offset++; // count our columns
                        continue;
                    }

                    $fieldCount = count($row);

                    // dump out the last field we stored and reset column count
                    // leading empty => should not occur, but assign to next field as colspan
                    if ($lastField !== null) {
                        $fields = array_merge($fields,$this->_addCell($lastField, $offset, $singleSpanUnit));
                        $offset = 1;
                    }

                    // filler => ''
                    if ($this->isFiller($cell)) {
                        // 58308 - Adjust displayColumns on the last field if it
                        // is set and we are an end column
                        if ($panelColumns - $offset === 1) {
                            $lastRowIndex = count($fields) - 1;
                            if (!is_array($fields[$lastRowIndex])) {
                                $fields[$lastRowIndex] = array(
                                    'name' => $fields[$lastRowIndex]
                                );
                            }
                            $fields[$lastRowIndex]['span'] = $singleSpanUnit;
                        }

                        $lastField = array(
                            'span' => $singleSpanUnit,
                        );

                        if ($fieldCount === 1) {
                            $lastField = array(
                                'span' => $this->maxSpan,
                            );
                        }
                    }
                    else {
                        // field => add the field def.
                        $fieldName = is_array($cell) ? $cell['name'] : $cell;
                        if (isset($this->_originalViewDef[$fieldName]))  {
                            $source = $this->_originalViewDef[$fieldName];
                        }
                        elseif (isset($fielddefs[$fieldName])) {
                            $source = self::_trimFieldDefs($fielddefs[$fieldName]);
                        }
                        else {
                            $source = $cell;
                        }

                        // If the field defs is empty it needs to be an array
                        $lastField = $this->getNewRowItem($source, (empty($fielddefs[$fieldName]) ? array() : $fielddefs[$fieldName]));
                    }

                }

                // dump out the last field we stored
                if ($lastField !== null) {
                    $fields = array_merge($fields,$this->_addCell($lastField,$offset,$singleSpanUnit));
                }

            }
            if (!empty($this->extraPanelMeta[$pName])) {
                // restore any extra panel meta
                $newPanel = $this->extraPanelMeta[$pName];
            }

            $newPanel['fields'] = $fields;
            $canonicalPanels[$panelIndex] = $newPanel;

            // Increment the panel index
            $panelIndex++;
        }

        return $canonicalPanels;
    }

    /**
     * here we convert from file (canonical) metadata => internal metadata format
     * @param $panels
     * @param $fielddefs
     * @return array $internalPanels
     */
    protected function _convertFromCanonicalForm($panels , $fielddefs)
    {
        // canonical form has format:
        // $panels[n]['label'] = label for panel n
        //           ['fields'] = array of fields


        // internally we want:
        // $panels[label for panel] = fields of panel in rows,cols format

        $internalPanels = array();

        // Get the header panel index for use in removing and injecting the header
        // panel meta when editing record views
        $this->headerPanelIndex = $this->getHeaderPanelIndex($panels);

        foreach ($panels as $n => $panel) {
            // If we are on a record view we need to hide the header panel from
            // studio. This is to prevent breaking the client side application.
            if ($this->_view == MB_RECORDVIEW && $n == $this->headerPanelIndex) {
                $this->headerPanelMeta = $panel;
                continue;
            }

            // Handle panel labeling...
            $pLabel = $n;
            if (!empty($panel['label'])) {
                $pLabel = $panel['label'];
            } elseif (isset($panel['name'])) {
                if (isset($this->panelLabels[$panel['name']])) {
                    $pLabel = $this->panelLabels[$panel['name']];
                }
            }

            // Get panel column value
            $panelColumns = 2;
            if (!empty($panel['columns'])) {
                $panelColumns = $panel['columns'];
            }

            // panels now have meta at this level so we need to store that
            $panelMeta = $panel;
            unset($panelMeta['fields']);
            $this->extraPanelMeta[$pLabel] = $panelMeta;

            // going from a list of fields to putting them in rows,cols format.
            $internalFieldRows = array();
            $row = array();
            foreach ($panel['fields'] as $field) {

                // figure out the colspan of the current field
                if (is_array($field) && !empty($field['span'])) {
                    $colspan = floor($field['span']/$this->maxSpan*$panelColumns);
                } else {
                    // Simple aesthetics... make the name field a full span but
                    // only if this is the header panel
                    if (isset($panel['name']) && $panel['name'] == 'panel_header' && $field == 'name') {
                        $colspan = $panelColumns;
                    } else {
                        $colspan = 1;
                    }
                }
                $colsTaken = 0;

                // figure out how much space is taken up already by other fields
                foreach($row as $rowField) {
                    if (is_array($rowField) && !empty($rowField['span'])) {
                        $colsTaken = $colsTaken + floor($rowField['span']/$this->maxSpan*$panelColumns);
                    } else {
                        $colsTaken = $colsTaken + 1;
                    }
                }

                $cols_left = $this->getMaxColumns() - $colsTaken;
                if ($cols_left < $colspan) {
                    // add $cols_left of (empty) to $row and put it in
                   $this->_packRowWithEmpty($row, $cols_left);
                   $internalFieldRows[] = $row;
                   $row = array();
                }

                // Gets the proper field name to insert from the field def
                $fieldToInsert = $this->getFieldToInsert($field);

                // add field to row + enough (empty) to make it to colspan
                $row[] = $this->_addInternalCell($fieldToInsert);
                $this->_packRowWithEmpty($row, $colspan-1);
            }

            // add the last incomplete row if necessary
            if (!empty($row)) {
                $cols_left = $this->getMaxColumns() - count($row);
                // add $cols_left of (empty) to $row and put it in
                $this->_packRowWithEmpty($row, $cols_left);
                $internalFieldRows[] = $row;
            }
            $internalPanels[$pLabel] = $internalFieldRows;
        }

        return $internalPanels;
    }


    /**
     * Returns a list of fields, generally from the original (not customized) viewdefs
     * @param $viewdef
     * @return array array of fields, indexed by field name
     */
    public function getFieldsFromPanels($panels)
    {
        // not canonical form... try parent method
        if (!isset($panels[0]['fields'])) {
            return parent::getFieldsFromPanels($panels);
        }

        $out = array();
        foreach ($panels as $panel) {
            foreach($panel['fields'] as $field) {
                if (!is_array($field)) {
                    $name = $field;
                } elseif (!empty($field['name'])) {
                    $name = $field['name'];
                } else {
                    $name = '';
                }
                if(empty($name)) {
                    $out[] = $field;
                } else {
                    $out[$name] = $field;
                }
            }
        }
        return $out;
    }

    /*
     * Remove a field from the layout
     *
     * @param string $fieldName Name of the field to remove
     * @return boolean True if the field was removed; false otherwise
     */
    function removeField ($fieldName)
    {
        // Set the return result
        $result = false;

        // Loop and find
        foreach ( $this->_viewdefs [ 'panels' ] as $panelID => $panel ) {
            foreach ($panel as $rowIndex => $row) {
                if (is_array($row)) {
                    foreach ($row as $fieldIndex => $field) {
                        if ($field == $fieldName) {
                            $panel[$rowIndex][$fieldIndex] = MBConstants::$EMPTY['name'];
                            $result = true;
                            break 2;
                        }
                    }
                }
            }

            if(!$result) {
                // we didn't find anything, no need to rearrange panels
                continue;
            }

            // Now check to see if any of our rows are totally empty, and if they
            // are, pluck them completely
            $newRows = array();
            foreach ($panel as $rowIndex => $row) {
                if (is_array($row)) {
                    $cols = count($row);
                    $empties = 0;
                    foreach ($row as $field) {
                        if ($field == MBConstants::$EMPTY['name']) {
                            $empties++;
                        }
                    }

                    if ($empties == $cols) {
                        // All empties, remove it and keep looping
                        continue;
                    }

                    $newRows[] = $row;
                }
            }

            $this->_viewdefs['panels'][$panelID] = $newRows;
            return true;
        }

        return false;
    }

    /**
     * Clears mobile and portal metadata caches that have been created by the API
     * to allow immediate rendering of changes at the client
     */
    protected function _clearCaches() {
        if ($this->implementation->isDeployed()) {
            MetaDataFiles::clearModuleClientCache($this->_moduleName,'view');
            MetaDataManager::clearAPICache(false);
        }
    }

    /**
     * Removes a field from the available field array
     *
     * @param array $availableFields The available fields array
     * @param string $field The field name to remove
     */
    protected function unsetAvailableField(&$availableFields, $field)
    {
        $remove = '';
        if (is_string($field)) {
            $remove = $field;

        } elseif (is_array($field) && isset($field['name'])) {
            $remove = $field['name'];
        }

        if ($remove) {
            // Only remove a field once.
            if (empty($this->fieldsRemovedFromAvailability[$remove])) {
                // Remove the field first
                unset($availableFields[$remove]);

                // Mark this field as having been removed. This prevents endless
                // recursion when a combination field is named after an actual
                // field in the view defs
                $this->fieldsRemovedFromAvailability[$remove] = true;

                // Now see if this field is a combination field in the original defs
                if (isset($this->_originalViewDef[$remove])
                    && is_array($this->_originalViewDef[$remove])
                    && isset($this->_originalViewDef[$remove]['fields'])
                    && is_array($this->_originalViewDef[$remove]['fields'])
                ) {
                    foreach ($this->_originalViewDef[$remove]['fields'] as $f) {
                        $this->unsetAvailableField($availableFields, $f);
                    }
                }
            }
        }
    }

    /**
     * Gets valid field defs for a field name
     *
     * @param  string $fieldname The fieldname to get the defs for
     * @return array
     */
    protected function getViewDefFromFieldname($fieldname)
    {
        if (is_array($fieldname)) {
            if (isset($fieldname['name'])) {
                $field = $fieldname['name'];
            } elseif(isset($fieldname['type'])) {
                $field = $fieldname['type'];
            }

            if (isset($field)) {
                return $this->getViewDefFromFieldname($field);
            }

            // This indicates an empty or non field field that is not in the
            // right format. This should be handled by the code that calls this.
            return false;
        }

        return parent::getViewDefFromFieldname($fieldname);
    }

    /**
     * Gets a proper field name or filler for a field def when inserting rows in
     * _convertFromCanonicalForm
     *
     * @param  array|string $field The field def or field name to get a value from
     * @return string A field name or a filler cell
     */
    protected function getFieldToInsert($field)
    {
        // Empty fields just need to be filler
        if (empty($field)) {
            return $this->FILLER;
        }

        // Arrays need to be inspected a little closer
        if (is_array($field)) {
            // Handle special fields like fieldset
            if (isset($field['type'])) {
                if ($field['type'] == 'fieldset' && isset($field['fields']) && isset($field['name'])) {
                    return $field['name'];
                }

                // This handles non-field fields like favorite and follow that 
                // may not have a name property
                if (!empty($field['readonly']) && empty($field['name'])) {
                    return $field['type'];
                }
            }

            // This handles normal condition named fields and filler fields
            if (empty($field['name'])) {
                $GLOBALS['log']->error("Possible malformed metadata in record view defs for {$this->_moduleName}: " . print_r($field, true));
                return $this->FILLER;
            }

            return $field['name'];
        }

        // Non empty non arrays just return the field
        return $field;
    }

    /**
     * Gets the index for the panel that is the header panel. Used in record
     * view since header panels in record view are not editable in studio.
     *
     * @param array $panels The panels array
     * @return string
     */
    public function getHeaderPanelIndex($panels)
    {
        // Default value is assumed to be the first panel unless there is a panel
        // named as the header panel
        $panelIndex = key($panels);
        foreach ($panels as $n => $panel) {
            if (isset($panel['name']) && $panel['name'] == $this->panelLabels['panel_header']) {
                $panelIndex = $n;
                break;
            }
        }

        return $panelIndex;
    }

    /**
     * Checks any hidden panels (panels that should not be editable) and removes
     * any fields from the available fields array that are in the hidden panels.
     *
     * NOTE: This is called in getAvailableFields, which is defined
     * in the parent class.
     *
     * @param array $availableFields Current array of available fields
     */
    protected function unsetHiddenPanelFields(&$availableFields)
    {
        if (!empty($this->headerPanelMeta['fields']) && is_array($this->headerPanelMeta['fields'])) {
            foreach ($this->headerPanelMeta['fields'] as $field) {
                $this->unsetAvailableField($availableFields, $field);
            }
        }
    }
}
