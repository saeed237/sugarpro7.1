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

//Custom plugins
//Search through the plugins to include any custom_utils.php files
$dir_path = "./custom/workflow/plugins";
foreach(SugarAutoLoader::getDirFiles("custom/workflow/plugins", true) as $dir) {
    if(SugarAutoLoader::existing("$dir/custom_utils.php")) {
        include_once("$dir/custom_utils.php");
    }
}
