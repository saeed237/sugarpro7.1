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




global $mod_strings;
global $current_user;

if (ACLController :: checkAccess('Contracts', 'edit', true))
{
    $module_menu[] = array ('index.php?module=Contracts&action=EditView&return_module=Contracts&return_action=DetailView', $mod_strings['LNK_NEW_CONTRACT'], 'CreateContracts');
}

if (ACLController :: checkAccess('Contracts', 'list', true))
{
    $module_menu[] = array ('index.php?module=Contracts&action=index', $mod_strings['LNK_CONTRACT_LIST'], 'Contracts');
}

if (ACLController :: checkAccess('Contracts', 'detail', true)) {
	
	$admin = Administration::getSettings();
}

if (ACLController::checkAccess('Contracts', 'import', true))
{
    $module_menu[] = array(
    	"index.php?module=Import&action=Step1&import_module=Contracts&return_module=Contracts&return_action=index",
        $mod_strings['LNK_IMPORT_CONTRACTS'],
    	"Import",
    	'Contracts'
	);
}

?>
