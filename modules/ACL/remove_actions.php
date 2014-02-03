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



global $current_user,$beanList, $beanFiles;
$actionarr = ACLAction::getDefaultActions();
if(is_admin($current_user)){
	$foundOne = false;
	foreach($actionarr as $actionobj){
		if(!isset($beanList[$actionobj->category]) || !file_exists($beanFiles[$beanList[$actionobj->category]])){
			if(!isset($_REQUEST['upgradeWizard'])){
				echo 'Removing for ' . $actionobj->category . '<br>';
			}
			$foundOne = true;
			ACLAction::removeActions($actionobj->category);
		}
	}
	if(!$foundOne)
		echo 'No ACL modules found that needed to be removed';
}


?>