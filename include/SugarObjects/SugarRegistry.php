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


/**
 * Global registry
 * @api
 */
class SugarRegistry
{
    private static $_instances = array();
    private $_data = array();

    public function __construct() {

    }

    public static function getInstance($name = 'default') {
        if (!isset(self::$_instances[$name])) {
            self::$_instances[$name] = new self();
        }
        return self::$_instances[$name];
    }

    public function __get($key) {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

    public function __set($key, $value) {
        $this->_data[$key] = $value;
    }

    public function __isset($key) {
        return isset($this->_data[$key]);
    }

    public function __unset($key) {
        unset($this->_data[$key]);
    }

    public function addToGlobals() {
        foreach ($this->_data as $k => $v) {
            $GLOBALS[$k] = $v;
        }
    }
}

