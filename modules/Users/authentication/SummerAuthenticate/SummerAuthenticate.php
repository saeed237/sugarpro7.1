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

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php');

class SummerAuthenticate extends SugarAuthenticate
{
	var $userAuthenticateClass = 'SummerAuthenticateUser';
	var $authenticationDir = 'SummerAuthenticate';

	public function __construct()
	{
		parent::SugarAuthenticate();
		$this->box = BoxOfficeClient::getInstance();
	}

    public function pre_login()
    {
        parent::pre_login();
        // go straight to authentication
        $token = $this->box->getToken();
        unset($_REQUEST['login_token']);
        SugarApplication::redirect("?module=Users&action=Authenticate&token=$token&".http_build_query($GLOBALS['app']->getLoginVars(false)));
    }

    public function loginAuthenticate()
    {
        $user = $this->box->getCurrentUser();
        if(empty($user)) {
            SugarApplication::redirect($this->box->loginUrl());
        }
        if(parent::loginAuthenticate($user['email'], '', false)) {
            // delete session when done
            // $this->box->deleteSession();
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
        ob_clean();
        $this->box->deleteSession();
        SugarApplication::redirect($this->box->loginUrl());
    }
}