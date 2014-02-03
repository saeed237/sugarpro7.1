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


require_once 'include/SugarMetric/Provider/Interface.php';

/**
 * SugarMetric_Provider_Log class used for logging and debugging metric's providers
 *
 * Registered in SugarMetric_Manager only if some logger class is available
 *
 * //TODO : Add setLogger($logger) and getLogger() method
 */
class SugarMetric_Provider_Log implements SugarMetric_Provider_Interface
{
    /**
     * @var LoggerManager
     */
    protected $logger;

    /**
     * Default logging level
     *
     * @var string
     */
    protected $logLevel = 'debug';

    /**
     * Initialize Log Metric Provider
     *
     * @param array $params optional params that come up from config.php
     */
    public function __construct($params)
    {
        if (!isset($GLOBALS['log']) && class_exists('SugarObject')) {
            require_once 'include/SugarLogger/LoggerManager.php';
            $this->logger = LoggerManager::getLogger('SugarCRM');
        } elseif (isset($GLOBALS['log'])) {
            $this->logger = $GLOBALS['log'];
        }

        if (isset($params['log_level'])) {
            $this->logLevel = $params['log_level'];
        }
    }

    /**
     * Returns "true" if some logger is available and was
     * Otherwise returns false
     *
     * @return bool
     */
    public function isLoaded()
    {
        return (bool) $this->logger;
    }

    /**
     * Set up a name for current Web Transaction
     *
     * @param string $name
     * @return null
     */
    public function setTransactionName($name)
    {
        $this->logger->{$this->logLevel}('Log Metric Provider: setTransactionName with "' . $name . '" is called');
    }

    /**
     * Add custom parameter to transaction stack trace
     *
     * @param string $name
     * @param mixed $value
     * @return null
     */
    public function addTransactionParam($name, $value)
    {
        $this->logger->{$this->logLevel}('Log Metric Provider: addTransactionParam with "' . $name . ' - ' . '" is called');
    }

    public function setCustomMetric($name, $value)
    {
        $this->logger->{$this->logLevel}('Log Metric Provider: setCustomMetric with "' . $name . ' - ' . $value . '" is called');
    }

    /**
     * Provide exception handling and reports to server stack trace information
     *
     * @param Exception $exception
     * @return null
     */
    public function handleException(Exception $exception)
    {
        $this->logger->{$this->logLevel}('Log Metric Provider: handleException with "' . $exception->getMessage() . '" is called');
    }

    /**
     * Set transaction class name (f.e. background, massupdate)
     *
     * @param string $name
     * @return null
     */
    public function setMetricClass($name)
    {
        $this->logger->{$this->logLevel}('Log Metric Provider: setMetricClass with class name: "' . $name . '" is called');
    }
}
