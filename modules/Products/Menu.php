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

if(ACLController::checkAccess('Products', 'edit', true))$module_menu[] = Array("index.php?module=Products&action=EditView&return_module=Products&return_action=DetailView", $mod_strings['LNK_NEW_PRODUCT'],"CreateProducts");
if(ACLController::checkAccess('Products', 'list', true))$module_menu[] =Array("index.php?module=Products&action=index&return_module=Products&return_action=DetailView", $mod_strings['LNK_PRODUCT_LIST'],"Price_List");
if(ACLController::checkAccess('Products', 'import', true))$module_menu[] =Array("index.php?module=Import&action=Step1&import_module=Products&return_module=Products&return_action=index", $mod_strings['LNK_IMPORT_PRODUCTS'],"Import", 'Products');


?>
