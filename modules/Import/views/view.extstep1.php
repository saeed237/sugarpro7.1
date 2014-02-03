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

 * Description: view handler for step 1 of the import process
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/
require_once('modules/Import/views/view.step3.php');
require_once('modules/Import/ImportCacheFiles.php');

class ImportViewExtStep1 extends ImportViewStep3
{

    protected $pageTitleKey = 'LBL_CONFIRM_EXT_TITLE';
    protected $currentFormID = 'extstep1';
    protected $previousAction = 'Step1';
    protected $nextAction = 'extdupcheck';

 	/**
     * @see SugarView::display()
     */
 	public function display()
    {
        $source = !empty($_REQUEST['external_source']) ? $_REQUEST['external_source'] : '';
        $importModule = $_REQUEST['import_module'];
        global $mod_strings, $app_strings, $current_user, $sugar_config;

        // Clear out this user's last import
        $seedUsersLastImport = BeanFactory::getBean('Import_2');
        $seedUsersLastImport->mark_deleted_by_user_id($current_user->id);
        ImportCacheFiles::clearCacheFiles();

        $mappingFile = $this->getMappingFile($source);
        if ( $mappingFile == null ) {
            $this->_showImportError($mod_strings['ERR_MISSING_MAP_NAME'],$_REQUEST['import_module'],'Step1');
            return;
        }
        $extSourceToSugarFieldMapping = $mappingFile->getMapping($importModule);

        // get list of required fields
        $required = array();
        foreach ( array_keys($this->bean->get_import_required_fields()) as $name ) {
            $properties = $this->bean->getFieldDefinition($name);
            if (!empty ($properties['vname']))
                $required[$name] = str_replace(":","",translate($properties['vname'] ,$this->bean->module_dir));
            else
                $required[$name] = str_replace(":","",translate($properties['name'] ,$this->bean->module_dir));
        }

        $mappedRows = $this->getMappingRows($importModule, $extSourceToSugarFieldMapping);
        $this->ss->assign("MODULE_TITLE", $this->getModuleTitle(false));
        $this->ss->assign("rows", $mappedRows);
        $this->ss->assign("COLUMNCOUNT", count($mappedRows));
        $this->ss->assign("IMPORT_MODULE", $importModule);
        $this->ss->assign("JAVASCRIPT", $this->_getJS($required));
        $this->ss->assign('CSS', $this->_getCSS());
        $this->ss->assign("CURRENT_STEP", $this->currentStep);

        $this->ss->assign("RECORDTHRESHOLD", $sugar_config['import_max_records_per_file']);
        $this->ss->assign("ENABLED_DUP_FIELDS", htmlentities(json_encode($this->getFieldsForDuplicateCheck()), ENT_QUOTES));
        $content = $this->ss->fetch('modules/Import/tpls/extstep1.tpl');
        $this->ss->assign("CONTENT",$content);
        $out = $this->ss->fetch('modules/Import/tpls/wizardWrapper.tpl');
        echo $out;
    }

    private function getFieldsForDuplicateCheck()
    {
        return array('email1', array('first_name', 'last_name'));
    }


    private function getMappingRows($module, $extSourceToSugarFieldMapping)
    {
        global $app_strings, $current_language;
        $columns = array();
        $mappedFields = array();
        $mod_strings = return_module_language($current_language, $module);
        $import_mod_strings = return_module_language($current_language, 'Import');
        $ignored_fields = array();

        foreach($extSourceToSugarFieldMapping as $externalKey => $sugarMapping)
        {
            // See if we have any field map matches
            $defaultValue = $externalKey;

            // build string of options
            $fields  = $this->bean->get_importable_fields();
            $options = array();
            $defaultField = '';
            foreach ( $fields as $fieldname => $properties )
            {
                // get field name
                if (!empty ($properties['vname']))
					$displayname = str_replace(":","",translate($properties['vname'] ,$this->bean->module_dir));
                else
					$displayname = str_replace(":","",translate($properties['name'] ,$this->bean->module_dir));
                // see if this is required
                $req_mark  = "";
                $req_class = "";
                if ( array_key_exists($fieldname, $this->bean->get_import_required_fields()) ) {
                    $req_mark  = ' ' . $app_strings['LBL_REQUIRED_SYMBOL'];
                    $req_class = ' class="required" ';
                }
                // see if we have a match
                $selected = '';
                if ( !empty($defaultValue) && !in_array($fieldname,$mappedFields) && !in_array($fieldname,$ignored_fields) )
                {
                    if ( strtolower($fieldname) == strtolower($sugarMapping['sugar_key']) )
                    {
                        $selected = ' selected="selected" ';
                        $defaultField = $fieldname;
                        $mappedFields[] = $fieldname;
                    }
                }
                // get field type information
                $fieldtype = '';
                if ( isset($properties['type'])
                        && isset($mod_strings['LBL_IMPORT_FIELDDEF_' . strtoupper($properties['type'])]) )
                    $fieldtype = ' [' . $mod_strings['LBL_IMPORT_FIELDDEF_' . strtoupper($properties['type'])] . '] ';
                if ( isset($properties['comment']) )
                    $fieldtype .= ' - ' . $properties['comment'];
                $options[$displayname.$fieldname] = '<option value="'.$fieldname.'" title="'. $displayname . htmlentities($fieldtype) . '"'
                    . $selected . $req_class . '>' . $displayname . $req_mark . '</option>\n';
            }

            // get default field value
            $defaultFieldHTML = '';
            if ( !empty($defaultField) ) {
                $defaultFieldHTML = getControl($module,$defaultField,$fields[$defaultField],( isset($default_values[$defaultField]) ? $default_values[$defaultField] : '' ));
            }

            if ( isset($default_values[$defaultField]) )
                unset($default_values[$defaultField]);

            // Bug 27046 - Sort the column name picker alphabetically
            ksort($options);

            $help_text = isset($sugarMapping['sugar_help_key']) ? $import_mod_strings[$sugarMapping['sugar_help_key']] : '';
            $rowLabel = isset($mod_strings[$sugarMapping['sugar_label']]) ? $mod_strings[$sugarMapping['sugar_label']] : $sugarMapping['default_label'] ;
            $columns[] = array(
                'field_choices' => implode('',$options),
                'default_field' => $defaultFieldHTML,
                'cell1'         => str_replace(":",'', $rowLabel),
                'show_remove'   => false,
                'ext_key'       => $externalKey,
                'help_text'     => $help_text
                );
        }

        return $columns;
    }

    private function getMappingFile($source)
    {
        $classname = 'ImportMap' . ucfirst(strtolower($source));
        if (! SugarAutoLoader::requireWithCustom("modules/Import/maps/{$classname}.php") ) {
        	SugarAutoLoader::requireWithCustom("modules/Import/maps/ImportMapOther.php");
        	$classname = 'ImportMapOther';
        	$importSource = 'other';
        }

        if ( class_exists($classname) )
        {
            $mapping_file = new $classname;
            return $mapping_file;
        }
        else
            return null;
    }

    private function getImportableExternalEAPMs()
    {
        require_once('include/externalAPI/ExternalAPIFactory.php');

        return ExternalAPIFactory::getModuleDropDown('Import', FALSE, FALSE, 'eapm_import_list');
    }

}

?>
