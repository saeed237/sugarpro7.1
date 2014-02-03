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

class SugarCacheMemory extends SugarCacheAbstract
{
    /**
     * @see SugarCacheAbstract::$_priority
     */
    protected $_priority = 999;
    
    /**
     * @see SugarCacheAbstract::useBackend()
     */
    public function useBackend()
    {
        // we'll always have this backend available
        return true;
    }
    
    /**
     * @see SugarCacheAbstract::_setExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _setExternal($key,$value)
    {
    }
    
    /**
     * @see SugarCacheAbstract::_getExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _getExternal($key)
    {
    }
    
    /**
     * @see SugarCacheAbstract::_clearExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _clearExternal($key)
    {
    }
    
    /**
     * @see SugarCacheAbstract::_resetExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _resetExternal()
    {
    }
}
