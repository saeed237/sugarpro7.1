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

class CampaignsViewClassic extends SugarView
{
 	function CampaignsViewClassic()
 	{
 		parent::SugarView();
 		$this->type = $this->action;
 	}

 	/**
	 * @see SugarView::display()
	 */
	public function display()
	{
 		// Call SugarController::getActionFilename to handle case sensitive file names
 		$file = SugarController::getActionFilename($this->action);
 		$classic = SugarAutoLoader::existingCustomOne('modules/' . $this->module . '/'. $file . '.php');
 		if($classic) {
 		    $this->includeClassicFile($classic);
 		    return true;
 		}
		return false;
 	}

    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
    	$params = array();
    	$params[] = $this->_getModuleTitleListParam($browserTitle);
    	if (isset($this->action)){
    		switch($_REQUEST['action']){
    				case 'WizardHome':
				    	if(!empty($this->bean->id))
				    	{
				    		$params[] = "<a href='index.php?module={$this->module}&action=DetailView&record={$this->bean->id}'>".$this->bean->name."</a>";
				    	}
				    	$params[] = $GLOBALS['mod_strings']['LBL_CAMPAIGN_WIZARD'];
				    	break;
				    case 'WebToLeadCreation':
    					$params[] = $GLOBALS['mod_strings']['LBL_LEAD_FORM_WIZARD'];
    					break;
    				case 'WizardNewsletter':
				    	if(!empty($this->bean->id))
				    	{
				    		$params[] = "<a href='index.php?module={$this->module}&action=DetailView&record={$this->bean->id}'>".$GLOBALS['mod_strings']['LBL_NEWSLETTER_TITLE']."</a>";
				    	}
				    	$params[] = $GLOBALS['mod_strings']['LBL_CREATE_NEWSLETTER'];
				    	break;
    				case 'CampaignDiagnostic':
    					$params[] = $GLOBALS['mod_strings']['LBL_CAMPAIGN_DIAGNOSTICS'];
    					break;
    				case 'WizardEmailSetup':
    					$params[] = $GLOBALS['mod_strings']['LBL_EMAIL_SETUP_WIZARD_TITLE'];
    					break;
    				case 'TrackDetailView':
    					if(!empty($this->bean->id))
    					{
	    					$params[] = "<a href='index.php?module={$this->module}&action=DetailView&record={$this->bean->id}'>".$this->bean->name."</a>";
    					}
	    				$params[] = $GLOBALS['mod_strings']['LBL_LIST_TO_ACTIVITY'];
    					break;
    		}//switch
    	}//fi

    	return $params;
    }
}