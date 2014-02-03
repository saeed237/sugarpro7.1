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

class LocaleApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'path' => array('locale'),
                'pathVars' => array(),
                'method' => 'localeOptions',
                'shortHelp' => 'Gets locale options so UI can populate the corresponding dropdowns',
                'longHelp' => 'include/api/help/locale_options_get_help.html',
                'ignoreMetaHash' => true,
                'keepSession' => true,
            ),
        );
    }

    public function localeOptions($api, $args)
    {
        global $locale, $sugar_config, $current_user;
        $data = array();
        $dformat = $locale->getPrecedentPreference($current_user->id?'datef':'default_date_format', $current_user);
        $tformat = $locale->getPrecedentPreference($current_user->id?'timef':'default_time_format', $current_user);
        $nformat = $locale->getPrecedentPreference('default_locale_name_format', $current_user);
        if (!array_key_exists($nformat, $sugar_config['name_formats'])) {
            $nformat = $sugar_config['default_locale_name_format'];
        }
        $data['timepref'] = $sugar_config['time_formats'];
        $data['datepref'] = $sugar_config['date_formats'];
        $data['default_locale_name_format'] = $locale->getUsableLocaleNameOptions($sugar_config['name_formats']);
        $data['timezone'] = $timezoneList = TimeDate::getTimezoneList();
        $data['_hash'] = $current_user->getUserMDHash();
        return $data;
    }

}

