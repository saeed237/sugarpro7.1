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

require_once('modules/Notifications/Notifications.php');

class NotificationsController extends SugarController
{
    var $action_remap = array ( ) ;

    /**
     * DEPRECATED 
     *
     */
    function action_checkNewNotifications()
    {
	    global $timedate;
	   
	    $thirtySecondsAgoFormatted = $timedate->getNow()->get("30 seconds ago")->asDb();

	    $now = $timedate->nowDb();

	    $lastNotiticationCheck = !empty($_SESSION['lastNotificationCheck']) ? $_SESSION['lastNotificationCheck'] : $thirtySecondsAgoFormatted;
	    
        $n = BeanFactory::getBean('Notifications');
        $unreadCount = $n->retrieveUnreadCountFromDateEnteredFilter($lastNotiticationCheck);
        
        //Store the last datetime checked.
        $_SESSION['lastNotificationCheck'] = $now;
        
        $results = array('unreadCount' => $unreadCount );

	    $json = getJSONobj();
		$out = $json->encode($results);
		ob_clean();
		print($out);
		sugar_cleanup(true);
	    
    }
}
?>
