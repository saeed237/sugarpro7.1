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

/*********************************************************************************

 * Description:  
 ********************************************************************************/
global $mod_strings;
global $current_user;
//array("index.php?module=ProductTemplates&action=EditView&return_module=ProductTemplates&return_action=DetailView", $mod_strings['LNK_NEW_PRODUCT'],"Products"),
if(is_admin($current_user)){
$module_menu = array( 
	array("index.php?module=Schedulers&action=index", $mod_strings['LNK_LIST_SCHEDULER'],"Schedulers"),
	array("index.php?module=Schedulers&action=EditView", $mod_strings['LNK_NEW_SCHEDULER'],"CreateScheduler"),
	
);
}
?>
