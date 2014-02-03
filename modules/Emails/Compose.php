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

/*********************************************************************************

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

//Shorten name.
$data = $_REQUEST;

if (!empty($data['listViewExternalClient'])) {
    $email = BeanFactory::getBean('Emails');
    echo $email->getNamePlusEmailAddressesForCompose($_REQUEST['action_module'], (explode(",", $_REQUEST['uid'])));
}
//For the full compose/email screen, the compose package is generated and script execution
//continues to the Emails/index.php page.
else if(!isset($data['forQuickCreate'])) {
	$ret = generateComposeDataPackage($data);
}

/**
 * Initialize the full compose window by creating the compose package
 * and then including Emails index.php file.
 *
 * @param Array $ret
 */
function initFullCompose($ret)
{
	global $current_user;
	$json = getJSONobj();
	$composeOut = $json->encode($ret);

	//For listview 'Email' call initiated by subpanels, just returned the composePackage data, do not
	//include the entire Emails page
	if ( isset($_REQUEST['ajaxCall']) && $_REQUEST['ajaxCall'])
	{
	    echo $composeOut;
	}
	else
	{
	   //For normal full compose screen
	   include('modules/Emails/index.php');
	   echo "<script type='text/javascript' language='javascript'>\ncomposePackage = {$composeOut};\n</script>";
	}
}

/**
 * Generate the compose data package consumed by the full and quick compose screens.
 *
 * @param Array $data
 * @param Bool $forFullCompose If full compose is set to TRUE, then continue execution and include the full Emails UI.  Otherwise
 *             the data generated is returned.
 * @param SugarBean $bean Optional - parent object with data
 */
function generateComposeDataPackage($data,$forFullCompose = TRUE, $bean = null)
{
	// we will need the following:
	if( isset($data['parent_type']) && !empty($data['parent_type']) &&
	isset($data['parent_id']) && !empty($data['parent_id']) &&
	!isset($data['ListView']) && !isset($data['replyForward'])) {
	    if(empty($bean)) {
    		global $mod_strings;
            $bean = BeanFactory::getBean($data['parent_type'], $data['parent_id']);
	    }
		if (isset($bean->full_name)) {
			$parentName = $bean->full_name;
		} elseif(isset($bean->name)) {
			$parentName = $bean->name;
		}else{
			$parentName = '';
		}
		$parentName = from_html($parentName);
		$namePlusEmail = '';
		if (isset($data['to_email_addrs'])) {
			$namePlusEmail = $data['to_email_addrs'];
			$namePlusEmail = from_html(str_replace("&nbsp;", " ", $namePlusEmail));
		} else {
			if (isset($bean->full_name)) {
				$namePlusEmail = from_html($bean->full_name) . " <". from_html($bean->emailAddress->getPrimaryAddress($bean)).">";
			} else  if(isset($bean->emailAddress)){
				$namePlusEmail = "<".from_html($bean->emailAddress->getPrimaryAddress($bean)).">";
			}
		}

		$subject = "";
		$body = "";
		$email_id = "";
		$attachments = array();
		if ($bean->module_dir == 'Cases') {
			$subject = str_replace('%1', $bean->case_number, $bean->getEmailSubjectMacro() . " ". from_html($bean->name)) ;//bug 41928
			$bean->load_relationship("contacts");
			$contact_ids = $bean->contacts->get();
			$contact = BeanFactory::getBean('Contacts');
			foreach($contact_ids as $cid)
			{
				$contact->retrieve($cid);
				$namePlusEmail .= empty($namePlusEmail) ? "" : ", ";
				$namePlusEmail .= from_html($contact->full_name) . " <".from_html($contact->emailAddress->getPrimaryAddress($contact)).">";
			}
		}
		if ($bean->module_dir == 'KBDocuments') {

			require_once("modules/Emails/EmailUI.php");
			$subject = $bean->kbdocument_name;
			$article_body = str_replace('/cache/images/',$GLOBALS['sugar_config']['site_url'].'/cache/images/',KBDocument::get_kbdoc_body_without_incrementing_count($bean->id));
			$body = from_html($article_body);
			$attachments = KBDocument::get_kbdoc_attachments_for_newemail($bean->id);
			$attachments = $attachments['attachments'];
		} // if
		if ($bean->module_dir == 'Quotes' && isset($data['recordId'])) {
			$quotesData = getQuotesRelatedData($bean,$data);
			global $current_language;
			$namePlusEmail = $quotesData['toAddress'];
			$subject = $quotesData['subject'];
			$body = $quotesData['body'];
			$attachments = $quotesData['attachments'];
			$email_id = $quotesData['email_id'];
		} // if
		$ret = array(
		'to_email_addrs' => $namePlusEmail,
		'parent_type'	 => $data['parent_type'],
		'parent_id'	     => $data['parent_id'],
		'parent_name'    => $parentName,
		'subject'		 => $subject,
		'body'			 => $body,
		'attachments'	 => $attachments,
		'email_id'		 => $email_id,

	);
} else if(isset($_REQUEST['ListView'])) {

	$email = BeanFactory::getBean('Emails');
	$namePlusEmail = $email->getNamePlusEmailAddressesForCompose($_REQUEST['action_module'], (explode(",", $_REQUEST['uid'])));
	$ret = array(
		'to_email_addrs' => $namePlusEmail,
		);
	} else if (isset($data['replyForward'])) {

		require_once("modules/Emails/EmailUI.php");

		$ret = array();
		$ie = BeanFactory::getBean('InboundEmail');
		$ie->email = BeanFactory::getBean('Emails');
		$ie->email->email2init();
		$replyType = $data['reply'];
		$email_id = $data['record'];
		$ie->email->retrieve($email_id);
		$emailType = "";
		if ($ie->email->type == 'draft') {
			$emailType = $ie->email->type;
		}
		$ie->email->from_addr = $ie->email->from_addr_name;
        $ie->email->to_addrs = to_html(!empty($ie->email->to_addrs_names)? $ie->email->to_addrs_names : $ie->email->to_addrs);
		$ie->email->cc_addrs = to_html($ie->email->cc_addrs_names);
		$ie->email->bcc_addrs = $ie->email->bcc_addrs_names;
		$ie->email->from_name = $ie->email->from_addr;
		$preBodyHTML = "&nbsp;<div><hr></div>";
		if ($ie->email->type != 'draft') {
			$email = $ie->email->et->handleReplyType($ie->email, $replyType);
		} else {
			$email = $ie->email;
			$preBodyHTML = "";
		} // else
		if ($ie->email->type != 'draft') {
			$emailHeader = $email->description;
		}
		$ret = $ie->email->et->displayComposeEmail($email);
		if ($ie->email->type != 'draft') {
			$ret['description'] = $emailHeader;
		}
		if ($replyType == 'forward' || $emailType == 'draft') {
			$ret = $ie->email->et->getDraftAttachments($ret);
		}
		$return = $ie->email->et->getFromAllAccountsArray($ie, $ret);

		if ($replyType == "forward") {
			$return['to'] = '';
		} else {
			if ($email->type != 'draft') {
				$return['to'] = from_html($ie->email->from_addr);
			}
		} // else
		$ret = array(
		'to_email_addrs' => $return['to'],
		'parent_type'	 => $return['parent_type'],
		'parent_id'	     => $return['parent_id'],
		'parent_name'    => $return['parent_name'],
		'subject'		 => $return['name'],
		'body'			 => $preBodyHTML . $return['description'],
		'attachments'	 => (isset($return['attachments']) ? $return['attachments'] : array()),
		'email_id'		 => $email_id,
		'fromAccounts'   => $return['fromAccounts'],
		);

        // If it's a 'Reply All' action, append the CC addresses
        if ($data['reply'] == 'replyAll') {
            $ret['cc_addrs'] = from_html($ie->email->to_addrs);
        }

	} else {
		$ret = array(
		'to_email_addrs' => '',
		);
	}

	if($forFullCompose)
		initFullCompose($ret);
	else
		return $ret;
}

function getQuotesRelatedData($bean,$data) {
	$return = array();
	$emailId = $data['recordId'];

  	require_once("modules/Emails/EmailUI.php");
	$email = BeanFactory::getBean('Emails', $emailId);
	$return['subject'] = $email->name;
	$return['body'] = from_html($email->description_html);
	$return['toAddress'] = $email->to_addrs;
	$ret = array();
	$ret['uid'] = $emailId;
	$ret = EmailUI::getDraftAttachments($ret);
	$return['attachments'] = $ret['attachments'];
	$return['email_id'] = $emailId;
	return $return;
} // fn
