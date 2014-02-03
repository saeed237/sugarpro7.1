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


require_once('include/EditView/EditView.php');

/**
 * QuickCreate - minimal object creation form
 * @api
 */
class QuickCreate extends EditView {
    /**
     * True if the create being populated via an AJAX call?
     */
    var $viaAJAX = false;

    function process() {
        global $current_user, $timedate;

        parent::process();

        $this->ss->assign('ASSIGNED_USER_ID', $current_user->id);
        $this->ss->assign('TEAM_ID', $current_user->default_team);

        $this->ss->assign('REQUEST', array_merge($_GET, $_POST));
        $this->ss->assign('CALENDAR_LANG', "en");

        $date_format = $timedate->get_cal_date_format();
        $this->ss->assign('USER_DATEFORMAT', '('. $timedate->get_user_date_format().')');
        $this->ss->assign('CALENDAR_DATEFORMAT', $date_format);

		$time_format = $timedate->get_user_time_format();
        $time_separator = ":";
        if(preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match)) {
           $time_separator = $match[1];
        }
        $t23 = strpos($time_format, '23') !== false ? '%H' : '%I';
        if(!isset($match[2]) || $match[2] == '') {
          $this->ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . "%M");
        } else {
          $pm = $match[2] == "pm" ? "%P" : "%p";
          $this->ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . "%M" . $pm);
        }

        $this->ss->assign('CALENDAR_FDOW', $current_user->get_first_day_of_week());
    }
}
?>
