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

/**
 * Update data for renamed modules
 */
class SugarUpgradeRenameModules extends UpgradeScript
{
    public $order = 7000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        require_once('modules/Studio/wizards/RenameModules.php');
        require_once('include/utils.php');

        $klass = new RenameModules();
        $languages = get_languages();

        foreach ($languages as $langKey => $langName) {
            //get list strings for this language
            $strings = return_app_list_strings_language($langKey);

            //get base list strings for this language
            if (file_exists("include/language/$langKey.lang.php")) {
                include("include/language/$langKey.lang.php");

                //Keep only renamed modules
                $renamedModules = array_diff($strings['moduleList'], $app_list_strings['moduleList']);

                foreach ($renamedModules as $moduleId => $moduleName) {
                    if(isset($app_list_strings['moduleListSingular'][$moduleId])) {
                        $klass->selectedLanguage = $langKey;

                        $replacementLabels = array(
                            'singular' => $strings['moduleListSingular'][$moduleId],
                            'plural' => $strings['moduleList'][$moduleId],
                            'prev_singular' => $app_list_strings['moduleListSingular'][$moduleId],
                            'prev_plural' => $app_list_strings['moduleList'][$moduleId],
                            'key_plural' => $moduleId,
                            'key_singular' => $klass->getModuleSingularKey($moduleId)
                        );
                        $klass->changeModuleModStrings($moduleId, $replacementLabels);
                    }
                }
            }
        }
    }
}
