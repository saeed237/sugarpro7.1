<?php
/**
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

require_once('modules/Forecasts/AbstractForecastHooks.php');

class ForecastWorksheetHooks extends AbstractForecastHooks
{

    /**
     * This method, just set the date_modified to the value from the db, vs the user formatted value that sugarbean sets
     * after it has been retrieved
     *
     * @param ForecastWorksheet $worksheet
     * @param string $event
     * @param array $params
     */
    public static function fixDateModified(ForecastWorksheet $worksheet, $event, $params = array())
    {
        $worksheet->date_modified = $worksheet->fetched_row['date_modified'];
    }

    /**
     * @param ForecastWorksheet $bean
     * @param string $event
     * @param array $args
     * @return bool
     */
    public static function checkRelatedName($bean, $event, $args)
    {

        if ($event == 'before_save') {
            if (empty($bean->account_id) && !empty($bean->account_name)) {
                $bean->account_name = '';
            }

            if (empty($bean->opportunity_id) && !empty($bean->opportunity_name)) {
                $bean->opportunity_name = '';
            }

            // if we are in a delete operation, don't update the date modified
            if (SugarBean::inOperation('delete') || SugarBean::inOperation('saving_related')) {
                $bean->date_modified = $bean->fetched_row['date_modified'];
            }
        }
        return true;
    }

    /**
     * @param ForecastWorksheet $bean
     * @param string $event
     * @param array $args
     * @return bool
     */
    public static function managerNotifyCommitStage($bean, $event, $args)
    {
        /**
         * Only run this logic hook when the following conditions are met
         *  - Bean is not a Draft Record
         *  - Bean is not a new Record
         *  - Forecast is Setup
         */
        if ($bean->draft === 0 && !empty($bean->fetched_row) && static::isForecastSetup()) {
            $forecast_by = self::$settings['forecast_by'];
            // make sure we have a bean of the one that we are forecasting by
            // and it's fetched_row commit_stage is equal to `include`
            // and it's updated commit_stage does not equal `include`
            if ($bean->parent_type === $forecast_by &&
                $bean->fetched_row['commit_stage'] === 'include' &&
                $bean->commit_stage !== 'include'
            ) {
                // send a notification to their manager if they have a manager
                /* @var $user User */
                $bean->load_relationship('assigned_user_link');
                $user = array_shift($bean->assigned_user_link->getBeans());
                if (!empty($user->reports_to_id)) {
                    $worksheet_strings = static::getLanguageStrings($bean->module_name);
                    $mod_strings = static::getLanguageStrings($bean->parent_type);

                    $notifyBean = static::getNotificationBean();
                    $notifyBean->assigned_user_id = $user->reports_to_id;
                    $notifyBean->type = 'information';
                    $notifyBean->created_by = $user->id;
                    $notifyBean->name = string_format(
                        $worksheet_strings['LBL_MANAGER_NOTIFY'],
                        array(
                            $mod_strings['LBL_MODULE_NAME_SINGULAR'],
                            $bean->name
                        )
                    );
                    $notifyBean->save();

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Utility Method to return a Notifications Bean
     *
     * @return Notifications
     */
    public static function getNotificationBean()
    {
        return BeanFactory::getBean('Notifications');
    }

    /**
     * Utility method to return the module language strings
     *
     * @param string $module
     * @return array|null
     */
    public static function getLanguageStrings($module)
    {
        // If the session has a language set, use that
        if (!empty($_SESSION['authenticated_user_language'])) {
            $lang = $_SESSION['authenticated_user_language'];
        } else {
            global $current_language;
            $lang = $current_language;
        }

        return return_module_language($lang, $module);
    }
}
