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

class TrackerManager {

private static $instance;
private static $monitor_id;
private $metadata = array();
private $monitors = array();
private $disabledMonitors = array();
private static $paused = false;

/**
 * Constructor for TrackerManager.  Declared private for singleton pattern.
 *
 */
private function TrackerManager() {
	require('modules/Trackers/config.php');
	$this->metadata = $tracker_config;
    self::$monitor_id = create_guid();
}

/**
 * setup
 * This is a private method used to load the configuration settings whereby
 * monitors may be disabled via the Admin settings interface
 *
 */
private function setup() {
	if(!empty($this->metadata) && empty($GLOBALS['installing'])) {
        
		$admin = Administration::getSettings('tracker');
		foreach($this->metadata as $key=>$entry) {
		   if(isset($entry['bean'])) {
		   	  if(!empty($admin->settings['tracker_'. $entry['name']])) {
		   	  	 $this->disabledMonitors[$entry['name']] = true;
		   	  }
		   }
		}
	}
}

public function setMonitorId($id) {
    self::$monitor_id = $id;
    foreach($this->monitors as $monitor) {
       $monitor->monitor_id = self::$monitor_id;
    }
}

/**
 * getMonitorId
 * Returns the monitor id associated with this TrackerManager instance
 * @returns String id value
 */
public function getMonitorId() {
    return self::$monitor_id;
}

/**
 * getInstance
 * Singleton method to return static instance of TrackerManager
 * @returns static TrackerManager instance
 */
static function getInstance(){
    if (!isset(self::$instance)) {
        self::$instance = new TrackerManager();
		//Set global variable for tracker monitor instances that are disabled
        self::$instance->setup();
    } // if
    return self::$instance;
}

/**
 * getMonitor
 * This method returns a Monitor instance based on the monitor name.
 * @param $name The String value of the monitor's name to retrieve
 * @return Monitor instance corresponding to name or a BlankMonitor instance if one could not be found
 */
public function getMonitor($name) {
	//don't waste our time on disabled monitors
	if($name!='tracker_sessions' && !empty($this->disabledMonitors[$name]))return false;
	if(isset($this->monitors[$name])) {
	   return $this->monitors[$name];
	}

	if(isset($this->metadata) && isset($this->metadata[$name])) {


       try {
	       $instance = $this->_getMonitor($this->metadata[$name]['name'], //name
	       						   self::$monitor_id, //monitor_id
	                               $this->metadata[$name]['metadata'],
	                               $this->metadata[$name]['store'] //store
	                               );
	       $this->monitors[$name] = $instance;
	       return $this->monitors[$name];
       } catch (Exception $ex) {
       	   $GLOBALS['log']->error($ex->getMessage());
       	   $GLOBALS['log']->error($ex->getTraceAsString());
       	   require_once('modules/Trackers/monitor/BlankMonitor.php');
       	   $this->monitors[$name] = new BlankMonitor();
       	   return $this->monitors[$name];
       }

    } else {
       $GLOBALS['log']->error($GLOBALS['app_strings']['ERR_MONITOR_NOT_CONFIGURED'] . "($name)");
       require_once('modules/Trackers/monitor/BlankMonitor.php');
       $this->monitors[$name] = new BlankMonitor();
       return $this->monitors[$name];
    }
}

private function _getMonitor($name='', $monitorId='', $metadata='', $store='')
{
	$class = strtolower($name.'_monitor');
	$monitor = null;
	if(SugarAutoLoader::requireWithCustom('modules/Trackers/monitor/'.$class.'.php') && class_exists($class)) {
	    $monitor = new $class($name, $monitorId, $metadata, $store);
	} else {
		$monitor = new Monitor($name, $monitorId, $metadata, $store);
	}

	$monitor->setEnabled(empty($this->disabledMonitors[$monitor->name]));
	return $monitor;
}

/**
 * save
 * This method handles saving the monitors and their metrics to the mapped Store implementations
 */
public function save() {

    // Session tracker always saves.
    if ( isset($this->monitors['tracker_sessions']) ) {
        $this->monitors['tracker_sessions']->save();
        unset($this->monitors['tracker_sessions']);
    }

    if(!$this->isPaused()){
		foreach($this->monitors as $monitor) {
			if(array_key_exists('Trackable', class_implements($monitor))) {
			   $monitor->save();
		    }
    	}
    }
}

/**
 * saveMonitor
 * Saves the monitor instance and then clears it
 * If ignoreDisabled is set the ignore the fact of this monitor being disabled
 */
public function saveMonitor($monitor, $flush=true, $ignoreDisabled = false) {

	if(!$this->isPaused() && !empty($monitor)){

		if((empty($this->disabledMonitors[$monitor->name]) || $ignoreDisabled) && array_key_exists('Trackable', class_implements($monitor))) {

		   $monitor->save($flush);

		   if($flush) {
			   $monitor->clear();
			   unset($this->monitors[strtolower($monitor->name)]);
		   }
	    }
	}
}

/**
 * unsetMonitor
 * Method to unset the monitor so that it will not be saved
 */
public function unsetMonitor($monitor) {
   if(!empty($monitor)) {
      unset($this->monitors[strtolower($monitor->name)]);
   }
}

/**
 * pause
 * This function is to be called by a client in order to pause tracking through the lifetime of a Request.
 * Tracking can be started again by calling unPauseTracking
 *
 * Usage: TrackerManager::getInstance()->pauseTracking();
 */
public function pause(){
	self::$paused = true;
}

/**
 * unPause
 * This function is to be called by a client in order to unPause tracking through the lifetime of a Request.
 * Tracking can be paused by calling pauseTracking
 *
 *  * Usage: TrackerManager::getInstance()->unPauseTracking();
 */
public function unPause(){
	self::$paused = false;
}


/**
 * isPaused
 * This function returns the current value of the private paused variable.
 * The result indicates whether or not the TrackerManager is paused.
 *
 * @return boolean value indicating whether or not TrackerManager instance is paused.
 */
public function isPaused() {
   return self::$paused;
}

/**
 * getDisabledMonitors
 * Returns an Array of Monitor's name(s) that hhave been set to disabled in the
 * Administration section.
 *
 * @return Array of disabled Monitor's name(s) that hhave been set to disabled in the
 * Administration section.
 */
public function getDisabledMonitors() {
	return $this->disabledMonitors;
}

/**
 * Set the disabled monitors
 *
 * @param array $disabledMonitors
 */
public function setDisabledMonitors($disabledMonitors) {
	$this->disabledMonitors = $disabledMonitors;
}

/**
 * unsetMonitors
 * Function to unset all Monitors loaded for a TrackerManager instance
 *
 */
public function unsetMonitors() {
	$mons = $this->monitors;
	foreach($mons as $key=>$m) {
		$this->unsetMonitor($m);
	}
}

}
?>
