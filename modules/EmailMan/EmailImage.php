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


if(empty($_REQUEST['id']) || !preg_match("/^[\w\d\-]+$/", $_REQUEST['id'])) {
	die("Not a Valid Entry Point");
}
global $mod_strings;
require_once('modules/Notes/Note.php');
$note = BeanFactory::getBean('Notes');
//check if file is an email image
if (!$note->retrieve_by_string_fields(array('id' => $_REQUEST['id'], 'parent_type' => "Emails"))) {
	die($mod_strings['LBL_INVALID_ENTRY_POINT']);
}

$location = $GLOBALS['sugar_config']['upload_dir']."/" . $_REQUEST['id'];

$mime = getimagesize($location);

if(!empty($mime)) {
	header("Content-Type: {$mime['mime']}");
} else {
	header("Content-Type: image/png");
}


readfile($location);


