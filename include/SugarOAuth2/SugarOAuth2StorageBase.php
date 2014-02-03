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

require_once 'include/SugarOAuth2/SugarOAuth2StoragePlatform.php';

/**
 * Sugar OAuth2.0 Base Storage system, allows the OAuth2 library we are using to
 * store and retrieve data by interacting with our Base client.
 *
 * This class should only be used by the OAuth2 library and cannot be relied
 * on as a stable API for any other sources.
 */
class SugarOAuth2StorageBase extends SugarOAuth2StoragePlatform {
    /**
     * The user type for this client
     *
     * @var string
     */
    protected $userType = 'user';

    /**
     * Gets a user bean
     *
     * @param  string $user_id The ID of the User to get
     * @return User
     */
    public function getUserBean($user_id) {
        return BeanFactory::getBean('Users', $user_id);
    }

    /**
     * Small validator for child classes to use to determine whether a session can
     * be written to
     *
     * @return boolean
     */
    public function canStartSession() {
        return true;
    }
    /**
     * Fills in any added session data needed by this client type
     *
     * This method is used by child classes like portal
     */
    public function fillInAddedSessionData()
    {
        if ($this->canStartSession() && !empty($this->userBean)) {
            // Grab the user's timezone preference if it's set
            $val = $this->userBean->getPreference('timezone');
            $needPreferenceSet = false;
            // If there is no setting for the user, fall back to the system setting
            if (!$val) {
                $val = TimeDate::guessTimezone();
                $needPreferenceSet = true;
            }

            // If there is still no timezone, fallback to UTC
            if (!$val) {
                $val = 'UTC';
                $needPreferenceSet = true;
            }

            if ($needPreferenceSet === true) {
                $this->userBean->setPreference('timezone', $val);
                $this->userBean->savePreferencesToDB();
            }

            $this->userBean->loadPreferences();
        }
        return true;
    }

    /**
     * Gets the authentication bean for a given client
     * @param OAuthToken
     * @return mixed
     */
    public function getAuthBean(OAuthToken $token) {
        $authBean = BeanFactory::getBean('Users', $token->assigned_user_id);
        if ( $authBean == null || $authBean->status == 'Inactive' ) {
            $authBean = null;
        }

        return $authBean;
    }

    /**
     * Gets contact and user ids for a user id. Most commonly different for clients
     * like portal
     *
     * @param string $client_id The client id for this check
     * @return array An array of contact_id and user_id
     */
    public function getIdsForUser($user_id, $client_id) {
        return array('contact_id' => '', 'user_id' => $user_id);
    }

    /**
     * Sets up necessary visibility for a client. Not all clients will set this
     *
     * @return void
     */
    public function setupVisibility() {}

    // BEGIN METHODS FROM IOAuth2GrantUser
	/**
	 * Grant access tokens for basic user credentials.
	 *
	 * Check the supplied username and password for validity.
	 *
	 * You can also use the $client_id param to do any checks required based
	 * on a client, if you need that.
	 *
	 * Required for OAuth2::GRANT_TYPE_USER_CREDENTIALS.
	 *
	 * @param $client_id
	 * Client identifier to be check with.
	 * @param $username
	 * Username to be check with.
	 * @param $password
	 * Password to be check with.
	 *
	 * @return
	 * TRUE if the username and password are valid, and FALSE if it isn't.
	 * Moreover, if the username and password are valid, and you want to
	 * verify the scope of a user's access, return an associative array
	 * with the scope values as below. We'll check the scope you provide
	 * against the requested scope before providing an access token:
	 * @code
	 * return array(
	 * 'scope' => <stored scope values (space-separated string)>,
	 * );
	 * @endcode
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.3
	 *
	 * @ingroup oauth2_section_4
	 */
	public function checkUserCredentials(IOAuth2GrantUser $storage, $client_id, $username, $password)
    {
        $clientInfo = $storage->getClientDetails($client_id);
        if ( $clientInfo === false ) {
            return false;
        }

        // Is just a regular Sugar User
        $auth = AuthenticationController::getInstance();
        // noHooks since we'll take care of the hooks on API level, to make it more generalized
        $loginSuccess = $auth->login($username,$password,array('passwordEncrypted'=>false,'noRedirect'=>true, 'noHooks'=>true));
        if ( $loginSuccess && !empty($auth->nextStep) ) {
            // Set it here, and then load it in to the session on the next pass
            // TODO: How do we pass the next required step to the client via the REST API?
            $GLOBALS['nextStep'] = $auth->nextStep;
        }

        if ( $loginSuccess ) {
            $this->userBean = $this->loadUserFromName($username);
            return array('user_id' => $this->userBean->id);
        } else {
            if(!empty($_SESSION['login_error'])) {
                $message = $_SESSION['login_error'];
            } else {
                $message = null;
            }
            throw new SugarApiExceptionNeedLogin($message);
        }
    }
    // END METHODS FROM IOAuth2GrantUser

    /**
     * Loads the current user from the user name
     * split out so that portal can load users properly
     *
     * @param string $username The name of the user you want to load
     *
     * @return SugarBean The user from the name
     */
    public function loadUserFromName($username)
    {
		if (!empty($GLOBALS['current_user'])) {
        	return $GLOBALS['current_user'];
        } 
        $userBean = BeanFactory::newBean('Users');
        $userBean = $userBean->retrieve_by_string_fields(
            array(
                'user_name'=>$username,
                'deleted'=>'0',
                'status'=>'Active',
                'portal_only'=>'0',
                'is_group'=>'0',
            ));
        if (empty($userBean)) {
            throw new SugarApiExceptionNeedLogin();
        }
        return $userBean;
    }
}
