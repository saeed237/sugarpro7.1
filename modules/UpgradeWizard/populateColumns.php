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

 //Request object must have these property values:
 //		Module: module name, this module should have a file called TreeData.php
 //		Function: name of the function to be called in TreeData.php, the function will be called statically.
 //		PARAM prefixed properties: array of these property/values will be passed to the function as parameter.

require_once('include/JSON.php');
require_once('include/entryPoint.php');
require_once('include/upload_file.php');
require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
require_once('modules/KBTags/TreeData.php');

$json = getJSONobj();
$selectedTable = $json->decode(html_entity_decode($_REQUEST['selectedTable']));
 if(isset($tagArticleIds['jsonObject']) && $tagArticleIds['jsonObject'] != null){
	$selectedTable = $selectedTable['jsonObject'];
  }
$GLOBALS['log']->fatal('************ comes here *********');
//$GLOBALS['log']->fatal($_REQUEST['selectedTable']);
function tableColumns($table_name){
	$GLOBALS['log']->fatal('********TABLE PASSED******* '.$table_name);
	global $sugar_config;
	global $setup_db_database_name;
    global $setup_db_host_name;
    global $setup_db_host_instance;
    global $setup_db_admin_user_name;
    global $setup_db_admin_password;
    
	//$db = &DBManagerFactory::getInstance('information_schema');

	$db_name= $sugar_config['dbconfig']['db_name'];
	$setup_db_host_name = $sugar_config['dbconfig']['db_host_name'];
  	$setup_db_admin_user_name = $sugar_config['dbconfig']['db_user_name'];
    $setup_db_host_instance = $sugar_config['dbconfig']['db_host_instance'];
    $setup_db_admin_password = $sugar_config['dbconfig']['db_password'];

    $link = @mysql_connect($setup_db_host_name, $setup_db_admin_user_name, $setup_db_admin_password);
    mysql_select_db('information_schema');

    $qu="SELECT column_name FROM information_schema.columns WHERE table_schema = '".$db_name."' AND table_name = '".$table_name."'";
	$ct =mysql_query($qu,$link);
    //$cols= '';
    $colsDrop = array();
    while($row = mysql_fetch_assoc($ct)){
    	 $colsDrop[] =$row['column_name'];
    }
    return $colsDrop;
}

$colsDrop = tableColumns($_REQUEST['selectedTable']);
if($colsDrop != null){
	$colsDropDown = "<option value=".$_REQUEST['selectedTable']." Columns>".$_REQUEST['selectedTable']." Columns</option>";
	foreach($colsDrop as $col){
		$colsDropDown .="<option value={$col}>{$col}</option>";
	}
}
//$response = "<script>document.getElementById('select_column').innerHTML=$colsDropDown</script>";
$response = $colsDropDown;

if (!empty($response)) {
	echo $response;
}
sugar_cleanup();
exit();
?>