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




require_once 'modules/Administration/Common.php';
class TabGroupHelper
{
    public $modules = array();
    public function getAvailableModules($lang = '')
    {
        static $availableModules = array();
        if (!empty($availableModules)) return $availableModules;
        
        $specifyLanguageAppListStrings = $GLOBALS['app_list_strings'];
        if (!empty($lang)) {
            $specifyLanguageAppListStrings = return_app_list_strings_language($lang);
        }
        foreach ($GLOBALS['moduleList'] as $value) {
            $availableModules[$value] = array('label'=>$specifyLanguageAppListStrings['moduleList'][$value], 'value'=>$value);
        }

        if (should_hide_iframes() && isset($availableModules['iFrames'])) {
           unset($availableModules['iFrames']);
        }
        return $availableModules;
    }

    /**
     * Takes in the request params from a save request and processes
     * them for the save.
     *
     * @param REQUEST params  $params
     */
    public function saveTabGroups($params)
    {
        //#30205
        global $sugar_config, $locale;

        //Get the selected tab group language
        if (!empty($_REQUEST['grouptab_lang'])) {
            $grouptab_lang = $_REQUEST['grouptab_lang'];
        } else {
            $grouptab_lang = $locale->getAuthenticatedUserLanguage();
        }

        $tabGroups = array();
        if (!empty($_REQUEST['dropdown_lang'])) {
            $selected_lang = $_REQUEST['dropdown_lang'];
        } else {
            $selected_lang = $locale->getAuthenticatedUserLanguage();
        }

        $slot_count = $params['slot_count'];
        $completedIndexes = array();
        for ($count = 0; $count < $slot_count; $count++) {
            if ($params['delete_' . $count] == 1 || !isset($params['slot_' . $count])) {
                continue;
            }

            $index = $params['slot_' . $count];
            if (isset($completedIndexes[$index])) {
               continue;
            }

            $labelID = (!empty($params['tablabelid_' . $index]))?$params['tablabelid_' . $index]: 'LBL_GROUPTAB' . $count . '_'. time();
            $labelValue = SugarCleaner::stripTags(from_html($params['tablabel_' . $index]), false);
            $app_strings = return_application_language($grouptab_lang);
            if (empty($app_strings[$labelID]) || $app_strings[$labelID] != $labelValue) {
                $contents = return_custom_app_list_strings_file_contents($grouptab_lang);
                $new_contents = replace_or_add_app_string($labelID,$labelValue, $contents);
                save_custom_app_list_strings_contents($new_contents, $grouptab_lang);

                $languages = get_languages();
                foreach ($languages as $language => $langlabel) {
                    if ($grouptab_lang == $language) {
                        continue;
                    }
                    $app_strings = return_application_language($language);
                    if (!isset($app_strings[$labelID])){
                        $contents = return_custom_app_list_strings_file_contents($language);
                        $new_contents = replace_or_add_app_string($labelID,$labelValue, $contents);
                        save_custom_app_list_strings_contents($new_contents, $language);
                    }
                }

                $app_strings[$labelID] = $labelValue;
            }
            $tabGroups[$labelID] = array('label'=>$labelID);
            $tabGroups[$labelID]['modules']= array();
            for($subcount = 0; isset($params[$index.'_' . $subcount]); $subcount++){
                $tabGroups[$labelID]['modules'][] = $params[$index.'_' . $subcount];
            }

            $completedIndexes[$index] = true;
        }

        // Force a rebuild of the app language
        global $current_user;
        include(SugarAutoLoader::existingCustomOne('modules/Administration/RebuildJSLang.php'));
        sugar_cache_clear('app_strings.'.$grouptab_lang);
        $newFile = create_custom_directory('include/tabConfig.php');
        write_array_to_file("GLOBALS['tabStructure']", $tabGroups, $newFile);
        $GLOBALS['tabStructure'] = $tabGroups;
    }
}
