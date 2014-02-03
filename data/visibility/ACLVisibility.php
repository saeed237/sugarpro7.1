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
 * ACL-driven visibility
 * @api
 */
class ACLVisibility extends SugarVisibility
{
    /**
     * (non-PHPdoc)
     * @see SugarVisibility::addVisibilityWhere()
     */
    public function addVisibilityWhere(&$query)
    {
        $action = $this->getOption('action', 'list');
        if($this->bean->bean_implements('ACL') && ACLController::requireOwner($this->bean->module_dir, $action)) {
            $owner_where = $this->bean->getOwnerWhere($GLOBALS['current_user']->id);
            if(!empty($query)) {
                $query .= " AND $owner_where";
            } else {
                $query = $owner_where;
            }
        }
        return $query;
    }

    public function addVisibilityWhereQuery(SugarQuery $sugarQuery, $options = array()) {
        $where = null;
        $this->addVisibilityWhere($where, $options);
        if(!empty($where)) {
            $sugarQuery->where()->addRaw($where);
        }
        
        return $sugarQuery;
    }
}