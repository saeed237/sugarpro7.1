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


class ForecastTreeSeedData {

    private $common;

    public function __construct()
    {
        require_once('modules/Forecasts/Common.php');
        $this->common = new Common();
    }

    /**
     * populateUserSeedData
     * This function populates the forecast_tree table with user data based on the entries
     * in the users table and the reports_to_id structure.
     * @return array
     */
    public function populateUserSeedData()
    {
        $results = $GLOBALS['db']->query("SELECT id, user_name, reports_to_id FROM users WHERE status = 'Active'");
        while(($row = $GLOBALS['db']->fetchByAssoc($results)))
        {
            $query = "INSERT INTO forecast_tree (id, name, hierarchy_type, user_id, parent_id) VALUES ('{$row['id']}', '{$row['user_name']}', 'users', '{$row['id']}', '{$row['reports_to_id']}')";
            $GLOBALS['db']->query($query);
        }
    }

    public function populateProductCategorySeedData()
    {
        $results = $GLOBALS['db']->query("SELECT id, name, parent_id, assigned_user_id, 'category' type FROM product_categories WHERE deleted=0 UNION SELECT id, name, category_id, '1', 'product' type FROM product_templates WHERE deleted=0");
        while(($row = $GLOBALS['db']->fetchByAssoc($results)))
        {
            $parent_id = empty($row['parent_id']) ? '' : $row['parent_id'];
            $assigned_user_id = empty($row['assigned_user_id']) ? '1' : $row['assigned_user_id'];
            $query = "INSERT INTO forecast_tree (id, name, hierarchy_type, user_id, parent_id) VALUES ('{$row['id']}', '{$row['name']}', 'products', '{$assigned_user_id}', '{$parent_id}')";
            $GLOBALS['db']->query($query);
        }
    }

}