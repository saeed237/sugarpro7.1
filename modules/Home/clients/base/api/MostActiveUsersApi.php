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


require_once('include/api/SugarApi.php');

class MostActiveUsersApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'mostactiveusers' => array(
                'reqType' => 'GET',
                'path' => array('mostactiveusers'),
                'pathVars' => array(),
                'method' => 'getMostActiveUsers',
                'shortHelp' => 'Returns most active users',
                'longHelp' => 'modules/Home/clients/base/api/help/MostActiveUsersApi.html',
            ),
        );
    }

    /**
     * Returns most active users for last n days
     * @param $api
     * @param $args
     * @return array
     */
    public function getMostActiveUsers($api, $args) {
        $days = isset($args['days']) ? (int) $args['days'] : 30;

        // meetings
        $query = "SELECT meetings.assigned_user_id user_id, count(meetings.id) count, users.first_name, users.last_name FROM meetings, users WHERE meetings.assigned_user_id = users.id AND users.deleted = 0 AND meetings.status='Held' AND meetings.date_modified > (CURDATE() - INTERVAL ".$days." DAY) GROUP BY user_id ORDER BY count DESC limit 1";
        $GLOBALS['log']->debug("Finding most active users for Meetings: ".$query);
        $result = $GLOBALS['db']->query($query);
        $meetings = array();
        
        if (!empty($result)) {
            $row = $GLOBALS['db']->fetchByAssoc($result);
            if (!empty($row)) {
                $meetings = $row;
            }
        }

        // calls
        $query = "SELECT calls.assigned_user_id user_id, count(calls.id) count, users.first_name, users.last_name FROM calls, users WHERE calls.assigned_user_id = users.id AND users.deleted = 0 AND calls.status='Held' AND calls.date_modified > (CURDATE() - INTERVAL ".$days." DAY) GROUP BY user_id ORDER BY count DESC limit 1";
        $GLOBALS['log']->debug("Finding most active users for Calls: ".$query);
        $result = $GLOBALS['db']->query($query);
        $calls = array();
        
        if (!empty($result)) {
            $row = $GLOBALS['db']->fetchByAssoc($result);
            if (!empty($row)) {
                $calls = $row;
            }
        }
        
        // inbound emails
        $query = "SELECT emails.assigned_user_id user_id, count(emails.id) count, users.first_name, users.last_name FROM emails, users WHERE emails.assigned_user_id = users.id AND users.deleted = 0 AND emails.type = 'inbound' AND emails.date_entered > (CURDATE() - INTERVAL ".$days." DAY) GROUP BY user_id ORDER BY count DESC limit 1";
        $GLOBALS['log']->debug("Finding most active users for Inbound Emails: ".$query);
        $result = $GLOBALS['db']->query($query);
        $inbounds = array();
        
        if (!empty($result)) {
            $row = $GLOBALS['db']->fetchByAssoc($result);
            if (!empty($row)) {
                $inbounds = $row;
            }
        }
        
        // outbound emails
        $query = "SELECT emails.assigned_user_id user_id, count(emails.id) count, users.first_name, users.last_name FROM emails, users WHERE emails.assigned_user_id = users.id AND users.deleted = 0 AND emails.status='sent' AND emails.type = 'out' AND emails.date_entered > (CURDATE() - INTERVAL ".$days." DAY) GROUP BY user_id ORDER BY count DESC limit 1";
        $GLOBALS['log']->debug("Finding most active users for Outbound Emails: ".$query);
        $result = $GLOBALS['db']->query($query);
        $outbounds = array();
        
        if (!empty($result)) {
            $row = $GLOBALS['db']->fetchByAssoc($result);
            if (!empty($row)) {
                $outbounds = $row;
            }
        }
        
        return array('meetings' => $meetings, 'calls' => $calls, 'inbound_emails' => $inbounds, 'outbound_emails' => $outbounds);
    }
}
