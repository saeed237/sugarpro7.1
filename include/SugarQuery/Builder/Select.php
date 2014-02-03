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
 * SugarQueryBuilder_Select
 * @api
 */

class SugarQuery_Builder_Select
{

    /**
     * Array of Select fields/statements
     * @var array
     */
    protected $select = array();

    protected $query;

    protected $countQuery = false;

    /**
     * Create Select Object
     * @param $columns
     */
    public function __construct(SugarQuery $query, $columns)
	{
        if(!is_array($columns)) {
            $columns = array_slice(func_get_args(), 1);
        }
        $this->query = $query;
        $this->field($columns);
	}

    /**
     * Select method
     * Add select elements
     * @param string $columns
     * @return object this
     */
	public function field($columns)
	{
        if(!is_array($columns)) {
            $columns = func_get_args();
        }
        if(!empty($this->select)) {
            $this->select = array_unique(array_merge($this->select, $columns), SORT_REGULAR);
        } else {
            $this->select = $columns;
        }
		return $this;
	}


    /**
     * SelectReset method
     * clear out the objects select array
     * @return object this
     */
	public function selectReset()
	{
		$this->select = array();
		return $this;
	}

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
	{
		return $this->$name;
	}

    public function setCountQuery()
    {
        $this->countQuery = true;
        return $this;
    }

    public function getCountQuery()
    {
        return $this->countQuery;
    }

    /**
     * Add bean field to the query
     * @param SugarQuery $query
     * @param string $field
     */
    protected function addFieldToQuery(SugarQuery $query, $field)
    {
        if (in_array($field, $this->select))
        {
            return;
        }

        $fieldName = is_array($field) ?  $field[0] : $field;
        $seed = !empty($query->from) && is_array($query->from) ? $query->from[0] : $query->from;
        if (!empty($seed) && isset($seed->field_defs[$fieldName]))
        {
            $def = $seed->field_defs[$fieldName];
            //Simple DB fields can be placed in the select normally
            if (!isset($def['source']) || $def['source'] == 'db')
            {
                $this->select[] = $field;
            } else
            {
                //Here is where we need to start implementing the harder code.
                //Similar to what we have in create_new_list_query, we will need joins, additional alias's, ect
                //I'm not sure how well we can do thins like track what tables are already joined in the query
                //And determine if we need to join them a second time or re-use the existing join.
            }
        } else
        {
            if (strpos($field, '.')) {
                // It looks like it's a related field that we need to select by the correct join name
                list($linkName, $column) = explode('.', $field);
                $join = $query->getJoinForLink($linkName);
                if (!empty($join)) {
                    $field = $join->joinName() . ".$column";
                }
            }
            $this->select[] = $field;
        }

    }


}