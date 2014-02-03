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

require_once('clients/base/api/ConfigModuleApi.php');

class ForecastsConfigApi extends ConfigModuleApi
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function registerApiRest()
    {
        return
            array(
                'forecastsConfigGet' => array(
                    'reqType' => 'GET',
                    'path' => array('Forecasts', 'config'),
                    'pathVars' => array('module', ''),
                    'method' => 'config',
                    'shortHelp' => 'Retrieves the config settings for a given module',
                    'longHelp' => 'include/api/help/config_get_help.html',
                ),
                'forecastsConfigCreate' => array(
                    'reqType' => 'POST',
                    'path' => array('Forecasts', 'config'),
                    'pathVars' => array('module', ''),
                    'method' => 'forecastsConfigSave',
                    'shortHelp' => 'Creates the config entries for the Forecasts module.',
                    'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastsConfigPut.html',
                ),
                'forecastsConfigUpdate' => array(
                    'reqType' => 'PUT',
                    'path' => array('Forecasts', 'config'),
                    'pathVars' => array('module', ''),
                    'method' => 'forecastsConfigSave',
                    'shortHelp' => 'Updates the config entries for the Forecasts module',
                    'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastsConfigPut.html',
                ),
            );
    }

    /**
     * Forecast Override since we have custom logic that needs to be ran
     *
     * {@inheritdoc}
     */
    public function forecastsConfigSave(ServiceBase $api, array $args)
    {
        //acl check, only allow if they are module admin
        if (!$api->user->isAdmin() && !$api->user->isDeveloperForModule('Forecasts')) {
            // No create access so we construct an error message and throw the exception
            $failed_module_strings = return_module_language($GLOBALS['current_language'], 'forecasts');
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
        //track what settings have changed to determine if timeperiods need rebuilt
        $prior_forecasts_settings = $admin->getConfigForModule('Forecasts', $api->platform);

        //If this is a first time setup, default prior settings for timeperiods to 0 so we may correctly recalculate
        //how many timeperiods to build forward and backward.  If we don't do this we would need the defaults to be 0
        if (empty($prior_forecasts_settings['is_setup'])) {
            $prior_forecasts_settings['timeperiod_shown_forward'] = 0;
            $prior_forecasts_settings['timeperiod_shown_backward'] = 0;
        }

        $upgraded = 0;
        if (!empty($prior_forecasts_settings['is_upgrade'])) {
            $db = DBManagerFactory::getInstance();
            // check if we need to upgrade opportunities when coming from version below 6.7.x.
            $upgraded = $db->getOne(
                "SELECT count(id) as total FROM upgrade_history
                    WHERE type = 'patch' AND status = 'installed' AND version LIKE '6.7.%';"
            );
            if ($upgraded == 1) {
                //TODO-sfa remove this once the ability to map buckets when they get changed is implemented (SFA-215).
                $args['has_commits'] = true;
            }
        }


        if ($upgraded || empty($prior_forecasts_settings['is_setup'])) {
            require_once('modules/UpgradeWizard/uw_utils.php');
            updateOpportunitiesForForecasting();
        }

        // we do the double check here since the front ent will send one one value if the input is empty
        if (empty($args['worksheet_columns']) || empty($args['worksheet_columns'][0])) {
            // set the defaults
            $args['worksheet_columns'] = array(
                'commit_stage',
                'parent_name',
                'likely_case',
            );
            if ($args['show_worksheet_best'] == 1) {
                $args['worksheet_columns'][] = 'best_case';
            }
            if ($args['show_worksheet_worst'] == 1) {
                $args['worksheet_columns'][] = 'worst_case';
            }
        }

        //reload the settings to get the current settings
        $current_forecasts_settings = parent::configSave($api, $args);

        // did this change?
        if ($prior_forecasts_settings['worksheet_columns'] !== $args['worksheet_columns']) {
            $this->setWorksheetColumns($api, $args['worksheet_columns'], $current_forecasts_settings['forecast_by']);
        }

        //if primary settings for timeperiods have changed, then rebuild them
        if ($this->timePeriodSettingsChanged($prior_forecasts_settings, $current_forecasts_settings)) {
            $timePeriod = TimePeriod::getByType($current_forecasts_settings['timeperiod_interval']);
            $timePeriod->rebuildForecastingTimePeriods($prior_forecasts_settings, $current_forecasts_settings);
        }
        return $current_forecasts_settings;
    }

    /**
     * Compares two sets of forecasting settings to see if the primary timeperiods settings are the same
     *
     * @param array $priorSettings              The Prior Settings
     * @param array $currentSettings            The New Settings Coming from the Save
     *
     * @return boolean
     */
    public function timePeriodSettingsChanged($priorSettings, $currentSettings)
    {
        if (!isset($priorSettings['timeperiod_shown_backward']) ||
            (isset($currentSettings['timeperiod_shown_backward']) &&
                ($currentSettings['timeperiod_shown_backward'] != $priorSettings['timeperiod_shown_backward'])
            )
        ) {
            return true;
        }
        if (!isset($priorSettings['timeperiod_shown_forward']) ||
            (isset($currentSettings['timeperiod_shown_forward']) &&
                ($currentSettings['timeperiod_shown_forward'] != $priorSettings['timeperiod_shown_forward'])
            )
        ) {
            return true;
        }
        if (!isset($priorSettings['timeperiod_interval']) ||
            (isset($currentSettings['timeperiod_interval']) &&
                ($currentSettings['timeperiod_interval'] != $priorSettings['timeperiod_interval'])
            )
        ) {
            return true;
        }
        if (!isset($priorSettings['timeperiod_type']) ||
            (isset($currentSettings['timeperiod_type']) &&
                ($currentSettings['timeperiod_type'] != $priorSettings['timeperiod_type'])
            )
        ) {
            return true;
        }
        if (!isset($priorSettings['timeperiod_start_date']) ||
            (isset($currentSettings['timeperiod_start_date']) &&
                ($currentSettings['timeperiod_start_date'] != $priorSettings['timeperiod_start_date'])
            )
        ) {
            return true;
        }
        if (!isset($priorSettings['timeperiod_leaf_interval']) ||
            (isset($currentSettings['timeperiod_leaf_interval']) &&
                ($currentSettings['timeperiod_leaf_interval'] != $priorSettings['timeperiod_leaf_interval'])
            )
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param ServiceBase $api
     * @param $worksheetColumns
     */
    public function setWorksheetColumns(ServiceBase $api, $worksheetColumns, $forecastBy)
    {
        if (!is_array($worksheetColumns)) {
            return false;
        }

        require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
        $listDefsParser = ParserFactory::getParser(MB_LISTVIEW, 'ForecastWorksheets', null, null, $api->platform);
        $listDefsParser->resetPanelFields();

        // get the proper order from the admin panel, where we defined what is displayed, in the order that we want it
        $mm = new MetadataManager($api->user);
        $views = $mm->getModuleViews('Forecasts');
        $fields = $views['forecastsConfigWorksheetColumns']['meta']['panels'][0]['fields'];

        $cteable = array(
            'commit_stage',
            'worst_case',
            'likely_case',
            'best_case',
            'date_closed',
            'sales_stage',
            'probability'
        );

        $currency_fields = array(
            'worst_case',
            'likely_case',
            'best_case',
            'list_price',
            'cost_price',
            'discount_price',
            'discount_amount',
            'total_amount'
        );

        foreach ($fields as $field) {
            if (!in_array($field['name'], $worksheetColumns)) {
                continue;
            }

            $column = $field['name'];
            $additionalDefs = array();

            // set the label for the parent_name field, depending on what we are forecasting by
            if ($column == 'parent_name') {
                $label = $forecastBy == 'Opportunities' ? 'LBL_OPPORTUNITY_NAME' : 'LBL_REVENUELINEITEM_NAME';
                $additionalDefs = array_merge(
                    $additionalDefs,
                    array('label' => $label)
                );
            }

            if (in_array($column, $cteable)) {
                $additionalDefs = array_merge(
                    $additionalDefs,
                    array('click_to_edit' => true)
                );
            }
            if (in_array($column, $currency_fields)) {
                $additionalDefs = array_merge(
                    $additionalDefs,
                    array(
                        'convertToBase' => true,
                        'showTransactionalAmount' => true
                    )
                );
            }
            $listDefsParser->addField($column, $additionalDefs);
        }

        // save the file, but we don't need to load the the $_REQUEST, so pass false
        $listDefsParser->handleSave(false);
    }
}
