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

require_once('include/EditView/SubpanelQuickCreate.php');
/**
 * Quick create form as a pop-up window
 * @api
 */
class PopupQuickCreate extends SubpanelQuickCreate{

	function PopupQuickCreate($module, $view='QuickCreate'){
		$this->defaultProcess = false;
		parent::SubpanelQuickCreate($module, $view, true);
		$this->ev->defs['templateMeta']['form']['buttons'] = array('POPUPSAVE', 'POPUPCANCEL');
	}

	function process($module){
        $form_name = 'form_QuickCreate_' . $module;
        $this->ev->formName = $form_name;
        $this->ev->process(true, $form_name);
		return $this->ev->display(false, true);
	}
}
?>