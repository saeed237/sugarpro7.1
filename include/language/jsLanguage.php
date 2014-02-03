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


class jsLanguage
{
    /**
     * Creates javascript versions of language files
     */
    public function jsLanguage()
    {
    }

    public function createAppStringsCache($lang = 'en_us')
    {
        // cn: bug 8242 - non-US langpack chokes
        $app_strings = return_application_language($lang);
        $app_list_strings = return_app_list_strings_language($lang);

        $json = getJSONobj();
        $app_list_strings_encoded = $json->encode($app_list_strings);
        $app_strings_encoded = $json->encode($app_strings);

        $str = <<<EOQ
SUGAR.language.setLanguage('app_strings', $app_strings_encoded);
SUGAR.language.setLanguage('app_list_strings', $app_list_strings_encoded);
EOQ;

        $cacheDir = create_cache_directory('jsLanguage/');
        if ($fh = @sugar_fopen($cacheDir . $lang . '.js', "w")) {
            fputs($fh, $str);
            fclose($fh);
        }
    }

    public function createModuleStringsCache($moduleDir, $lang = 'en_us', $return = false)
    {
        global $mod_strings;
        $json = getJSONobj();

        // cn: bug 8242 - non-US langpack chokes
        // Allows for modification of mod_strings by individual modules prior to
        // sending down to JS
        if (empty($mod_strings)) {
            $mod_strings = return_module_language($lang, $moduleDir);
        }

        $mod_strings_encoded = $json->encode($mod_strings);
        $str = "SUGAR.language.setLanguage('" . $moduleDir . "', " . $mod_strings_encoded . ");";

        $cacheDir = create_cache_directory('jsLanguage/' . $moduleDir . '/');

        if ($fh = @fopen($cacheDir . $lang . '.js', "w")) {
            fputs($fh, $str);
            fclose($fh);
        }

        if ($return) {
            return $str;
        }
    }

}
