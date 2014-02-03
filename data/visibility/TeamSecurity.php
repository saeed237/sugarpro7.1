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
 * Team security visibility
 */
class TeamSecurity extends SugarVisibility
{
    public function addVisibilityFrom(&$query)
    {
        // Support portal will never respect Teams, even if they do earn more than them even while raising the teamsets
        if(isset($_SESSION['type'])&&$_SESSION['type']=='support_portal') {
            return;
        }


        // copied from old team security clause
        if($this->bean->module_dir == 'WorkFlow') return;
        if(!$this->bean->disable_row_level_security) {
            // We need to confirm that the user is a member of the team of the item.

            global $current_user;
            if(empty($current_user)) {
                $current_user_id = '';
            } else {
                $current_user_id = $current_user->id;
            }
            // The user either has to be an admin, or be assigned to the team that owns the data
            $team_table_alias = 'team_memberships';
            $table_alias = $this->getOption('table_alias');
            if(!empty( $table_alias)) {
                $team_table_alias .= $table_alias;
            } else {
                $table_alias = $this->bean->table_name;
            }

            if ((empty($current_user) || !$current_user->isAdminForModule($this->module_dir)) && $this->module_dir != 'WorkFlow') {
                if($this->getOption('as_condition')) {
                    $query .= " AND {$table_alias}.team_set_id IN (select tst.team_set_id from team_sets_teams tst
                              INNER JOIN team_memberships {$team_table_alias} ON tst.team_id = {$team_table_alias}.team_id
                              AND {$team_table_alias}.user_id = '$current_user_id'
                              AND {$team_table_alias}.deleted=0)";
                } else {
                    $query .= " INNER JOIN (select tst.team_set_id from team_sets_teams tst";
                    $query .= " INNER JOIN team_memberships {$team_table_alias} ON tst.team_id = {$team_table_alias}.team_id
                                        AND {$team_table_alias}.user_id = '$current_user_id'
                                        AND {$team_table_alias}.deleted=0 group by tst.team_set_id) {$table_alias}_tf on {$table_alias}_tf.team_set_id  = {$table_alias}.team_set_id ";
                    if($this->getOption('join_teams')) {
                        $query .= " INNER JOIN teams ON teams.id = team_memberships.team_id AND teams.deleted=0 ";
                    }
                }
            }
        }
    }

    /**
     * Add Visibility to a SugarQuery Object
     * @param SugarQuery $sugarQuery
     * @param array $options
     * @return string|SugarQuery
     */
    public function addVisibilityFromQuery(SugarQuery $sugarQuery, $options = array())
    {
        if($this->getOption('as_condition')) {
            $table_alias = $this->getOption('table_alias');
            if(empty($sugarQuery->join[$table_alias])) {
                return;
            }
            $join = $sugarQuery->join[$table_alias];
            $add_join = '';
            $this->addVisibilityFrom($add_join, $options);
            if(!empty($add_join)) {
                if(substr($add_join, 0, 5) == " AND ") {
                    $add_join = substr($add_join, 5);
                }
                $join->on()->queryAnd()->addRaw($add_join);
            }
        } else {
            $join = '';
            $this->addVisibilityFrom($join, $options);
            if(!empty($join)) {
                $sugarQuery->joinRaw($join);
            }
        }
        return $sugarQuery;
    }
}