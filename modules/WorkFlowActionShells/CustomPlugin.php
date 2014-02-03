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



	//Used for custom plugins
	if(
	!empty($_REQUEST['plugin_action']) && $_REQUEST['plugin_action']!=""
	&&
	!empty($_REQUEST['plugin_module']) && $_REQUEST['plugin_module']!=""){

		if(SugarAutoLoader::existing('custom/workflow/plugins/'.$_REQUEST['plugin_module'].'/'.$_REQUEST['plugin_action'].'.php')){
				include_once('custom/workflow/plugins/'.$_REQUEST['plugin_module'].'/'.$_REQUEST['plugin_action'].'.php');
		} else {
			echo "custom plugin file not found";
		}
	} else {

		echo "A custom plugin step 2 was not specified";
	}


?>
