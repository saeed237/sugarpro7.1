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

class tracker_monitor extends Monitor {

    /**
     * Monitor constructor
     */
    function tracker_monitor($name='', $monitorId='', $metadata='', $store='') {
        parent::Monitor($name, $monitorId, $metadata, $store);
    }
    
    
    /**
     * save
     * This method retrieves the Store instances associated with monitor and calls
     * the flush method passing with the montior ($this) instance.
     * @param $flush boolean parameter indicating whether or not to flush the instance data to store or possibly cache
     */
    public function save($flush=true) {
    	//if the monitor does not have values set no need to do the work saving. 
    	if(!$this->dirty)return false;
    	
    	if(!$this->isEnabled() && (isset($this->visible) && !$this->getValue('visible'))) {
    		return false;
    	}
    	
    	if(empty($GLOBALS['tracker_' . $this->table_name])) {
    	    foreach($this->stores as $s) {
	    		$store = $this->getStore($s);
	    		$store->flush($this);
    		}
    	}
    	$this->clear();
    }

}

?>
