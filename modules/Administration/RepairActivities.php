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

if(!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

global $timedate;

$callBean = BeanFactory::getBean('Calls');
$callQuery = "SELECT * FROM calls where calls.status != 'Held' and calls.deleted=0";

$result = $callBean->db->query($callQuery, true, "");
$row = $callBean->db->fetchByAssoc($result);
while ($row != null) {
    $date_end = $timedate->fromDb($row['date_start'])->modify("+{$row['duration_hours']} hours {$row['duration_minutes']} mins")->asDb();
    $updateQuery = "UPDATE calls set calls.date_end='{$date_end}' where calls.id='{$row['id']}'";
	$call = BeanFactory::getBean('Calls');
    $call->db->query($updateQuery);
    $row = $callBean->db->fetchByAssoc($result);
}

$meetingBean = BeanFactory::getBean('Meetings');
$meetingQuery = "SELECT * FROM meetings where meetings.status != 'Held' and meetings.deleted=0";

$result = $meetingBean->db->query($meetingQuery, true, "");
$row = $meetingBean->db->fetchByAssoc($result);
while ($row != null) {
    $date_end = $timedate->fromDb($row['date_start'])->modify("+{$row['duration_hours']} hours {$row['duration_minutes']} mins")->asDb();
	$updateQuery = "UPDATE meetings set meetings.date_end='{$date_end}' where meetings.id='{$row['id']}'";
	$call = BeanFactory::getBean('Calls');
    $call->db->query($updateQuery);
    $row = $callBean->db->fetchByAssoc($result);
}
echo $mod_strings['LBL_DIAGNOSTIC_DONE'];

