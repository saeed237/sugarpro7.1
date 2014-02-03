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



function get_body($ss, $vardef)
{
	$edit_mod_strings = return_module_language($GLOBALS['current_language'], 'EditCustomFields');
	$ss->assign('MOD', $edit_mod_strings);

	$edValue = '';
    if(!empty($vardef['default_value'])) {
        $edValue = $vardef['default_value'];
        $edValue = str_replace(array("\r\n", "\n"), " ",$edValue);
    }
    $ss->assign('HTML_EDITOR', $edValue);
    $ss->assign('preSave', 'document.popup_form.presave();');
    $ss->assign('hideReportable', true);
	///////////////////////////////////
	return $ss->fetch('modules/DynamicFields/templates/Fields/Forms/html.tpl');
}
?>
