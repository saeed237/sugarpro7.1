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


class ACLFieldsEditView{
	function getView($module, $role_id){
		$fields = ACLField::getFields( $module, '', $role_id);
		$sugar_smarty = new Sugar_Smarty();
		if(substr($module, 0, 2)=='KB'){
        	$sugar_smarty->assign('LBL_MODULE', 'KBDocuments');
        }
        else{
        	$sugar_smarty->assign('LBL_MODULE', $module);
        }
        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], 'ACLFields');
		$sugar_smarty->assign('MOD', $GLOBALS['mod_strings']);
		$sugar_smarty->assign('APP', $GLOBALS['app_strings']);
		$sugar_smarty->assign('FLC_MODULE', $module);
		$sugar_smarty->assign('APP_LIST', $GLOBALS['app_list_strings']);
		$sugar_smarty->assign('FIELDS', $fields);
		foreach($GLOBALS['aclFieldOptions'] as $key=>$option){
			$GLOBALS['aclFieldOptions'][$key] = translate($option, 'ACLFields');
		}
		$sugar_smarty->assign('OPTIONS',  $GLOBALS['aclFieldOptions']);
		$req_options = $GLOBALS['aclFieldOptions'];
		unset($req_options[-99]);
		$sugar_smarty->assign('OPTIONS_REQUIRED',  $req_options);
		return  $sugar_smarty->fetch('modules/ACLFields/EditView.tpl');
	}
}
?>