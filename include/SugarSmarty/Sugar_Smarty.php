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


require_once('vendor/Smarty/Smarty.class.php');

if(!defined('SUGAR_SMARTY_DIR'))
{
	define('SUGAR_SMARTY_DIR', sugar_cached('smarty/'));
}

/**
 * Smarty wrapper for Sugar
 * @api
 */
class Sugar_Smarty extends Smarty
{
    protected static $_plugins_dir;
	function Sugar_Smarty()
	{
		if(!file_exists(SUGAR_SMARTY_DIR))mkdir_recursive(SUGAR_SMARTY_DIR, true);
		if(!file_exists(SUGAR_SMARTY_DIR . 'templates_c'))mkdir_recursive(SUGAR_SMARTY_DIR . 'templates_c', true);
		if(!file_exists(SUGAR_SMARTY_DIR . 'configs'))mkdir_recursive(SUGAR_SMARTY_DIR . 'configs', true);
		if(!file_exists(SUGAR_SMARTY_DIR . 'cache'))mkdir_recursive(SUGAR_SMARTY_DIR . 'cache', true);

		$this->template_dir = '.';
		$this->compile_dir = SUGAR_SMARTY_DIR . 'templates_c';
		$this->config_dir = SUGAR_SMARTY_DIR . 'configs';
		$this->cache_dir = SUGAR_SMARTY_DIR . 'cache';
		$this->request_use_auto_globals = true; // to disable Smarty from using long arrays

        if(empty(self::$_plugins_dir)) {
            self::$_plugins_dir = array();
            if (SugarAutoLoader::fileExists('custom/include/SugarSmarty/plugins')) {
                self::$_plugins_dir[] = 'custom/include/SugarSmarty/plugins';
            }
            if (SugarAutoLoader::fileExists('custom/vendor/Smarty/plugins')) {
                self::$_plugins_dir[] = 'custom/vendor/Smarty/plugins';
            }
            self::$_plugins_dir[] = 'include/SugarSmarty/plugins';
            self::$_plugins_dir[] = 'vendor/Smarty/plugins';
        }
        $this->plugins_dir = self::$_plugins_dir;

		$this->assign("VERSION_MARK", getVersionedPath(''));
	}

	/**
	 * Fetch template or custom double
	 * @see Smarty::fetch()
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
	 */
	public function fetchCustom($resource_name, $cache_id = null, $compile_id = null, $display = false)
	{
	    return $this->fetch(SugarAutoLoader::existingCustomOne($resource_name), $cache_id, $compile_id, $display);
	}

	/**
	 * Display template or custom double
	 * @see Smarty::display()
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
	 */
	function displayCustom($resource_name, $cache_id = null, $compile_id = null)
	{
	    return $this->display(SugarAutoLoader::existingCustomOne($resource_name), $cache_id, $compile_id);
	}

	/**
	 * Override default _unlink method call to fix Bug 53010
	 *
	 * @param string $resource
     * @param integer $exp_time
     */
    function _unlink($resource, $exp_time = null)
    {
        if(file_exists($resource)) {
            return parent::_unlink($resource, $exp_time);
        }

        // file wasn't found, so it must be gone.
        return true;
    }
}
