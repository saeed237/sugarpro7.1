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

require_once 'include/utils.php';

global $sugar_config, $dbconfig, $beanList, $beanFiles, $app_strings, $app_list_strings, $current_user;

global $currentModule, $focus;

if ( !empty($_REQUEST['user_id'])) {
    $result = BeanFactory::retrieveBean('Users', $_REQUEST['user_id']);
    if (empty($result)) {
        session_destroy();
        sugar_cleanup();
        die("The user id doesn't exist");
    }
    $current_entity = $current_user = $result;
}
else if ( ! empty($_REQUEST['contact_id'])) {
    $result = BeanFactory::retrieveBean('Contacts', $_REQUEST['contact_id'], array('disable_row_level_security' => true));
    if(empty($result)) {
        session_destroy();
        sugar_cleanup();
        die("The contact id doesn't exist");
    }
    $current_entity = $result;
}
else if ( ! empty($_REQUEST['lead_id'])) {
    $result = BeanFactory::retrieveBean('Leads', $_REQUEST['lead_id'], array('disable_row_level_security' => true));
    if(empty($result)) {
        session_destroy();
        sugar_cleanup();
        die("The lead id doesn't exist");
    }
    $current_entity = $result;
}

$focus = BeanFactory::retrieveBean(clean_string($_REQUEST['module']), $_REQUEST['record'], array('disable_row_level_security' => true));

if(empty($focus)) {
	session_destroy();
	sugar_cleanup();
	die("The focus id doesn't exist");
}

$focus->set_accept_status($current_entity,$_REQUEST['accept_status']);
$url  = $sugar_config['site_url'] . '#' . buildSidecarRoute($currentModule, $focus->id);

print $app_strings['LBL_STATUS_UPDATED']."<BR><BR>";
print $app_strings['LBL_STATUS']. " ". $app_list_strings['dom_meeting_accept_status'][$_REQUEST['accept_status']];
print "<BR><BR>";

print "<a href='{$url}'>" . $app_strings['LBL_MEETING_GO_BACK'] . "</a><br />";
sugar_cleanup();
exit;
