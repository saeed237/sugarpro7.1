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

class SugarCacheMemcached extends SugarCacheAbstract
{
    /**
     * @var Memcache server name string
     */
    protected $_host = '127.0.0.1';
    
    /**
     * @var Memcache server port int
     */
    protected $_port = 11211;
    
    /**
     * @var Memcached object
     */
    protected $_memcached = '';
    
    /**
     * @see SugarCacheAbstract::$_priority
     */
    protected $_priority = 900;
     
    /**
     * @see SugarCacheAbstract::useBackend()
     */
    public function useBackend()
    {
        if ( extension_loaded('memcached')
                && empty($GLOBALS['sugar_config']['external_cache_disabled_memcached'])
                && $this->_getMemcachedObject() )
            return true;
            
        return false;
    }
    
    /**
     * @see SugarCacheAbstract::__construct()
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get the memcached object; initialize if needed
     */
    protected function _getMemcachedObject()
    {
        if ( !($this->_memcached instanceOf Memcached) ) {
            $this->_memcached = new Memcached();
            $this->_host = SugarConfig::getInstance()->get('external_cache.memcache.host', $this->_host);
            $this->_port = SugarConfig::getInstance()->get('external_cache.memcache.port', $this->_port);
            if ( !@$this->_memcached->addServer($this->_host,$this->_port) ) {
                return false;
            }
        }
        
        return $this->_memcached;
    }
    
    /**
     * @see SugarCacheAbstract::_setExternal()
     */
    protected function _setExternal(
        $key,
        $value
        )
    {
        $this->_getMemcachedObject()->set($key, $value, $this->_expireTimeout);
    }
    
    /**
     * @see SugarCacheAbstract::_getExternal()
     */
    protected function _getExternal(
        $key
        )
    {
        $returnValue = $this->_getMemcachedObject()->get($key);
        if ( $this->_getMemcachedObject()->getResultCode() != Memcached::RES_SUCCESS ) {
            return null;
        }

        return $returnValue;
    }
    
    /**
     * @see SugarCacheAbstract::_clearExternal()
     */
    protected function _clearExternal(
        $key
        )
    {
        $this->_getMemcachedObject()->delete($key);
    }
    
    /**
     * @see SugarCacheAbstract::_resetExternal()
     */
    protected function _resetExternal()
    {
        $this->_getMemcachedObject()->flush();
    }
}
