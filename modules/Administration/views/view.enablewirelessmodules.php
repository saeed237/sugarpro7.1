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


require_once('include/SugarLicensing/SugarLicensing.php');

class AdministrationViewEnablewirelessmodules extends SugarView
{
 	/**
	 * @see SugarView::preDisplay()
	 */
	public function preDisplay()
    {
        if(!is_admin($GLOBALS['current_user']))
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
    }

    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;

    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".$mod_strings['LBL_MODULE_NAME']."</a>",
    	   translate('LBL_WIRELESS_MODULES_ENABLE')
    	   );
    }

    /**
	 * @see SugarView::display()
	 */
	public function display()
	{
        require_once('modules/Administration/Forms.php');

        global $mod_strings;
        global $app_list_strings;
        global $app_strings;
        global $license;
        global $current_user;
        global $currentModule;

        $configurator = new Configurator();
        $this->ss->assign('config', $configurator->config);

        $enabled_modules = array();
        $disabled_modules = array();

        // replicate the essential part of the behavior of the private loadMapping() method in SugarController
        foreach (SugarAutoLoader::existingCustom('include/MVC/Controller/wireless_module_registry.php') as $file)
        {
            require $file;
        }

        foreach ( $wireless_module_registry as $e => $def )
        {
            if (in_array($e, $GLOBALS['moduleList']))
            {
                $enabled_modules [ $e ] = empty($app_list_strings['moduleList'][$e]) ? $e : ($app_list_strings['moduleList'][$e]);
            }
        }

        // Employees should be in the mobile module list by default
        if (!empty($wireless_module_registry['Employees']))
        {
            $enabled_modules ['Employees'] = $app_strings['LBL_EMPLOYEES'];
        }

        require_once('modules/ModuleBuilder/Module/StudioBrowser.php');
        $browser = new StudioBrowser();
        $browser->loadModules();

        foreach ( $browser->modules as $e => $def)
        {
            if ( empty ( $enabled_modules [ $e ]) && in_array($e, $GLOBALS['moduleList']) )
            {
                $disabled_modules [ $e ] = empty($app_list_strings['moduleList'][$e]) ? $e : ($app_list_strings['moduleList'][$e]);
            }
        }

        if (empty($wireless_module_registry['Employees']))
        {
            $disabled_modules ['Employees'] = $app_strings['LBL_EMPLOYEES'];
        }

        $json_enabled = array();
        foreach($enabled_modules as $mod => $label)
        {
            $json_enabled[] = array("module" => $mod, 'label' => $label);
        }

        $json_disabled = array();
        foreach($disabled_modules as $mod => $label)
        {
            $json_disabled[] = array("module" => $mod, 'label' => $label);
        }

        // We need to grab the license key
        $key = $license->settings["license_key"];
        $this->ss->assign('url', $this->getMobileEdgeUrl($key));

        $this->ss->assign('enabled_modules', json_encode($json_enabled));
        $this->ss->assign('disabled_modules', json_encode($json_disabled));
        $this->ss->assign('mod', $GLOBALS['mod_strings']);
        $this->ss->assign('APP', $GLOBALS['app_strings']);

        echo getClassicModuleTitle(
                "Administration",
                array(
                    "<a href='index.php?module=Administration&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>",
                   translate('LBL_WIRELESS_MODULES_ENABLE')
                   ),
                false
                );
        echo $this->ss->fetch('modules/Administration/templates/enableWirelessModules.tpl');
    }

    /**
     * Grab the mobile edge server link by polling the licensing server.
     * @returns string url
     */
    protected function getMobileEdgeUrl($license) {
        $licensing = new SugarLicensing();
        $result = $licensing->request("/rest/fetch/mobileserver", array('key' => $license));

        // Check if url exists for the provided key.
        if (isset($result["mobileserver"]["server"]["url"])) {
            return $result["mobileserver"]["server"]["url"];
        } else {
            return '';
        }
    }
}
