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

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $mod_strings, $app_strings, $sugar_config;
	if(ACLController::checkAccess('Contacts', 'edit', true))$module_menu[] = Array("index.php?module=Contacts&action=EditView&return_module=Contacts&return_action=index", $mod_strings['LNK_NEW_CONTACT'],"CreateContacts", 'Contacts');

	if(ACLController::checkAccess('Contacts', 'import', true))$module_menu[] =Array("index.php?module=Contacts&action=ImportVCard", $mod_strings['LNK_IMPORT_VCARD'],"CreateContacts", 'Contacts');
	if(ACLController::checkAccess('Contacts', 'list', true))$module_menu[] =Array("index.php?module=Contacts&action=index&return_module=Contacts&return_action=DetailView", $mod_strings['LNK_CONTACT_LIST'],"Contacts", 'Contacts');
if(empty($sugar_config['disc_client'])){
	if(ACLController::checkAccess('Contacts', 'list', true))$module_menu[] =Array("index.php?module=Reports&action=index&view=contacts", $mod_strings['LNK_CONTACT_REPORTS'],"ContactReports", 'Contacts');
}
	if(ACLController::checkAccess('Contacts', 'import', true))$module_menu[] =Array("index.php?module=Import&action=Step1&import_module=Contacts&return_module=Contacts&return_action=index", $mod_strings['LNK_IMPORT_CONTACTS'],"Import", 'Contacts');

?>