<?php

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
 * TeamSet represents a unique combination of Teams in the system. The goal here is to reduce the amount of duplicated
 * data.
 *
 * Example: West, East, Global could represent  one team set
 * East, Global could represent another.
 *
 * So records that have these combinbations of teams will have the same team_set_id.
 *
 */
require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
require_once('modules/Teams/TeamSetManager.php');

class TeamSet extends SugarBean{
    /*
    * char(36) GUID
    */
    var $id;
    /*
    * This is not being used right now for any purpose within the application. However, in the future we will have
    * named team sets called aliases so that you instead of selecting the same teams,  you can have 'macros' which
    * will allows the user to select an alias and get all of the teams associated with that team set.
    */
    var $name;
    /*
    * When saving a team set we need to ensure that the combination does not exist, so rather than looking it up
    * by joining on the teams within the set, we save the md5 of the sorted ids of the teams for easy look up.
    */
    var $team_md5;
    /*
    * This is NOT A DB FIELD, but simply used to return the primary team id
    */
    var $primary_team_id;
    /*
    * The number of teams associated with a team set.
    */
    var $team_count = 0;

    var $date_modified;
    /*
    * Whether this record has been soft deleted or not.
    */
    var $deleted;

    var $team_ids;

    var $table_name = "team_sets";
    var $object_name = "TeamSet";
    var $module_name = "TeamSets";
    var $module_dir = 'Teams';
    var $disable_custom_fields = true;
    /**
    * Default constructor
    *
    */
    public function __construct(){
        parent::__construct();
        $this->disable_row_level_security =true;
    }

    /**
    * Returns an array of Team objects for the given team_set_id
    *
    * @param id $team_set_id
    * @return array of Team objects
    */
    public function getTeams($team_set_id){
        ///TODO CONCAT
        $sql = "SELECT teams.id, teams.name, teams.name_2 FROM teams INNER JOIN team_sets_teams ON team_sets_teams.team_id = teams.id WHERE team_sets_teams.team_set_id = '$team_set_id'";
        $result = $this->db->query($sql);
        $teams = array();

        while($row = $this->db->fetchByAssoc($result)){
            $team = BeanFactory::getBean('Teams');
            $team->id = $row['id'];
            $team->name = $row['name'];
            $team->name_2 = $row['name_2'];
            $teams[$team->id] = $team;
        }
        return $teams;
    }

    /**
    * Returns an array of team ids associated with a given team set id
    *
    * @param id $team_set_id
    * @return array of team ids
    */
    public function getTeamIds($team_set_id){
        $teams_arr = TeamSetManager::getUnformattedTeamsFromSet($team_set_id);
        $team_ids = array();
        if ( is_array($teams_arr) )
            foreach($teams_arr as $team)
                $team_ids[] = $team['id'];

        return $team_ids;
    }

    /**
    * Given an array of team_ids, determine if the set already exists, if it does return the set_id, if not,
    * create the set and return the id.
    *
    * @param array $team_ids
    * @return id	the id of the newly created team set
    */
    public function addTeams($team_ids){
        if(!is_array($team_ids)){
        $team_ids = array($team_ids);
        }
        $stats = $this->_getStatistics($team_ids);
        $team_md5 = $stats['team_md5'];
        $team_count = $stats['team_count'];
        $this->primary_team_id = $stats['primary_team_id'];
        $team_ids = $stats['team_ids'];

        //we may already have this team set id in cache, so let's not bother to run a select
        //just return
        $teamSetIdFromMD5 = TeamSetManager::getTeamSetIdFromMD5($team_md5);

        if(!is_null($teamSetIdFromMD5)){
            return $teamSetIdFromMD5;
        }

        $sql = "SELECT id FROM $this->table_name WHERE team_md5 = '$team_md5'";
        $result = $this->db->query($sql);
        $row = $this->db->fetchByAssoc($result);
        if (!$row){
            //we did not find a set with this combination of teams
            //so we should create the set and associate the teams with the set and return the set id.
            if(count($team_ids) == 1) {
            $this->new_with_id = true;
            $this->id = $team_ids[0];
            }
            $this->team_md5 = $team_md5;
            $this->primary_team_id = $this->getPrimaryTeamId();
            $this->name = $team_md5;
            $this->team_count = $team_count;
            $this->save();
            foreach($team_ids as $team_id){
                $this->_addTeamToSet($team_id);
            }
            TeamSetManager::addTeamSetMD5($this->id, $this->team_md5);
            return $this->id;
        }else{
            TeamSetManager::addTeamSetMD5($row['id'], $team_md5);
            return $row['id'];
        }
    }

    /**
    * Compute generic statistics we need when saving a team set.
    *
    * @param array $team_ids
    * @return array
    */
    protected function _getStatistics($team_ids){
        $team_md5 = '';
        sort($team_ids, SORT_STRING);
        $primary_team_id = '';
        //remove any dups
        $teams = array();

        $team_count = count($team_ids);
        if($team_count == 1) {
            $team_md5 = md5($team_ids[0]);
            $teams[] = $team_ids[0];
            if(empty($this->primary_team_id)) {
            $primary_team_id = $team_ids[0];
            }
        } else {
            for($i=0; $i<$team_count; $i++) {

                $team_id = $team_ids[$i];

                if(!array_key_exists("$team_id", $teams)){
                    $team_md5 .= $team_id;
                    if(empty($this->primary_team_id)){
                        $primary_team_id = $team_id;
                    }
                    $teams["$team_id"] = $team_id;
                }
            }
            $team_md5 = md5($team_md5);
        }
        return array('team_ids' => $team_ids, 'team_md5' => $team_md5, 'primary_team_id' => $primary_team_id, 'team_count' => $team_count);
    }

    /**
    * Given a team_id remove that team from this particular set
    *
    * @param string $team_id
    */
    public function removeTeamFromSet($team_id){
        $GLOBALS['log']->info("Removing team_id: {$team_id} from team set: {$this->id}");
        $sqlDelete = "DELETE FROM team_sets_teams WHERE team_id = '$team_id' AND team_set_id = '$this->id'";
        //$this->db->query($sqlDelete,true,"Error deleting team id from team_sets_teams: ");

        //have to recalc the md5 hash and the count
        $stats = $this->_getStatistics($this->getTeamIds($this->id));
        $this->team_md5 = $stats['team_md5'];
        $this->team_count = $stats['team_count'];
        $this->save();
    }


    public function getPrimaryTeamId(){
        return $this->primary_team_id;
    }

    /**
    * Associate the teams with the team set
    *
    * @param id $team_id	the team id to associate with the team set
    */
    private function _addTeamToSet($team_id){
        if($this->load_relationship('teams')){
            $this->teams->add($team_id);
        }else{
            $guid = create_guid();
            $insertQuery = "INSERT INTO team_sets_teams (id, team_set_id, team_id) VALUES ('{$guid}', '{$this->id}', '{$team_id}')";
            $GLOBALS['db']->query($insertQuery);
        }
    }

    /**
    * Used in export to generate the proper sql to join on team sets
    *
    * @param String $table_name	the table name of the module we are using
    * @return String
    */
    public static function getTeamNameJoinSql($table_name){
        return " LEFT JOIN  team_sets ts ON $table_name.team_set_id=ts.id  AND ts.deleted=0
                LEFT JOIN  teams teams ON teams.id=ts.id AND teams.deleted=0 AND teams.deleted=0 ";
    }

    /**
     * Retrieve all team set ids for a given user.
     * @static
     * @param $user_id
     * @return array
     */
    public static function getTeamSetIdsForUser($user_id)
    {
        $cacheKey = "teamSetIdByUser{$user_id}";
        $cachedResults = sugar_cache_retrieve($cacheKey);
        if($cachedResults)
            return $cachedResults;

        $results = array();
        $sql = "SELECT tst.team_set_id from team_sets_teams tst INNER JOIN team_memberships team_memberships ON tst.team_id = team_memberships.team_id
                AND team_memberships.user_id = '$user_id' AND team_memberships.deleted=0 group by tst.team_set_id";
        $rs = $GLOBALS['db']->query($sql, TRUE, "Error retrieving team set ids for user.");
        while($row = $GLOBALS['db']->fetchByAssoc($rs))
        {
            $results[] = $row['team_set_id'];
        }
        sugar_cache_put($cacheKey, $results);
        return $results;
    }
    /**
    * Determine whether a user has access to any of the teams on a team set.
    *
    * @param id $user_id
    * @param id $team_set_id
    * @return boolean	true if the user has acces, false otherwise
    */
    function isUserAMember($user_id, $team_set_id = '', $team_ids = array()){
        // determine whether the user is already on the team
        $sql = '';
        if(!empty($team_set_id)){
            $sql = "SELECT team_memberships.id FROM team_memberships INNER JOIN team_sets_teams ON team_sets_teams.team_id = team_memberships.team_id WHERE user_id='$user_id' AND team_sets_teams.team_set_id='$team_set_id' AND team_memberships.deleted = 0";
        }elseif(!empty($team_ids)){
            $team_id_str = "'" . implode("','", $team_ids) . "'";
            $sql = "SELECT team_memberships.id FROM team_memberships WHERE user_id='$user_id' AND team_id IN ($team_id_str) AND team_memberships.deleted = 0";
        }else{
            return false;
        }

        $result = $this->db->query($sql, TRUE, "Error finding team memberships: ");
        $row = $this->db->fetchByAssoc($result);

        if ($row != null) {
            return true;
        }
        return false;
    }

    /**
    * Returns all the users of teams of teamset
    *
    * @param id $team_set_id
    * @param boolean $only_active_users
    * @return array - users
    */
    function getTeamSetUsers($team_set_id, $only_active_users = false) {
        $usersArray = array();
        $teamIds = $this->getTeamIds($team_set_id);
        if(!empty($teamIds)) {
            foreach($teamIds as $team_id) {
                $team = BeanFactory::getBean('Teams');
                $team->id = $team_id;
                $usersList = $team->get_team_members($only_active_users);
                if (!empty($usersList)) {
                    foreach($usersList as $user) {
                        $usersArray[$user->id] = $user;
                    } // foreach
                } // if
            } // foreach
        } // if
        return $usersArray;
    } // fn

    /**
    * This is used in Reports to give faster performance so we do not have to perform the subquery. We might come back to this
    * if we can find a way to speed up the subquery.
    *
    * @param string $user_id
    * @return bool
    */
    public function populateUserTempTable($current_user){
        if(!is_admin($current_user)){
            $user_id = $current_user->id;
            $selectQuery = "SELECT tst.team_set_id, tst.date_modified FROM team_sets_teams tst INNER JOIN team_memberships ON tst.team_id = team_memberships.team_id AND team_memberships.user_id = '$current_user->id' AND team_memberships.deleted=0 group by tst.team_set_id ORDER BY date_modified DESC";

            $foundInCache = false;

            $teamSetsUsers = sugar_cache_retrieve('TeamSetsUsersCache');
            if ( $teamSetsUsers != null && !empty($teamSetsUsers[$user_id])) {
                $foundInCache = true;
            }

			$cachedfile = sugar_cached('modules/Teams/TeamSetsUsersCache.php');
            if (!$foundInCache && file_exists($cachedfile) ) {
                require_once($cachedfile);
                if(!empty($teamSetsUsers[$user_id])){
                        $foundInCache = true;
                }
            }

            $result = $this->db->query($selectQuery, TRUE, "Error finding team memberships: ");
            $row = $this->db->fetchByAssoc($result);

            if($foundInCache){
                //check if the date_modified of the first record is later than the last cache for this user.
                if($row['date_modified'] <= $teamSetsUsers[$user_id]){
                    return true;
                }
            }else{
                $teamSetsUsers[$user_id] = $row['date_modified'];
                sugar_cache_put('TeamSetsUsersCache',$teamSetsUsers);

                if ( ! file_exists($cachedfile) ) { mkdir_recursive(dirname($cachedfile)); }

                $fd = fopen($cachedfile,'w');
                fwrite($fd,"<?php\n\n".'$teamSetsUsers = '.var_export($teamSetsUsers,true).";\n ?>");
                fclose($fd);
            }

            //delete everything for this user first
            $delQuery = "DELETE FROM team_sets_users WHERE user_id = '$user_id'";
            $this->db->query($delQuery);

            //now update the table
            $insertQuery = "INSERT INTO team_sets_users (team_set_id, user_id) VALUES ";
            $isFirst = true;
            while($row = $this->db->fetchByAssoc($result)){
                if(!$isFirst){
                    $insertQuery .= ",";
                }
                $isFirst = false;
                $insertQuery .= "('{$row['team_set_id']}', '{$user_id}')";
            }
            $this->db->query($insertQuery, TRUE, "Error finding team memberships: ");
        }
        return true;
    }
}
