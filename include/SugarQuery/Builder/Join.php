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
 * This is the base object for building SugarQueries Joins
 * ************ WARNING**********************************************
 * THIS CLASS AND ALL RELATED CLASSES WILL BE FUNDAMENTALLY CHANGING
 * DO NOT USE THIS TO BUILD YOUR QUERIES.
 * ******************************************************************
 *
 */

require_once('include/SugarQuery/Builder/Where.php');
require_once('include/SugarQuery/Builder/Andwhere.php');
require_once('include/SugarQuery/Builder/Orwhere.php');

class SugarQuery_Builder_Join {

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var null|string
     */
    protected $table;

    /**
     * @var array
     */
    protected $on = array();

    /**
     * @var bool|string
     */
    public $raw = false;

    /**
     * @var bool|string
     */
    public $linkName = false;
	/**
	 * Create the JOIN Object
	 * @param string $table
	 * @param string $type
	 */
	public function __construct($table = null, array $options = array())
	{
		// Set the table to JOIN on
		$this->table = $table;
		$this->options = $options;
	}

	/**
	 * Set the ON criteria
	 * @param string $c1
	 * @param string $op
	 * @param string $c2
	 * @return object this
	 */
	public function on()
	{
        if(!isset($this->on['and'])) {
            $this->on['and'] = new SugarQuery_Builder_Andwhere();
        }

		return $this->on['and'];
	}

    /**
     * Set the ON criteria
     * @param string $c1
     * @param string $op
     * @param string $c2
     * @return object this
     */
    public function onOr()
    {
        if(!isset($this->on['or'])) {
            $this->on['or'] = new SugarQuery_Builder_Orwhere();
        }

        return $this->on['or'];
    }

	/**
	 * Add a string of Raw SQL
	 * @param string $sql
	 * @return SugarQuery_Builder_Join
	 */
	public function addRaw($sql) {
		$this->raw = $sql;
		return $this;
	}

	/**
	 * Add a string that is a link name from vardefs
	 * @param string $linkName
	 * @return SugarQuery_Builder_Join
	 */
	public function addLinkName($linkName) {
		$this->linkName = $linkName;
		return $this;
	}

	/**
	 * Return name of the join table
	 * @return string
	 */
	public function joinName()
	{
	    if(!empty($this->options['alias'])) {
	        return $this->options['alias'];
	    }
	    return $this->table;
	}


	public function __get($name)
	{
		return $this->$name;
	}

}