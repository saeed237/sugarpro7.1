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
 * This file is where the user authentication occurs. No redirection should happen in this file.
 *
 */
class SugarAuthenticateUser{

	/**
	 * Does the actual authentication of the user and returns an id that will be used
	 * to load the current user (loadUserOnSession)
	 *
	 * @param STRING $name
	 * @param STRING $password
	 * @param STRING $fallback - is this authentication a fallback from a failed authentication
	 * @return STRING id - used for loading the user
	 */
	function authenticateUser($name, $password, $fallback=false)
	{
	    $row = User::findUserPassword($name, $password, "(portal_only IS NULL OR portal_only !='1') AND (is_group IS NULL OR is_group !='1') AND status !='Inactive'");

	    // set the ID in the seed user.  This can be used for retrieving the full user record later
		//if it's falling back on Sugar Authentication after the login failed on an external authentication return empty if the user has external_auth_disabled for them
		if (empty ($row) || !empty($row['external_auth_only'])) {
			return '';
		} else {
			return $row['id'];
		}
	}
	/**
	 * Checks if a user is a sugarLogin user
	 * which implies they should use the sugar authentication to login
	 *
	 * @param STRING $name
	 * @param STRIUNG $password
	 * @return boolean
	 */
	function isSugarLogin($name, $password)
	{
	    $row = User::findUserPassword($name, $password, "(portal_only IS NULL OR portal_only !='1') AND (is_group IS NULL OR is_group !='1') AND status !='Inactive' AND sugar_login=1");
	    return !empty($row);
	}

	/**
	 * this is called when a user logs in
	 *
	 * @param STRING $name
	 * @param STRING $password
	 * @param STRING $fallback - is this authentication a fallback from a failed authentication
	 * @return boolean
	 */
	function loadUserOnLogin($name, $password, $fallback = false, $PARAMS = array()) {
		global $login_error;

		$GLOBALS['log']->debug("Starting user load for ". $name);
		if(empty($name) || empty($password)) return false;
		$input_hash = $password;
		$passwordEncrypted = false;
		if (!empty($PARAMS) && isset($PARAMS['passwordEncrypted']) && $PARAMS['passwordEncrypted']) {
			$passwordEncrypted = true;
		}// if
		if (!$passwordEncrypted) {
			$input_hash = SugarAuthenticate::encodePassword($password);
		} // if
		$user_id = $this->authenticateUser($name, $input_hash, $fallback);
		if(empty($user_id)) {
			$GLOBALS['log']->fatal('SECURITY: User authentication for '.$name.' failed');
			return false;
		}
		$this->loadUserOnSession($user_id);
		return true;
	}
	/**
	 * Loads the current user bassed on the given user_id
	 *
	 * @param STRING $user_id
	 * @return boolean
	 */
	function loadUserOnSession($user_id=''){
		if(!empty($user_id)){
			$_SESSION['authenticated_user_id'] = $user_id;
		}

		if(!empty($_SESSION['authenticated_user_id']) || !empty($user_id)){
			$GLOBALS['current_user'] = BeanFactory::getBean('Users');
			if($GLOBALS['current_user']->retrieve($_SESSION['authenticated_user_id'])){
				return true;
			}
		}
		return false;

	}

}

?>
