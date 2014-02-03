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




global $gridline;
global $theme;
global $beanList;
global $beanFiles;


if(empty($_REQUEST['module']))
{
	die("'module' was not defined");
}

if(empty($_REQUEST['record']))
{
	die("'record' was not defined");
}

if(!isset($beanList[$_REQUEST['module']]))
{
	die("'".$_REQUEST['module']."' is not defined in \$beanList");
}

$subpanel = $_REQUEST['subpanel'];
$record = $_REQUEST['record'];
$module = $_REQUEST['module'];


$image_path = 'themes/'.$theme.'/images/';

if(empty($_REQUEST['inline']))
{
	insert_popup_header($theme);
}

include('include/SubPanel/SubPanel.php');
$layout_def_key = '';
if(!empty($_REQUEST['layout_def_key'])){
	$layout_def_key = $_REQUEST['layout_def_key'];
}

$subpanel_object = new SubPanel($module, $record, $subpanel,null, $layout_def_key);

$subpanel_object->setTemplateFile('include/SubPanel/SubPanelDynamic.html');

if(!empty($_REQUEST['mkt_id']) && $_REQUEST['mkt_id'] != 'all') {// bug 32910
    $mkt_id = $_REQUEST['mkt_id'];
}

if(!empty($mkt_id)) {
    $subpanel_object->subpanel_defs->_instance_properties['function_parameters']['EMAIL_MARKETING_ID_VALUE'] = $mkt_id;
}
echo (empty($_REQUEST['inline']))?$subpanel_object->get_buttons():'' ;

$subpanel_object->display();

if(empty($_REQUEST['inline']))
{
	insert_popup_footer($theme);
}

?>