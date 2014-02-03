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

/**
 * Database
 * This is an implementation of the Store interface where the storage uses
 * the configured database instance as defined in DBManagerFactory::getInstance() method
 *
 */
class DatabaseStore implements Store {

    public function flush($monitor) {

       $metrics = $monitor->getMetrics();
       $columns = array();
       $values = array();
       $db = DBManagerFactory::getInstance();
       foreach($metrics as $name=>$metric) {
       	  if(!empty($monitor->$name)) {
       	  	 $columns[] = $name;
       	  	 if($metrics[$name]->_type == 'int') {
       	  	    $values[] = intval($monitor->$name);
       	  	 } else if($metrics[$name]->_type == 'double') {
                $values[] = floatval($monitor->$name);
             } else if ($metrics[$name]->_type == 'datetime') {
             	$values[] = $db->convert($GLOBALS['db']->quoted($monitor->$name), "datetime");
       	  	 } else {
                $values[] = $db->quoted($monitor->$name);
             }
       	  }
       } //foreach

       if(empty($values)) {
       	  return;
       }

       $id = $db->getAutoIncrementSQL($monitor->table_name,'id');
       if(!empty($id)) {
       	  $columns[] = 'id';
       	  $values[] = $id;
       }

       $query = "INSERT INTO $monitor->table_name (" .implode("," , $columns). " ) VALUES ( ". implode("," , $values). ')';
	   $db->query($query);
    }
}

?>
