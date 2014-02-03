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


require_once('modules/Trackers/monitor/Monitor.php');
require_once('modules/Trackers/Metric.php');
require_once('modules/Trackers/Trackable.php');

class BlankMonitor extends Monitor implements Trackable {
    
    /**
     * BlankMonitor constructor
     */
    function BlankMonitor() {

    }
    
    /**
     * setValue
     * Sets the value defined in the monitor's metrics for the given name
     * @param $name String value of metric name
     * @param $value Mixed value 
     * @throws Exception Thrown if metric name is not configured for monitor instance
     */
    function setValue($name, $value) {

    }
    
    /**
     * getStores
     * Returns Array of store names defined for monitor instance
     * @return Array of store names defined for monitor instance
     */
    function getStores() {
        return null;	
    }
    
    /**
     * getMetrics
     * Returns Array of metric instances defined for monitor instance
     * @return Array of metric instances defined for monitor instance
     */
    function getMetrics() {
    	return null;
    }
    
    /**
     * save
     * This method retrieves the Store instances associated with monitor and calls
     * the flush method passing with the montior ($this) instance.
     * 
     */
    public function save() {
 	
    }


	/**
	 * getStore
	 * This method checks if the Store implementation has already been instantiated and
	 * will return the one stored; otherwise it will create the Store implementation and
	 * save it to the Array of Stores.
	 * @param $store The name of the store as defined in the 'modules/Trackers/config.php' settings
	 * @return An instance of a Store implementation
	 * @throws Exception Thrown if $store class cannot be loaded
	 */
	protected function getStore($store) {
		return null;
	}

    
	/**
	 * clear
	 * This function clears the metrics data in the monitor instance
	 */
	public function clear() {

	}
}

?>