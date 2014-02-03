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

global $mod_strings;
if(empty($_REQUEST['record'])) {
	sugar_die($mod_strings['LBL_DELETE_ERROR']);
} else {
	
	$focus = BeanFactory::getBean('InboundEmail');

	// retrieve the focus in order to populate it with ID. otherwise this
	// instance will be marked as deleted and than replaced by another instance,
	// which will be saved and tracked (bug #47552)
	$focus->retrieve($_REQUEST['record']);
	$focus->mark_deleted($_REQUEST['record']);
	header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);
}

?>
