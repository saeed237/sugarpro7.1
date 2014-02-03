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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
global $mod_strings;
$module_menu = Array();
$module_menu[]= array("index.php?module=InboundEmail&action=EditView", $mod_strings['LNK_LIST_CREATE_NEW_GROUP'],"CreateMailboxes");
$module_menu[]= array("index.php?module=InboundEmail&action=EditView&mailbox_type=bounce", $mod_strings['LNK_LIST_CREATE_NEW_BOUNCE'],"CreateBounceboxes");
$module_menu[]= array("index.php?module=InboundEmail&action=index", $mod_strings['LNK_LIST_MAILBOXES'],"InboundEmail");

if(is_admin($GLOBALS['current_user']))$module_menu[]= array("index.php?module=Schedulers&action=index", $mod_strings['LNK_LIST_SCHEDULER'],"Schedulers");
	//array("index.php?module=Queues&action=Seed", $mod_strings['LNK_SEED_QUEUES'],"CustomQueries"),
?>
