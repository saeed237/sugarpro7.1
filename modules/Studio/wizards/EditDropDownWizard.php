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




require_once('modules/Studio/DropDowns/DropDownHelper.php');
class EditDropDownWizard extends StudioWizard {
	var $wizard = 'EditDropDownWizard';
    function welcome(){
		return 'You can rename the global dropdown list here.';
	}
	function back(){
	    
	    ob_clean();
	     if(!empty($_SESSION['studio']['module'])){
	        header('Location: index.php?action=wizard&module=Studio&wizard=SelectModuleAction');
	        sugar_cleanup(true);
	     }
	     header('Location: index.php?action=wizard&module=Studio&wizard=StudioWizard');
	    sugar_cleanup(true);
	     
	    
	   
	}
	function options(){
//		return array('EditDropdown'=>$GLOBALS['mod_strings']['LBL_SW_EDIT_DROPDOWNS'], 'CreateDropdown'=>$GLOBALS['mod_strings']['LBL_ED_CREATE_DROPDOWN'] );
	}
	
	function process($option){
		switch($option){
		    case 'EditDropdown':
		        parent::process($option);
		        require_once('modules/Studio/DropDowns/EditView.php');
		        break;
		    case 'SaveDropDown':
		        DropDownHelper::saveDropDown($_REQUEST);
		        require_once('modules/Studio/DropDowns/EditView.php');
		        break;
		    default:
		         parent::process($option);
		}
	}
	
	function display()
	{
	    // override the parent display - don't display any wizard stuff
	}
	
}

?>
