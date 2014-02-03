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




abstract class SugarForecasting_AbstractForecastArgs
{
    /**
     * @var array Rest Arguments
     */
    protected $args;

    /**
     * Class Constructor
     * @param array $args       Service Arguments
     */
    public function __construct($args)
    {
        $this->setArgs($args);
    }

    /**
     * Set the arguments
     *
     * @param array $args
     * @return SugarForecasting_AbstractForecast
     */
    public function setArgs($args)
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Return the arguments array
     *
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Get a specific Arg Value, If it doesn't exist return Empty
     *
     * @param $key
     * @return string
     */
    public function getArg($key)
    {
        return isset($this->args[$key]) ? $this->args[$key] : "";
    }

    /**
     * Set an Arg to track
     *
     * @param string $key
     * @param mixed $value
     * @return SugarForecasting_AbstractForecast
     */
    public function setArg($key, $value)
    {
        $this->args[$key] = $value;

        return $this;
    }

}