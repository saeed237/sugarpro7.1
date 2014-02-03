<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
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


require_once ('modules/ModuleBuilder/parsers/ModuleBuilderParser.php');

class ParserModifyPortalConfig extends ModuleBuilderParser
{

    /**
     * Constructor
     */
    function init()
    {
    }

    /**
     * handles portal config save and creating of portal users
     */
    function handleSave()
    {
        $portalFields = array('appStatus', 'defaultUser', 'appName', 'logoURL', 'serverUrl', 'maxQueryResult', 'maxSearchQueryResult');
        $portalConfig = array(
            'platform' => 'portal',
            'debugSugarApi' => true,
            'logLevel' => 'ERROR',
            'logWriter' => 'ConsoleWriter',
            'logFormatter' => 'SimpleFormatter',
            'metadataTypes' => array(),
            'displayModules' => array(
                'Home',
                'Bugs',
                'Cases',
                'KBDocuments'
            ),
            'serverTimeout' => 30,
            'defaultModule' => 'Cases',
            'orderByDefaults' => array(
                'Cases' => array(
                    'field' => 'case_number',
                    'direction' => 'desc'
                ),
                'Bugs' => array(
                    'field' => 'bug_number',
                    'direction' => 'desc'
                ),
                'Notes' => array(
                    'field' => 'date_modified',
                    'direction' => 'desc'
                ),
                'KBDocuments' => array(
                    'field' => 'date_modified',
                    'direction' => 'desc'
                )
            )
        );
        if (inDeveloperMode()) {
            $portalConfig['logLevel'] = 'DEBUG';
        }
        foreach ($portalFields as $field) {
            if (isset($_REQUEST[$field])) {
                $portalConfig[$field] = $_REQUEST[$field];
            }
        }

        //Get the current portal status because if it has changed we need to clear the base metadata
        $admin = Administration::getSettings();
        $wasActive = !empty($admin->settings['portal_on']);
        if (isset($portalConfig['appStatus']) && $portalConfig['appStatus'] == 'true') {
            $portalConfig['appStatus'] = 'online';
            $portalConfig['on'] = 1;
            //Clear the base metadata if portal was not active
            $clearBaseMetadata = !$wasActive;
        } else {
            $portalConfig['appStatus'] = 'offline';
            $portalConfig['on'] = 0;
            //Clear the base metadata if portal was active
            $clearBaseMetadata = $wasActive;
        }
        //TODO: Remove after we resolve issues with test associated to this
        $GLOBALS['log']->info("Updating portal config");
        foreach ($portalConfig as $fieldKey => $fieldValue) {

            if(!$GLOBALS ['system_config']->saveSetting('portal', $fieldKey, json_encode($fieldValue), 'support')){
                $GLOBALS['log']->fatal("Error saving portal config var $fieldKey, orig: $fieldValue , json:".json_encode($fieldValue));
            }

        }

        $cachedBasePrivateMetadata = sugar_cached('api/metadata/metadata_base_private.php');
        $cachedPublicMetadata = sugar_cached('api/metadata/metadata_portal_public.php');
        $cachedPrivateMetadata = sugar_cached('api/metadata/metadata_portal_private.php');
        // Clear the cached public and private metadata files
        if ($clearBaseMetadata && file_exists($cachedBasePrivateMetadata)) {
            unlink($cachedBasePrivateMetadata);
        }
        if (file_exists($cachedPublicMetadata))
            unlink($cachedPublicMetadata);
        if (file_exists($cachedPrivateMetadata))
            unlink($cachedPrivateMetadata);

        // Verify the existence of the javascript config file
        if (!file_exists('portal2/config.js')) {
            require_once 'ModuleInstall/ModuleInstaller.php';
            ModuleInstaller::handlePortalConfig();
        }

        // Clear the Contacts file b/c portal flag affects rendering
        if (file_exists($cachedfile = sugar_cached('modules/Contacts/EditView.tpl')))
            unlink($cachedfile);

        if (isset($portalConfig['on']) && $portalConfig['on'] == 1) {
            $u = $this->getPortalUser();
            $role = $this->getPortalACLRole();

            if (!($u->check_role_membership($role->name))) {
                $u->load_relationship('aclroles');
                $u->aclroles->add($role);
                $u->save();
            }
        } else {
            $this->removeOAuthForPortalUser();
        }

    }

    /**
     * Creates Portal User
     * @return User
     */
    function removeOAuthForPortalUser()
    {
        // Try to retrieve the portal user. If exists, check for
        // corresponding oauth2 and mark deleted.
        $portalUserName = "SugarCustomerSupportPortalUser";
        $id = User::retrieve_user_id($portalUserName);
        if ($id) {
            $clientSeed = BeanFactory::newBean('OAuthKeys');
            $clientBean = $clientSeed->fetchKey('support_portal', 'oauth2');
            if ($clientBean) {
                $clientSeed->mark_deleted($clientBean->id);
            }
        }
    }
        
    /**
     * Creates Portal User
     * @return User
     */
    function getPortalUser()
    {
        $portalUserName = "SugarCustomerSupportPortalUser";
        $id = User::retrieve_user_id($portalUserName);
        if (!$id) {
            $user = BeanFactory::getBean('Users');
            $user->user_name = $portalUserName;
            $user->title = 'Sugar Customer Support Portal User';
            $user->description = $user->title;
            $user->first_name = "";
            $user->last_name = $user->title;
            $user->status = 'Active';
            $user->receive_notifications = 0;
            $user->is_admin = 0;
            $random = time() . mt_rand();
            $user->authenicate_id = md5($random);
            $user->user_hash = User::getPasswordHash($random);
            $user->default_team = '1';
            $user->created_by = '1';
            $user->portal_only = '1';
            $user->save();
            $id = $user->id;

            // set user id in system settings
            $GLOBALS ['system_config']->saveSetting('supportPortal', 'RegCreatedBy', $id);
        }
        $this->createOAuthForPortalUser();
        $resultUser = BeanFactory::getBean('Users', $id);
        return $resultUser;
    }

    // Make the oauthkey record for this portal user now if it doesn't exists
    function createOAuthForPortalUser() 
    {
        $clientSeed = BeanFactory::newBean('OAuthKeys');
        $clientBean = $clientSeed->fetchKey('support_portal', 'oauth2');
        if (!$clientBean) {
            $newKey = BeanFactory::newBean('OAuthKeys');
            $newKey->oauth_type = 'oauth2';
            $newKey->c_secret = '';
            $newKey->client_type = 'support_portal';
            $newKey->c_key = 'support_portal';
            $newKey->name = 'OAuth Support Portal Key';
            $newKey->description = 'This OAuth key is automatically created by the OAuth2.0 system to enable logins to the serf-service portal system in Sugar.';
            $newKey->save();
        }
    }

    /**
     * Creates Portal role and sets ACLS
     * @return ACLRole
     */
    function getPortalACLRole()
    {
        global $mod_strings;
        $allowedModules = array('Bugs', 'Cases', 'Notes', 'KBDocuments', 'Contacts');
        $allowedActions = array('edit', 'admin', 'access', 'list', 'view');
        $role = BeanFactory::getBean('ACLRoles');
        $role->retrieve_by_string_fields(array('name' => 'Customer Self-Service Portal Role'));
        if (empty($role->id)) {
            $role->name = "Customer Self-Service Portal Role";
            $role->description = $mod_strings['LBL_PORTAL_ROLE_DESC'];
            $role->save();
            $roleActions = $role->getRoleActions($role->id);
            foreach ($roleActions as $moduleName => $actions) {
                // enable allowed moduels
                if (isset($actions['module']['access']['id']) && !in_array($moduleName, $allowedModules)) {
                    $role->setAction($role->id, $actions['module']['access']['id'], ACL_ALLOW_DISABLED);
                } elseif (isset($actions['module']['access']['id']) && in_array($moduleName, $allowedModules)) {
                    $role->setAction($role->id, $actions['module']['access']['id'], ACL_ALLOW_ENABLED);
                } else {
                    foreach ($actions as $action => $actionName) {
                        if (isset($actions[$action]['access']['id'])) {
                            $role->setAction($role->id, $actions[$action]['access']['id'], ACL_ALLOW_DISABLED);
                        }
                    }
                }
                if (in_array($moduleName, $allowedModules)) {
                    $role->setAction($role->id, $actions['module']['access']['id'], ACL_ALLOW_ENABLED);
                    $role->setAction($role->id, $actions['module']['admin']['id'], ACL_ALLOW_ALL);
                    foreach ($actions['module'] as $actionName => $action) {
                        if (in_array($actionName, $allowedActions)) {
                            $aclAllow = ACL_ALLOW_ALL;
                        } else {
                            $aclAllow = ACL_ALLOW_NONE;
                        }
                        if ($moduleName == 'KBDocuments' && $actionName == 'edit') {
                            $aclAllow = ACL_ALLOW_NONE;
                        }
                        if ($moduleName == 'Contacts') {
                            if ($actionName == 'edit' || $actionName == 'view') {
                                $aclAllow = ACL_ALLOW_OWNER;
                            } else {
                                $aclAllow = ACL_ALLOW_NONE;
                            }

                        }
                        if ($actionName != 'access') {
                            $role->setAction($role->id, $action['id'], $aclAllow);
                        }

                    }
                }
            }
        }
        return $role;
    }

}

?>
