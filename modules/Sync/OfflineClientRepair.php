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


global $current_user;

$current_user->is_admin = 1;
$_REQUEST['mode'] = 'execute';
include_once('modules/Administration/RepairIndex.php');


//rrs: if we synced down custom fields the languages were not being updated.
$mod_strings = return_module_language('en_us', 'Administration');
include_once('modules/Administration/QuickRepairAndRebuild.php');
$randc = new RepairAndClear();
$randc->repairAndClearAll(array('clearAll', 'repairDatabase'), array('All Modules'), true, false);
include_once('include/SugarObjects/LanguageManager.php');
LanguageManager::clearLanguageCache();
$current_user->is_admin = 0;
