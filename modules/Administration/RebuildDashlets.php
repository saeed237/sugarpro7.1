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

global $current_user;
$silent = isset($_REQUEST['silent']) ? true : false;
if(is_admin($current_user)){
    global $mod_strings;
	if (!$silent) { echo $mod_strings['LBL_REBUILD_DASHLETS_DESC']; }
    if(is_file($cachedfile = sugar_cached('dashlets/dashlets.php'))) {
        unlink($cachedfile);
    }
    require_once('include/Dashlets/DashletCacheBuilder.php');

    $dc = new DashletCacheBuilder();
    $dc->buildCache();
   if( !$silent ) echo '<br><br><br><br>' . $mod_strings['LBL_REBUILD_DASHLETS_DESC_SUCCESS'];
}
else{
	sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}
?>