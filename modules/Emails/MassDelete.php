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


if(!empty($_REQUEST['grabbed'])) {
	
	$focus = BeanFactory::getBean('Emails');
	
	$emailIds = array();
	// CHECKED ONLY:
	$grabEx = explode('::',$_REQUEST['grabbed']);
	
	foreach($grabEx as $k => $emailId) {
		if($emailId != "undefined") {
			$focus->mark_deleted($emailId);
		}
	}
	
	header('Location: index.php?module=Emails&action=ListViewGroup');
} else {
	global $mod_strings;
	// error
	$error = $mod_strings['LBL_MASS_DELETE_ERROR'];
	header('Location: index.php?module=Emails&action=ListViewGroup&error='.$error);
}

?>
