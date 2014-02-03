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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Trackers/store/Store.php');

class TrackerQueriesDatabaseStore implements Store {

    public function flush($monitor)
    {
        $db = DBManagerFactory::getInstance();
        if($monitor->run_count > 1) {
            $query = "UPDATE $monitor->table_name set run_count={$monitor->run_count}, sec_avg={$monitor->sec_avg}, sec_total={$monitor->sec_total}, date_modified='{$monitor->date_modified}' where query_hash = '{$monitor->query_hash}'";
            $db->query($query);
            return;
        }

       $metrics = $monitor->getMetrics();
       $values = array();
       foreach($metrics as $name=>$metric) {
       	  if(!empty($monitor->$name)) {
       	  	 $columns[] = $name;
       	  	 $fields[$name] = array('name' => $name, 'type' => $metrics[$name]->_type);
       	  	 $values[$name] = $monitor->$name;
           }
       } //foreach

       if(empty($values)) {
       	  return;
       }

       $fields['id'] = array('auto_increment' => true, "name" => "id", "type" => "int");
       $db->insertParams($monitor->table_name, $fields, $values);
    }
}
