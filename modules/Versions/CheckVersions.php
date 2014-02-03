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

	//returns a list of components that are not of expected version
	function get_invalid_versions(){
		$invalid = array();
		
		require_once('modules/Versions/ExpectedVersions.php');
		
		foreach($expect_versions as $expect){
			$version = BeanFactory::getBean('Versions');
			$result = $version->db->query("Select * from  $version->table_name  where  name='". $expect['name'] . "'");
			$valid = $version->db->fetchByAssoc($result);
			if($valid == null || ( !$version->is_expected_version($expect) && !empty($version->name) )){
		
				$invalid[$expect['name']] = $expect;
			}
		}
		return $invalid;
	}

?>