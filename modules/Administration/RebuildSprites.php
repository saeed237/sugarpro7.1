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
if(is_admin($current_user))
{
    if(!isset($_REQUEST['process']))
    {
        global $mod_strings;
        echo '<br>'.$mod_strings['LBL_REPAIR_JS_FILES_PROCESSING'];
        echo'<div id="msgDiv"></div>';
        $ss = new Sugar_Smarty();
        $ss->display('modules/Administration/templates/RebuildSprites.tpl');
    }
}

?>