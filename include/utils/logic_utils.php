<?php
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



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function get_hook_array($module_name){

			$hook_array = null;
			// This will load an array of the hooks to process
			include("custom/modules/$module_name/logic_hooks.php");
			return $hook_array;

//end function return_hook_array
}



function check_existing_element($hook_array, $event, $action_array){

	if(isset($hook_array[$event])){
		foreach($hook_array[$event] as $action){

			if($action[1] == $action_array[1]){
				return true;
			}
		}
	}
		return false;

//end function check_existing_element
}

function replace_or_add_logic_type($hook_array){



	$new_entry = build_logic_file($hook_array);

   	$new_contents = "<?php\n$new_entry\n?>";

	return $new_contents;
}



function write_logic_file($module_name, $contents)
{
		$file = "modules/".$module_name . '/logic_hooks.php';
		$file = create_custom_directory($file);
		$fp = sugar_fopen($file, 'wb');
		fwrite($fp,$contents);
		fclose($fp);
		SugarAutoLoader::addToMap($file);
//end function write_logic_file
}

function build_logic_file($hook_array){

	$hook_contents = "";

	$hook_contents .= "// Do not store anything in this file that is not part of the array or the hook version.  This file will	\n";
	$hook_contents .= "// be automatically rebuilt in the future. \n ";
	$hook_contents .= "\$hook_version = 1; \n";
	$hook_contents .= "\$hook_array = Array(); \n";
	$hook_contents .= "// position, file, function \n";

    foreach ($hook_array as $event_array => $event) {
        $hook_contents .= "\$hook_array['".$event_array."'] = Array(); \n";
        foreach ($event as $second_key => $elements) {
            $hook_contents .= "\$hook_array['".$event_array."'][] = Array(";
            foreach ($elements as $el) {
                $hook_contents .= var_export($el, true) . ',';
            }
            $hook_contents .= ");\n";
        }
	//end foreach hook_array as event => action_array
	}

	$hook_contents .= "\n\n";

	return $hook_contents;

//end function build_logic_file
}

?>
