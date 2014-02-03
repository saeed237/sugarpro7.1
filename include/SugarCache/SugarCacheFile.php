<?php
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


require_once('include/SugarCache/SugarCacheAbstract.php');

class SugarCacheFile extends SugarCacheAbstract
{
    /**
     * @var path and file which will store the cache used for this backend
     */
    protected $_cacheFileName = 'externalCache.php';

    /**
     * @var bool true if the cache has changed and needs written to disk
     */
    protected $_cacheChanged = false;

    /**
     * @see SugarCacheAbstract::$_priority
     */
    protected $_priority = 990;

    /**
     * @see SugarCacheAbstract::useBackend()
     */
    public function useBackend()
    {
        if ( !parent::useBackend() )
            return false;

        if ( !empty($GLOBALS['sugar_config']['external_cache_enabled_file']) )
            return true;

        return false;
    }

    /**
     * @see SugarCacheAbstract::__construct()
     *
     * For this backend, we'll read from the SugarCacheFile::_cacheFileName file into
     * the SugarCacheFile::$localCache array.
     */
    public function __construct()
    {
        parent::__construct();

        if ( isset($GLOBALS['sugar_config']['external_cache_filename']) )
            $this->_cacheFileName = $GLOBALS['sugar_config']['external_cache_filename'];
    }

    /**
     * @see SugarCacheAbstract::__destruct()
     *
     * For this backend, we'll write the SugarCacheFile::$localCache array serialized out to a file
     */
    public function __destruct()
    {
        parent::__destruct();

        if ( $this->_cacheChanged )
            sugar_file_put_contents(sugar_cached($this->_cacheFileName), serialize($this->_localStore));
    }

    /**
	 * This is needed to prevent unserialize vulnerability
     */
    public function __wakeup()
    {
        // clean all properties
        foreach(get_object_vars($this) as $k => $v) {
            $this->$k = null;
        }
        throw new Exception("Not a serializable object");
    }

    /**
     * @see SugarCacheAbstract::_setExternal()
     *
     * Does nothing; we write to cache on destroy
     */
    protected function _setExternal(
        $key,
        $value
        )
    {
        $this->_cacheChanged = true;
    }

    /**
     * @see SugarCacheAbstract::_getExternal()
     */
    protected function _getExternal(
        $key
        )
    {
        // load up the external cache file
        if ( sugar_is_file($cachedfile = sugar_cached($this->_cacheFileName)))
            $this->localCache = unserialize(file_get_contents($cachedfile));

        if ( isset($this->_localStore[$key]) )
            return $this->_localStore[$key];

        return null;
    }

    /**
     * @see SugarCacheAbstract::_clearExternal()
     *
     * Does nothing; we write to cache on destroy
     */
    protected function _clearExternal(
        $key
        )
    {
        $this->_cacheChanged = true;
    }

    /**
     * @see SugarCacheAbstract::_resetExternal()
     *
     * Does nothing; we write to cache on destroy
     */
    protected function _resetExternal()
    {
        $this->_cacheChanged = true;
    }
}
