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


/**
 * SugarMetric library data providers interface
 *
 * Declaration of common SugarMetric Provider listeners methods
 */
interface SugarMetric_Provider_Interface
{
    /**
     * Returns information about provider loaded status
     * F.e. could return false when specific extension is loaded on server
     *
     * @return bool
     */
    public function isLoaded();

    /**
     * Set up a name for current Web Transaction
     *
     * @param string $name
     * @return null
     */
    public function setTransactionName($name);

    /**
     * Add custom parameter to transaction stack trace
     *
     * @param string $name
     * @param mixed $value
     * @return null
     */
    public function addTransactionParam($name, $value);

    /**
     * Set up custom metric.
     *
     * @param string $name
     * @param float $value
     * @return mixed
     */
    public function setCustomMetric($name, $value);

    /**
     * Provide exception handling and reports to server stack trace information
     *
     * @param Exception $exception
     * @return mixed
     */
    public function handleException(Exception $exception);

    /**
     * Set transaction class name (f.e. background, massupdate)
     *
     * @param string $name
     * @return null
     */
    public function setMetricClass($name);
}
