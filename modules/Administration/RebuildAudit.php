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

include('include/modules.php');

global $beanFiles, $mod_strings;
echo $mod_strings['LBL_REBUILD_AUDIT_SEARCH'] . ' <BR>';
foreach ($beanFiles as $bean => $file)
{
	if(strlen($file) > 0 && file_exists($file)) {
		require_once($file);
	    $focus = BeanFactory::newBeanByName($bean);
		if ($focus->is_AuditEnabled()) {
			if (!$focus->db->tableExists($focus->get_audit_table_name())) {
				printf($mod_strings['LBL_REBUILD_AUDIT_SEARCH'],$focus->get_audit_table_name(), $focus->object_name);
				$focus->create_audit_table();
			} else {
				printf($mod_strings['LBL_REBUILD_AUDIT_SKIP'],$focus->object_name);
			}
		}
	}
}
echo $mod_strings['LBL_DONE'];
?>