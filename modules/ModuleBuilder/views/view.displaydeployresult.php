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

require_once('modules/ModuleBuilder/MB/AjaxCompose.php');

class ViewDisplaydeployresult extends SugarView
{
	function ViewDisplaydeployresult(){
		$this->show_header = false;
		$this->show_title = false;
 		$this->show_subpanels = false;
 		$this->show_search = false;
 		$this->show_footer = true;
 		$this->show_javascript = true;
 		$this->view_print = false;
	}

	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;

    	return array(
    	   translate('LBL_MODULE_NAME','Administration'),
    	   ModuleBuilderController::getModuleTitle(),
    	   );
    }

	function display()
	{
		$message = $this->view_object_map['message'];
		echo $message.getVersionedScript('cache/include/javascript/sugar_grp1_yui.js?')."<script type='text/javascript' language='Javascript'>YAHOO.util.Connect.asyncRequest('GET', 'index.php?module=Administration&action=RebuildRelationship&silent=true');</script>";
	}
}
