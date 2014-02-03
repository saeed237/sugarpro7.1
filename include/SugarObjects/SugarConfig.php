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
 * Config manager
 * @api
 */
class SugarConfig
{
    var $_cached_values = array();

    static function getInstance() {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new SugarConfig();
        }
        return $instance;
    }

    function get($key, $default = null) {
        if (!isset($this->_cached_values[$key])) {
            if (!class_exists('SugarArray', true)) {
				require 'include/utils/array_utils.php';
			}
            $this->_cached_values[$key] = isset($GLOBALS['sugar_config']) ?
                SugarArray::staticGet($GLOBALS['sugar_config'], $key, $default) :
                $default;
        }
        return $this->_cached_values[$key];
    }

    function clearCache($key = null) {
        if (is_null($key)) {
            $this->_cached_values = array();
        } else {
            unset($this->_cached_values[$key]);
        }
    }
}

