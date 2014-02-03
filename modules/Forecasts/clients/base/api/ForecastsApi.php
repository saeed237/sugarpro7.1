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

require_once 'include/api/SugarApi.php';
require_once 'modules/Forecasts/ForecastsDefaults.php';

class ForecastsApi extends SugarApi
{
    public function registerApiRest()
    {
        $parentApi = array(
            'init' => array(
                'reqType' => 'GET',
                'path' => array('Forecasts','init'),
                'pathVars' => array(),
                'method' => 'forecastsInitialization',
                'shortHelp' => 'Returns forecasts initialization data and additional user data',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastsApiInitGet.html',
            ),
            'selecteUserObject' => array(
                'reqType' => 'GET',
                'path' => array('Forecasts', 'user', '?'),
                'pathVars' => array('', '', 'user_id'),
                'method' => 'retrieveSelectedUser',
                'shortHelp' => 'Returns selectedUser object for given user',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastsApiUserGet.html',
            ),
            'timeperiod' => array(
                'reqType' => 'GET',
                'path' => array('Forecasts', 'enum', 'selectedTimePeriod'),
                'pathVars' => array('', '', ''),
                'method' => 'timeperiod',
                'shortHelp' => 'forecast timeperiod',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastApiTimePeriodGet.html',
            ),
            'reportees' => array(
                'reqType' => 'GET',
                'path' => array('Forecasts', 'reportees', '?'),
                'pathVars' => array('', '', 'user_id'),
                'method' => 'getReportees',
                'shortHelp' => 'Gets reportees to a user by id',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastApiReporteesGet.html',
            ),
            'list' => array(
                'reqType' => 'GET',
                'path' => array('Forecasts',),
                'pathVars' => array('module'),
                'method' => 'returnEmptySet',
                'shortHelp' => 'Forecast list endpoint returns an empty set',
                'longHelp' => 'include/api/help/module_record_favorite_put_help.html',
            ),
            'getQuotaRollup' => array(
                'reqType' => 'GET',
                'path'      => array('Forecasts', '?', 'quotas', 'rollup', '?'),
                'pathVars'  => array('', 'timeperiod_id', '', 'quota_type', 'user_id'),
                'method' => 'getQuota',
                'shortHelp' => 'Returns the rollup quota for the user by timeperiod',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastsQuotasApiGet.html',
            ),
            'getQuotaDirect' => array(
                'reqType' => 'GET',
                'path'      => array('Forecasts', '?', 'quotas', 'direct', '?'),
                'pathVars'  => array('', 'timeperiod_id', '', 'quota_type', 'user_id'),
                'method' => 'getQuota',
                'shortHelp' => 'Returns the direct quota for the user by timeperiod',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastsQuotasApiGet.html',
            ),
        );
        return $parentApi;
    }

    /**
     * Returns an empty set for favorites and filter because those operations on forecasts are impossible
     * @param $api
     * @param $args
     * @return array
     */
    public function returnEmptySet($api, $args) {
        return array('next_offset' => -1, 'records' => array());
    }
    /**
     * Returns the initialization data for the module including currently logged-in user data,
     * timeperiods, and admin config settings
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function forecastsInitialization($api, $args) {
        global $current_user;

        if(!SugarACL::checkAccess('Forecasts', 'access')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $returnInitData = array();
        $defaultSelections = array();

        // Add Forecasts-specific items to returned data
        $returnInitData["initData"]["userData"]['isManager'] = User::isManager($current_user->id);
        $returnInitData["initData"]["userData"]['showOpps'] = false;
        $returnInitData["initData"]["userData"]['first_name'] = $current_user->first_name;
        $returnInitData["initData"]["userData"]['last_name'] = $current_user->last_name;

        // INVESTIGATE: these need to be more dynamic and deal with potential customizations based on how filters are built in admin and/or studio
        /* @var $admin Administration */
        $admin = BeanFactory::getBean("Administration");
        $forecastsSettings = $admin->getConfigForModule("Forecasts", "base");
        // we need to make sure all the default setting are there, if they are not
        // it should set them to the default value + clear the metadata and kick out a 412 error to force
        // the metadata to reload
        $this->compareSettingsToDefaults($admin, $forecastsSettings, $api);

        // TODO: These should probably get moved in with the config/admin settings, or by themselves since this file will probably going away.
        $tp = TimePeriod::getCurrentTimePeriod($forecastsSettings['timeperiod_leaf_interval']);
        if (!empty($tp->id)) {
            $defaultSelections["timeperiod_id"] = array(
                'id' => $tp->id,
                'label' => $tp->name
            );
        } else {
            $defaultSelections["timeperiod_id"]["id"] = '';
            $defaultSelections["timeperiod_id"]["label"] = '';
        }

        $returnInitData["initData"]['forecasts_setup'] = (isset($forecastsSettings['is_setup'])) ? $forecastsSettings['is_setup'] : 0;

        $defaultSelections["ranges"] = array("include");
        $defaultSelections["group_by"] = 'forecast';
        $defaultSelections["dataset"] = 'likely';

        // push in defaultSelections
        $returnInitData["defaultSelections"] = $defaultSelections;

        return $returnInitData;
    }

    /**
     * Retrieves user data for a given user id
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function retrieveSelectedUser(ServiceBase $api, $args)
    {
        global $locale;
        $uid = $args['user_id'];
        /* @var $user User */
        $user = BeanFactory::getBean('Users', $uid);
        $data = array();
        $data['id'] = $user->id;
        $data['user_name'] = $user->user_name;
        $data['full_name'] = $locale->getLocaleFormattedName($user->first_name, $user->last_name);
        $data['first_name'] = $user->first_name;
        $data['last_name'] = $user->last_name;
        $data['isManager'] = User::isManager($user->id);
        return $data;
    }

    /**
     * Return the dom of the current timeperiods.
     *
     * //TODO, move this logic to store the values in a custom language file that contains the timeperiods for the Forecast module
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return array of timeperiods
     */
    public function timeperiod($api, $args)
    {
        // base file and class name
        $file = 'include/SugarForecasting/Filter/TimePeriodFilter.php';
        $klass = 'SugarForecasting_Filter_TimePeriodFilter';

        // check for a custom file exists
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);
        // create the class

        /* @var $obj SugarForecasting_AbstractForecast */
        $obj = new $klass($args);
        return $obj->process();
    }

    /**
     * Retrieve an array of Users and their tree state that report to the user that was passed in
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return array|string of users that reported to specified/current user
     */
    public function getReportees($api, $args)
    {
        $args['user_id'] = isset($args["user_id"]) ? $args["user_id"] : $GLOBALS["current_user"]->id;
        $args['level'] = isset($args['level']) ? (int) $args['level'] : 1;

        // base file and class name
        $file = 'include/SugarForecasting/ReportingUsers.php';
        $klass = 'SugarForecasting_ReportingUsers';

        // check for a custom file exists
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);
        // create the class

        /* @var $obj SugarForecasting_AbstractForecast */
        $obj = new $klass($args);
        $reportees = $obj->process();
        
        if (($args['level'] < 0 || $args['level'] > 1)) {
            // may contain parent
            $children = isset($reportees['children']) ? $reportees['children'] : $reportees[1]['children'];
            
            foreach ($children as &$child) {
                if ($child['metadata']['id'] != $args['user_id']) {
                    $childArgs = $args;
                    $childArgs['user_id'] = $child['metadata']['id'];
                    $childArgs['level'] = $args['level'] - 1;
                    $childReportees = $this->getReportees($api, $childArgs);
                    $child['children'] = isset($childReportees['children']) ? $childReportees['children'] : $childReportees[1]['children'];
                }
            }
            
            isset($reportees['children']) ? $reportees['children'] = $children : $reportees[1]['children'] = $children;
        }

        return $reportees;
    }

    /**
     * @param Administration $admin
     * @param array $forecastsSettings
     * @param RestService $api
     * @throws SugarApiExceptionInvalidHash
     */
    protected function compareSettingsToDefaults(Administration $admin, $forecastsSettings, $api)
    {
        $defaultConfig = ForecastsDefaults::getDefaults();
        $missing_config = array_diff(array_keys($defaultConfig), array_keys($forecastsSettings));
        if (!empty($missing_config)) {
            foreach ($missing_config as $config) {
                $val = $defaultConfig[$config];
                if (is_array($val)) {
                    $val = json_encode($val);
                }
                $admin->saveSetting('Forecasts', $config, $val, $api->platform);
            }
            MetaDataManager::clearAPICache();
            throw new SugarApiExceptionInvalidHash();
        }
    }

    /**
     * Returns the Quota for a given timeperiod_id, user_id, and quota_type
     *
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function getQuota($api, $args) {
        if(!SugarACL::checkAccess('Quotas', 'access')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        /* @var $quotaBean Quota */
        $quotaBean = BeanFactory::getBean('Quotas');

        $isRollup = ($args['quota_type'] == 'rollup');

        // add the manager's rollup quota to the data returned
        $data = $quotaBean->getRollupQuota($args['timeperiod_id'], $args['user_id'], $isRollup);

        // add if the manager is a top-level manager or not
        $data['isTopLevelManager'] = User::isTopLevelManager($args['user_id']);

        return $data;
    }
}
