<?php
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


/**
 * ContactsViewRetrieveEmailUsername.php
 * 
 * This class overrides SugarView and provides an implementation for the RetrieveEmailUsername
 * method used for returning the information about an email address
 * 
 * @author Collin Lee
 * */
 
require_once('include/MVC/View/SugarView.php');
require_once("include/JSON.php");

class ContactsViewRetrieveEmail extends SugarView {
	
 	function ContactsViewRetrieveEmail(){
 		parent::SugarView();
 	}
 	
 	function process() {
		$this->display();
 	}

 	function display(){
	    $data = array();
	    $data['target'] = $_REQUEST['target'];
        if(!empty($_REQUEST['email'])) {
	        $db = DBManagerFactory::getInstance();
	        $email = $GLOBALS['db']->quote(strtoupper(trim($_REQUEST['email'])));
	        $result = $db->query("SELECT * FROM email_addresses WHERE email_address_caps = '$email' AND deleted = 0");
			if($row = $db->fetchByAssoc($result)) {
		        $data['email'] = $row;
			} else {
				$data['email'] = '';
			}
        }
		$json = new JSON(JSON_LOOSE_TYPE);
		echo $json->encode($data); 
 	}	
}
?>