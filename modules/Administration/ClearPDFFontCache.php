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
    if (!$silent) { echo $mod_strings['LBL_CLEAR_PDFFONTS_DESC']; }
    require_once('include/Sugarpdf/FontManager.php');
    $fontManager = new FontManager();
    if($fontManager->clearCachedFile()){
        if( !$silent ) echo '<br><br><br><br>' . $mod_strings['LBL_CLEAR_PDFFONTS_DESC_SUCCESS'];
    }else{
        if( !$silent ) echo '<br><br><br><br>' . $mod_strings['LBL_CLEAR_PDFFONTS_DESC_FAILURE'];
    }
}
else{
    sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
}
?>