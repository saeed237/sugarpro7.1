<?php
//FILE SUGARCRM flav=pro
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


require_once('include/MVC/View/views/view.quickcreate.php');

class ContactsViewQuickcreate extends ViewQuickcreate
{
    public function preDisplay() 
    {
    	parent::preDisplay();
    	if($this->_isDCForm) {
    		//XXX TODO 20110329 Frank Steegmans: Hack to make quick create fields populate when used through the DC menu
    		//          NOTE HOWEVER that sqs_objects form fields are not properly populated because of some other hacks
    		//          resulting in none of the fields properly populating when selecting an account
    		if(!empty($this->bean->phone_office))$_REQUEST['phone_work'] = $this->bean->phone_office;
    		if(!empty($this->bean->billing_address_street))$_REQUEST['primary_address_street'] = $this->bean->billing_address_street;
    		if(!empty($this->bean->billing_address_city))$_REQUEST['primary_address_city'] = $this->bean->billing_address_city;
    		if(!empty($this->bean->billing_address_state))$_REQUEST['primary_address_state'] = $this->bean->billing_address_state;
    		if(!empty($this->bean->billing_address_country))$_REQUEST['primary_address_country'] = $this->bean->billing_address_country;
    		if(!empty($this->bean->billing_address_postalcode))$_REQUEST['primary_address_postalcode'] = $this->bean->billing_address_postalcode;
	   	}
    }    
}