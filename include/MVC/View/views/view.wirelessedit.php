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

require_once('include/SugarWireless/SugarWirelessView.php');

/**
 * ViewWirelessdetail extends SugarWirelessView and is the view for wireless
 * edit views.
 */
class ViewWirelessedit extends SugarWirelessView
{
 	/**
 	 * Public function to set up the relate POST parameters in form
 	 */
 	protected function relate_module(){
		$this->ss->assign('RELATE_MODULE', true);
		$this->ss->assign('RELATE_TO', $_POST['related_module']);
		$this->ss->assign('RELATE_ID', $_POST['relate_id']);
		$this->ss->assign('RELATED_MODULE', $_POST['related_module']);
		$this->ss->assign('RETURN_MODULE', $_POST['related_module']);
		$this->ss->assign('RETURN_ID', $_POST['relate_id']);

        require("include/modules.php");
        $this->ss->assign('RELATE_FIELD',strtolower($beanList[$_POST['related_module']]).'_id');

        if ( isset($_POST['from_subpanel']) && $_POST['from_subpanel'] == '1' ) {
	            $defs = SugarAutoLoader::existingCustomOne('modules/'.$_POST['related_module'].'/metadata/wireless.subpaneldefs.php');
	            if($defs) {
	                require $defs;
	            }
                //If an Ext/WirelessLayoutdefs/wireless.subpaneldefs.ext.php file exists, then also load it as well
                $defs = SugarAutoLoader::loadExtension("wireless_subpanels", $_POST['related_module']);
                if($defs) {
                    require $defs;
                }

                if ( isset($layout_defs[$_POST['related_module']]['subpanel_setup']) ) {
                foreach ( $layout_defs[$_POST['related_module']]['subpanel_setup'] as $data ) {
                    if ( $data['module'] == $this->module ) {
                        $this->ss->assign('RELATE_NAME', $data['get_subpanel_data']);
                    }
                }
            }
        }
 	}

 	/**
 	 * Public function that handles the display of the wireless edit view.
 	 */
 	public function display(){
		// print the header
 	    $this->wl_header();
 	    // print the select list
		$this->wl_select_list();

		// retrieve the fields
		$this->ss->assign('fields', $this->get_field_defs());

        // Set return module and action
        $this->ss->assign('RETURN_MODULE', $this->module);
        $this->ss->assign('RETURN_ACTION', $_POST['return_action']);

		// check to see if the edit is coming from Add Related form
		if (!empty($_POST['relate_to']) || !empty($_POST['relate_id'])){
			$this->relate_module();
		}

		// set up Smarty variables
		$this->ss->assign('BEAN_ID', $this->bean->id);
		$this->ss->assign('BEAN_NAME', $this->bean->name);
	   	$this->ss->assign('MODULE', $this->module);
	   	$this->ss->assign('MODULE_NAME', translate('LBL_MODULE_NAME',$this->module));
	   	$this->ss->assign('DETAILS', $this->bean_details('WirelessEditView'));

	   	// display the edit view
		$this->ss->display('include/SugarWireless/tpls/wirelessedit.tpl');

		// print the footer
		$this->wl_footer();

		// allow Tracker to pick up this edit view hit
		$this->action = 'EditView';
 	}

}
?>
