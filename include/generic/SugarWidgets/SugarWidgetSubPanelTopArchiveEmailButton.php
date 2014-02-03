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






class SugarWidgetSubPanelTopArchiveEmailButton extends SugarWidgetSubPanelTopButton
{
	function display($defines)
	{
		if((ACLController::moduleSupportsACL($defines['module'])  && !ACLController::checkAccess($defines['module'], 'edit', true) ||
			$defines['module'] == "History" & !ACLController::checkAccess("Emails", 'edit', true))){
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
		
		global $app_strings;
		global $mod_strings;
		global $currentModule;

		$title = $app_strings['LBL_TRACK_EMAIL_BUTTON_TITLE'];
		$value = $app_strings['LBL_TRACK_EMAIL_BUTTON_LABEL'];
		$this->module = 'Emails';

		$additionalFormFields = array();
		$additionalFormFields['type'] = 'archived';
		// cn: bug 5727 - must override the parents' parent for contacts (which could be an Account)
		$additionalFormFields['parent_type'] = $defines['focus']->module_dir; 
		$additionalFormFields['parent_id'] = $defines['focus']->id;
		$additionalFormFields['parent_name'] = $defines['focus']->name;

		if(isset($defines['focus']->email1))
		{
			$additionalFormFields['to_email_addrs'] = $defines['focus']->email1;
		}
		if(ACLController::moduleSupportsACL($defines['module'])  && !ACLController::checkAccess($defines['module'], 'edit', true)){
			$button = "<input id='".preg_replace('[ ]', '', $value)."_button'  title='$title' class='button' type='button' name='".preg_replace('[ ]', '', strtolower($value))."_button' value='$value' disabled/>\n";
			return $button;
		}
		$button = $this->_get_form($defines, $additionalFormFields);
		$button .= "<input id='".preg_replace('[ ]', '', $value)."_button' title='$title' class='button' type='submit' name='".preg_replace('[ ]', '', strtolower($value))."_button' value='$value'/>\n";
		$button .= "</form>";
		return $button;
	}
}
?>
