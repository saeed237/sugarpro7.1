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
 * Represents a relationship where part of the data is substituted by the current_user_id
 * @api
 */
class UserBasedRelationship extends M2MRelationship
{
    public $type = "user-based";
    
    public function __construct($def)
    {
        $this->userField = $def['user_field'];
        
        parent::__construct($def);
    }

    protected function buildSugarQueryRoleWhere($sugar_query, $table = "", $ignore_role_filter = false)
    {
        $sugar_query = parent::buildSugarQueryRoleWhere($sugar_query, $table, $ignore_role_filter);
        
        $sugar_query->join[$table]->on()->equals($table.'.'.$this->userField,$GLOBALS['current_user']->id);

        return $sugar_query;
    }
}

