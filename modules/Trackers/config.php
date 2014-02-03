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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$tracker_config = 
  array (
    'tracker' => 
    array (
      'bean' => 'Tracker',
      'name' => 'Tracker',
      'metadata' => 'modules/Trackers/vardefs.php',
      'store' => 
      array (
        0 => 'DatabaseStore',
      ),
    ),
    'tracker_sessions' => 
    array (
      'bean' => 'TrackerSession',
      'name' => 'tracker_sessions',
      'metadata' => 'metadata/tracker_sessionsMetaData.php',
      'store' => 
      array (
        0 => 'TrackerSessionsDatabaseStore',
      ),
    ),
    'tracker_perf' => 
    array (
      'bean' => 'TrackerPerf',
      'name' => 'tracker_perf',
      'metadata' => 'metadata/tracker_perfMetaData.php',
      'store' => 
      array (
        0 => 'DatabaseStore',
      ),
    ),
    'tracker_queries' => 
    array (
      'bean' => 'TrackerQuery',
      'name' => 'tracker_queries',
      'metadata' => 'metadata/tracker_queriesMetaData.php',
      'store' => 
      array (
        0 => 'TrackerQueriesDatabaseStore',
      ),
    ),
    'tracker_tracker_queries' => 
    array (
      'name' => 'tracker_tracker_queries',
      'metadata' => 'metadata/tracker_tracker_queriesMetaData.php',
      'store' => 
      array (
        0 => 'DatabaseStore',
      ),
    ),
  );
?>