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

require_once('clients/base/api/ModuleApi.php');

class ConfigModuleApi extends ModuleApi
{
    /**
     * Setup the endpoint that belong to this API EndPoint
     *
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'config' => array(
                'reqType' => 'GET',
                'path' => array('<module>', 'config'),
                'pathVars' => array('module', ''),
                'method' => 'config',
                'shortHelp' => 'Retrieves the config settings for a given module',
                'longHelp' => 'include/api/help/module_config_get_help.html',
            ),
            'configCreate' => array(
                'reqType' => 'POST',
                'path' => array('<module>', 'config'),
                'pathVars' => array('module', ''),
                'method' => 'configSave',
                'shortHelp' => 'Creates the config entries for the given module',
                'longHelp' => 'include/api/help/module_config_post_help.html',
            ),
            'configUpdate' => array(
                'reqType' => 'PUT',
                'path' => array('<module>', 'config'),
                'pathVars' => array('module', ''),
                'method' => 'configSave',
                'shortHelp' => 'Updates the config entries for given module',
                'longHelp' => 'include/api/help/module_config_put_help.html',
            ),
        );
    }

    /**
     * Returns the config settings for the given module
     *
     * @throws SugarApiExceptionNotAuthorized
     * @param ServiceBase $api
     * @param $args 'module' is required, 'platform' is optional and defaults to 'base'
     * @return array
     */
    public function config(ServiceBase $api, $args)
    {
        $this->requireArgs($args, array('module'));
        $seed = BeanFactory::newBean($args['module']);
        $adminBean = BeanFactory::getBean("Administration");

        //acl check
        if (!$seed->ACLAccess('access')) {
            // No create access so we construct an error message and throw the exception
            $moduleName = null;
            if (isset($args['module'])) {
                $failed_module_strings = return_module_language($GLOBALS['current_language'], $args['module']);
                $moduleName = $failed_module_strings['LBL_MODULE_NAME'];
            }
            $args = null;
            if (!empty($moduleName)) {
                $args = array('moduleName' => $moduleName);
            }
            throw new SugarApiExceptionNotAuthorized(
                $GLOBALS['app_strings']['EXCEPTION_ACCESS_MODULE_CONFIG_NOT_AUTHORIZED'],
                $args
            );
        }

        if (!empty($args['module'])) {
            return $adminBean->getConfigForModule($args['module'], $api->platform);
        }
        return;
    }

    /**
     * Save function for the config settings for a given module.
     *
     * @throws SugarApiExceptionNotAuthorized
     * @param ServiceBase $api
     * @param array $args           'module' is required, 'platform' is optional and defaults to 'base'
     * @return array
     */
    public function configSave(ServiceBase $api, $args)
    {
        $this->requireArgs($args, array('module'));

        $module = $args['module'];

        // these are not part of the config values, so unset
        unset($args['module']);
        unset($args['__sugar_url']);

        //acl check, only allow if they are module admin
        if (!$api->user->isAdmin() && !$api->user->isDeveloperForModule($module)) {
            // No create access so we construct an error message and throw the exception
            $failed_module_strings = return_module_language($GLOBALS['current_language'], $module);
            $moduleName = $failed_module_strings['LBL_MODULE_NAME'];

            $args = null;
            if (!empty($moduleName)) {
                $args = array('moduleName' => $moduleName);
            }

            throw new SugarApiExceptionNotAuthorized(
                $GLOBALS['app_strings']['EXCEPTION_CHANGE_MODULE_CONFIG_NOT_AUTHORIZED'],
                $args
            );
        }

        $admin = BeanFactory::getBean('Administration');

        foreach ($args as $name => $value) {
            if (is_array($value)) {
                $admin->saveSetting($module, $name, json_encode($value), $api->platform);
            } else {
                $admin->saveSetting($module, $name, $value, $api->platform);
            }
        }

        MetaDataManager::clearAPICache();

        return $admin->getConfigForModule($module, $api->platform);
    }
}
