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





require_once('modules/Versions/DefaultVersions.php');

foreach($default_versions as $default_version){
	
	$version = BeanFactory::getBean('Versions');
	$query="select count(*) the_count from versions where name='{$default_version['name']}'";
	$result=$version->db->query($query);
	$row=$version->db->fetchByAssoc($result);
	if ($row== null or $row['the_count'] ==0) {
		$version->name = $default_version['name'];
		$version->file_version = $default_version['file_version'];
		$version->db_version = $default_version['db_version'];
		$version->save();
	}
}

?>