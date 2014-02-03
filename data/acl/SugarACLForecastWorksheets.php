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

require_once('data/SugarACLStrategy.php');

class SugarACLForecastWorksheets extends SugarACLStrategy
{
    /**
     * @var RevenueLineItem|Opportunity|SugarBean
     */
    protected static $forecastByBean;

    /**
     * Are we an admin for the current bean?
     *
     * @var boolean|null
     */
    protected static $isAdminForBean = null;

    /**
     * Run the check Access for this custom ACL helper.
     *
     * @param string $module
     * @param string $view
     * @param array $context
     * @return bool
     */
    public function checkAccess($module, $view, $context)
    {
        if ($module != 'ForecastWorksheets') {
            return false;
        }

        if ($view == 'team_security') {
            // Let the other modules decide
            return true;
        }

        // Let's make it a little easier on ourselves and fix up the actions nice and quickly
        $view = SugarACLStrategy::fixUpActionName($view);
        $bean = $this->getForecastByBean();
        $current_user = $this->getCurrentUser($context);

        if (static::$isAdminForBean === null) {
            static::$isAdminForBean = $current_user->isAdminForModule($bean->module_name);
        }
        if (static::$isAdminForBean) {
            return true;
        }

        if (empty($view) || empty($current_user->id)) {
            return true;
        }

        if ($view == 'field') {
            // Opp Bean, Amount Field = Likely Case on worksheet
            if ($bean instanceof Opportunity && $context['field'] == 'likely_case') {
                $context['field'] = 'amount';
            }

            // always set the bean to the context
            $context['bean'] = $bean;
            // make sure the user has access to the field
            return $bean->ACLFieldAccess($context['field'], $context['action'], $context);
        }

        return true;
    }

    /**
     * Return the bean for what we are forecasting by
     *
     * @return RevenueLineItem|Opportunity|SugarBean
     */
    protected function getForecastByBean()
    {
        if (!(static::$forecastByBean instanceof SugarBean)) {
            /* @var $admin Administration */
            $admin = BeanFactory::getBean('Administration');
            $settings = $admin->getConfigForModule('Forecasts');

            // if we don't have the forecast_by from the db, grab the defaults that we use on set.
            if (empty($settings['forecast_by'])) {
                require_once('modules/Forecasts/ForecastsDefaults.php');
                $settings = ForecastsDefaults::getDefaults();
            }

            $bean = $settings['forecast_by'];

            static::$forecastByBean = BeanFactory::getBean($bean);
        }

        return static::$forecastByBean;
    }
}
