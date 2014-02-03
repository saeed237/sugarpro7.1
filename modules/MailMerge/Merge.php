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

require_once('soap/SoapHelperFunctions.php');
require_once('modules/MailMerge/MailMerge.php');
require_once('include/upload_file.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;

$xtpl = new XTemplate('modules/MailMerge/Merge.html');

$module = $_SESSION['MAILMERGE_MODULE'];
$document_id = $_SESSION['MAILMERGE_DOCUMENT_ID'];
$selObjs = urldecode($_SESSION['SELECTED_OBJECTS_DEF']);
$relObjs = (isset($_SESSION['MAILMERGE_RELATED_CONTACTS']) ? $_SESSION['MAILMERGE_RELATED_CONTACTS'] : '');

$relModule = '';
if(!empty($_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'])){
	$relModule = $_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'];
}

if($_SESSION['MAILMERGE_MODULE'] == null)
{
	sugar_die("Error during Mail Merge process.  Please try again.");
}

$_SESSION['MAILMERGE_MODULE'] = null;
$_SESSION['MAILMERGE_DOCUMENT_ID'] = null;
$_SESSION['SELECTED_OBJECTS_DEF'] = null;
$_SESSION['MAILMERGE_SKIP_REL'] = null;
$_SESSION['MAILMERGE_CONTAINS_CONTACT_INFO'] = null;
$item_ids = array();
parse_str(stripslashes(html_entity_decode($selObjs, ENT_QUOTES)),$item_ids);

if($module == 'CampaignProspects'){
    $module = 'Prospects';
    if(!empty($_SESSION['MAILMERGE_CAMPAIGN_ID'])){
    	$targets = array_keys($item_ids);
    	require_once('modules/Campaigns/utils.php');
    	campaign_log_mail_merge($_SESSION['MAILMERGE_CAMPAIGN_ID'],$targets);
    }
}
$seed = BeanFactory::getBean($module);
$fields =  get_field_list($seed);

$document = BeanFactory::getBean('DocumentRevisions', $document_id);

if(!empty($relModule)){
    $rel_seed = BeanFactory::getBean($relModule);
}

global $sugar_config;

$filter = array();
if(array_key_exists('mailmerge_filter', $sugar_config)){
 //   $filter = $sugar_config['mailmerge_filter'];
}
array_push($filter, 'link');

$merge_array = array();
$merge_array['master_module'] = $module;
$merge_array['related_module'] = $relModule;
//rrs log merge
$ids = array();

foreach($item_ids as $key=>$value)
{
	if(!empty($relObjs[$key])){
	   $ids[$key] = $relObjs[$key];
	}else{
	   $ids[$key] = '';
	}
}//rof
$merge_array['ids'] = $ids;

$dataDir = getcwd(). '/' . sugar_cached('MergedDocuments/');
if(!file_exists($dataDir))
{
	sugar_mkdir($dataDir);
}
srand((double)microtime()*1000000);
$mTime = microtime();
$dataFileName = 'sugardata'.$mTime.'.php';
write_array_to_file('merge_array', $merge_array, $dataDir.$dataFileName);
//Save the temp file so we can remove when we are done
$_SESSION['MAILMERGE_TEMP_FILE_'.$mTime] = $dataDir.$dataFileName;
$site_url = $sugar_config['site_url'];
//$templateFile = $site_url . '/' . UploadFile::get_upload_url($document);
$templateFile = $site_url.'/'.UploadFile::get_url(from_html($document->filename),$document->id);
$dataFile =$dataFileName;
$redirectUrl = 'index.php?action=index&step=5&module=MailMerge&mtime='.$mTime;
$startUrl = 'index.php?action=index&module=MailMerge&reset=true';

$relModule = trim($relModule);
$contents = "SUGARCRM_MAIL_MERGE_TOKEN#$templateFile#$dataFile#$module#$relModule";

$rtfFileName = 'sugartokendoc'.$mTime.'.doc';
$fp = sugar_fopen($dataDir.$rtfFileName, 'w');
fwrite($fp, $contents);
fclose($fp);

$_SESSION['mail_merge_file_location'] = sugar_cached('MergedDocuments/').$rtfFileName;
$_SESSION['mail_merge_file_name'] = $rtfFileName;

$xtpl->assign("MAILMERGE_FIREFOX_URL", $site_url .'/'.$GLOBALS['sugar_config']['cache_dir'].'MergedDocuments/'.$rtfFileName);
$xtpl->assign("MAILMERGE_START_URL", $startUrl);
$xtpl->assign("MAILMERGE_TEMPLATE_FILE", $templateFile);
$xtpl->assign("MAILMERGE_DATA_FILE", $dataFile);
$xtpl->assign("MAILMERGE_MODULE", $module);

$xtpl->assign("MAILMERGE_REL_MODULE", $relModule);
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("MAILMERGE_REDIRECT_URL", $redirectUrl);
$xtpl->parse("main");
$xtpl->out("main");
?>
