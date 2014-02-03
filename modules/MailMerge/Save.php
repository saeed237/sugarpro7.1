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

$module = $_POST['mailmerge_module'];
$document_id = $_POST['document_id'];
$selObjs = urldecode($_POST['selected_objects_def']);

$item_ids = array();
parse_str($selObjs,$item_ids);

$seed = BeanFactory::getBean($module);
$fields =  get_field_list($seed);

$document = BeanFactory::getBean('Documents', $document_id);

$items = array();
foreach($item_ids as $key=>$value)
{
	$seed->retrieve($key);
	$items[] = $seed;
}

ini_set('max_execution_time', 600);
ini_set('error_reporting', 'E_ALL');
$dataDir = create_cache_directory("MergedDocuments/");
$fileName = UploadFile::realpath("upload://$document->document_revision_id");
$outfile = pathinfo($document->filename, PATHINFO_FILENAME);

$mm = new MailMerge(null, null, $dataDir);
$mm->SetDataList($items);
$mm->SetFieldList($fields);
$mm->Template(array($fileName, $outfile));
$file = $mm->Execute();
$mm->CleanUp();

header("Location: index.php?module=MailMerge&action=Step4&file=".urlencode($file));
