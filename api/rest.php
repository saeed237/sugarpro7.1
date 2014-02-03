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


ob_start();
chdir(dirname(__FILE__).'/../');
define('ENTRY_POINT_TYPE', 'api');
require('include/entryPoint.php');
require_once("include/api/RestService.php");
SugarAutoLoader::load('custom/include/RestService.php');
$restServiceClass = SugarAutoLoader::customClass('RestService');

$service = new $restServiceClass();
$service->execute();

