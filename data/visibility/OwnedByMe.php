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


class OwnedByMe
{
    protected  $bean;
    public function __construct($bean)
    {
        $this->bean = $bean;
        $this->module_dir = $this->bean->module_dir;
    }

    public function addVisibilityClause(&$query)
    {
        global $current_user;
        $query .= " INNER JOIN (SELECT id FROM {$this->bean->table_name} WHERE {$this->bean->table_name}.assigned_user_id='{$current_user->id}') mememe ON mememe.id={$this->bean->table_name}.id";
    }
}
