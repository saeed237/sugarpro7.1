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

require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
require_once('include/SugarSearchEngine/SugarSearchEngineMappingHelper.php');

/**
 * Module mapping for Elastica
 */
class SugarSearchEngineElasticMapping
{
    /**
     * @var \SugarSearchEngineElastic
     */
    private $sse;

    public function __construct(SugarSearchEngineElastic $sse)
    {
        $this->sse = $sse;
    }

    /**
     *
     * This function creates the mapping on particular type/module and field.
     * Ths can be used when user changes the field settings (like boost level) in Studio.
     * index must exist before calling this function.
     *
     * @param $module module name
     * @param $fieldDefs field name of the module
     *
     * @return boolean true if mapping successfully created, false otherwise
     */
    public function setFieldMapping($module, $fieldDefs)
    {
        $properties = $this->constructMappingProperties($fieldDefs);

        if (is_array($properties) && count($properties) > 0)
        {
            $index = new Elastica_Index($this->sse->getClient(), $this->sse->getIndexName());
            $type = new Elastica_Type($index, $module);
            $mapping = new Elastica_Type_Mapping($type, $properties);
            $mapping->setProperties($properties);
            try
            {
                $mapping->send();
            }
            catch (Elastica_Exception_Response $e)
            {
                $GLOBALS['log']->error("elastic response exception when creating mapping, message= " . $e->getMessage());
                return false;
            }
        }

        return true;
    }

    /**
     *
     * This function returns an array of properties given a field definition array.
     *
     * @param $fieldDefs array of field definitions
     *
     * @return an array of properties
     */
    protected function constructMappingProperties($fieldDefs) {
        $properties = array();

        foreach ($fieldDefs as $name => $fieldDef)
        {
            if (!empty($fieldDef['name']))
            {
                $fieldName = $fieldDef['name'];
            }
            else
            {
                continue;
            }

            if (isset($fieldDef['full_text_search']))
            {
                $tmpArray = array();

                foreach ($fieldDef['full_text_search'] as $sugarName => $val)
                {
                    $mappingName = SugarSearchEngineMappingHelper::getMappingName('Elastic', $sugarName);
                    if (!empty($mappingName))
                    {
                        $tmpArray[$mappingName] = $fieldDef['full_text_search'][$sugarName];
                    }
                }

                // field type is required when setting mapping
                if (empty($tmpArray['type']))
                {
                    $tmpArray['type'] = SugarSearchEngineMappingHelper::getTypeFromSugarType('Elastic', $fieldDef);
                }

                $properties[$fieldName] = $tmpArray;
            }
        }
        if (isset($properties['doc_owner']) == false)
        {
            $properties['doc_owner'] = array(
                'type' => 'string',
                'index' => 'not_analyzed'
            );
        }
        if (isset($properties['user_favorites']) == false) {
            $properties['user_favorites'] = array(
                'type' => 'string',
                'index' => 'not_analyzed'
            );
        }        
        return $properties;
    }

    /**
     *
     * This function creates a full mapping for all modules.
     * index must exist before calling this function.
     *
     */
    public function setFullMapping()
    {
        $allModules = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsForAllModules();

        // if the index already exists, is there a way to create mapping for multiple modules at once?
        // for now, create one mapping for a module at a time
        foreach ($allModules as $name => $module)
        {
            $this->setFieldMapping($name, $module);
        }
    }

    /**
     *
     * This function creates the mapping for particular module/type.
     * index must exist before calling this function.
     *
     * @param $module module name
     *
     * @return boolean true if mapping successfully created, false otherwise
     */
    public function setModuleMapping($module)
    {
        $fieldDefs = $this->sse->retrieveFtsEnabledFieldsPerModule($module);

        return $this->setFieldMapping($module, $fieldDefs);
    }

}
