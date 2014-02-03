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

/**
 * Redis SugarCache backend, using the PHP Redis C library at http://github.com/nicolasff/phpredis
 */
class SugarCacheRedis extends SugarCacheAbstract
{
    /**
     * @var Redis server name string
     */
    protected $_host = 'localhost';
    
    /**
     * @var Redis server port int
     */
    protected $_port = 6379;
    
    /**
     * @var Redis object
     */
    protected $_redis = null;
    
    /**
     * @see SugarCacheAbstract::$_priority
     */
    protected $_priority = 920;
    
    /**
     * @see SugarCacheAbstract::useBackend()
     */
    public function useBackend()
    {
        if ( !parent::useBackend() )
            return false;
        
        if ( extension_loaded("redis")
                && empty($GLOBALS['sugar_config']['external_cache_disabled_redis'])
                && $this->_getRedisObject() )
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
     * Get the memcache object; initialize if needed
     */
    protected function _getRedisObject()
    {
        try {
            if ( !($this->_redis instanceOf Redis) ) {
                $this->_redis = new Redis();
                $this->_host = SugarConfig::getInstance()->get('external_cache.redis.host', $this->_host);
                $this->_port = SugarConfig::getInstance()->get('external_cache.redis.port', $this->_port);
                if ( !$this->_redis->connect($this->_host,$this->_port) ) {
                    return false;
                }
            }
        }
        catch (RedisException $e)
        {
            return false;
        }
        
        return $this->_redis;
    }
    
    /**
     * @see SugarCacheAbstract::_setExternal()
     */
    protected function _setExternal(
        $key,
        $value
        )
    {
        $value = serialize($value);
        $key = $this->_fixKeyName($key);
        
        $this->_getRedisObject()->set($key,$value);
        $this->_getRedisObject()->expire($key, $this->_expireTimeout);
    }
    
    /**
     * @see SugarCacheAbstract::_getExternal()
     */
    protected function _getExternal(
        $key
        )
    {
        $key = $this->_fixKeyName($key);
        $returnValue = $this->_getRedisObject()->get($key);
        // return null if we don't get a cache hit
        if ( $returnValue === false ) {
            return null;
        }
        
        return is_string($returnValue) ?
            unserialize($returnValue) :
            $returnValue;
    }
    
    /**
     * @see SugarCacheAbstract::_clearExternal()
     */
    protected function _clearExternal(
        $key
        )
    {
        $key = $this->_fixKeyName($key);
        $this->_getRedisObject()->delete($key);
    }
    
    /**
     * @see SugarCacheAbstract::_resetExternal()
     */
    protected function _resetExternal()
    {
        $this->_getRedisObject()->flushAll();
    }
    
    /**
     * Fixed the key naming used so we don't have any spaces
     *
     * @param  string $key
     * @return string fixed key name
     */
    protected function _fixKeyName($key)
    {
        return str_replace(' ','_',$key);
    }
}
