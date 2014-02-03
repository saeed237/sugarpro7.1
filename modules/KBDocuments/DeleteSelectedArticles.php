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

//process request parameters. consider following parameters.
//function, and all parameters prefixed with PARAM.
//PARAMT_ are tree level parameters.
//PARAMN_ are node level parameters.


$json = getJSONobj();
$selectedArticles = $json->decode(html_entity_decode($_REQUEST['selectedArticles']));
 if(isset($selectedArticles['jsonObject']) && $selectedArticles['jsonObject'] != null){
	$selectedArticles = $selectedArticles['jsonObject'];
 }	 
 
foreach($selectedArticles as $articleId){
	if(!empty($articleId)){		
		
		       
        //retrieve article  
        $kbarticle = BeanFactory::getBean('KBDocuments', $articleId);        	        		       
        $deleted=1; 
        //also retrieve children and check if there is any article linked                                                 
        $kbarticle->deleted = 1;
        $kbarticle->save();
        //also delete related 
        $kbdocrevs = KBDocument::get_kbdocument_revisions($articleId);
    
  	   if (!empty($kbdocrevs) && is_array($kbdocrevs)) {
		 foreach($kbdocrevs as $key=>$thiskbid) {	
			$thiskbversion = BeanFactory::getBean('KBDocumentRevisions', $thiskbid);			
	        $docrev_ids = KBDocumentRevision::get_docrevs($thiskbid);
			foreach($docrev_ids as $key=>$thisdocrevid){
			 $thisdocrev = BeanFactory::getBean('DocumentRevisions', $thisdocrevid);
			 UploadFile::unlink_file($thisdocrevid,$thisdocrev->filename);
			 //mark version deleted
			 $thisdocrev->mark_deleted($thisdocrev->id);
			 //also retrieve the content
			 if($thisdocrev->file_ext == null && $thisdocrev->file_mime_type == null){
			   //this is content retrieve and mark it delete
			   	
			 }			 
			}				
		   //mark kbdoc revision deleted	
		   $thiskbversion->mark_deleted($thiskbversion->id);
		  }				
	    }                   
          
		$q = 'UPDATE kbdocuments_kbtags SET deleted = '.$deleted.' WHERE kbdocument_id = \''.$articleId.'\'';    
		$GLOBALS['db']->query($q);
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
		 $root_node->expanded = true;    
		 $tagstree->add_node($root_node);                
               
        $response = $tagstree->generate_nodes_array();
        $response= $response."<script> document.getElementById('selected_directory_children').innerHTML='' </script>";         
if (!empty($response)) {	
    echo $response;
	//$json = getJSONobj();
	//print $json->encode($response);	
	//return the parameters
}
sugar_cleanup();
exit();
?>