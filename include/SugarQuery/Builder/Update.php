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
 * This is the base object for building SugarQueries Update
 * ************ WARNING**********************************************
 * THIS CLASS AND ALL RELATED CLASSES WILL BE FUNDAMENTALLY CHANGING
 * DO NOT USE THIS TO BUILD YOUR QUERIES.  
 * ******************************************************************
 * 
 */
class SugarQuery_Builder_Update {
	/**
	 * Table for the update
	 */
	protected $table;

	/**
	 * SET Array for the updates
	 */
	protected $set = array();

	protected $order_by = array();

	protected $limit = NULL;

	/**
	 * Set up the UPDATE with the initial table
	 * @param string $table 
	 */
	public function __construct($table = NULL)
	{
		if ($table)
		{
			// Set the inital table name
			$this->table = $table;
		}
	}

	/**
	 * Set a Table to user
	 * @param string $table 
	 * @return object this
	 */
	public function table($table)
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Set the SET Paramaters
	 * @param array $pairs 
	 * @return object this
	 */
	public function set(array $pairs)
	{
		foreach ($pairs as $column => $value)
		{
			$this->set[] = array($column, $value);
		}

		return $this;
	}

	/**
	 * Set the Column, Value 
	 * @param string $column
	 * @param string $value 
	 * @return object this
	 */
	public function value($column, $value)
	{
		$this->set[] = array($column, $value);

		return $this;
	}

	public function __get($name)
	{
		return $this->$name;
	}


	/**
	 * Set an Order By Close
	 * @param string $column 
	 * @param string $direction 
	 * @return object this
	 */
	public function orderBy($column, $direction = NULL)
	{
		$this->order_by[] = array($column, $direction);

		return $this;
	}

	/**
	 * Set a LIMIT clause
	 * @param int $number 
	 * @return object this
	 */
	public function limit($number)
	{
		$this->limit = $number;

		return $this;
	}	

}