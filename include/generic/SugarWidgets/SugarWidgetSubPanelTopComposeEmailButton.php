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






class SugarWidgetSubPanelTopComposeEmailButton extends SugarWidgetSubPanelTopButton
{
	var $form_value = '';
    
    public function getWidgetId()
    {
    	global $app_strings;
		$this->form_value = $app_strings['LBL_COMPOSE_EMAIL_BUTTON_LABEL'];
    	return parent::getWidgetId();
    }

	function display($defines)
	{
		if((ACLController::moduleSupportsACL($defines['module'])  && !ACLController::checkAccess($defines['module'], 'edit', true) ||
			$defines['module'] == "Activities" & !ACLController::checkAccess("Emails", 'edit', true))){
			$temp = '';
			return $temp;
		}

        /**
         * if module is hidden or subpanel for the module is hidden - doesn't show quick create button
         */
        if ( SugarWidget::isModuleHidden( 'Emails' ) )
        {
            return '';
        }

		global $app_strings,$current_user,$sugar_config,$beanList,$beanFiles;
		$title = $app_strings['LBL_COMPOSE_EMAIL_BUTTON_TITLE'];
		//$accesskey = $app_strings['LBL_COMPOSE_EMAIL_BUTTON_KEY'];
		$value = $app_strings['LBL_COMPOSE_EMAIL_BUTTON_LABEL'];
		$parent_type = $defines['focus']->module_dir;
		$parent_id = $defines['focus']->id;

		//martin Bug 19660
		$userPref = $current_user->getPreference('email_link_type');
		$defaultPref = $sugar_config['email_default_client'];
		if($userPref != '') {
			$client = $userPref;
		} else {
			$client = $defaultPref;
		}
		if($client != 'sugar') {
			$bean = $defines['focus'];
			// awu: Not all beans have emailAddress property, we must account for this
			if (isset($bean->emailAddress)){
				$to_addrs = $bean->emailAddress->getPrimaryAddress($bean);
				$button = "<input class='button' type='button'  value='$value'  id='". $this->getWidgetId() . "'  name='".preg_replace('[ ]', '', $value)."'   title='$title' onclick=\"location.href='mailto:$to_addrs';return false;\" />";
			}
			else{
				$button = "<input class='button' type='button'  value='$value'  id='". $this->getWidgetId() ."'  name='".preg_replace('[ ]', '', $value)."'  title='$title' onclick=\"location.href='mailto:';return false;\" />";
			}
		} else {
			//Generate the compose package for the quick create options.
    		$composeData = array("parent_id" => $parent_id, "parent_type"=>$parent_type);
            require_once('modules/Emails/EmailUI.php');
            $eUi = new EmailUI();
            $j_quickComposeOptions = $eUi->generateComposePackageForQuickCreate($composeData, http_build_query($composeData), false, $defines['focus']);

            $button = "<input title='$title'  id='". $this->getWidgetId()."'  onclick='SUGAR.quickCompose.init($j_quickComposeOptions);' class='button' type='submit' name='".preg_replace('[ ]', '', $value)."_button' value='$value' />";
		}
		return $button;
	}
}
