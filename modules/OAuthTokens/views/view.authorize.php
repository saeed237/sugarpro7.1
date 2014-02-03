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



require_once 'include/SugarOAuthServer.php';

class OauthTokensViewAuthorize extends SugarView
{
	public function display()
    {
        if(!SugarOAuthServer::enabled()) {
            sugar_die($GLOBALS['mod_strings']['LBL_OAUTH_DISABLED']);
        }
        global $current_user;
        if(!isset($_REQUEST['token']) && isset($_REQUEST['oauth_token'])) {
            $_REQUEST['token'] = $_REQUEST['oauth_token'];
        }
        $sugar_smarty = new Sugar_Smarty();
        $sugar_smarty->assign('APP', $GLOBALS['app_strings']);
        $sugar_smarty->assign('MOD', $GLOBALS['mod_strings']);
        $sugar_smarty->assign('token', $_REQUEST['token']);
        $sugar_smarty->assign('sid', session_id());
        $token = OAuthToken::load($_REQUEST['token']);
        if(empty($token) || empty($token->consumer) || $token->tstate != OAuthToken::REQUEST || empty($token->consumer_obj)) {
            sugar_die('Invalid token');
        }

        if(empty($_REQUEST['confirm'])) {
            $sugar_smarty->assign('consumer', sprintf($GLOBALS['mod_strings']['LBL_OAUTH_CONSUMERREQ'], $token->consumer_obj->name));
// SM: roles disabled for now
//            $roles = array('' => '');
//            $allroles = ACLRole::getAllRoles();
//            foreach($allroles as $role) {
//                $roles[$role->id] = $role->name;
//            }
//            $sugar_smarty->assign('roles', $roles);
            $hash = md5(rand());
            $_SESSION['oauth_hash'] = $hash;
            $sugar_smarty->assign('hash', $hash);
            echo $sugar_smarty->fetch('modules/OAuthTokens/tpl/authorize.tpl');
        } else {
            if($_REQUEST['sid'] != session_id() || $_SESSION['oauth_hash'] != $_REQUEST['hash']) {
                sugar_die('Invalid request');
            }
            $verify = $token->authorize(array("user" => $current_user->id));
            if(!empty($token->callback_url)){
                $redirect_url=$token->callback_url;
                if(strchr($redirect_url, "?") !== false) {
                    $redirect_url .= '&';
                } else {
                    $redirect_url .= '?';
                }
                $redirect_url .= "oauth_verifier=".$verify.'&oauth_token='.$_REQUEST['token'];
                SugarApplication::redirect($redirect_url);
            }
            $sugar_smarty->assign('VERIFY', $verify);
            $sugar_smarty->assign('token', '');
            echo $sugar_smarty->fetch('modules/OAuthTokens/tpl/authorized.tpl');
        }
    }

}

