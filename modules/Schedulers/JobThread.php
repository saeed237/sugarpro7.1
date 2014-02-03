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


/*if($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']) { // make sure this script only gets executed locally
	header('Location: index.php?action=Login&module=Users');
	return;
} else
*/
if(!empty($_REQUEST['job_id'])) {
	
	
	$job_id = $_REQUEST['job_id'];

	if(empty($GLOBALS['log'])) { // setup logging
		
		$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM'); 	
	}
	ob_implicit_flush();
	ignore_user_abort(true);// keep processing if browser is closed
	set_time_limit(0);// no time out
	$GLOBALS['log']->debug('Job [ '.$job_id.' ] is about to FIRE. Updating Job status in DB');
	$qLastRun = "UPDATE schedulers SET last_run = '".$runTime."' WHERE id = '".$job_id."'";
	$this->db->query($qStatusUpdate);
	$this->db->query($qLastRun);
	
	$job = new Job();
	$job->runtime = TimeDate::getInstance()->nowDb();
	if($job->startJob($job_id)) {
		$GLOBALS['log']->info('----->Job [ '.$job_id.' ] was fired successfully');
	} else {
		$GLOBALS['log']->fatal('----->Job FAILURE job [ '.$job_id.' ] could not complete successfully.');
	}
	
	$GLOBALS['log']->debug('Job [ '.$a['job'].' ] has been fired - dropped from schedulers_times queue and last_run updated');
	$this->finishJob($job_id);
	return true;
} else {
	$GLOBALS['log']->fatal('JOB FAILURE JobThread.php called with no job_id.  Suiciding this thread.');
	die();
}
?>
