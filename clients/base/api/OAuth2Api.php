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

require_once('include/SugarOAuth2/SugarOAuth2Server.php');

class OAuth2Api extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'token' => array(
                'reqType' => 'POST',
                'path' => array('oauth2','token'),
                'pathVars' => array('',''),
                'method' => 'token',
                'shortHelp' => 'OAuth2 token requests.',
                'longHelp' => 'include/api/help/oauth2_token_post_help.html',
                'noLoginRequired' => true,
                'keepSession' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'oauth_logout' => array(
                'reqType' => 'POST',
                'path' => array('oauth2','logout'),
                'pathVars' => array('',''),
                'method' => 'logout',
                'shortHelp' => 'OAuth2 logout.',
                'longHelp' => 'include/api/help/oauth2_logout_post_help.html',
                'keepSession' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'oauth_bwc_login' => array(
                'reqType' => 'POST',
                'path' => array('oauth2','bwc', 'login'),
                'pathVars' => array('','',''),
                'method' => 'bwcLogin',
                'shortHelp' => 'Bwc login for bwc modules. Internal usage only.',
                'longHelp' => 'include/api/help/oauth2_bwc_login_post_help.html',
                'keepSession' => true,
                'ignoreMetaHash' => true,
                'ignoreSystemStatusError' => true,
            ),
            'oauth_sudo' => array(
                'reqType' => 'POST',
                'path' => array('oauth2','sudo','?'),
                'pathVars' => array('','','user_name'),
                'method' => 'sudo',
                'shortHelp' => 'Get an access token for another user',
                'longHelp' => 'include/api/help/oauth2_sudo_post_help.html',
                'ignoreMetaHash' => true,
            ),
        );
    }

    protected function getOAuth2Server($args)
    {
        $platform = empty($args['platform']) ? 'base' : $args['platform'];
        $oauth2Server = SugarOAuth2Server::getOAuth2Server();
        $oauth2Server->setPlatform($platform);

        return $oauth2Server;
    }

    public function token($api, $args)
    {
        $validVersion = $this->isSupportedClientVersion($api, $args);

        if ( !$validVersion ) {
            throw new SugarApiExceptionClientOutdated();
        }

        $oauth2Server = $this->getOAuth2Server($args);
        try {
            $GLOBALS['logic_hook']->call_custom_logic('Users', 'before_login');
            $authData = $oauth2Server->grantAccessToken($args);
            // if we're here, the login was OK
            if (!empty($GLOBALS['current_user'])) {
                $GLOBALS['current_user']->call_custom_logic('after_login');
            }
            $cleanupChance = isset($GLOBALS['sugar_config']['token_cleanup_probability'])?(int)$GLOBALS['sugar_config']['token_cleanup_probability']:10;
            if (mt_rand() % $cleanupChance == 0) {
                // cleanup based on probability
                OAuthToken::cleanup();
            }
        } catch (OAuth2ServerException $e) {
            // failed to get token - something went wrong - list as failed login
            $GLOBALS['logic_hook']->call_custom_logic('Users', 'login_failed');
            throw $e;
        } catch(SugarApiExceptionNeedLogin $e) {
            $GLOBALS['logic_hook']->call_custom_logic('Users', 'login_failed');
            // have API throw login exception wil full data
            $api->needLogin($e);
        }

        $loginStatus = apiCheckLoginStatus();
        if ($loginStatus !== true && $loginStatus['level'] != 'warning') {
            if (($loginStatus['level'] == 'admin_only' || $loginStatus['level'] == 'maintenance')
                 && $GLOBALS['current_user']->isAdmin() ) {
                // Let them through
            } else {
                // This is no good, they shouldn't be allowed in.
                $e = new SugarApiExceptionMaintenance($systemStatus['message'], null, null, 0, $systemStatus['level']);
                $e->setExtraData("url", $systemStatus['url']);
                throw $e;
            }
        }

        // Adding the setcookie() here instead of calling $api->setHeader() because
        // manually adding a cookie header will break 3rd party apps that use cookies
        setcookie(RestService::DOWNLOAD_COOKIE, $authData['download_token'], time()+$authData['refresh_expires_in'], ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), true);
        return $authData;
    }

    public function logout($api, $args) 
    {
        $oauth2Server = $this->getOAuth2Server($args);
        if(!empty($api->user)) {
            $api->user->call_custom_logic('before_logout');
        }

        if ( isset($args['refresh_token']) ) {
            // Nuke the refresh token as well.
            // No security checks needed here to make sure the refresh token is theirs,
            // because if someone else has your refresh token logging out is the nicest possible thing they could do.
            $oauth2Server->storage->unsetRefreshToken($args['refresh_token']);
        }

        setcookie(RestService::DOWNLOAD_COOKIE, false, -1, ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), true);

        // The OAuth access token is actually just a session, so we can nuke that here.
        $_SESSION = array();
        session_regenerate_id(true);

        // Whack the cookie that was set in BWC mode
        setcookie(session_name(), session_id(), time() - 3600, ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), ini_get('session.cookie_httponly'));
        $GLOBALS['logic_hook']->call_custom_logic('Users', 'after_logout');

        return array('success'=>true);
    }

    /**
     * By default OAuth is not using cookies. For bwc we need cookies.
     *
     * Use the information supplied by oauth2 on $_SESSION.
     *
     * @param $api
     * @param $args
     */
    public function bwcLogin($api, $args)
    {
        // Send back session_name so the client can use it for other bwc functions, 
        // like studio, module builder, etc when sessions expire outside of the
        // ajax calls
        $session_name = session_name();

        setcookie(
            $session_name, 
            session_id(), 
            ini_get('session.cookie_lifetime'), 
            ini_get('session.cookie_path'), 
            ini_get('session.cookie_domain'), 
            ini_get('session.cookie_secure'), 
            ini_get('session.cookie_httponly')
        );

        return array('name' => $session_name);
    }

    /**
     * This API allows a user to impersonate another user
     * restricting their security to the level of the impersonated user
     *
     * @param ServiceBase $api
     * @param array $args
     */
    public function sudo(ServiceBase $api, array $args)
    {
        if (!$api->user->isAdmin() || !empty($_SESSION['sudo_for'])) {
            // Don't let non-admins sudo
            // Also don't let a sudo user sudo again (so they can't hide their tracks)
            throw new SugarApiExceptionNotAuthorized();
        }

        if (!empty($args['client_id'])) {
            $clientId = $args['client_id'];
        } else {
            $clientId = 'sugar';
        }

        if (!empty($args['platform'])) {
            $platform = $args['platform'];
        } else {
            $platform = 'base';
        }


        $oauth2Server = $this->getOAuth2Server($args);

        $token = $oauth2Server->getSudoToken($args['user_name'], $clientId, $platform);

        if (!$token) {
            throw new SugarApiExceptionRequestMethodFailure("Could not setup a token for the requested user");
        }

        return $token;
    }

    /**
     * This function checks to make sure that if a client version is supplied it is up to date.
     *
     * @param ServiceBase $api The service api
     * @param array $args The arguments passed in to the function
     * @return bool True if the version was good, false if it wasn't
     */
    public function isSupportedClientVersion(ServiceBase $api, array $args)
    {
        if (!empty($args['client_info']['app']['name'])
            && !empty($args['client_info']['app']['version'])) {
            
            $name = $args['client_info']['app']['name'];
            $version = $args['client_info']['app']['version'];
            
            if (isset($api->api_settings['minClientVersions'][$name])
                && version_compare($api->api_settings['minClientVersions'][$name], $args['client_info']['app']['version'],'>') ) {
                // Version is too old, force them to upgrade.
                return false;
            }
        }

        return true;
    }
}
