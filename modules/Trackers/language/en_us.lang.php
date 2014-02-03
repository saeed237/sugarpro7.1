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

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array (
		  //Labels for methods in the TrackerReporter.php file that are shown in TrackerDashlet
		  'ShowActiveUsers'      => 'Show Active Users',
		  'ShowLastModifiedRecords' => 'Last 10 Modified Records',
		  'ShowTopUser' => 'Top User',
		  'ShowMyModuleUsage' => 'My Module Usage',
		  'ShowMyWeeklyActivities' => 'My Weekly Activity',
		  'ShowTop3ModulesUsed' => 'My Top 3 Modules Used',
		  'ShowLoggedInUserCount' => 'Active User Count',
		  'ShowMyCumulativeLoggedInTime' => 'My Cumulative Login Time (This Week)',
		  'ShowUsersCumulativeLoggedInTime' => 'Users Cumulative Login Time (This Week)',
		  
		  //Column header mapping
		  'action' => 'Action',
		  'active_users' => 'Active User Count',
		  'date_modified' => 'Date of Last Action',
		  'different_modules_accessed' => 'Number Of Modules Accessed',
		  'first_name' => 'First Name',
		  'item_id' => 'ID',
		  'item_summary' => 'Name',
		  'last_action' => 'Last Action Date/Time',
		  'last_name' => 'Last Name',
		  'module_name' => 'Module Name',
		  'records_modified' => 'Total Records Modified',
		  'top_module' => 'Top Module Accessed',
		  'total_count' => 'Total Page Views',
		  'total_login_time' => 'Time (hh:mm:ss)',
		  'user_name' => 'Username',
		  'users' => 'Users',
		  
		  //Administration related labels
		  'LBL_ENABLE' => 'Enabled',
		  'LBL_MODULE_NAME_TITLE' => 'Trackers',
		  'LBL_MODULE_NAME' => 'Trackers',
		  'LBL_MODULE_NAME_SINGULAR' => 'Tracker',
		  'LBL_TRACKER_SETTINGS' => 'Tracker Settings',
		  'LBL_TRACKER_QUERIES_DESC' => 'Tracker Queries',
		  'LBL_TRACKER_QUERIES_HELP' => 'Track SQL statements when "Log slow queries" is enabled and the query execution time exceeds the "Slow query time threshold" value',
		  'LBL_TRACKER_PERF_DESC' => 'Tracker Performance',
		  'LBL_TRACKER_PERF_HELP' => 'Track database roundtrips, files accessed and memory usage',
		  'LBL_TRACKER_SESSIONS_DESC' => 'Tracker Sessions',
		  'LBL_TRACKER_SESSIONS_HELP' => 'Track active users and users&rsquo; session information',
		  'LBL_TRACKER_DESC' => 'Tracker Actions',
		  'LBL_TRACKER_HELP' => 'Track user&rsquo;s page views (modules and records accessed) and record saves',
		  'LBL_TRACKER_PRUNE_INTERVAL' => 'Number of days of Tracker data to store when Scheduler prunes the tables',
		  'LBL_TRACKER_PRUNE_RANGE' => 'Number of days',
);
?>
