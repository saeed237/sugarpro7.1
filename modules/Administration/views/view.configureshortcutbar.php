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

class ViewConfigureshortcutbar extends SugarView
{
    /**
     * List of modules that should not be available for selection.
     *
     * @var array
     */
    private $blacklistedModules = array('EAPM', 'Users', 'Employees', 'PdfManager');
    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;

    	return array("<a href='index.php?module=Administration&action=index'>".$mod_strings['LBL_MODULE_NAME']."</a>", $mod_strings['LBL_CONFIGURE_SHORTCUT_BAR']);
    }

    /**
	 * @see SugarView::preDisplay()
	 */
	public function preDisplay()
	{
	    global $current_user;

	    if (!is_admin($current_user))
        {
	        sugar_die("Unauthorized access to administration.");
        }
	}

    /**
	 * @see SugarView::display()
	 */
    public function display()
    {
        require_once("include/JSON.php");
        $json = new JSON();

        global $mod_strings;
        global $moduleList;

        $title = getClassicModuleTitle(
            "Administration",
            array(
                "<a href='index.php?module=Administration&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>",
                translate('LBL_CONFIGURE_SHORTCUT_BAR')
            ),
            false
        );
        $msg = "";
        $failed = false;
        $GLOBALS['log']->info("Administration ConfigureShortcutBar view");

        $modulesWithQuickCreate = array();

        // get all modules that have quickcreate menus
        foreach ($moduleList as $module) {
            $quickCreateFile = "modules/$module/clients/base/menus/quickcreate/quickcreate.php";
            if (!file_exists("custom/{$quickCreateFile}") && !file_exists($quickCreateFile)) {
                continue;
            }
            if (file_exists("custom/{$quickCreateFile}")) {
                include "custom/{$quickCreateFile}";
            } else {
                include $quickCreateFile;
            }
            $modulesWithQuickCreate[$module] = !empty($viewdefs[$module]['base']['menu']['quickcreate']['visible']) ? $viewdefs[$module]['base']['menu']['quickcreate']['visible'] : false;
        }

        //If save is set, save then let the user know if the save worked.
        if (!empty($_REQUEST['enabled_modules'])) {
            $toDecode = html_entity_decode($_REQUEST['enabled_modules'], ENT_QUOTES);
            // get the enabled
            $enabledModules = array_flip(json_decode($toDecode));

            foreach ($modulesWithQuickCreate as $module => $val) {

                // didn't change don't need to change it
                if ($val === true && array_key_exists($module, $enabledModules)) {
                    continue;
                } elseif ($val === false && !array_key_exists($module, $enabledModules)) {
                    continue;
                }

                $quickCreateFile = "modules/$module/clients/base/menus/quickcreate/quickcreate.php";
                $arrayName = "viewdefs['{$module}']['base']['menu']['quickcreate']";
                // require the file
                if (file_exists("custom/{$quickCreateFile}")) {
                    include "custom/{$quickCreateFile}";
                } else {
                    include $quickCreateFile;
                }
                $viewdefs[$module]['base']['menu']['quickcreate']['visible'] = !$val;
                sugar_mkdir(dirname("custom/{$quickCreateFile}"), null, true);
                if (!write_array_to_file(
                    $arrayName,
                    $viewdefs[$module]['base']['menu']['quickcreate'],
                    "custom/{$quickCreateFile}"
                )) {
                    $failed = true;
                }
            }
            if ($failed === true) {
                echo translate("LBL_SAVE_FAILED");
            } else {
                MetaDataManager::clearAPICache();
                echo "true";
            }
        } else {
            //Start with the default module
            $enabled = array();
            $disabled = array();
            foreach ($modulesWithQuickCreate as $module => $value) {
                if ($value === true) {
                    $enabled[$module] = array("module" => $module, 'label' => translate($module));
                } else {
                    $disabled[$module] = array("module" => $module, 'label' => translate($module));
                }
            }

            ksort($enabled);
            ksort($disabled);

            $enabled = $this->filterModules($enabled);
            $disabled = $this->filterModules($disabled);
            $this->ss->assign('APP', $GLOBALS['app_strings']);
            $this->ss->assign('MOD', $GLOBALS['mod_strings']);
            $this->ss->assign('title', $title);

            $this->ss->assign('enabled_modules', $json->encode($enabled));
            $this->ss->assign('disabled_modules', $json->encode($disabled));
            $this->ss->assign('description', translate("LBL_CONFIGURE_SHORTCUT_BAR"));
            $this->ss->assign('msg', $msg);

            $returnModule = !empty($_REQUEST['return_module']) ? $_REQUEST['return_module'] : 'Administration';
            $returnAction = !empty($_REQUEST['return_action']) ? $_REQUEST['return_action'] : 'index';
            $this->ss->assign('RETURN_MODULE', $returnModule);
            $this->ss->assign('RETURN_ACTION', $returnAction);

            echo $this->ss->fetch('modules/Administration/templates/ShortcutBar.tpl');
        }
    }

    protected function filterModules($moduleList)
    {
        $results = array();
        foreach($moduleList as $mod)
        {
            if(!in_array($mod['module'], $this->blacklistedModules))
                $results[] = $mod;
        }
        return $results;
    }
}
