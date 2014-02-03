<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once 'include/MVC/View/SidecarView.php';
require_once "include/api/RestService.php";
require_once 'clients/base/api/OAuth2Api.php';
require_once 'include/SugarOAuth2/SugarOAuth2Server.php';

class UsersViewAuthenticate extends SidecarView
{
    /**
     * Do we need only data for parent window or the whole Sidecar?
     * @var bool
     */
    protected $dataOnly = false;

    public function preDisplay()
    {
        if(session_id()) {
            // kill old session
            session_destroy();
        }
        SugarAutoLoader::load('custom/include/RestService.php');
        $restServiceClass = SugarAutoLoader::customClass('RestService');
        $service = new $restServiceClass();
        SugarOAuth2Server::getOAuth2Server(); // to load necessary classes

        $oapi = new OAuth2Api();
        $args = $_REQUEST;
        $args['client_id'] = 'sugar';
        $args['client_secret'] = '';
        if (!empty($_REQUEST['SAMLResponse'])) {
            $args['grant_type'] = SugarOAuth2Storage::SAML_GRANT_TYPE;
            $args['assertion'] = $_REQUEST['SAMLResponse'];
        } else {
            if(empty($args['grant_type'])) {
                $args['grant_type'] = OAuth2::GRANT_TYPE_USER_CREDENTIALS;
                if(!empty($args['user_name']) && isset($args['user_password'])) {
                    // old-style login, let's translate it
                    $args['username'] = $args['user_name'];
                    $args['password'] = $args['user_password'];
                }
            }
        }
        try {
            $this->authorization = $oapi->token($service, $args);
        } catch (Exception $e) {
            $GLOBALS['log']->error("Login exception: " . $e->getMessage());
            sugar_die($e->getMessage());
        }
        if(!empty($_REQUEST['dataOnly'])) {
            $this->dataOnly = true;
        }
        parent::preDisplay();
    }

    public function display()
    {
        if($this->dataOnly) {
            $this->ss->assign("siteUrl", $GLOBALS['sugar_config']['site_url']);
            $this->ss->display(SugarAutoLoader::existingCustomOne('modules/Users/tpls/AuthenticateParent.tpl'));
        } else {
            parent::display();
        }
    }
}
