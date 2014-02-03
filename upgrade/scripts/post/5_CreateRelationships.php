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

/**
 * Create new rels for CE->PRO
 */
class SugarUpgradeCreateRelationships extends UpgradeScript
{
    public $order = 5000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if(!($this->from_flavor == 'ce' && $this->toFlavor('pro'))) return;

	    $relForObjects = array('leads'=>'Leads','campaigns'=>'Campaigns','prospects'=>'Prospects');
	    foreach($relForObjects as $relObjName=>$relModName){
	        $guid = create_guid();
	        $result= $this->db->query("SELECT id FROM relationships WHERE relationship_name = '{$relObjName}_team'");
	        $a = $this->db->fetchByAssoc($result);
	        if(!isset($a['id']) && empty($a['id']) ){
	            $qRel = "INSERT INTO relationships (id,relationship_name, lhs_module, lhs_table, lhs_key, rhs_module, rhs_table, rhs_key, join_table, join_key_lhs, join_key_rhs, relationship_type, relationship_role_column, relationship_role_column_value, reverse, deleted)
	            VALUES ('{$guid}', '{$relObjName}_team','Teams','teams','id','{$relModName}','{$relObjName}','team_id',NULL,NULL,NULL,'one-to-many',NULL,NULL,'0','0')";
	            $this->db->query($qRel);
	        }
	    }

	    $guid = create_guid();
	    $result= $this->db->query("SELECT id FROM relationships WHERE relationship_name = 'tracker_monitor_id'");
	    $a = $this->db->fetchByAssoc($result);
	    if(!isset($a['id']) && empty($a['id']) ){
			$qRel = "INSERT INTO relationships (id,relationship_name, lhs_module, lhs_table, lhs_key, rhs_module, rhs_table, rhs_key, join_table, join_key_lhs, join_key_rhs, relationship_type, relationship_role_column, relationship_role_column_value, reverse, deleted)
			VALUES ('{$guid}', 'tracker_monitor_id','TrackerPerfs','tracker_perf','monitor_id','Trackers','tracker','monitor_id',NULL,NULL,NULL,'one-to-many',NULL,NULL,'0','0')";
			$this->db->query($qRel);
	    }
    }
}
