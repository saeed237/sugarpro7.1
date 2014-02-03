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
$tagdata = $json->decode(html_entity_decode($_REQUEST['newTagName']));
if(isset($tagdata['jsonObject']) && $tagdata['jsonObject'] != null){
	$tagdata = $tagdata['jsonObject'];
 }	
//save the tag
$admin = '';
if( $tagdata[0] !=null) $tag_name= $tagdata[0];
if( $tagdata[1] !=null) $parent_tag_id = $tagdata[1];
if( $tagdata[2] !=null) $admin = $tagdata[2];

if($admin==1){
 $admin=true;	
}
else{
 $admin=false;	
}

$found = false;

if(!empty($tag_name)){
	       
    //retrieve all the children of the parent tag. if parent tag is null then retrieve all 
    //tags whose parent is null. compare with the new tag name. 

    if($parent_tag_id == 'All_Tags'){
    	$parent_tag_id = '';
    }

    $query="select id,tag_name from kbtags where deleted = 0 and";
    if (empty($parent_tag_id)) {
    	$query.=" parent_tag_id is null order by tag_name";	
    } else {
    	$query.=" parent_tag_id = '$parent_tag_id' order by tag_name";	    
    }
  
    $result=$GLOBALS['db']->query($query);
  
  
	while (($row=$GLOBALS['db']->fetchByAssoc($result))!= null) {
      
      if (!empty($row['id']) && !empty($row['tag_name'])) {                            
         if(from_html($row['tag_name'])==$tag_name){
         	$found = true;         	
         	break;
         }
      }
	}  		        
}

 if(!$found){ 
           
    $kbtag = BeanFactory::getBean('KBTags');        
    $kbtag->tag_name  = $tag_name;
    if($parent_tag_id != null){
     $kbtag->parent_tag_id  = $parent_tag_id;
    }		         
    $kbtag->save();
     //refresh tree
    $tagstree=new Tree('tagstree');
    $tagstree->set_param('module','KBTags');
    if($admin) {        
      $tagstree->set_param('moduleview','admin');
      $nodes=get_tags_nodes(false,true,null);
      $root_node = new Node('All_Tags', $mod_strings['LBL_TAGS_ROOT_LABEL']);
       foreach ($nodes as $node) {                                         
            $root_node->add_node($node);                       
        }
      $href_string = "javascript:handler:SUGAR.kb.adminClick()";
      if ($root_node) {
    	    $root_node->set_property("href",$href_string);   	
      }        
      $root_node->expanded = true;    
      $tagstree->add_node($root_node);   
    } 
    else{
       $tagstree->set_param('moduleview','modal');
       //$nodes = get_tags_nodes_cached(null);
       //$nodes=get_tags_nodes(false,null); 
       $nodes=get_tags_nodes(false,false,null);
       $root_node = new Node('All_Tags', $mod_strings['LBL_TAGS_ROOT_LABEL']);
       foreach ($nodes as $node) {                                         
            $root_node->add_node($node);                       
        }

      $href_string = "javascript:handler:SUGAR.kb.modalClose('tagstree')";
      if ($root_node) {
    	    $root_node->set_property("href",$href_string);   	
      }   
      $root_node->expanded = true;    
      $tagstree->add_node($root_node);    
    }                         

       //$tagstree->add_node($root_node);
       
      $response = $tagstree->generate_nodes_array();
 }
 else{
 	$response = 1;
 }                  
if (!empty($response)) {	
    echo $response;
	//$json = getJSONobj();
	//print $json->encode($response);	
	//return the parameters
}
sugar_cleanup();
exit();
?>
