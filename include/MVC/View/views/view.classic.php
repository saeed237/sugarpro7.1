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

require_once('include/MVC/View/SugarView.php');
require_once('include/MVC/Controller/SugarController.php');

class ViewClassic extends SugarView
{
 	/**
 	 * @see SugarView::SugarView()
 	 */
    public function __construct(
 	    $bean = null,
        $view_object_map = array()
        )
    {
 		parent::SugarView();
 		$this->type = $this->action;
 	}

 	/**
 	 * @see SugarView::display()
 	 */
    public function display()
    {
		if(($this->bean instanceof SugarBean) && isset($this->view_object_map['remap_action']) && !$this->bean->ACLAccess($this->view_object_map['remap_action']))
		{
		  ACLController::displayNoAccess(true);
		  return false;
		}
 		// Call SugarController::getActionFilename to handle case sensitive file names
 		$file = SugarController::getActionFilename($this->action);
 		$classic_file = SugarAutoLoader::existingCustomOne('modules/' . $this->module . '/'. $file . '.php');
 		if($classic_file) {
 		    $this->includeClassicFile($classic_file);
 		    return true;
 		}
		return false;
 	}
}
