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





function get_body(&$ss, $vardef){
    global $app_list_strings;
	//$edit_mod_strings = return_module_language($current_language, 'EditCustomFields');
	//$edit_mod_strings['COLUMN_TITLE_DEFAULT_VALUE'] = $edit_mod_strings['COLUMN_TITLE_URL'];
	$vars = $ss->get_template_vars();
	$fields = $vars['module']->mbvardefs->vardefs['fields'];
	$fieldOptions = array();
	foreach($fields as $id=>$def) {
		$fieldOptions[$id] = $def['name'];
	}
	$ss->assign('fieldOpts', $fieldOptions);
    $link_target = !empty($vardef['link_target']) ? $vardef['link_target'] : '_blank';
    $ss->assign('TARGET_OPTIONS', get_select_options_with_id($app_list_strings['link_target_dom'], $link_target));
    $ss->assign('LINK_TARGET', $link_target);
    $ss->assign('LINK_TARGET_LABEL', $app_list_strings['link_target_dom'][$link_target]);
    
    $ss->assign('hideReportable', true);
    $ss->assign('hideImportable', 'false');
    $ss->assign('hideDuplicatable', 'false');
    return $ss->fetch('modules/DynamicFields/templates/Fields/Forms/image.tpl');
 }

?>
