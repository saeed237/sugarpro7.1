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
 * This is the base object for building SugarQueries Insert
 * ************ WARNING**********************************************
 * THIS CLASS AND ALL RELATED CLASSES WILL BE FUNDAMENTALLY CHANGING
 * DO NOT USE THIS TO BUILD YOUR QUERIES.  
 * ******************************************************************
 * 
 */
class SugarQuery_Builder_Insert {
	/**
	 * Table to do the insert on
	 */
	protected $table;

	/**
	 * Columns array for the inserts
	 */
	protected $columns = array();

	/**
	 * Values of the insert
	 */
	protected $values = array();

	/**
	 * Constructor, sets up the insert
	 * @param string $table 
	 * @param array $columns 
	 * @return object this
	 */
	public function __construct($table = NULL, array $columns = NULL)
	{
		if ($table)
		{
			// Set the inital table name
			$this->table = $table;
		}

		if ($columns)
		{
			// Set the column names
			$this->columns = $columns;
		}
	}

	/**
	 * Set the Table for the insert
	 * @param string $table 
	 * @return object this
	 */
	public function table($table)
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Set the columns for the insert
	 * @param array $columns 
	 * @return object this
	 */
	public function columns(array $columns)
	{
		$this->columns = $columns;

		return $this;
	}

	/**
	 * Set the values for the insert
	 * @param array $values 
	 * @return object this
	 */
	public function values(array $values)
	{
		// Get all of the passed values
		$values = func_get_args();

		$this->values = array_merge($this->values, $values);

		return $this;
	}

	public function __get($name)
	{
		return $this->$name;
	}

}