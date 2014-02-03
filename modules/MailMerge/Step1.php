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

require_once('modules/MailMerge/modules_array.php');

require_once('include/json_config.php');
$json_config = new json_config();

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;
global $sugar_version, $sugar_config, $db;

$xtpl = new XTemplate('modules/MailMerge/Step1.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign('JSON_CONFIG_JAVASCRIPT', $json_config->get_static_json_server(false, true));

if($_SESSION['MAILMERGE_MODULE'] == 'Campaigns' || $_SESSION['MAILMERGE_MODULE'] == 'CampaignProspects'){
	$modules_array['Campaigns'] = 'Campaigns';
}
$module_list = $modules_array;

if(isset($_REQUEST['reset']) && $_REQUEST['reset'])
{
	$_SESSION['MAILMERGE_MODULE'] = null;
	$_SESSION['MAILMERGE_DOCUMENT_ID'] = null;
	$_SESSION['SELECTED_OBJECTS_DEF'] = null;
	$_SESSION['MAILMERGE_SKIP_REL'] = null;
	$_SESSION['MAILMERGE_RECORD'] = null;
	$_SESSION['MAILMERGE_RECORDS'] = null;
	$_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'] = null;
}
$fromListView = false;
if(!empty($_REQUEST['record']))
{
	$_SESSION['MAILMERGE_RECORD'] = $_REQUEST['record'];
}
else if(isset($_REQUEST['uid'])) {
	$_SESSION['MAILMERGE_RECORD'] = explode(',', $_REQUEST['uid']);

}
else if(isset($_REQUEST['entire']) && $_REQUEST['entire'] == 'true') {
	// do entire list
	$focus = BeanFactory::getBean( $_SESSION['MAILMERGE_MODULE']);

	if(isset($_SESSION['export_where']) && !empty($_SESSION['export_where'])) { // bug 4679
		$where = $_SESSION['export_where'];
	} else {
		$where = '';
	}
    $beginWhere = substr(trim($where), 0, 5);
    if ($beginWhere == "where")
        $where = substr(trim($where), 5, strlen($where));
    $orderBy = '';
	$query = $focus->create_export_query($orderBy,$where);

	$result = $db->query($query,true,"Error mail merging {$_SESSION['MAILMERGE_MODULE']}: "."<BR>$query");

	$new_arr = array();
	while($val = $db->fetchByAssoc($result,false))
	{
		array_push($new_arr, $val['id']);
	}
	$_SESSION['MAILMERGE_RECORD'] = $new_arr;
}
else if(isset($_SESSION['MAILMERGE_RECORDS']))
{

	$fromListView = true;
	$_SESSION['MAILMERGE_RECORD'] = $_SESSION['MAILMERGE_RECORDS'];
	$_SESSION['MAILMERGE_RECORDS'] = null;
}
$rModule = '';
if(isset($_SESSION['MAILMERGE_RECORD']))
{
	if(!empty($_POST['return_module']) && $_POST['return_module'] != "MailMerge")
	{
		$rModule = $_POST['return_module'];
	}
	else if($fromListView)
	{
		$rModule = 	$_SESSION['MAILMERGE_MODULE_FROM_LISTVIEW'];
		$_SESSION['MAILMERGE_MODULE_FROM_LISTVIEW'] = null;
	}
	else
	{
		$rModule = $_SESSION['MAILMERGE_MODULE'];
	}
	if($rModule == 'CampaignProspects'){
    	$rModule = 'Campaigns';
	}

	$_SESSION['MAILMERGE_MODULE'] = $rModule;
	if(!empty($rModule) && $rModule != "MailMerge")
	{
	    $seed = BeanFactory::getBean($rModule);
	    $selected_objects = '';
    	foreach($_SESSION['MAILMERGE_RECORD'] as $record_id)
    	{
    		if($rModule == 'Campaigns'){

    			$prospect = BeanFactory::getBean('Prospects');
    			$prospect_module_list = array('leads', 'contacts', 'prospects', 'users');
    			foreach($prospect_module_list as $mname){
	    			$pList = $prospect->retrieveTargetList("campaigns.id = '$record_id' AND related_type = #$mname#", array('id', 'first_name', 'last_name'));

	    			foreach($pList['list'] as $bean){
	    				$selected_objects .= $bean->id.'='.str_replace("&", "##", $bean->name).'&';
	    			}
    			}
    		}else{
    	   		$seed->retrieve($record_id);
    	   		$selected_objects .= $record_id.'='.str_replace("&", "##", $seed->name).'&';
    		}
    	}


    	if($rModule != 'Contacts'
    	   && $rModule != 'Leads' && $rModule != 'Products' && $rModule != 'Campaigns'
    	   )
    	{
    		$_SESSION['MAILMERGE_SKIP_REL'] = false;
    		$xtpl->assign("STEP", "2");
    		$xtpl->assign("SELECTED_OBJECTS", $selected_objects);
    		$_SESSION['SELECTED_OBJECTS_DEF'] = $selected_objects;
    	}
    	else
    	{
    		$_SESSION['MAILMERGE_SKIP_REL'] = true;
    		$xtpl->assign("STEP", "2");
    		$_SESSION['SELECTED_OBJECTS_DEF'] = $selected_objects;
    	}
    }
    else
    {
    	$xtpl->assign("STEP", "2");
    }

}
else
{
	$xtpl->assign("STEP", "2");
}
$modules = $module_list;
$func = "";
if($rModule == 'Campaigns'){
	$func = "disableModuleDropDown();";
}
$xtpl->assign("MAILMERGE_DISABLE_DROP_DOWN", $func);
$xtpl->assign("MAILMERGE_MODULE_OPTIONS", get_select_options_with_id($modules, $_SESSION['MAILMERGE_MODULE']));
$xtpl->assign("MAILMERGE_TEMPLATES", get_select_options_with_id(getDocumentRevisions(), '0'));

if(isset($_SESSION['MAILMERGE_MODULE'])){
	$module_select_text = $mod_strings['LBL_MAILMERGE_SELECTED_MODULE'];
	$xtpl->assign("MAILMERGE_NUM_SELECTED_OBJECTS",count($_SESSION['MAILMERGE_RECORD'])." ".$_SESSION['MAILMERGE_MODULE']." Selected");
}
else{
	$module_select_text = $mod_strings['LBL_MAILMERGE_MODULE'];
}
$xtpl->assign("MODULE_SELECT", $module_select_text);
if($_SESSION['MAILMERGE_MODULE'] == 'Campaigns'){
    $_SESSION['MAILMERGE_MODULE'] = 'CampaignProspects';
}

$admin = Administration::getSettings();
$user_merge = $current_user->getPreference('mailmerge_on');
if ($user_merge != 'on' || !isset($admin->settings['system_mailmerge_on']) || !$admin->settings['system_mailmerge_on']){
	$xtpl->assign("ADDIN_NOTICE", $mod_strings['LBL_ADDIN_NOTICE']);
	$xtpl->assign("DISABLE_NEXT_BUTTON", "disabled");
}


$xtpl->parse("main");
$xtpl->out("main");

/*function get_user_module_list($user){
	global $app_list_strings, $current_language;
	$app_list_strings = return_app_list_strings_language($current_language);
	$modules = query_module_access_list($user);
	global $modInvisList;

	return $modules;
}*/

function getDocumentRevisions()
{
	$document = BeanFactory::getBean('Documents');

	$currentDate = $document->db->now();
	$empty_date = $document->db->emptyValue("date");

			$query = "SELECT revision, document_name, document_revisions.id FROM document_revisions
LEFT JOIN documents on documents.id = document_revisions.document_id
WHERE ((active_date <= $currentDate AND exp_date > $currentDate)
	OR (active_date is NULL) or (active_date = ".$empty_date.")
	OR (active_date <= $currentDate AND ((exp_date = $empty_date OR (exp_date is NULL)))))
AND is_template = 1 AND template_type = 'mailmerge' AND documents.deleted = 0 ORDER BY document_name";

			$result = $document->db->query($query,true,"Error retrieving $document->object_name list: ");

                        $list = Array();
                        $list['None'] = 'None';
                        while(($row = $document->db->fetchByAssoc($result)) != null)
                            {
                                $revision = null;
                                $docName = $row['document_name'];
                                $revision = $row['revision'];
                                if(!empty($revision));
                                {
                                        $docName .= " (rev. ".$revision.")";
                                }
                                $list[$row['id']] = $docName;
                            }
                        return $list;

}
?>
