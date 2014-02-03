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
 * Class dealing with searchable modules
 * @api
 */
class SugarSearchEngineMetadataHelper
{
    /**
     * Cache key for enabled modules
     */
    const ENABLE_MODULE_CACHE_KEY = 'ftsEnabledModules';

    /**
     * Cache key for disabled modules
     */
    const DISABLED_MODULE_CACHE_KEY = 'ftsDisabledModules';


    /**
     * Retrieve all FTS fields for all FTS enabled modules.
     *
     * @return array
     */
    public static function retrieveFtsEnabledFieldsForAllModules()
    {
        $cachedResults = sugar_cache_retrieve(self::ENABLE_MODULE_CACHE_KEY);
        if($cachedResults != null && !empty($cachedResults) )
        {
            $GLOBALS['log']->debug("Retrieving enabled fts modules from cache");
            return $cachedResults;
        }

        $results = array();

        require_once('modules/Home/UnifiedSearchAdvanced.php');
        $usa = new UnifiedSearchAdvanced();
        $modules = $usa->retrieveEnabledAndDisabledModules();

        foreach($modules['enabled'] as $module)
        {
            $fields = self::retrieveFtsEnabledFieldsPerModule($module['module']);
            $results[$module['module']] = $fields;
        }

        sugar_cache_put(self::ENABLE_MODULE_CACHE_KEY, $results, 0);
        return $results;

    }

    /**
     * Return all of the modules disabled for FTS by the administrator
     *
     * @return mixed|The
     */
    public static function getSystemEnabledFTSModules()
    {
        require_once('modules/Home/UnifiedSearchAdvanced.php');
        $usa = new UnifiedSearchAdvanced();
        $modules = $usa->retrieveEnabledAndDisabledModules();
        $enabledModules = array();
        foreach($modules['enabled'] as $module)
        {
            $enabledModules[ $module['module'] ] = $module['module'];
        }

        return $enabledModules;
    }

    /**
     * For a given module, return all of the full text search enabled fields.
     *
     * @param $module
     *
     */
    public static function retrieveFtsEnabledFieldsPerModule($module)
    {
        $results = array();
        if( is_string($module))
        {
            $obj = BeanFactory::getBean($module, null);
            if($obj == null)
               return FALSE;
        }
        else if( is_a($module, 'SugarBean') )
        {
            $obj = $module;
        }
        else
        {
            return $results;
        }

        if (empty($obj->table_name))
        {
            return $results;
        }

        $cacheKey = "fts_fields_{$obj->table_name}";
        $cacheResults = sugar_cache_retrieve($cacheKey);
        if(!empty($cacheResults))
            return $cacheResults;

        foreach($obj->field_defs as $field => $def)
        {
            if (isset($def['full_text_search']) && is_array($def['full_text_search'])) {
                $results[$field] = $def;
            }
        }

        sugar_cache_put($cacheKey, $results);
        return $results;

    }

    /**
     * Return all of the FTS enabled modules for a specific user
     *
     * @static
     * @param null|User $user
     * @return array
     */
    public static function getUserEnabledFTSModules(User $user = null)
    {
        if($user == null)
            $user = $GLOBALS['current_user'];

        $userDisabled = $user->getPreference('fts_disabled_modules');
        $userDisabled = explode(",", $userDisabled);

        $enabledModules = self::retrieveFtsEnabledFieldsForAllModules();
        $enabledModules = array_keys($enabledModules);

        $filteredEnabled = array();
        foreach($enabledModules as $m)
        {
            if( ! in_array($m, $userDisabled) )
            {
                $filteredEnabled[] = $m;
            }
        }

        return $filteredEnabled;
    }

    /**
     * Determine if a module is FTS enabled.
     *
     * @param $module
     * @return bool
     */
    public static function isModuleFtsEnabled($module)
    {
        $GLOBALS['log']->debug("Checking if module is fts enabled");
        $enabledModules = self::getSystemEnabledFTSModules();

        return in_array($module, $enabledModules);
    }


}