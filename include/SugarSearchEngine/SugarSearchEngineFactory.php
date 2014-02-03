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
 * Search Engines drivers factory class
 * @api
 */
class SugarSearchEngineFactory
{
    /**
     * @var SugarSearchEngineInterface
     */
    public static $_instance;

    /**
     * Singleton pattern
     */
    private function __construct(){}

    /**
     * getInstance()
     *
     * Connect to the backend engine and store for later use
     *
     * @static
     * @return SugarSearchEngineInterface
     */
    public static function getInstance($name = '', $config = array(), $useDefaultWhenFTSDown = false)
    {
        require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
        if ($useDefaultWhenFTSDown && SugarSearchEngineAbstractBase::isSearchEngineDown())
        {
            $name = 'SugarSearchEngine';
        }

       if (!isset(self::$_instance[$name]))
       {
           self::$_instance[$name] = self::setupEngine($name, $config);
       }

       return self::$_instance[$name];
    }

    public static function getFTSEngineNameFromConfig()
    {
        $name = "";
        if(isset($GLOBALS['sugar_config']['full_text_engine']) &&
           is_array($GLOBALS['sugar_config']['full_text_engine']))
        {
            $keys = array_keys($GLOBALS['sugar_config']['full_text_engine']);
            $name = array_pop($keys);
        }
        return $name;
    }
    /**
     * @static
     * @param string $name
     * @param array $config
     * @return bool
     */
    protected static function setupEngine($name = '', $config = array())
    {
        // if name is empty set name and config
        if(empty($name) && !empty($GLOBALS['sugar_config']['full_text_engine'])) {
            $name = self::getFTSEngineNameFromConfig();
            $config = $GLOBALS['sugar_config']['full_text_engine'][$name];
        }

        // if config is empty set config
        if(empty($config) && !empty($GLOBALS['sugar_config']['full_text_engine'][$name])) {
            $config = $GLOBALS['sugar_config']['full_text_engine'][$name];
        }

        $defaultTemplateLocation = "include/SugarSearchEngine/%sSugarSearchEngine%s.php";

        $searchEngineLocations = array(
            sprintf($defaultTemplateLocation, $name.'/', $name),
            sprintf($defaultTemplateLocation, '','')
        );

        foreach($searchEngineLocations as $engineLocation)
        {
            $engineInstance = self::loadSearchEngineFromLocation($engineLocation, $config);
            if($engineInstance !== FALSE)
            {
                $GLOBALS['log']->debug("Found Sugar Search Engine: " . get_class($engineInstance));
                return $engineInstance;
            }
        }
    }

    /**
     * @static
     * @param $filePath
     * @return bool
     */
    protected static function loadSearchEngineFromLocation($filePath, $config)
    {
        if( SugarAutoLoader::requireWithCustom($filePath) )
        {
            $engineClass = basename($filePath, ".php");
            $engineInstance = new $engineClass($config);

            if ($engineInstance instanceof SugarSearchEngineInterface )
            {
                return $engineInstance;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
}

