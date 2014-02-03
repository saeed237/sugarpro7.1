<?php
//FILE SUGARCRM flav=pro
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


require_once('include/connectors/filters/default/filter.php');

class ext_rest_zoominfocompany_filter extends default_filter {	
	
public function getList($args, $module) {
	
	if(empty($args)) {
	   return null;	
	}

	$list = $this->_component->getSource()->getList($args, $module);

	if(empty($list) && isset($args['companyName'])) {
	   if(preg_match('/^(.*?)([\,|\s]+.*?)$/', $args['companyName'], $matches)) {
	   	 $GLOBALS['log']->info("ext_rest_zoominfocompany_filter, change companyName search term");
	   	 $args['companyName'] = $matches[1];
	     $list = $this->_component->getSource()->getList($args, $module);
	   }
	} 			
	
	//If count was 0 and state and/or country value was used, we try to improve searching
	if(empty($list) && isset($args['companyName']) && isset($args['ZipCode'])) {
	   $GLOBALS['log']->info("ext_rest_zoominfocompany_filter, unset ZipCode search term");
	   unset($args['ZipCode']);	
	   $list = $this->_component->getSource()->getList($args, $module);
	}	
	
	if(empty($list) && isset($args['companyName']) && isset($args['Country'])) {
	   $GLOBALS['log']->info("ext_rest_zoominfocompany_filter, unset Country search term");
	   unset($args['Country']);	
	   $list = $this->_component->getSource()->getList($args, $module);
	} 

	return $list;
}
	
}

?>