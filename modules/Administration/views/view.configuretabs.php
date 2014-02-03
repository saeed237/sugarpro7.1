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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Administration/Forms.php');
require_once('include/SubPanel/SubPanelDefinitions.php');
require_once('modules/MySettings/TabController.php');

class ViewConfiguretabs extends SugarView
{
    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".$mod_strings['LBL_MODULE_NAME']."</a>",
    	   $mod_strings['LBL_CONFIG_TABS']
    	   );
    }
    
    /**
	 * @see SugarView::preDisplay()
	 */
	public function preDisplay()
	{
	    global $current_user;
        
	    if (!is_admin($current_user)) {
	        sugar_die("Unauthorized access to administration.");
        }
	}
    
    /**
	 * @see SugarView::display()
	 */
	public function display()
	{
        global $mod_strings;
        global $app_list_strings;
        global $app_strings;
        
        require_once("modules/MySettings/TabController.php");
        $controller = new TabController();
        $tabs = $controller->get_tabs_system();
        // Remove Home module from UI.  We add it back to front of display tab list on save.
        if (isset($tabs[0]['Home'])) {
            unset($tabs[0]['Home']);
        }
        if (isset($tabs[1]['Home'])) {
            unset($tabs[1]['Home']);
        }
        $enabled= array();
        foreach ($tabs[0] as $key=>$value)
        {
            $enabled[] = array("module" => $key, 'label' => translate($key));
        }
        $disabled = array();
        foreach ($tabs[1] as $key=>$value)
        {
            $disabled[] = array("module" => $key, 'label' => translate($key));
        }
        
        $user_can_edit = $controller->get_users_can_edit();
        $this->ss->assign('APP', $GLOBALS['app_strings']);
        $this->ss->assign('MOD', $GLOBALS['mod_strings']);
        $this->ss->assign('user_can_edit',  $user_can_edit);
        $this->ss->assign('enabled_tabs', json_encode($enabled));
        $this->ss->assign('disabled_tabs', json_encode($disabled));
        $this->ss->assign('title',$this->getModuleTitle(false));
        
        //get list of all subpanels and panels to hide 
        $mod_list_strings_key_to_lower = array_change_key_case($app_list_strings['moduleList']);
        $panels_arr = SubPanelDefinitions::get_all_subpanels();
        $hidpanels_arr = SubPanelDefinitions::get_hidden_subpanels();
        
        if(!$hidpanels_arr || !is_array($hidpanels_arr)) $hidpanels_arr = array();
        
        //create array of subpanels to show, used to create Drag and Drop widget
        $enabled = array();
        foreach ($panels_arr as $key) {
            if(empty($key)) continue;
            $key = strtolower($key);
            $enabled[] =  array("module" => $key, "label" => $mod_list_strings_key_to_lower[$key]);
        }
        
        //now create array of subpanels to hide for use in Drag and Drop widget
        $disabled = array();
        foreach ($hidpanels_arr as $key) {
            if(empty($key)) continue;
            $key = strtolower($key);
            $disabled[] =  array("module" => $key, "label" => $mod_list_strings_key_to_lower[$key]);
        }
        
        $this->ss->assign('enabled_panels', json_encode($enabled));
        $this->ss->assign('disabled_panels', json_encode($disabled));
        
        echo $this->ss->fetch('modules/Administration/templates/ConfigureTabs.tpl');	
    }
}
