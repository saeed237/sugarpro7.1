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
 * ContactsViewContactAddressPopup
 * 
 * */
 
require_once('include/MVC/View/SugarView.php');
require_once('modules/Contacts/Popup_picker.php');

class ContactsViewMailMergePopup extends SugarView {
	
 	function ContactAddressPopup(){
 		parent::SugarView();
 	}
 	
 	function process() {
		$this->display();
 	}

 	function display() {
 		
		$popup = new Popup_Picker();
		echo $popup->process_page_for_merge();
 	}	
}
?>