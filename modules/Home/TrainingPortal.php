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
global $app_list_strings;
global $app_strings;
global $current_language;
global $sugar_config;
global $sugar_flavor;
global $sugar_version;

$send_version = isset($sugar_version) ? $sugar_version : "";
$send_edition = isset($sugar_flavor) ? $sugar_flavor : "";
$send_lang = isset($current_language) ? $current_language : "";
$send_key = isset($sugar_config['unique_key']) ? $sugar_config['unique_key'] : "";


$sugar_smarty = new Sugar_Smarty();

$iframe_url = add_http("www.sugarcrm.com/network/redirect.php?to=training&tmpl=network&version={$send_version}&edition={$send_edition}&language={$send_lang}&key={$send_key}");
$sugar_smarty->assign('iframeURL', $iframe_url);

echo $sugar_smarty->fetch('modules/Home/TrainingPortal.tpl');

?>