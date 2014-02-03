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



require_once('modules/Administration/Common.php');
require_once('modules/Administration/QuickRepairAndRebuild.php');
class DropDownHelper
{
    public $modules = array();
    public function getDropDownModules()
    {
        $dir = dir('modules');
        while ($entry = $dir->read()) {
            if (file_exists('modules/'. $entry . '/EditView.php')) {
                $this->scanForDropDowns('modules/'. $entry . '/EditView.php', $entry);
            }
        }

    }

    public function scanForDropDowns($filepath, $module)
    {
        $contents = file_get_contents($filepath);
        $matches = array();
        preg_match_all('/app_list_strings\s*\[\s*[\'\"]([^\]]*)[\'\"]\s*]/', $contents, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $match) {
                $this->modules[$module][$match] = $match;
            }
        }
    }

    /**
     * Allow for certain dropdowns to be filtered when edited by pre 5.0 studio (eg. Rename Tabs)
     *
     * @param string name
     * @param array dropdown
     * @return array Filtered dropdown list
     */
    public function filterDropDown($name,$dropdown)
    {
        $results = array();
        switch ($name) {
            //When renaming tabs ensure that the modList dropdown is filtered properly.
            case 'moduleList':
                $hiddenModList = array_flip($GLOBALS['modInvisList']);
                $moduleList = array_flip($GLOBALS['moduleList']);

                foreach ($dropdown as $k => $v) {
                    if (isset($moduleList[$k])) {
                        $results[$k] = $v;
                    }
                }
                break;
            default: //By default perform no filtering
                $results = $dropdown;
        }

        return $results;
    }

    /**
     * Takes in the request params from a save request and processes
     * them for the save.
     *
     * @param REQUEST params  $params
     */
    public function saveDropDown($params)
    {
        global $locale;
        $count = 0;
        $dropdown = array();
        $dropdown_name = $params['dropdown_name'];

        if (!empty($_REQUEST['dropdown_lang'])) {
            $selected_lang = $_REQUEST['dropdown_lang'];
        } else {
            $selected_lang = $locale->getAuthenticatedUserLanguage();
        }

        $my_list_strings = return_app_list_strings_language($selected_lang);
        while (isset($params['slot_' . $count])) {
            $index = $params['slot_' . $count];
            $key = (isset($params['key_' . $index]))?SugarCleaner::stripTags($params['key_' . $index]): 'BLANK';
            $value = (isset($params['value_' . $index]))?SugarCleaner::stripTags($params['value_' . $index]): '';
            if ($key == 'BLANK') {
                $key = '';
            }
            
            $key = trim($key);
            $value = trim($value);
            if (empty($params['delete_' . $index])) {
                $dropdown[$key] = $value;
            }
            $count++;
        }

        if ($selected_lang == $GLOBALS['current_language']) {
           $GLOBALS['app_list_strings'][$dropdown_name] = $dropdown;
        }
        $contents = return_custom_app_list_strings_file_contents($selected_lang);

        //get rid of closing tags they are not needed and are just trouble
        $contents = str_replace("?>", '', $contents);
        if (empty($contents)) $contents = "<?php";
        //add new drop down to the bottom
        if (!empty($params['use_push'])) {
            //this is for handling moduleList and such where nothing should be 
            //deleted or anything but they can be renamed
            foreach ($dropdown as $key=>$value) {
                //only if the value has changed or does not exist do we want to add it this way
                if (!isset($my_list_strings[$dropdown_name][$key]) || strcmp($my_list_strings[$dropdown_name][$key], $value) != 0 ) {
                    //clear out the old value
                    $pattern_match = '/\s*\$app_list_strings\s*\[\s*\''.$dropdown_name.'\'\s*\]\[\s*\''.$key.'\'\s*\]\s*=\s*[\'\"]{1}.*?[\'\"]{1};\s*/ism';
                    $contents = preg_replace($pattern_match, "\n", $contents);
                    //add the new ones
                    $contents .= "\n\$app_list_strings['$dropdown_name']['$key']=" . var_export_helper($value) . ";";
                }
            }
        } else {
            //clear out the old value
            $pattern_match = '/\s*\$app_list_strings\s*\[\s*\''.$dropdown_name.'\'\s*\]\s*=\s*array\s*\([^\)]*\)\s*;\s*/ism';
            $contents = preg_replace($pattern_match, "\n", $contents);
            //add the new ones
            $contents .= "\n\$app_list_strings['$dropdown_name']=" . var_export_helper($dropdown) . ";";
        }

        // Bug 40234 - If we have no contents, we don't write the file. Checking for "<?php" because above it's set to that if empty
        if ($contents != "<?php") {
            save_custom_app_list_strings_contents($contents, $selected_lang);
            sugar_cache_reset();
        }
        
        // Bug38011
        $repairAndClear = new RepairAndClear();
        $repairAndClear->module_list = array(translate('LBL_ALL_MODULES'));
        $repairAndClear->show_output = false;
        $repairAndClear->clearJsLangFiles();
        // ~~~~~~~~
    }
}
