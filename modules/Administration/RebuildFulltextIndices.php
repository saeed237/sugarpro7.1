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

global $current_user, $mod_strings;

if(!is_admin($current_user)){
	die($mod_strings['LBL_REBUILD_FULL_TEXT_ABORT']);
}

//find  modules that have a full-text index and rebuild it.
global $beanFiles;
foreach ($beanFiles as $beanname=>$beanpath) {
	require_once($beanpath);
	$focus = BeanFactory::newBeanByName($beanname);

	//skips beans based on same tables. user, employee and group are an example.
	if(empty($focus->table_name) || isset($processed_tables[$focus->table_name])) {
		continue;
	} else {
		$processed_tables[$focus->table_name]=$focus->table_name;
	}

	if(!empty($dictionary[$focus->object_name]['indices'])) {
		$indices=$dictionary[$focus->object_name]['indices'];
	} else {
		$indices=array();
	}

	//clean vardef definitions.. removed indexes not value for this dbtype.
	//set index name as the key.
	$var_indices=array();
	foreach ($indices as $definition) {
		//database helpers do not know how to handle full text indices
		if ($definition['type']=='fulltext') {
			if (isset($definition['db']) and $definition['db'] != $GLOBALS['db']->dbType) {
				continue;
			}

			echo "Rebuilding Index {$definition['name']} <BR/>";
			$GLOBALS['db']->query('alter index ' .$definition['name'] . " REBUILD");
		}

	}
}
?>
