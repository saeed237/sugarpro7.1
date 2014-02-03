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

interface SugarOAuth2StorageInterface {
    /**
     * Get the user type for this user
     * 
     * @return string
     */
    public function getUserType();
    
    /**
     * Gets a user bean 
     * 
     * @param  string $user_id The ID of the User to get
     * @return User
     */
    public function getUserBean($user_id);

    /**
     * Small validator for child classes to use to determine whether a session can
     * be written to
     * 
     * @return boolean
     */
    public function canStartSession();

    /**
     * Fills in any added session data needed by this client type
     * 
     * This method is used by child classes like portal
     */
    public function fillInAddedSessionData();

    /**
     * Gets the authentication bean for a given client
     * 
     * @param OAuthToken
     * @return mixed
     */
    public function getAuthBean(OAuthToken $token);

    /**
     * Gets contact and user ids for a user id. Most commonly different for clients
     * like portal
     * 
     * @param string $user_id The ID of the user this is for
     * @param string $client_id The client id for this check
     * @return array An array of contact_id and user_id
     */
    public function getIdsForUser($user_id, $client_id);

    /**
     * Sets up necessary visibility for a client. Not all clients will set this
     * 
     * @return void
     */
    public function setupVisibility();
}