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






class SugarWidgetSubPanelEmailLink extends SugarWidgetField {

	function displayList(&$layout_def) {
		global $current_user;
		global $beanList;
		global $focus;
		global $sugar_config;
		global $locale;

		if(isset($layout_def['varname'])) {
			$key = strtoupper($layout_def['varname']);
		} else {
			$key = $this->_get_column_alias($layout_def);
			$key = strtoupper($key);
		}
		$value = $layout_def['fields'][$key];



			if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
			else $action = '';

			if(isset($_REQUEST['module'])) $module = $_REQUEST['module'];
			else $module = '';

			if(isset($_REQUEST['record'])) $record = $_REQUEST['record'];
			else $record = '';

			if (!empty($focus->name)) {
				$name = $focus->name;
			} else {
				if( !empty($focus->first_name) && !empty($focus->last_name)) {
					$name = $locale->getLocaleFormattedName($focus->first_name, $focus->last_name);
					}
				if(empty($name)) {
					$name = '*';
				}
			}

			$userPref = $current_user->getPreference('email_link_type');
			$defaultPref = $sugar_config['email_default_client'];
			if($userPref != '') {
				$client = $userPref;
			} else {
				$client = $defaultPref;
			}

			if($client == 'sugar')
			{
			    $composeData = array(
			        'load_id' => $layout_def['fields']['ID'],
                    'load_module' => $this->layout_manager->defs['module_name'],
                    'parent_type' => $this->layout_manager->defs['module_name'],
                    'parent_id' => $layout_def['fields']['ID'],
			        'return_module' => $module,
			        'return_action' => $action,
			        'return_id' => $record
			    );
                if(isset($layout_def['fields']['FULL_NAME'])){
                    $composeData['parent_name'] = $layout_def['fields']['FULL_NAME'];
                    $composeData['to_email_addrs'] = sprintf("%s <%s>", $layout_def['fields']['FULL_NAME'], $layout_def['fields']['EMAIL1']);
                } else {
                    $composeData['to_email_addrs'] = $layout_def['fields']['EMAIL1'];
                }
                require_once('modules/Emails/EmailUI.php');
                $eUi = new EmailUI();
                $j_quickComposeOptions = $eUi->generateComposePackageForQuickCreate($composeData, http_build_query($composeData), true);

                $link = "<a href='javascript:void(0);' onclick='SUGAR.quickCompose.init($j_quickComposeOptions);'>";
			} else {
				$link = '<a href="mailto:' . $value .'" >';
			}

			return $link.$value.'</a>';

	}
} // end class def
