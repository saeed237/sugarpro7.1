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
require_once('include/upload_file.php');
require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
require_once('modules/KBTags/TreeData.php');

$json = getJSONobj();
$search_tag_name = $json->decode(html_entity_decode($_REQUEST['searchTagName']));

if(!empty($search_tag_name)){
		       
        //create campaign log    
        $query="select id from kbtags where deleted = '0' and tag_name=$search_tag_name order by tag_name";	
        $result = $GLOBALS['db']->query($query);    
        $searched_tagIds  =  $GLOBALS['db']->fetchByAssoc($result);
          
        //next search the parents (root node) of each tag found
        //combine parent child/ren and expand tree
        $tagstree=new Tree('tagstree');
        $tagstree->set_param('module','KBTags');
        $tagstree->set_param('moduleview','SearchTags');
        $nodes=get_search_tags_nodes(true,$searched_tagIds);
                
        foreach ($nodes as $node) {
            $tagstree->add_node($node);       
        } 
     }         
        $response = $tagstree->generate_nodes_array();
                      
if (!empty($response)) {	
    echo $response;
	//$json = getJSONobj();
	//print $json->encode($response);	
	//return the parameters
}
sugar_cleanup();
exit();
?>