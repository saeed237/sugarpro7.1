<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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


define('ENTRY_POINT_TYPE', 'gui');
include ('include/MVC/preDispatch.php');
$startTime = microtime(true);
require_once('include/entryPoint.php');
ob_start();
require_once('include/MVC/SugarApplication.php');
$app = new SugarApplication();
/*
$app->startSession() is now part of SugarApplication::execute() method.
We only load session if the entry point requires it.
*/
$app->execute();
