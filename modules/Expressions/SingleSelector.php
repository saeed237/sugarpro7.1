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

global $theme;

require_once('include/utils/expression_utils.php');
global $app_strings;
global $app_list_strings;
global $mod_strings;

global $urlPrefix;
global $currentModule;
global $sugar_version, $sugar_config;

$focus = BeanFactory::getBean('Expressions');

if(!empty($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
} else {
	sugar_die("You shouldn't be here");
}
if(!empty($_REQUEST['value'])) {
    $value = $_REQUEST['value'];
} else {
	$value ="";
}
if(!empty($_REQUEST['dom_name'])) {
    $dom_name = $_REQUEST['dom_name'];
} else {
	$dom_name ="";
}
if(!empty($_REQUEST['meta_filter_name'])) {
    $meta_filter_name = $_REQUEST['meta_filter_name'];
} else {
	$meta_filter_name ="";
}
if(!empty($_REQUEST['trigger_type'])) {
    $trigger_type = $_REQUEST['trigger_type'];
} else {
	$trigger_type = "";
}


////////////////////////////////////////////////////////
// Start the output
////////////////////////////////////////////////////////
	$form =new XTemplate ('modules/Expressions/SingleSelector.html');
	$GLOBALS['log']->debug("using file modules/Expressions/SingleSelector.html");

$form->assign("MOD", $mod_strings);
$form->assign("APP", $app_strings);
$form->assign("PLEASE_SELECT", $mod_strings['LBL_PLEASE_SELECT']);
$form->assign("OPENER_ID", $_REQUEST['opener_id']);
$form->assign("HREF_OBJECT", $_REQUEST['href_object']);

$select_options = $focus->get_selector_array($type, $value, $dom_name, false, $meta_filter_name, true, $trigger_type, false);

$form->assign("SELECTOR_DROPDOWN", $select_options);

$form->assign("MODULE_NAME", $currentModule);
$form->assign("GRIDLINE", $gridline);

insert_popup_header($theme);

$form->parse("embeded");
$form->out("embeded");


$form->parse("main");
$form->out("main");

insert_popup_footer();