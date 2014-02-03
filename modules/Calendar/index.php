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


if(!ACLController::checkAccess('Calendar', 'list', true)){
	ACLController::displayNoAccess(true);
}

require_once('modules/Calendar/Calendar.php');
require_once('modules/Calendar/CalendarDisplay.php');
require_once("modules/Calendar/CalendarGrid.php");

global $cal_strings, $current_language;
$cal_strings = return_module_language($current_language, 'Calendar');

if(empty($_REQUEST['view'])){
	$_REQUEST['view'] = SugarConfig::getInstance()->get('calendar.default_view','week');
}

$cal = new Calendar($_REQUEST['view']);

if(in_array($cal->view,array('day','week','month'))){
	$cal->add_activities($GLOBALS['current_user']);	
}else if($cal->view == 'shared'){
	$cal->init_shared();	
	global $shared_user;				
	$shared_user = BeanFactory::getBean('Users');	
	foreach($cal->shared_ids as $member){
		$shared_user->retrieve($member);
		$cal->add_activities($shared_user);
	}
}

if(in_array($cal->view, array("day","week","month","shared"))){
	$cal->load_activities();
}

if (!empty($_REQUEST['print']) && $_REQUEST['print'] == 'true') {
    $cal->setPrint(true);
}

$display = new CalendarDisplay($cal);
$display->display_title();
if($cal->view == "shared")
	$display->display_shared_html();
$display->display_calendar_header();
$display->display();
$display->display_calendar_footer();	

?>
