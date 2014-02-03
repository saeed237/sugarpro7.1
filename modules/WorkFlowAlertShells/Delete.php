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


global $mod_strings;



$focus = BeanFactory::getBean('WorkFlowAlertShells');

if(!isset($_REQUEST['record']))
	sugar_die($mod_strings['ERR_DELETE_RECORD']);

	$focus->retrieve($_REQUEST['record']);
	
	//mark delete alert components and sub expression components
	$alert_object_list = $focus->get_linked_beans('alert_components','WorkFlowAlert');
	
	foreach($alert_object_list as $alert_object){
		mark_delete_components($alert_object->get_linked_beans('expressions','Expression'));
		mark_delete_components($alert_object->get_linked_beans('rel1_alert_fil','Expression'));
		mark_delete_components($alert_object->get_linked_beans('rel2_alert_fil','Expression'));
		$alert_object->mark_deleted($alert_object->id);	
		
	//end foreach alert_object
	}	
	
	$focus->mark_deleted($_REQUEST['record']);

	$workflow_object = $focus->get_workflow_object();
	$workflow_object->write_workflow();

header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);
?>
