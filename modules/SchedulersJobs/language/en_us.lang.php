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

$mod_strings = array (
'LBL_NAME' => 'Job Name',
'LBL_EXECUTE_TIME'			=> 'Execute Time',
'LBL_SCHEDULER_ID' 	=> 'Scheduler',
'LBL_STATUS' 	=> 'Job Status',
'LBL_RESOLUTION' 	=> 'Result',
'LBL_MESSAGE' 	=> 'Messages',
'LBL_DATA' 	=> 'Job Data',
'LBL_REQUEUE' 	=> 'Retry on failure',
'LBL_RETRY_COUNT' 	=> 'Maximum retries',
'LBL_FAIL_COUNT' 	=> 'Failures',
'LBL_INTERVAL' 	=> 'Minimum interval between tries',
'LBL_CLIENT' 	=> 'Owning client',
'LBL_PERCENT'	=> 'Pecent complete',
'LBL_JOB_GROUP' => 'Job group',
// Errors
'ERR_CALL' 	=> "Cannot call function: %s",
'ERR_CURL' => "No CURL - cannot run URL jobs",
'ERR_FAILED' => "Unexpected failure, please check PHP logs and sugarcrm.log",
'ERR_PHP' => "%s [%d]: %s in %s on line %d",
'ERR_NOUSER' => "No User ID specified for the job",
'ERR_NOSUCHUSER' => "User ID %s not found",
'ERR_JOBTYPE' 	=> "Unknown job type: %s",
'ERR_TIMEOUT' => "Forced failure on timeout",
'ERR_JOB_FAILED_VERBOSE' => 'Job %1$s (%2$s) failed in CRON run',
);
