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

require_once('include/formbase.php');
require_once('include/upload_file.php');
require_once('modules/KBDocuments/Forms.php');

global $mod_strings, $timedate;
$mod_strings = return_module_language($current_language, 'KBDocuments');

$prefix='';
$do_final_move = 0;

$KBDocument = BeanFactory::getBean('KBDocuments');
$KBRevision = BeanFactory::getBean('KBDocumentRevisions');
if (isset($_REQUEST['record'])) {
	$KBDocument->retrieve($_REQUEST['record']);
}

if(!$KBDocument->ACLAccess('Save')){
		ACLController::displayNoAccess(true);
		sugar_cleanup(true);
}

$KBDocument = populateFromPost('', $KBDocument);
//set check_notify flag
$check_notify = false;


if (isset($KBDocument->id)) {
    //retrieve the existing document before saving the current
    $old_Id = $KBDocument->id;
    $oldKB = BeanFactory::getBean('KBDocuments', $old_Id);
    //check if status has changed
    if($oldKB->status_id != $KBDocument->status_id){
       //check if status was draft or in review
        if(($oldKB->status_id == 'Draft' && $KBDocument->status_id=='In Review') ||
           ($oldKB->status_id == 'In Review' && $KBDocument->status_id=='Draft') ||
           ($oldKB->status_id == 'Published')){
	    	$check_notify = true;
	    }
	    if($KBDocument->status_id == 'Published'){
	    	$check_notify = true;
	    	//also set the published date if it's null or empty
	    	if(empty($KBDocument->active_date) || $KBDocument->active_date==null){
	            $KBDocument->active_date = $timedate->nowDate();
	    	}
	    	if(empty($KBDocument->kbdoc_approver_id) || $KBDocument->kbdoc_approver_id==null){
	            $KBDocument->kbdoc_approver_id = $current_user->id;
	    	}
	    }
	    if($KBDocument->status_id != 'Published'){
	    	//also set the published date if it's null or empty
	    	if(!empty($KBDocument->active_date) || $KBDocument->active_date!=null){
	            $KBDocument->active_date = '';
	    	}
	    }
	    if($KBDocument->status_id == 'In Review'){
		    if(empty($KBDocument->kbdoc_approver_id) || $KBDocument->kbdoc_approver_id==null){
		            $KBDocument->kbdoc_approver_id = $current_user->id;
		    	}
	    }
    }

  //save document tags

  $KBDocument->save($check_notify);
  $return_id = $KBDocument->id;
  $KBRevision->retrieve($KBDocument->kbdocument_revision_id);
  //update the content
  $KBContent = BeanFactory::getBean('KBContents', $KBRevision->kbcontent_id);
  $KBContent->team_id = $KBDocument->team_id;
  if(strpos(getenv('HTTP_USER_AGENT'), 'MSIE')){
      $KBContent->kbdocument_body = $_REQUEST['body_html'];
  } else{
      $article_body = '';
      $url_arr = parse_url($sugar_config['site_url']);
      $article_body = str_replace($sugar_config['site_url'].'/cache/images/', $url_arr['path'].'/cache/images/', $_REQUEST['body_html']);
      $article_body = str_replace($url_arr['path'].'/cache/images/', $sugar_config['site_url'].'/cache/images/', $article_body);
      $KBContent->kbdocument_body = $article_body;
  }
  $KBContent->save();
  //save tags
	if(isset($_REQUEST['docTagIds'])  && $_REQUEST['docTagIds'] != null){
		for($i=0;$i<count($_REQUEST['docTagIds']);$i++){
			if(isset($_REQUEST['docTagIds'][$i]) && !empty($_REQUEST['docTagIds'][$i])) {
	           $KBDocumentKBTag = BeanFactory::getBean('KBDocumentKBTags');
			   $KBDocumentKBTag->kbtag_id = $_REQUEST['docTagIds'][$i];
			   $KBDocumentKBTag->kbdocument_id = $KBDocument->id;
			   $KBDocumentKBTag->team_id = $KBDocument->team_id;
			   $KBDocumentKBTag->save();
			}
		}
	}

	//also update the already saved kbdocuments_kbtags team_id
	$KBDocumentKBTag = BeanFactory::getBean('KBDocumentKBTags');
	$q = 'UPDATE kbdocuments_kbtags SET team_id = \''.$KBDocument->team_id.'\' WHERE kbdocument_id = \''.$KBDocument->id.'\'';
	$KBDocumentKBTag->db->query($q);
}
else {
	  if($KBDocument != null){
		if($KBDocument->status_id == 'In Review' || $KBDocument->status_id == 'Published'){

			$check_notify = true;
			if(empty($KBDocument->kbdoc_approver_id) || $KBDocument->kbdoc_approver_id==null){
	            $KBDocument->kbdoc_approver_id = $current_user->id;
	    	}
		}
		if($KBDocument->status_id == 'Published'){
	    	//set the published date if it's null or empty
	    	if(empty($KBDocument->active_date) || $KBDocument->active_date==null){
	            $KBDocument->active_date = $timedate->nowDate();

	    	}
	    }
	    if($KBDocument->status_id != 'Published'){
	    	//also set the published date if it's null or empty
	    	if(!empty($KBDocument->active_date) || $KBDocument->active_date!=null){
	            $KBDocument->active_date = '';
	    	}
	    }
	  }

	//save kbdocument first
	  $kb_id = create_guid();
	  $KBRevision->change_log = $mod_strings['DEF_CREATE_LOG'];
	  $KBRevision->revision = $KBDocument->revision;
	  $KBRevision->kbdocument_id = $kb_id;
	  $KBRevision->latest = true;
	  $KBRevision->save();
	//save tags
		if(isset($_REQUEST['docTagIds']) && $_REQUEST['docTagIds'] != null){
			for($i=0;$i<count($_REQUEST['docTagIds']);$i++){
				if(isset($_REQUEST['docTagIds'][$i]) && !empty($_REQUEST['docTagIds'][$i])) {
		           $KBDocumentKBTag = BeanFactory::getBean('KBDocumentKBTags');
				   $KBDocumentKBTag->kbtag_id = $_REQUEST['docTagIds'][$i];
				   $KBDocumentKBTag->kbdocument_id = $kb_id;
				   $KBDocumentKBTag->team_id = $KBDocument->team_id;
				   $KBDocumentKBTag->save();
				}
			}
		}
		if($_REQUEST['body_html'] != null){
		    $DocRevision = BeanFactory::getBean('DocumentRevisions');
			$KBContent = BeanFactory::getBean('KBContents');
			//relate doc revision and kbdoc revision
			$DocRevision->filename = $KBDocument->kbdocument_name;
			$DocRevision->save();
		    //relate doc revision to kbcontent
			$KBContent->document_revision_id = $DocRevision->id;
			$KBContent->team_id = $KBDocument->team_id;
			if(strpos(getenv('HTTP_USER_AGENT'), 'MSIE')){
			    $KBContent->kbdocument_body = $_REQUEST['body_html'];
			} else{
				$article_body = '';
				$url_arr = parse_url($sugar_config['site_url']);
	            $article_body = str_replace($sugar_config['site_url'].'/cache/images/', $url_arr['path'].'/cache/images/', $_REQUEST['body_html']);
            	$article_body = str_replace($url_arr['path'].'/cache/images/', $sugar_config['site_url'].'/cache/images/', $article_body);
	            $KBContent->kbdocument_body = $article_body;
			}
			$KBContent->save();
		}

		//update document with document revision

	    //save all the attachments as documents and link them to the kbdocument


	    //update the kbdocument revision with document revision and content
		$KBRevision->kbcontent_id = $KBContent->id;
		$KBRevision->document_revision_id = $DocRevision->id;
		$KBRevision->save();
		//update kbdocument with kbdocument revision id
		$KBDocument->id = $kb_id;
		$KBDocument->new_with_id = true;
		$KBDocument->kbdocument_revision_id = $KBRevision->id;
		$return_id = $KBDocument->save($check_notify);
}




if (!isset($_POST[$prefix.'is_template'])) $KBDocument->is_template = 0;
else $KBDocument->is_template = 1;

$upload_file = new UploadFile('uploadfile');
$do_final_move = 0;

//loop through all the attachments and convert them into documents
//also take the KBDocumentbody and convert into a document
$file_uploaded_count = count($_FILES);
//array of removed files
$files = explode(",", $_REQUEST['removed_files']);

for($i = 0; $i < $file_uploaded_count; $i++) {
	$found = false;
	foreach($files as $file){
		if($file == $_FILES['kbdoc_attachment'.$i]['name']){
			$found = true;
			break;
		}
	}
	if($found){
		//do nothing
	}
	else{
		$upload_file = new UploadFile('kbdoc_attachment'.$i);

		if($upload_file == null || $_FILES['kbdoc_attachment'.$i]['size']==0) {
			continue;
		}
	    $DocRevision = BeanFactory::getBean('DocumentRevisions');
	    if(isset($_FILES['kbdoc_attachment'.$i]) && $upload_file->confirm_upload()) {

		     //prepare document revision
		    $DocRevision->filename = $upload_file->get_stored_file_name();
		    $DocRevision->file_mime_type = $upload_file->mime_type;
			$DocRevision->file_ext = $upload_file->file_ext;
		 	$DocRevision->save();

		 	//save kbrvision
		    $KBRevisionAtts = BeanFactory::getBean('KBDocumentRevisions');
		 	$KBRevisionAtts->change_log = $mod_strings['DEF_CREATE_LOG'];
		    $KBRevisionAtts->revision = $KBDocument->revision;
		    $KBRevisionAtts->kbdocument_id = $KBDocument->id;
		    $KBRevisionAtts->document_revision_id = $DocRevision->id;
		    //$KBRevisionAtts->latest = true;
		    $KBRevisionAtts->save();

		 	//update document with revision id
		 	//$Document->document_revision_id = $DocRevision->id;

		 	//$Document->save();

		 	$do_final_move = 1;
		 	if ($do_final_move) {
	  	      $upload_file->final_move($DocRevision->id);
	        }
	        else if ( ! empty($_REQUEST['old_id'])) {
	   	      $upload_file->duplicate_file($_REQUEST['old_id'], $DocRevision->id, $DocRevision->filename);
	        }
	   }
  }
}

if(isset($_REQUEST['removed_tags']) && !empty($_REQUEST['removed_tags'])){
	$tags = explode(",", $_REQUEST['removed_tags']);
	$deleted = 1;
	foreach($tags as $tag_id){
		$tag_id= trim($tag_id);
		if(!empty($tag_id)){
			$KBDocumentKBTag = BeanFactory::getBean('KBDocumentKBTags');
			$q = 'UPDATE kbdocuments_kbtags SET deleted = \''.$deleted.'\' WHERE kbtag_id = \''.$tag_id.'\' and kbdocument_id = \''.$KBDocument->id.'\'';
			$KBDocumentKBTag->db->query($q);
		}
	}

}
if(isset($_REQUEST['removed_attachments']) && !empty($_REQUEST['removed_attachments'])){
	$atts = explode(",", $_REQUEST['removed_attachments']);
	$deleted = 1;
	foreach($atts as $docrev_id){
		$docrev_id = trim($docrev_id);
		if(!empty($docrev_id)){
			$DocumentRevision = BeanFactory::getBean('DocumentRevisions');
			$q = 'UPDATE document_revisions SET deleted = '.$deleted.' WHERE id = \''.$docrev_id.'\'';
			$DocumentRevision->db->query($q);
		}
	}
}


//$return_id = $KBDocument->id;
$GLOBALS['log']->debug("Saved record with id of ".$return_id);
handleRedirect($return_id, "KBDocuments");

?>