<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 * Base class for visibility implementations
 * @api
 */
abstract class SugarVisibility
{
    /**
     * Parent bean
     * @var SugarBean
     */
    protected $bean;
    protected $module_dir;

    /**
     * Options for this run
     * @var array|null
     */
    protected $options;

    /**
     * @param SugarBean $bean
     */
    public function __construct($bean)
    {
        $this->bean = $bean;
        $this->module_dir = $this->bean->module_dir;
    }

    /**
     * Add visibility clauses to the FROM part of the query
     * @param string $query
     * @return string
     */
    public function addVisibilityFrom(&$query)
    {
        return $query;
    }

    /**
     * Add visibility clauses to the WHERE part of the query
     * @param string $query
     * @return string
     */
    public function addVisibilityWhere(&$query)
    {
        return $query;
    }

   /**
     * Add visibility clauses to the FROM part of the query
     * @param string $query
     * @return string
     */
    public function addVisibilityFromQuery(SugarQuery $query)
    {
        return $query;
    }

    /**
     * Add visibility clauses to the WHERE part of the query
     * @param string $query
     * @return string
     */
    public function addVisibilityWhereQuery(SugarQuery $query)
    {
        return $query;
    }


    /**
     * Get visibility options
     * @param string $name
     * @param mixed $default Default value if option not set
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        if(isset($this->options[$name])) {
            return $this->options[$name];
        }
        return $default;
    }

    /**
     * Set visibility options
     * @param array $options
     * @return SugarVisibility
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}