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
 * repair the workflow sessions
 */
class SugarUpgradeRepairWorkflow extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if(!$this->toFlavor('pro')) return;

        require_once('modules/WorkFlow/WorkFlow.php');
    	require_once('modules/WorkFlowTriggerShells/WorkFlowTriggerShell.php');
    	require_once('include/workflow/glue.php');
        // grab all workflows that are time based and have not been deleted
        $query = "SELECT workflow_triggershells.id trigger_id FROM workflow LEFT JOIN workflow_triggershells ON workflow_triggershells.parent_id = workflow.id WHERE workflow.deleted = 0 AND workflow.type = 'Time' AND workflow_triggershells.type = 'compare_any_time'";
        $data = $this->db->query($query);
        if(empty($data)) {
            return;
        }
        while($row = $this->db->fetchByAssoc($data)) {
    			$shell = new WorkFlowTriggerShell();
    			$glue_object = new WorkFlowGlue();
    			$shell->retrieve($row['trigger_id']);
    			$shell->eval = $glue_object->glue_normal_compare_any_time($shell);
    			$shell->save();
        }
    	//call repair workflow
    	$workflow_object = new WorkFlow();
    	$workflow_object->repair_workflow();
    }
}
