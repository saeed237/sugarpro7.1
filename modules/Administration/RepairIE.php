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
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/


	
$db = DBManagerFactory::getInstance();

$badAccts = array();

$q = "SELECT id, name, email_password FROM inbound_email WHERE deleted=0 AND status='Active'";
$r = $db->query($q);

while($a = $db->fetchByAssoc($r)) {
	$ieX = BeanFactory::getBean('InboundEmail', $a['id']);
	if(!$ieX->repairAccount()) {
		// none of the iterations worked.  flag for display
		$badAccts[$a['id']] = $a['name'];
	}
}

if(empty($badAccts)) {
	echo $mod_strings['LBL_REPAIR_IE_SUCCESS'];
} else {
	echo "<div class='error'>{$mod_strings['LBL_REPAIR_IE_FAILURE']}</div><br />";
	foreach($badAccts as $id => $acctName) {
		echo "<a href='index.php?module=InboundEmail&action=EditView&record={$id}' target='_blank'>{$acctName}</a><br />";
	}
}

?>