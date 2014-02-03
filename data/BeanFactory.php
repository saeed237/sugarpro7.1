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


require_once('data/SugarBean.php');

/**
 * Factory to create SugarBeans
 * @api
 */
class BeanFactory {
    protected static $loadedBeans = array();
    protected static $maxLoaded = 100;
    protected static $total = 0;
    protected static $loadOrder = array();
    protected static $touched = array();
    protected static $flipBeans;
    public static $hits = 0;
    /**
     * Bean class overrides
     * @var array
     */
    public static $bean_classes = array();

    /**
     * Returns a SugarBean object by id. The Last 10 loaded beans are cached in memory to prevent multiple retrieves per request.
     * If no id is passed, a new bean is created.
     * @static
     * @param String $module
     * @param String $id
     * @param Array $params A name/value array of parameters. Names: encode, deleted,
     *        disable_row_level_security
     *        If $params is boolean we revert to the old arguments (encode, deleted), and use $params as $encode.
     *        This will be changed to using only $params in later versions.
     * @param Bool $deleted @see SugarBean::retrieve
     * @return SugarBean|null
     */
    public static function getBean($module, $id = null, $params = array(), $deleted = true)
    {

    	// Check if params is an array, if not use old arguments
    	if (isset($params) && !is_array($params)) {
    		$params = array('encode' => $params);
    	}


        // Pull values from $params array
        if (defined('ENTRY_POINT_TYPE') && constant('ENTRY_POINT_TYPE') == 'api') {
            // In API mode, we can cache all beans unless specifically told not
            // to retrieve a cached version.
            $encode = false;
            $can_cache = isset($params['use_cache']) ? $params['use_cache'] : true;
        } else {
            // In GUI mode, we will cache only encoded beans unless specifically
            // told not to retrieve a cached version.
            $encode = isset($params['encode']) ? $params['encode'] : true;
            $can_cache = isset($params['use_cache']) ? $params['use_cache'] && $encode : $encode;
        }

    	$deleted = isset($params['deleted']) ? $params['deleted'] : $deleted;

        if (!isset(self::$loadedBeans[$module])) {
            self::$loadedBeans[$module] = array();
            self::$touched[$module] = array();
        }

        $beanClass = self::getBeanName($module);

        if (empty($beanClass) || !class_exists($beanClass)) return null;

        if (!empty($id))
        {
            if (!$can_cache || empty(self::$loadedBeans[$module][$id]))
            {
                // $bean = new $beanClass();
                $bean = SugarBean::_createBean($beanClass);
                // Pro+ versions, to disable team check if we have rights
                // to change the parent bean, but not the related (e.g. change Account Name of Opportunity)
                if (!empty($params['disable_row_level_security'])) {
                    $bean->disable_row_level_security = true;
                }
                $result = $bean->retrieve($id, $encode, $deleted);

                if(empty($result)) {
                    if(empty($params['strict_retrieve'])) {
                        return $bean;
                    } else {
                        return null;
                    }
                } else if ($can_cache) {
                    self::registerBean($module, $bean, $id);
                }
            } else {
                self::$hits++;
                self::$touched[$module][$id]++;
                $bean = self::$loadedBeans[$module][$id];
            }
        } else {
            $bean = SugarBean::_createBean($beanClass);
        }

        return $bean;
    }

    /**
     * Same as getBean but return null if retrieve fails
     * @param string $module
     * @param string $id
     * @param array $params
     * @param bool $deleted
     * @return SugarBean|null
     */
    public static function retrieveBean($module, $id = null, $params = array(), $deleted = true)
    {
        // Check if params is an array, if not use old arguments
        if (isset($params) && !is_array($params)) {
        	$params = array('encode' => $params);
        }
        $params['strict_retrieve'] = true;
        return self::getBean($module, $id, $params, $deleted);
    }

    /**
     * Delete bean and remove from cache
     * Uses mark_deleted function
     * @param string $module
     * @param string $id
     * @return SugarBean|null return bean in case we need it for something, or null if no such module
     */
    public static function deleteBean($module, $id)
    {
       $bean = self::getBean($module);
       if(empty($bean)) return null;
       $bean->mark_deleted($id);
       if(isset(self::$loadedBeans[$module][$id])) {
           unset(self::$loadedBeans[$module][$id]);
       }
       return $bean;
    }

    /**
     * Create new empty bean
     * @param string $module
     * @return SugarBean
     */
    public static function newBean($module)
    {
        return self::getBean($module);
    }

    /**
     * Create new empty bean by object name
     * @param string $name
     * @return SugarBean|null
     */
    public static function newBeanByName($name)
    {
        if(empty(self::$flipBeans)) {
            self::$flipBeans = array_flip($GLOBALS['beanList']);
        }
        if(empty(self::$flipBeans[$name])) {
            return null;
        }
        return self::getBean(self::$flipBeans[$name]);
    }

    /**
     * Get bean class name by module name
     * @param string $module
     * @return string|false
     */
    public static function getBeanName($module)
    {
        if(!empty(self::$bean_classes[$module])) {
            return self::$bean_classes[$module];
        }
        global $beanList;
        if (empty($beanList[$module]))  {
            return false;
        }

        return $beanList[$module];
    }

    /**
     * Returns the object name / dictionary key for a given module. This should normally
     * be the same as the bean name, but may not for special case modules (ex. Case vs aCase)
     * @static
     * @param String $module
     * @return bool
     */
    public static function getObjectName($module)
    {
        global $objectList;
        if (empty($objectList[$module]))
            return self::getBeanName($module);

        return $objectList[$module];
    }


    /**
     * @static
     * This function registers a bean with the bean factory so that it can be access from accross the code without doing
     * multiple retrieves. Beans should be registered as soon as they have an id.
     * @param String $module
     * @param SugarBean $bean
     * @param bool|String $id
     * @return bool true if the bean registered successfully.
     */
    public static function registerBean($module, $bean, $id=false)
    {
        global $beanList;
        if (empty($beanList[$module]))  return false;

        if (!isset(self::$loadedBeans[$module]))
            self::$loadedBeans[$module] = array();

        //Do not double register a bean
        if (!empty($id) && isset(self::$loadedBeans[$module][$id]))
            return true;

        $index = "i" . (self::$total % self::$maxLoaded);
        //We should only hold a limited number of beans in memory at a time.
        //Once we have the max, unload the oldest bean.
        if (count(self::$loadOrder) >= self::$maxLoaded - 1)
        {
            for($i = 0; $i < self::$maxLoaded; $i++)
            {
                if (isset(self::$loadOrder[$index]))
                {
                    $info = self::$loadOrder[$index];
                    //If a bean isn't in the database yet, we need to hold onto it.
                    if (!empty(self::$loadedBeans[$info['module']][$info['id']]->in_save))
                    {
                        self::$total++;
                    }
                    //Beans that have been used recently should be held in memory if possible
                    else if (!empty(self::$touched[$info['module']][$info['id']]) && self::$touched[$info['module']][$info['id']] > 0)
                    {
                        self::$touched[$info['module']][$info['id']]--;
                        self::$total++;
                    }
                    else
                        break;
                } else {
                    break;
                }
                $index = "i" . (self::$total % self::$maxLoaded);
            }
            if (isset(self::$loadOrder[$index]))
            {
                unset(self::$loadedBeans[$info['module']][$info['id']]);
                unset(self::$touched[$info['module']][$info['id']]);
                unset(self::$loadOrder[$index]);
            }
        }

         if(!empty($bean->id))
            $id = $bean->id;

        if ($id)
        {
            self::$loadedBeans[$module][$id] = $bean;
            self::$total++;
            self::$loadOrder[$index] = array("module" => $module, "id" => $id);
            self::$touched[$module][$id] = 0;
        } else{
            return false;
        }
        return true;
    }

    /**
     * Override module's class with custom class
     *
     * For use mainly in unit tests
     *
     * @param string $module
     * @param string $klass
     */
    public static function setBeanClass($module, $klass = null)
    {
        if(empty($klass)) {
            unset(self::$bean_classes[$module]);
        } else {
            self::$bean_classes[$module] = $klass;
        }
    }
}

