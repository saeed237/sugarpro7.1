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

/**
 * Class AbstractForecastHooks
 *
 * This is a Forecast Logic Hook Base class, this can be used so we can just have the different Logic Hooks extend
 * this class so we only have this code once.
 */
abstract class AbstractForecastHooks
{
    public static $settings;

    /**
     * Utility Method to make sure Forecast is setup and usable
     *
     * @return bool
     */
    public static function isForecastSetup()
    {
        /* @var $admin Administration */
        if (empty(static::$settings)) {
            $admin = BeanFactory::getBean('Administration');
            static::$settings = $admin->getConfigForModule('Forecasts');
        }
        return static::$settings['is_setup'] == 1;
    }
}
