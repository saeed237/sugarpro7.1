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




class TeamDemoData {
	var $_team;
	var $_large_scale_test;

	var $guids = array(
		'jim'	=> 'seed_jim_id',
		'sarah'	=> 'seed_sarah_id',
		'sally'	=> 'seed_sally_id',
		'max'	=> 'seed_max_id',
		'will'	=> 'seed_will_id',
		'chris'	=> 'seed_chris_id',
	/*
	 * Pending fix of demo data mechanism
		'jim'	=> 'jim00000-0000-0000-0000-000000000000',
		'sarah'	=> 'sarah000-0000-0000-0000-000000000000',
		'sally'	=> 'sally000-0000-0000-0000-000000000000',
		'max'	=> 'max00000-0000-0000-0000-000000000000',
		'will'	=> 'will0000-0000-0000-0000-000000000000',
		'chris'	=> 'chris000-0000-0000-0000-000000000000',
	*/
	);

	/**
	 * Constructor for creating demo data for teams
	 */
	function TeamDemoData($seed_team, $large_scale_test = false)
	{
		$this->_team = $seed_team;
		$this->_large_scale_test = $large_scale_test;
	}
	
	/**
	 * 
	 */
	function create_demo_data() {
		global $current_language;
		global $sugar_demodata;
		foreach($sugar_demodata['teams'] as $v)
		{
			if (!$this->_team->retrieve($v['team_id']))
			$this->_team->create_team($v['name'], $v['description'], $v['team_id']);
		}

		if($this->_large_scale_test)
		{
			$team_list = $this->_seed_data_get_team_list();
			foreach($team_list as $team_name)
			{
				$this->_quick_create($team_name);
			}
		}
		
		$this->add_users_to_team();
	}

	function add_users_to_team() {
		// Create the west team memberships
		$this->_team->retrieve("West");
		$this->_team->add_user_to_team($this->guids['sarah']);
		$this->_team->add_user_to_team($this->guids['sally']);
		$this->_team->add_user_to_team($this->guids["max"]);

		// Create the east team memberships
		$this->_team->retrieve("East");
		$this->_team->add_user_to_team($this->guids["will"]);
		$this->_team->add_user_to_team($this->guids['chris']);
	}
	
	/**
	 * 
	 */
	function get_random_team()
	{
		$team_list = $this->_seed_data_get_team_list();
		$team_list_size = count($team_list);
		$random_index = mt_rand(0,$team_list_size-1);
		
		return $team_list[$random_index];
	}

	/**
	 * 
	 */
	function get_random_teamset()
	{
		$team_list = $this->_seed_data_get_teamset_list();
		$team_list_size = count($team_list);
		$random_index = mt_rand(0,$team_list_size-1);
		
		return $team_list[$random_index];
	}	
	
	
	/**
	 * 
	 */
	function _seed_data_get_teamset_list()
	{
		$teamsets = Array();
		$teamsets[] = array("East", "West");
		$teamsets[] = array("East", "West", "1");
		$teamsets[] = array("West", "East");		
		$teamsets[] = array("West", "East", "1");
		$teamsets[] = array("1", "East");
		$teamsets[] = array("1", "West");
		return $teamsets;
	}
		
	
	/**
	 * 
	 */
	function _seed_data_get_team_list()
	{
		$teams = Array();
//bug 28138 todo
		$teams[] = "north";
		$teams[] = "south";
		$teams[] = "left";
		$teams[] = "right";
		$teams[] = "in";
		$teams[] = "out";
		$teams[] = "fly";
		$teams[] = "walk";
		$teams[] = "crawl";
		$teams[] = "pivot";
		$teams[] = "money";
		$teams[] = "dinero";
		$teams[] = "shadow";
		$teams[] = "roof";
		$teams[] = "sales";
		$teams[] = "pillow";
		$teams[] = "feather";

		return $teams;
	}
	
	/**
	 * 
	 */
	function _quick_create($name)
	{
		if (!$this->_team->retrieve($name))
		{
			$this->_team->create_team($name, $name, $name);
		}
	}
	
	
}
?>
