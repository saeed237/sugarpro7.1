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
 * Visibility limitations for Reports
 * @api
 */
class ReportVisibility extends SugarVisibility
{
    protected $disallowed_modules;

    /**
     * (non-PHPdoc)
     * @see SugarVisibility::addVisibilityWhere()
     */
    public function addVisibilityWhere(&$query)
    {
        global $current_user;
        if (!empty($current_user) && $current_user->isAdminForModule("Reports")) {
            return $query;
        }

        $table_alias = $this->getOption('table_alias');
        if(empty( $table_alias)) {
            $table_alias = $this->bean->table_name;
        }

        $disallowed_modules = $this->getDisallowedModules();

        if($disallowed_modules) {
            $where_clause = "$table_alias.module NOT IN ('".join("','", $disallowed_modules)."')";
            if(!empty($query)) {
                $query .= " AND $where_clause";
            } else {
                $query = $where_clause;
            }
        }
        return $query;
    }

    /**
     * Get list of modules not allowed for reporting
     * @return array
     */
    public function getDisallowedModules()
    {
        if(!is_null($this->disallowed_modules)) {
            return $this->disallowed_modules;
        }
        if(empty($GLOBALS['report_modules'])) {
            require_once 'modules/Reports/config.php';
            if(empty($GLOBALS['report_modules'])) {
                // this shouldn't happen but if it does, no modules for you
                return array_keys($GLOBALS['beanList']);
            }
        }
        $this->disallowed_modules = array();
        foreach($GLOBALS['report_modules'] as $module => $name) {
            $seed = BeanFactory::getBean($module);
            if(empty($seed) || !$seed->ACLAccess("view")) {
                $this->disallowed_modules[] = $module;
            }
        }
        return $this->disallowed_modules;
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
