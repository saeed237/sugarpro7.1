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
 * ResourceObserver.php
 * This class serves as the base class for the notifier/observable pattern used
 * by the resource management framework.
 */
class ResourceObserver {

var $module;
var $limit;

function ResourceObserver($module) {
	$this->module = $module;
}

function setLimit($limit) {
	$this->limit = $limit;
}

function notify($msg = '') {
    if($this->dieOnError) {
       die($GLOBALS['app_strings']['ERROR_NOTIFY_OVERRIDE']);
    } else {
       echo($GLOBALS['app_strings']['ERROR_NOTIFY_OVERRIDE']);	
    }
}	
	
}

?>
