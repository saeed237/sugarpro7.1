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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


require_once('modules/Contacts/ContactOpportunityRelationship.php');


global $app_strings;
global $app_list_strings;
global $mod_strings;
global $sugar_version, $sugar_config;

$focus = new ContactOpportunityRelationship();

if(isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}

// Prepopulate either side of the relationship if passed in.
safe_map('opportunity_name', $focus);
safe_map('opportunity_id', $focus);
safe_map('contact_name', $focus);
safe_map('contact_id', $focus);
safe_map('contact_role', $focus);


$GLOBALS['log']->info("Contact opportunity relationship");

$json = getJSONobj();
require_once('include/QuickSearchDefaults.php');
$qsd = QuickSearchDefaults::getQuickSearchDefaults();
$sqs_objects = array('opportunity_name' => $qsd->getQSParent());
$sqs_objects['opportunity_name']['populate_list'] = array('opportunity_name', 'opportunity_id');
$quicksearch_js = '<script type="text/javascript" language="javascript">sqs_objects = ' . $json->encode($sqs_objects) . '</script>';
echo $quicksearch_js;

$xtpl=new XTemplate ('modules/Contacts/ContactOpportunityRelationshipEdit.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

$xtpl->assign("RETURN_URL", "&return_module=$currentModule&return_action=DetailView&return_id=$focus->id");
$xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
$xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
$xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("CONTACT",$contactName = Array("NAME" => $focus->contact_name, "ID" => $focus->contact_id));
$xtpl->assign("OPPORTUNITY",$oppName = Array("NAME" => $focus->opportunity_name, "ID" => $focus->opportunity_id));

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$mod_strings['LBL_CONTACT_OPP_FORM_TITLE']." ".$contactName['NAME'] . " - ". $oppName['NAME']), true);

$xtpl->assign("CONTACT_ROLE_OPTIONS", get_select_options_with_id($app_list_strings['opportunity_relationship_type_dom'], $focus->contact_role));




$xtpl->parse("main");

$xtpl->out("main");


$javascript = new javascript();
$javascript->setFormName('EditView');
$javascript->setSugarBean($focus);
$javascript->addToValidateBinaryDependency('opportunity_name', 'alpha', $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $mod_strings['LBL_OPP_NAME'], 'false', '', 'opportunity_id');
echo $javascript->getScript();


?>
