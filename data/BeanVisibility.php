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



require_once 'data/SugarVisibility.php';

/**
 * Bean visibility manager
 * @api
 */
class BeanVisibility
{
    /**
     * List of strategies to apply to this bean
     * @var array
     */
    protected $strategies = array();
    /**
     * Parent bean
     * @var SugarBean
     */
    protected $bean;

    /**
     * @param SugarBean $bean
     * @param array $metadata
     */
    public function __construct($bean, $metadata)
    {
        $this->bean = $bean;
        foreach($metadata as $visclass => $data) {
            if($data === false) continue;
            $this->strategies[] = new $visclass($bean, $data);
        }
    }

    /**
     * Add the strategy to the list
     * @param string $strategy Strategy class name
     * @param mixed $data Strategy params
     */
    public function addStrategy($strategy, $data = null)
    {
        $this->strategies[] = new $strategy($this->bean, $data);
    }

    /**
     * Add visibility clauses to the FROM part of the query
     * @param string $query
     * @param array $options
     * @return string Modified query
     */
    public function addVisibilityFrom(&$query, $options = array())
    {
        foreach($this->strategies as $strategy) {
            $strategy->setOptions($options)->addVisibilityFrom($query);
        }
        return $query;
    }

    /**
     * Add visibility clauses to the WHERE part of the query
     * @param string $query
     * @param array $options
     * @return string Modified query
     */
    public function addVisibilityWhere(&$query, $options = array())
    {
        foreach($this->strategies as $strategy) {
            $strategy->setOptions($options)->addVisibilityWhere($query);
        }
        return $query;
    }

    public function addVisibilityFromQuery(SugarQuery $query, $options = array()) {
        foreach($this->strategies as $strategy) {
            $strategy->setOptions($options)->addVisibilityFromQuery($query);
        }
        return $query;
    }

    public function addVisibilityWhereQuery(SugarQuery $query, $options = array()) {
        foreach($this->strategies as $strategy) {
            $strategy->setOptions($options)->addVisibilityWhereQuery($query);
        }
        return $query;
    }    
}
