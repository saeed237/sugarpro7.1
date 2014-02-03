<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once 'data/BeanFactory.php';
require_once 'include/SugarFields/SugarFieldHandler.php';
require_once 'include/MetaDataManager/MetaDataManager.php';
require_once 'include/TimeDate.php';

class CurrentUserApi extends SugarApi
{
    /**
     * Hash of user preference indexes and their corresponding metadata index 
     * name. This is used in both the user pref setting in this class and in 
     * user preference setting in BWC mode. The list of preference indexes will
     * be used by the BWC implementation to determine whether the state of the 
     * user has changed so as to notify clients that they need to rerequest user
     * data.
     * 
     * @var array
     */
    protected $userPrefMeta = array(
        'timezone' => 'timezone',
        'datef' => 'datepref',
        'timef' => 'timepref',
        'currency' => 'currency',
        'signature_default' => 'signature_default',
        'signature_prepend' => 'signature_prepend',
        'email_link_type' => 'email_link_type',
        'default_locale_name_format' => 'default_locale_name_format',
    );

    const TYPE_ADMIN = "admin";
    const TYPE_USER = "user";

    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'path' => array('me',),
                'pathVars' => array(),
                'method' => 'retrieveCurrentUser',
                'shortHelp' => 'Returns current user',
                'longHelp' => 'include/api/help/me_get_help.html',
                'ignoreMetaHash' => true,
                'keepSession' => true,
                'ignoreSystemStatusError' => true,
            ),
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('me',),
                'pathVars' => array(),
                'method' => 'updateCurrentUser',
                'shortHelp' => 'Updates current user',
                'longHelp' => 'include/api/help/me_put_help.html',
            ),
            'updatePassword' =>  array(
                'reqType' => 'PUT',
                'path' => array('me','password'),
                'pathVars'=> array(''),
                'method' => 'updatePassword',
                'shortHelp' => "Updates current user's password",
                'longHelp' => 'include/api/help/me_password_put_help.html',
            ),
            'verifyPassword' =>  array(
                'reqType' => 'POST',
                'path' => array('me','password'),
                'pathVars'=> array(''),
                'method' => 'verifyPassword',
                'shortHelp' => "Verifies current user's password",
                'longHelp' => 'include/api/help/me_password_post_help.html',
            ),

            'userPreferences' =>  array(
                'reqType' => 'GET',
                'path' => array('me','preferences'),
                'pathVars'=> array(),
                'method' => 'userPreferences',
                'shortHelp' => "Returns all the current user's stored preferences",
                'longHelp' => 'include/api/help/me_preferences_get_help.html',
                'ignoreMetaHash' => true,
            ),

            'userPreferencesSave' =>  array(
                'reqType' => 'PUT',
                'path' => array('me','preferences'),
                'pathVars'=> array(),
                'method' => 'userPreferencesSave',
                'shortHelp' => "Mass Save Updated Preferences For a User",
                'longHelp' => 'include/api/help/me_preferences_put_help.html',
                'keepSession' => true,
            ),

            'userPreference' =>  array(
                'reqType' => 'GET',
                'path' => array('me','preference', '?'),
                'pathVars'=> array('', '', 'preference_name'),
                'method' => 'userPreference',
                'shortHelp' => "Returns a specific preference for the current user",
                'longHelp' => 'include/api/help/me_preference_preference_name_get_help.html',
            ),

            'userPreferenceCreate' =>  array(
                'reqType' => 'POST',
                'path' => array('me','preference', '?'),
                'pathVars'=> array('', '', 'preference_name'),
                'method' => 'userPreferenceSave',
                'shortHelp' => "Create a preference for the current user",
                'longHelp' => 'include/api/help/me_preference_preference_name_post_help.html',
                'keepSession' => true,
            ),
            'userPreferenceUpdate' =>  array(
                'reqType' => 'PUT',
                'path' => array('me','preference', '?'),
                'pathVars'=> array('', '', 'preference_name'),
                'method' => 'userPreferenceSave',
                'shortHelp' => "Update a specific preference for the current user",
                'longHelp' => 'include/api/help/me_preference_preference_name_put_help.html',
                'keepSession' => true,
            ),
            'userPreferenceDelete' =>  array(
                'reqType' => 'DELETE',
                'path' => array('me','preference', '?'),
                'pathVars'=> array('', '', 'preference_name'),
                'method' => 'userPreferenceDelete',
                'shortHelp' => "Delete a specific preference for the current user",
                'longHelp' => 'include/api/help/me_preference_preference_name_delete_help.html',
                'keepSession' => true,
            ),
        );
    }
    
    /**
     * Retrieves the current user info
     *
     * @param $api
     * @param $args
     * @return array
     */
    public function retrieveCurrentUser($api, $args)
    {
        $current_user = $this->getUserBean();

        // Get the basics
        $user_data = $this->getBasicUserInfo();

        if (isset($args['platform'])) {
            $platform = array(basename($args['platform']),'base');
        } else {
            $platform = array('base');
        }
        // Fill in the rest
        $user_data['type'] = self::TYPE_USER;
        if ($current_user->isAdmin()) {
            $user_data['type'] = self::TYPE_ADMIN;
        }
        $user_data['show_wizard'] = $this->shouldShowWizard();
        $user_data['id'] = $current_user->id;
        $current_user->_create_proper_name_field();
        $user_data['full_name'] = $current_user->full_name;
        $user_data['user_name'] = $current_user->user_name;
        $user_data['picture'] = $current_user->picture;
        $user_data['acl'] = $this->getAcls($platform);
        $user_data['is_manager'] = User::isManager($current_user->id);

        require_once 'modules/Teams/TeamSetManager.php';

        $teams = $current_user->get_my_teams();
        $my_teams = array();
        foreach ($teams as $id => $name) {
            $my_teams[] = array("id" => $id, "name" => $name,);
        }
        $user_data['my_teams'] = $my_teams;

        $defaultTeams = TeamSetManager::getTeamsFromSet($current_user->team_set_id);
        foreach ($defaultTeams as $id => $team) {
            $defaultTeams[$id]['primary'] = false;
            if ($team['id'] == $current_user->team_id) {
                $defaultTeams[$id]['primary'] = true;
            }
        }
        $user_data['preferences']['default_teams'] = $defaultTeams;

        // Send back a hash of this data for use by the client
        $user_data['_hash'] = $current_user->getUserMDHash();

        return array('current_user' => $user_data);
    }

    /**
     * Returns TRUE if a user needs to run through the setup wizard after install
     * Used when building $user_data['show_wizard']
     * @return bool TRUE if client should run wizard
     */
    public function shouldShowWizard()
    {
        $current_user = $this->getUserBean();
        $isInstanceConfigured = $current_user->getPreference('ut');
        return !filter_var($isInstanceConfigured, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Updates current user info
     *
     * @param $api
     * @param $args
     * @return array
     */
    public function updateCurrentUser($api, $args)
    {
        $bean = $this->getUserBean();

        // setting these for the loadBean
        $args['module'] = $bean->module_name;
        $args['record'] = $bean->id;

        $id = $this->updateBean($bean, $api, $args);

        return $this->retrieveCurrentUser($api, $args);
    }

    /**
     * Updates the current user's password
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionMissingParameter|SugarApiExceptionNotFound
     */
    public function updatePassword($api, $args)
    {
        $user_data['valid'] = false;

        // Deals with missing required args else assigns oldpass and new paswords
        if (empty($args['old_password']) || empty($args['new_password'])) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionMissingParameter('Error: Missing argument.');
        } else {
            $oldpass = $args['old_password'];
            $newpass = $args['new_password'];
        }

        $bean = $this->getUserIfPassword($oldpass);
        if (null !== $bean) {
            $change = $this->changePassword($bean, $oldpass, $newpass);
            if (!$change) {
                $user_data['message'] = 'Error: There was a problem updating password for this user.';
            } else {
                $user_data = array_merge($user_data, $change);
            }
        } else {
            $user_data['message'] = 'Error: Incorrect password.';
        }

        return $user_data;
    }

    /**
     * Verifies against the current user's password
     *
     * @param $api
     * @param $args
     * @return array
     */
    public function verifyPassword($api, $args)
    {
        $user_data['valid'] = false;

        // Deals with missing required args else assigns oldpass and new paswords
        if (empty($args['password_to_verify'])) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionMissingParameter('Error: Missing argument.');
        }

        // If the user password is good, send that messaging back
        if (!is_null($this->getUserIfPassword($args['password_to_verify']))) {
            $user_data['valid'] = true;
            $user_data['message'] = 'Password verified.';
            $user_data['expiration'] = $this->getUserLoginExpirationPreference();
        }

        return $user_data;
    }

    protected function getMetadataManager( $platform = 'base', $public = false)
    {
        $current_user = $this->getUserBean();

        return new MetaDataManager($current_user, $platform, $public);
    }

    /**
     * Gets acls given full module list passed in.
     * @param string The platform e.g. portal, mobile, base, etc.
     * @return array
     */
    public function getAcls($platform)
    {
        // in this case we should always have current_user be the user
        global $current_user;
        $mm = $this->getMetadataManager($platform);
        $fullModuleList = array_keys($GLOBALS['app_list_strings']['moduleList']);
        $acls = array();
        foreach ($fullModuleList as $modName) {
            $bean = BeanFactory::newBean($modName);
            if (!$bean || !is_a($bean,'SugarBean') ) {
                // There is no bean, we can't get data on this
                continue;
            }


            $acls[$modName] = $mm->getAclForModule($modName,$current_user);
            $acls[$modName] = $this->verifyACLs($acls[$modName]);
        }
        // Handle enforcement of acls for clients that override this (e.g. portal)
        $acls = $this->enforceModuleACLs($acls);

        return $acls;
    }

    /**
     * Manipulates the ACLs as needed, per client
     *
     * @param  array $acls
     * @return array
     */
    protected function verifyACLs(Array $acls)
    {
        // No manipulation for base acls
        return $acls;
    }

    /**
     * Enforces module specific ACLs for users without accounts, as needed
     *
     * @param  array $acls
     * @return array
     */
    protected function enforceModuleACLs(Array $acls)
    {
        // No manipulation for base acls
        return $acls;
    }

    /**
     * Checks a given password and sends back the user bean if the password matches
     *
     * @param  string $passwordToVerify
     * @return User
     */
    protected function getUserIfPassword($passwordToVerify)
    {
        $user = BeanFactory::getBean('Users', $GLOBALS['current_user']->id);
        $currentPassword = $user->user_hash;
        if (User::checkPassword($passwordToVerify, $currentPassword)) {
            return $user;
        }

        return null;
    }
    
    /**
     * Gets the list of fields that should trigger a user metadata change reauth
     *
     * @return array
     */
    public function getUserPrefsToCache()
    {
        return $this->userPrefMeta;
    }

    
    protected function getUserPref($user, $pref, $metaName) 
    {
        $method = 'getUserPref' . ucfirst($pref);
        if (method_exists($this, $method)) {
            return $this->$method($user);
        }
        
        return array($metaName => $user->getPreference($pref));
    }

    /**
     * Gets the user preference name by meta name.
     *
     * @param string $metaName
     * @return string
     */
    protected function getUserPreferenceName($metaName)
    {
        if(false !== $preferenceName = array_search($metaName, $this->userPrefMeta)) {
            return $preferenceName;
        }
        return $metaName;
    }

    /**
     * Gets the user's timezone setting
     * 
     * @param User $user The current user
     * @return string
     */
    protected function getUserPrefTimezone($user)
    {
        // Grab the user's timezone preference if it's set
        $val = $user->getPreference('timezone');

        $timeDate = TimeDate::getInstance();

        // If there is no setting for the user, fall back to the system setting
        if (!$val) {
            $val = $timeDate->guessTimezone();
        }

        // If there is still no timezone, fallback to UTC
        if (!$val) {
            $val = 'UTC';
        }

        $dateTime = new SugarDateTime();
        $timeDate->tzUser($dateTime, $user);
        $offset = $timeDate->getIsoOffset($dateTime,array('stripTZColon' => true));
        $offsetSec = $dateTime->getOffset();

        return array('timezone' => $val, 'tz_offset' => $offset, 'tz_offset_sec' => $offsetSec);
    }
    
    protected function getUserPrefCurrency($user)
    {
        global $locale;
        
        $currency = BeanFactory::getBean('Currencies');
        $currency_id = $user->getPreference('currency');
        $currency->retrieve($currency_id);
        $return['currency_id'] = $currency->id;
        $return['currency_name'] = $currency->name;
        $return['currency_symbol'] = $currency->symbol;
        $return['currency_iso'] = $currency->iso4217;
        $return['currency_rate'] = $currency->conversion_rate;
        
        // user number formatting prefs
        $return['decimal_precision'] = $locale->getPrecision();
        $return['decimal_separator'] = $locale->getDecimalSeparator();
        $return['number_grouping_separator'] = $locale->getNumberGroupingSeparator();
        
        return $return;
    }
    
    protected function getUserPrefSignature_default($user) 
    {
        // email signature preferences
        return array('signature_default' => $user->getDefaultSignature());
    }
    
    protected function getUserPrefSignature_prepend($user)
    {
        return array('signature_prepend' => $user->getPreference('signature_prepend') ? 'true' : 'false');
    }
    
    protected function getUserPrefEmail_link_type($user)
    {
        $useSugarEmailClient = ($user->getEmailClientPreference() === 'sugar');

        if ($useSugarEmailClient && !OutboundEmailConfigurationPeer::validSystemMailConfigurationExists($user)) {
            // even though the user's preference is to use the sugar email client, the user does not have a valid
            // outbound email configuration, so email must be sent from the user's email client
            $useSugarEmailClient = false;
        }

        return array('use_sugar_email_client' => ($useSugarEmailClient) ? 'true' : 'false');
    }
    
    protected function getUserPrefLanguage($user)
    {
        // use their current auth language if it exists
        if (!empty($_SESSION['authenticated_user_language'])) {
            $language = $_SESSION['authenticated_user_language'];
        } elseif (!empty($user->preferred_language)) {
            // if current auth language doesn't exist get their preferred lang from the user obj
            $language = $user->preferred_language;
        } else {
            // if nothing exists, get the sugar_config default language
            $language = $GLOBALS['sugar_config']['default_language'];
        }
        
        return array('language' => $language);
    }

    /**
     * Gets the basic user data that all users that are logged in will need. Client
     * specific user information will be filled in within the client API class.
     *
     * @return array
     */
    protected function getBasicUserInfo()
    {
        global $current_user;
        
        $this->forceUserPreferenceReload($current_user);
        
        $user_data['preferences'] = array();
        foreach ($this->userPrefMeta as $pref => $metaName) {
            // Twitterate this, since long lines are the devil
            $val = $this->getUserPref($current_user, $pref, $metaName);
            $user_data['preferences'] = array_merge($user_data['preferences'], $val);
        }
        
        // Handle timezones specially, the fallback is important
        $timezone = $this->getUserPrefTimezone($current_user);
        $user_data['preferences'] = array_merge($user_data['preferences'], $timezone);

        // Handle language on its own for now
        $lang = $this->getUserPrefLanguage($current_user);
        $user_data['preferences'] = array_merge($user_data['preferences'], $lang);
        
        // Set the user module list
        $user_data['module_list'] = $this->getModuleList();
        
        return $user_data;
    }

    /**
     * Gets the user bean for the user of the api
     *
     * @return User
     */
    protected function getUserBean()
    {
        global $current_user;

        return $current_user;
    }

    /**
     * Changes a password for a user from old to new
     *
     * @param  User   $bean User bean
     * @param  string $old  Old password
     * @param  string $new  New password
     * @return array
     */
    protected function changePassword($bean, $old, $new)
    {
        if ($bean->change_password($old, $new)) {
            return array(
                'valid' => true,
                'message' => 'Password updated.',
                'expiration' => $bean->getPreference('loginexpiration'),
            );
        }

        return array();
    }

    /**
     * Gets the preference for user login expiration
     *
     * @return string
     */
    protected function getUserLoginExpirationPreference()
    {
        global $current_user;

        return $current_user->getPreference('loginexpiration');
    }

    /**
     * Return all the current users preferences
     *
     * @param  RestService $api  Api Service
     * @param  array       $args Array of arguments from the rest call
     * @return mixed       User Preferences, if the category exists.  If it doesn't then return an empty array
     */
    public function userPreferences($api, $args)
    {
        $current_user = $this->getUserBean();

        $category = 'global';
        if (isset($args['category'])) {
            $category = $args['category'];
        }
        $this->forceUserPreferenceReload($current_user);

        $prefs = (isset($current_user->user_preferences[$category])) ?
                        $current_user->user_preferences[$category] :
                        array();

        return $prefs;
    }
    /**
     * Update multiple user preferences at once
     *
     * @param  RestService $api  Api Service
     * @param  array       $args Array of arguments from the rest call
     * @return mixed       Return the updated keys with their values
     */
    public function userPreferencesSave($api, $args)
    {
        $current_user = $this->getUserBean();

        $category = 'global';
        if (isset($args['category'])) {
            $category = $args['category'];
            unset($args['category']);
        }

        // set each of the args in the array
        foreach ($args as $key => $value) {
            $preferenceName = $this->getUserPreferenceName($key);
            $current_user->setPreference($preferenceName, $value, 0, $category);
        }

        // save the preferences to the db
        $current_user->save();
        $args['_hash'] = $current_user->getUserMDHash();
        return $args;
    }

    /**
     * Return a specific preference for the key that was passed in.
     *
     * @param  RestService $api
     * @param  array       $args
     * @return mixed
     * @return mixed
     */
    public function userPreference($api, $args)
    {
        $current_user = $this->getUserBean();

        $category = 'global';
        if (isset($args['category'])) {
            $category = $args['category'];
        }
        $this->forceUserPreferenceReload($current_user);

        $pref = $current_user->getPreference($args['preference_name'], $category);

        return (!is_null($pref)) ? $pref : "";
    }

    /**
     * Update a preference.  The key is part of the url and the value comes from the value $args variable
     *
     * @param  RestService $api
     * @param  array       $args
     * @return array
     */
    public function userPreferenceSave($api, $args)
    {
        $current_user = $this->getUserBean();

        $category = 'global';
        if (isset($args['category'])) {
            $category = $args['category'];
        }

        $preferenceName = $this->getUserPreferenceName($args['preference_name']);

        $current_user->setPreference($preferenceName, $args['value'], 0, $category);
        $current_user->save();

        return array($preferenceName => $args['value']);
    }

    /**
     * Delete a preference.  Since there is no way to actually delete with out resetting the whole category, we just
     * set the value of the key = null.
     *
     * @param  RestService $api
     * @param  array       $args
     * @return mixed
     */
    public function userPreferenceDelete($api, $args)
    {
        $current_user = $this->getUserBean();

        $category = 'global';
        if (isset($args['category'])) {
            $category = $args['category'];
        }

        $preferenceName = $this->getUserPreferenceName($args['preference_name']);

        $current_user->setPreference($preferenceName, null, 0, $category);
        $current_user->save();

        return $preferenceName;
    }

    /**
     * Gets display module list per user defined tabs
     * @return array
     */
    public function getModuleList()
    {
        $current_user = $this->getUserBean();
        // Loading a standard module list
        require_once 'modules/MySettings/TabController.php';
        $controller = new TabController();
        $moduleList = $this->list2Array(reset($controller->get_tabs($current_user)));
        return $moduleList;
    }
    /**
     * Filters a list of modules against the display modules
     * @param $moduleList
     * @return array
     */
    protected function filterDisplayModules($moduleList)
    {
        $current_user = $this->getUserBean();
        // Loading a standard module list
        require_once 'modules/MySettings/TabController.php';
        $controller = new TabController();
        $ret = array_intersect_key($controller->get_user_tabs($current_user), $moduleList);

        return $this->list2Array($ret);

    }

    /**
     * converts hash into flat array preserving order
     * @param $ret
     * @return array
     */
    public function list2Array($ret)
    {
        $output = array();
        foreach ($ret as $mod => $lbl) {
            $output[] = $mod;
        }

        return $output;
    }
    
    /**
     * Forces a fresh fetching of user preferences.
     * 
     * User preferences are written to the users session, so when an admin changes
     * a preference for a user, that user won't get the change until they logout.
     * This forces a fresh fetching of a users preferences from the DB when called.
     * This shouldn't be too expensive of a hit since user preferences need only
     * be fetched once and can be stored on the client.
     * 
     * @param User $current_user A User bean
     */
    public function forceUserPreferenceReload($current_user)
    {
        // If there is a unique_key in the session, save it and change it so that
        // loadPreferences() on the user will be forced to collect a fresh set
        // of preferences.
        $uniqueKey = null;
        if (isset($_SESSION['unique_key'])) {
            $uniqueKey = $_SESSION['unique_key'];
            $_SESSION['unique_key'] = 't_' . time();
        }
        
        $current_user->loadPreferences();
        
        // Set this back to what it was
        $_SESSION['unique_key'] = $uniqueKey;
    }
}
