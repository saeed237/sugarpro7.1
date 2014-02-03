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


class SugarModule
{
    protected static $_instances = array();

    protected $_moduleName;

    public static function get(
        $moduleName
        )
    {
        if ( !isset(self::$_instances[$moduleName]) )
            self::$_instances[$moduleName] = new SugarModule($moduleName);

        return self::$_instances[$moduleName];
    }

    public function __construct(
        $moduleName
        )
    {
        $this->_moduleName = $moduleName;
    }

    /**
     * Returns true if the given module implements the indicated template
     *
     * @param  string $template
     * @return bool
     */
    public function moduleImplements(
        $template
        )
    {
        $focus = self::loadBean();

        if ( !$focus )
            return false;

        return is_a($focus,$template);
    }

    /**
     * Returns the bean object of the given module
     *
     * @return object
     */
    public function loadBean($beanList = null, $beanFiles = null, $returnObject = true)
    {
        return BeanFactory::getBean($this->_moduleName);
//         // Populate these reference arrays
//         if ( empty($beanList) ) {
//             global $beanList;
//         }
//         if ( empty($beanFiles) ) {
//             global $beanFiles;
//         }
//         if ( !isset($beanList) || !isset($beanFiles) ) {
//             require('include/modules.php');
//         }

//         if ( isset($beanList[$this->_moduleName]) ) {
//             $bean = $beanList[$this->_moduleName];
//             if (isset($beanFiles[$bean])) {
//                 if ( !$returnObject ) {
//                     return true;
//                 }
//                 if ( !sugar_is_file($beanFiles[$bean]) ) {
//                     return false;
//                 }
//                 require_once($beanFiles[$bean]);
//                 $focus = new $bean;
//             }
//             else {
//                 return false;
//             }
//         }
//         else {
//             return false;
//         }

//         return $focus;
    }
}
