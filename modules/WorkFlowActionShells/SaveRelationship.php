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

if(!empty($_REQUEST['workflow_id']) && !empty($_REQUEST['record_id']))
{
    $action_shell = BeanFactory::getBean('WorkFlowActionShells', $_REQUEST['record_id']);
	$new_action_shell = $action_shell;
	$new_action_shell->id = "";
	$new_action_shell->parent_id = $_REQUEST['workflow_id'];
	$new_action_shell->save();
	$new_id = $new_action_shell->id;

	//process actions
	$action_shell->retrieve($_REQUEST['record_id']);
	$action_shell->copy($new_id);

    $workflow = BeanFactory::getBean('WorkFlow', $_REQUEST['workflow_id']);
	$workflow->write_workflow();

	$javascript = "<script>window.opener.document.DetailView.action.value = 'DetailView';";
	$javascript .= "window.opener.document.DetailView.submit();";
	$javascript .= "window.close();</script>";
	echo $javascript;
}
?>
