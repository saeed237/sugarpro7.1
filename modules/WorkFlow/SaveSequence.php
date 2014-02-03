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

 * Description:  
 ********************************************************************************/


require_once('include/controller/Controller.php');


$local_log =& LoggerManager::getLogger('index');

$focus = BeanFactory::getBean('WorkFlow');
$controller = new Controller();

	
	//if we are saving from the adddatasetform
	$focus->retrieve($_REQUEST['workflow_id']);

		
		$magnitude = 1;
		$direction = $_REQUEST['direction'];

		$controller->init($focus, "Save");
		$controller->change_component_order($magnitude, $direction, $focus->base_module);

$focus->save();

$focus->write_workflow();
	
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Workflow";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "ProcessListView";

//echo "index.php?action=$return_action&module=$return_module&record=$return_id";

header("Location: index.php?action=$return_action&module=$return_module&base_module=".$_REQUEST['base_module']."");
?>
