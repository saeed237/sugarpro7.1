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


global $mod_strings;

// We suggest that if you wish to modify an existing layout, copy & paste the existing layout files to new files
// this will prevent conflicts with future upgrades.

// To add a layout, you will need to register the new file below and in the $layouts_dom array
// in modules/Quotes/language/<lang>.lang.php
global $layouts;
$layouts = array();

if (SugarAutoLoader::fileExists('custom/modules/Quotes/sugarpdf/sugarpdf.standard.php')) {
    $layouts['Standard'] = 'custom/modules/Quotes/sugarpdf/sugarpdf.standard.php';
}
if (SugarAutoLoader::fileExists('custom/modules/Quotes/sugarpdf/sugarpdf.invoice.php')) {
	$layouts['Invoice'] = 'custom/modules/Quotes/sugarpdf/sugarpdf.invoice.php';
}

/**
 * a kind of silly getter...
 * @returns array layout array
 */
function get_layouts() {
	global $mod_strings;
    global $app_list_strings;
	global $layouts;
    $list = array();
    if(isset($layouts)) {
	   foreach($layouts as $key=>$value) {
                   if(array_key_exists($key, $app_list_strings['layouts_dom'])){ //bug 49954
		   $list[$key] = $app_list_strings['layouts_dom'][$key];
		}
	  }
    }
	return $list;
}

/**
 * gets a layout and "prints" it
 * @param array array of layouts
 */
function print_layout($layout) {
	global $mod_strings;
	global $layouts;

    if(!isset($layouts[$layout])) {
		$GLOBALS['log']->fatal("quote layout is not registered in modules/Quotes/Layouts.php");
		sugar_die ("quote layout is not registered in modules/Quotes/Layouts.php");
	} elseif (!is_file($layouts[$layout])) {
		$GLOBALS['log']->fatal("quote layout file does not exist: ".$layouts[$layout]);
		sugar_die ("quote layout file does not exist: ".$layouts[$layout]);
	} else {
		include_once($layouts[$layout]);
	}
}


foreach(SugarAutoLoader::existing('modules/Quotes/Layouts.override.php', 'custom/modules/Quotes/Layouts.php') as $file) {
    include_once $file;
}

if(isset($_REQUEST['email_action']) && $_REQUEST['email_action']=="EmailLayout") {
	//check to make sure the layout is set
	if (isset($_REQUEST['layout'])) {
		include_once('modules/Quotes/EmailPDF.php');
		$email_id = email_layout($_REQUEST['layout']);
	}

	//redirect
	if($email_id=="") {
		//Redirect to quote, since something went wrong
		echo "There was an error with your request";
		exit; //end if email id is blank
	} else {
		//Redirect to new email draft just created
		header("Location: index.php?action=Compose&module=Emails&parent_type=Quotes&return_module=Quotes&return_action=DetailView&return_id=".$_REQUEST['record']."&recordId=$email_id"."&parent_id=".$_REQUEST['record']);
	}
//end if email layout
} else {
	if (isset($_REQUEST['layout'])) {
		print_layout($_REQUEST['layout']);
	}//end if else traditional print layout
}

?>
