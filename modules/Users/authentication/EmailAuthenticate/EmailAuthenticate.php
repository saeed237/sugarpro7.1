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




/**
 * This file is used to control the authentication process. 
 * It will call on the user authenticate and controll redirection 
 * based on the users validation
 *
 */
require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php');
class EmailAuthenticate extends SugarAuthenticate {
	var $userAuthenticateClass = 'EmailAuthenticateUser';
	var $authenticationDir = 'EmailAuthenticate';
	/**
	 * Constructs EmailAuthenticate
	 * This will load the user authentication class
	 *
	 * @return EmailAuthenticate
	 */
	function EmailAuthenticate(){
	    
		parent::SugarAuthenticate();
	}

}
