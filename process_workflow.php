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


require_once('modules/WorkFlow/WorkFlowSchedule.php');

global $app_list_strings, $app_strings, $current_language;

$mod_strings = return_module_language('en_us', 'WorkFlow');


//run as admin
global $current_user;
$current_user = Scheduler::initUser();

$process_object = new WorkFlowSchedule();
$process_object->process_scheduled();
unset($process_object);


//sugar_cleanup(); // moved to cron.php
?>
