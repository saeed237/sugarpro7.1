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


require_once('include/resource/Observers/ResourceObserver.php');

/**
 * WebResourceObserver.php
 * This is a subclass of ResourceObserver to provide notification handling
 * for web clients.
 */
class WebResourceObserver extends ResourceObserver {

function WebResourceObserver($module) {
   parent::ResourceObserver($module);
}

/**
 * notify
 * Web implementation to notify the browser
 * @param msg String message to possibly display
 * 
 */
public function notify($msg = '') {
   echo $msg;
   sugar_cleanup(true);
}	
	
}

?>
