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


require_once('include/SearchForm/SearchForm2.php');

class EmployeesSearchForm extends SearchForm {
    /**
     * This builds an EmployeesSearchForm from a classic search form.
     */
    public function __construct( SearchForm $oldSearchForm ) {
        parent::SearchForm($oldSearchForm->seed, $oldSearchForm->module, $oldSearchForm->action);
        $this->setup(
            // $searchdefs
            array($oldSearchForm->module => $oldSearchForm->searchdefs),
            // $searchFields
            array($oldSearchForm->module => $oldSearchForm->searchFields),
            // $tpl
            $oldSearchForm->tpl,
            // $displayView
            $oldSearchForm->displayView,
            // listViewDefs
            $oldSearchForm->listViewDefs);
        
        $this->lv = $oldSearchForm->lv;
                     
    }
    
    public function generateSearchWhere($add_custom_fields = false, $module = '') {
        $onlyActive = false;
        if (isset($this->searchFields['open_only_active_users']['value'])) {
            if ( $this->searchFields['open_only_active_users']['value'] == 1) {
                $onlyActive = true;
            }
            unset($this->searchFields['open_only_active_users']['value']);
        }
        $where_clauses = parent::generateSearchWhere($add_custom_fields, $module);
        
        if ( $onlyActive ) {
            $where_clauses[] = "users.employee_status = 'Active'";
        }
        
        // Add in code to remove portal/group/hidden users
        $where_clauses[] = "users.portal_only = 0";
        $where_clauses[] = "(users.is_group = 0 or users.is_group is null)";
        $where_clauses[] = "users.show_on_employees = 1";
        return $where_clauses;
    }
}