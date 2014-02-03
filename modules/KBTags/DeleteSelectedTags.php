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

$tagHasArticle = '';

function tagHasArticle($kbTagId){
	$hasArticle = false;
	$search_str = "SELECT kbdocument_id from kbdocuments_kbtags
                          WHERE kbtag_id = '$kbTagId' and deleted=0";                                                        
         $res = $GLOBALS['db']->query($search_str);
         if($GLOBALS['db']->fetchByAssoc($res) != null){
         	$hasArticle = true;
         	//$tagHasArticle = "<script> alert('This tag has articles') </script>";
         }
    if(!$hasArticle){     
      $hasArticle = check_tag_child_tags_for_articles($kbTagId);
     }    
    return $hasArticle;     
}

$GLOBALS['log']->fatal($tagHasArticle);

//process request parameters. consider following parameters.
//function, and all parameters prefixed with PARAM.
//PARAMT_ are tree level parameters.
//PARAMN_ are node level parameters.


$json = getJSONobj();
$tagIds = $json->decode(html_entity_decode($_REQUEST['selectedTagIds']));
 if(isset($tagIds['jsonObject']) && $tagIds['jsonObject'] != null){
	$tagIds = $tagIds['jsonObject'];
 }	 
foreach($tagIds as $tagId){
	if(!empty($tagId)){
		       
        //retrieve Tag    
        $kbtag = BeanFactory::getBean('KBTags');                    
	if(tagHasArticle($tagId) || $tagId=='FAQs'){              
              /*
              if($tagHasArticle == null){
                $tagHasArticle = "<script>alert('" . $tagId.' ';
                $tagHasArticle.=" has articles')</script>";
              }
              else{
              	$tagHasArticle .=$tagId.' ';
              }
              */      
              $can_not_delete_msg = $mod_strings['LBL_TAGS_CHILD_TAGS_WITH_ARTICLE_CAN_NOT_BE_DELETED'];
              $can_not_delete_faq_msg = $mod_strings['LBL_FAQ_TAG_CAN_NOT_BE_DELETED'];  
              if($tagId=='FAQs'){
              	$tagHasArticle = "<script>alert('" . $tagId." $can_not_delete_faq_msg')</script>";
              }
              else{              	              
              	$tagHasArticle = "<script>alert('$can_not_delete_msg')</script>";
              }               	                                	
        }
        else{ 
	        $kbtag->retrieve($tagId);		        		        
	        //also retrieve children and check if there is any article linked                                                 
	        $kbtag->deleted = 1;
	        $kbtag->save();
        }
	}
}	
        $tagstree=new Tree('tagstree');
        $tagstree->set_param('module','KBTags');
        $tagstree->set_param('moduleview','admin');
        //$nodes=get_tags_nodes(true);
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
               
       if($tagHasArticle != null){
           $response = $tagHasArticle; 	
           $response .= $tagstree->generate_nodes_array();
        }
        else{
          $response = $tagstree->generate_nodes_array();
        }
        $response= $response."<script> document.getElementById('selected_directory_children').innerHTML='' </script>";
        $GLOBALS['log']->fatal($tagHasArticle);  
if (!empty($response)) {	
    echo $response;
	//$json = getJSONobj();
	//print $json->encode($response);	
	//return the parameters
}
sugar_cleanup();
exit();
?>