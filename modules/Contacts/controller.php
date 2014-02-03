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


class ContactsController extends SugarController
{
	function action_Popup(){
		if(!empty($_REQUEST['html']) && $_REQUEST['html'] == 'mail_merge'){
			$this->view = 'mailmergepopup';
		}else{
			$this->view = 'popup';
		}
	}
	
    function action_ValidPortalUsername()
    {
		$this->view = 'validportalusername';
    }

    function action_RetrieveEmail()
    {
        $this->view = 'retrieveemail';	
    }

    function action_ContactAddressPopup()
    {
		$this->view = 'contactaddresspopup';
    }
  
    function action_CloseContactAddressPopup()
    {
    	$this->view = 'closecontactaddresspopup';
    }    
}
?>