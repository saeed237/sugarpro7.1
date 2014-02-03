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

class tracker_queries_monitor extends Monitor implements Trackable {

    var $cached_data = array();
    
    /**
     * constructor
     */
    function tracker_queries_monitor($name='', $monitorId='', $metadata='', $store='') {
        parent::Monitor($name, $monitorId, $metadata, $store);
    }
   
    /**
     * save
     * This method retrieves the Store instances associated with monitor and calls
     * the flush method passing with the montior ($this) instance.
     * 
     */
    public function save($flush=true) {

        $this->cached_data[] = $this->toArray();

    	if($flush && empty($GLOBALS['tracker_' . $this->table_name]) && !empty($this->cached_data)) {
            require_once('modules/Trackers/TrackerUtility.php');
            $write_entries = array();

            foreach($this->cached_data as $entry) {
                $query = str_replace(array("\r", "\n", "\r\n", "\t"), ' ', $entry['text']);
                $query = preg_replace("/\s{2,}/", ' ', $query);
                $query = TrackerUtility::getGenericSQL($query);
                $entry['text'] = $query;

                $md5 = md5($query);

                if(!isset($write_entries[$md5])) {

                   $entry['query_hash'] = $md5;
                   $result = $GLOBALS['db']->query("SELECT * FROM tracker_queries WHERE query_hash = '{$md5}'");

                   if ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                        $entry['query_id'] = $row['query_id'];
                        $entry['run_count'] = $row['run_count'] + 1;
                        $entry['sec_total'] = $row['sec_total'] + $entry['sec_total'];
                        $entry['sec_avg'] =  ($entry['sec_total'] / $entry['run_count']);
                    } else {
                        $entry['query_id'] = create_guid();
                        $entry['run_count'] = 1;
                        $entry['sec_total'] = $entry['sec_total'];
                        $entry['sec_avg'] = $entry['sec_total'];
                    }
                    $write_entries[$md5] = $entry;
                } else {
                    $write_entries[$md5]['run_count'] = $write_entries[$md5]['run_count']++;
                    $write_entries[$md5]['sec_total'] = $write_entries[$md5]['sec_total'] + $entry['sec_total'];
                    $write_entries[$md5]['sec_avg'] = ($write_entries[$md5]['sec_total'] / $write_entries[$md5]['run_count']);
                } //if-else
            } //foreach


            $trackerManager = TrackerManager::getInstance();

            if($monitor2 = $trackerManager->getMonitor('tracker_tracker_queries')){
                $trackerManager->pause();
                //Loop through the stored cached data entries
                foreach($write_entries as $write_e) {
                    //Set the values from the cached data entries
                    foreach($write_e as $name=>$value) {
                        $this->$name = $value;
                    } //foreach

                    //Write to the tracker_tracker_monitor monitor
                    $monitor2->setValue('monitor_id', $this->monitor_id);
                    $monitor2->setValue('date_modified', $this->date_modified);
                    $monitor2->setValue('query_id', $this->query_id);
                    $monitor2->save($flush); // <--- save to tracker_tracker_monitor

                    foreach($this->stores as $s) {
                        $store = $this->getStore($s);
                        //Flush to the store
                        $store->flush($this);
                    }
                    //Clear the monitor
                    $this->clear();
                } //foreach
                $trackerManager->unPause();
            }
        unset($this->cached_data);
    	} //if
   } //save
}
?>
