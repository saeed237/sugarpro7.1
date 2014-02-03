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

$ret=array();
$params1=array();
$nodes=array();

$GLOBALS['log']->debug("TreeData:session started");
$current_language = $GLOBALS['current_language'];

//process request parameters. consider following parameters.
//function, and all parameters prefixed with PARAM.
//PARAMT_ are tree level parameters.
//PARAMN_ are node level parameters.
//module  name and function name parameters are the only ones consumed
//by this file..
foreach ($_REQUEST as $key=>$value) {

	switch ($key) {
	
		case "function":
		case "call_back_function":
			$func_name=$value;
			$params1['TREE']['function']=$value;
			break;
			
		default:
			$pssplit=explode('_',$key);
			if ($pssplit[0] =='PARAMT') {
				unset($pssplit[0]);
				$params1['TREE'][implode('_',$pssplit)]=$value;				
			} else {
				if ($pssplit[0] =='PARAMN') {
					$depth=$pssplit[count($pssplit)-1];
					//parmeter is surrounded  by PARAMN_ and depth info.
					unset($pssplit[count($pssplit)-1]);unset($pssplit[0]);	
					$params1['NODES'][$depth][implode('_',$pssplit)]=$value;
				} else {
					if ($key=='module') {
						if (!isset($params1['TREE']['module'])) {
							$params1['TREE'][$key]=$value;	
						}
					} else { 	
						$params1['REQUEST'][$key]=$value;
					}					
				}
			}
	}	
}	
$modulename=$params1['TREE']['module']; ///module is a required parameter for the tree.
require('include/modules.php');
if (!empty($modulename) && !empty($func_name) && isset($beanList[$modulename]) ) {
    require_once('modules/'.$modulename.'/TreeData.php');
    $TreeDataFunctions = array(
        'ProductTemplates' => array('get_node_data'=>'','get_categories_and_products'=>''),
        'ProductCategories' => array('get_node_data'=>'','get_product_categories'=>''),
        'KBTags' => array(
            'get_node_data'=>'',
            'get_tags_nodes'=>'',
            'get_tags_nodes_cached'=>'',
            'childNodes'=>'',
            'get_searched_tags_nodes'=>'',
            'find_peers'=>'',
            'getRootNode'=>'',
            'getParentNode'=>'',
            'get_tags_modal_nodes'=>'',
            'get_admin_browse_articles'=>'',
            'tagged_documents_count'=>'',
            'tag_count'=>'',
            'get_browse_documents'=>'',
            'get_tag_nodes_for_browsing'=>'',
            'create_browse_node'=>'',
            'untagged_documents_count'=>'',
            'check_tag_child_tags_for_articles'=>'',
            'childTagsHaveArticles'=>'',
            ),
        'KBDocuments' => array(
            'get_node_data'=>'',
            'get_category_nodes'=>'',
            'get_documents'=>'',
            ),
        'Forecasts' => array(
            'get_node_data'=>'',
            'get_worksheet'=>'',
            'commit_forecast'=>'',
            'save_worksheet'=>'',
            'list_nav'=>'',
            'reset_worksheet'=>'',
            'get_chart'=>'',
            ),
        'Documents' => array(
            'get_node_data'=>'',
            'get_category_nodes'=>'',
            'get_documents'=>'',
            ),
        );
        
	if (isset($TreeDataFunctions[$modulename][$func_name])) {
		$ret=call_user_func($func_name,$params1);
    }
}

if (!empty($ret)) {
	echo $ret;
}

?>
