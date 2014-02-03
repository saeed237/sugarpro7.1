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
 ********************************************************************************/



require_once('include/workflow/plugin_utils.php');

global $beanFiles;
global $mod_strings;
global $db;

function remove_workflow_dir($dir) {
   if($elements = glob($dir."/*")){
       foreach($elements as $element) {
           is_dir($element)? remove_workflow_dir($element) : unlink($element);
       }
   }
}



$workflow_object = BeanFactory::getBean('WorkFlow');


	$module_array = $workflow_object->get_module_array();

	foreach($module_array as $key => $module){

		$dir = "custom/modules/".$module."/workflow";
		if(file_exists($dir)){
			
			remove_workflow_dir($dir);
			
		//end if directory does exist
		}
		
	//end foreach loop	
	}	
	



//clean workflow cache..rebuilt done.
echo $mod_strings['LBL_REBUILD_WORKFLOW_CACHE'];
$workflow_object->repair_workflow(); 

echo $mod_strings['LBL_DONE'] . '<BR>';


build_plugin_list();


echo $mod_strings['LBL_REBUILD_WORKFLOW_COMPILING'] . $mod_strings['LBL_DONE'];

?>
