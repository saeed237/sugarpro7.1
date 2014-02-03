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
 * External API to meeting system
 * @api
 */
interface WebMeeting {
	public function scheduleMeeting($bean);
	public function unscheduleMeeting($bean);
	public function inviteAttendee($bean, $attendee, $sendInvites = false);
	public function uninviteAttendee($bean, $attendee);
	public function listMyMeetings();
	public function getMeetingDetails($bean);
}
