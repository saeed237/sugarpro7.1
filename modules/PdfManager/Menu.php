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


global $mod_strings, $sugar_config, $app_strings;

if(SugarACL::checkAccess('PdfManager', 'edit', true))$module_menu[] =Array("index.php?module=PdfManager&action=EditView&return_module=PdfManager&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'],"CreatePdfManager");
if(SugarACL::checkAccess('PdfManager', 'list', true))$module_menu[] =Array("index.php?module=PdfManager&action=index&return_module=PdfManager&return_action=index", $mod_strings['LNK_LIST'],"PdfManager");

$module_menu[] =Array("index.php?return_module=PdfManager&return_action=index&module=Configurator&action=SugarpdfSettings", $mod_strings['LNK_EDIT_PDF_TEMPLATE'], "PdfManager");
