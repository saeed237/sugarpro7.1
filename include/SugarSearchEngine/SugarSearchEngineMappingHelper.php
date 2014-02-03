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



/**
 * Helper class for search engine mappings
 * @api
 */
class SugarSearchEngineMappingHelper
{
    /**
     * mapping map
     * This defines the vardefs to search engine mapping.
     * Technically we only need to define them if the vardef name is different from the search engine mapping name.
     * But it won't hurt to define them even if they are the same.
     * @var array
     */
    protected static $mappingMap = array (
        'Elastic' => array (
            'boost' => 'boost',
            'analyzer' => 'analyzer',
            'type' => 'type',
        ),
    );

    /**
     * non string type map
     * sugar vardef type to search engine type mapping
     * @var array
     */
    private static $typeMap = array(
        'Elastic' => array (
            // searching string in non string types seems to cause elastic to return 500 error
            // for example, search 'aaa' in case_number field (type=long) when no data indexed causes error
            // we also need to figure out how date works with date format
            // so use only strings for now
            /*
            'type' => array(
                'bool' => 'boolean',
                'int' => 'long',
                'currency' => 'double',
                'date' => 'date',
                'datetime' => 'date',
            ),
            'dbType' => array(
                'decimal' => 'double',
            ),
            */
           'type' => array(
                'datetimecombo'  =>  'date',
            ),
        ),
    );

    /**
     * this defines the field types that can be enabled for full text search
     * @var array
     */
    protected static $ftsEnabledFieldTypes = array('name', 'user_name', 'varchar', 'decimal', 'float', 'int', 'phone', 'text', 'url');

    /**
     *
     * Given a field type, determine whether this type can be enabled for full text search.
     *
     * @param $type field type
     *
     * @return boolean whether the field type can be enabled for full text search
     */
    public static function isTypeFtsEnabled($type)
    {
        return in_array($type, self::$ftsEnabledFieldTypes);
    }

    /**
     *
     * Given a modulename, determine whether this module can be enabled for full text search.
     *
     * @param $moduleName module name
     *
     * @return boolean whether the module can be enabled for full text search
     */
    public static function shouldShowModule($moduleName)
    {
        require_once('modules/Home/UnifiedSearchAdvanced.php');
        $usa = new UnifiedSearchAdvanced();
        $modLists = $usa->retrieveEnabledAndDisabledModules();

        foreach ($modLists as $list)
        {
            foreach ($list as $module)
            {
                if (isset($module['module']) && $module['module'] == $moduleName)
                {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     *
     * Given a search engine name and a vardef name, this function returns corresponding search engine map type.
     *
     * @param $name search engine name
     * @param $sugarName vardef name
     *
     * @return string search engine map name, or the original name if the mapping is not found
     */
    public static function getMappingName($name, $sugarName)
    {
        if (isset(self::$mappingMap[$name]) && isset(self::$mappingMap[$name][$sugarName]))
        {
            return self::$mappingMap[$name][$sugarName];
        }

        return $sugarName;
    }
    /**
     *
     * This function returns search engine dependent field type.
     *
     * @param $name search engine name
     * @param $fieldDefs array of field definitions
     *
     * @return string search engine dependent type
     */
    public static function getTypeFromSugarType($name, $fieldDef)
    {
        $searchEngineType = '';
        if (isset($fieldDef['type']))
        {
            $sugarType = $fieldDef['type'];
            if (isset(self::$typeMap[$name]['type'][$sugarType]))
            {
                $searchEngineType = self::$typeMap[$name]['type'][$sugarType];
            }
        }

        if (empty($searchEngineType) && isset($fieldDef['dbType']))
        {
            $sugarType = $fieldDef['dbType'];
            if (isset(self::$typeMap[$name]['dbType'][$sugarType]))
            {
                $searchEngineType = self::$typeMap[$name]['dbType'][$sugarType];
            }
        }

        if (empty($searchEngineType))
        {
            $searchEngineType = 'string'; // default
        }

        return $searchEngineType;
    }

}