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

global $mod_strings, $app_strings;
$module_menu = Array();
if(is_admin_for_module($GLOBALS['current_user'],'Products'))$module_menu[]= Array("index.php?module=Shippers&action=EditView&return_module=Shippers&return_action=DetailView", $mod_strings['LNK_NEW_SHIPPER'],"Shippers");
                                                            $module_menu[]= Array("index.php?module=TaxRates&action=EditView&return_module=TaxRates&return_action=DetailView", $mod_strings['LNK_NEW_TAXRATE'],"TaxRates");if(ACLController::checkAccess('TaxRates', 'import', true))  $module_menu[] =Array("index.php?module=Import&action=Step1&import_module=TaxRates&return_module=TaxRates&return_action=index", $mod_strings['LNK_IMPORT_TAXRATES'],"Import", 'Contacts');

?>