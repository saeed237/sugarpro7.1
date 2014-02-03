<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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
		global $current_language;
		$smarty = new Sugar_Smarty();
			$temp_bean_list = $beanList;
			asort($temp_bean_list);
			$values= array_values($temp_bean_list);
			$output= array_keys($temp_bean_list);  
			$output_local = array();
			if($current_language != 'en_us') {
				foreach($output as $temp_out) {
					$output_local[] = translate($temp_out);
				}
			} else {
				$output_local = $output;
			}
			//sort($output);
			//sort($values);
			$values=array_merge(array($mod_strings['LBL_ALL_MODULES']), $values);
			$output= array_merge(array($mod_strings['LBL_ALL_MODULES']),$output_local);
			$checkbox_values=array(
									 'clearTpls',
									 'clearJsFiles',
									 'clearVardefs', 
									 'clearJsLangFiles',
									 'clearDashlets',
									 'clearThemeCache',
									 'rebuildAuditTables',
									 'rebuildExtensions',
									 'clearLangFiles',
                                     'clearSearchCache',
			                         'clearPDFFontCache',
			                         //'repairDatabase'
									 );
			$checkbox_output = array(   $mod_strings['LBL_QR_CBOX_CLEARTPL'], 
                                        $mod_strings['LBL_QR_CBOX_CLEARJS'],
                                        $mod_strings['LBL_QR_CBOX_CLEARVARDEFS'],
                                        $mod_strings['LBL_QR_CBOX_CLEARJSLANG'],
                                        $mod_strings['LBL_QR_CBOX_CLEARDASHLET'],
                                        $mod_strings['LBL_QR_CBOX_CLEARTHEMECACHE'],
                                        $mod_strings['LBL_QR_CBOX_REBUILDAUDIT'],
                                        $mod_strings['LBL_QR_CBOX_REBUILDEXT'],
                                        $mod_strings['LBL_QR_CBOX_CLEARLANG'],
                                        $mod_strings['LBL_QR_CBOX_CLEARSEARCH'],
                                        $mod_strings['LBL_QR_CBOX_CLEARPDFFONT'],
                                        //$mod_strings['LBL_QR_CBOX_DATAB'],
									 );
			$smarty->assign('checkbox_values', $checkbox_values);
			$smarty->assign('values', $values);
			$smarty->assign('output', $output);
			$smarty->assign('MOD', $mod_strings);
			$smarty->assign('checkbox_output', $checkbox_output);
			$smarty->assign('checkbox_values', $checkbox_values);
			$smarty->display("modules/Administration/templates/QuickRepairAndRebuild.tpl");

