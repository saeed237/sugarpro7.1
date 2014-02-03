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

 * Description:  Contains a variety of utility functions for the Import module
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

/**
 * Returns an input control for this fieldname given
 *
 * @param  string $module
 * @param  string $fieldname
 * @param  string $vardef
 * @param  string $value
 * @return string html for input element for this control
 */
function getControl(
    $module,
    $fieldname,
    $vardef = null,
    $value = ''
    )
{
    global $current_language, $app_strings, $dictionary, $app_list_strings, $current_user;

    // use the mod_strings for this module
    $mod_strings = return_module_language($current_language,$module);

 	// set the filename for this control
    $file = create_cache_directory('modules/Import/') . $module . $fieldname . '.tpl';

    if ( !is_file($file)
            || inDeveloperMode()
            || !empty($_SESSION['developerMode']) ) {

        if ( !isset($vardef) ) {
            $focus = BeanFactory::getBean($module);
            $vardef = $focus->getFieldDefinition($fieldname);
        }

        // if this is the id relation field, then don't have a pop-up selector.
        if( $vardef['type'] == 'relate' && $vardef['id_name'] == $vardef['name']) {
            $vardef['type'] = 'varchar';
        }

        // create the dropdowns for the parent type fields
        if ( $vardef['type'] == 'parent_type' ) {
            $vardef['type'] = 'enum';
        }

        // remove the special text entry field function 'getEmailAddressWidget'
        if ( isset($vardef['function'])
                && ( $vardef['function'] == 'getEmailAddressWidget'
                    || $vardef['function']['name'] == 'getEmailAddressWidget' ) )
            unset($vardef['function']);

        // load SugarFieldHandler to render the field tpl file
        static $sfh;

        if(!isset($sfh)) {
            require_once('include/SugarFields/SugarFieldHandler.php');
            $sfh = new SugarFieldHandler();
        }

        $displayParams = array();
        $displayParams['formName'] = 'importstep3';

        $contents = $sfh->displaySmarty('fields', $vardef, 'ImportView', $displayParams);

        // Remove all the copyright comments
        $contents = preg_replace('/\{\*[^\}]*?\*\}/', '', $contents);

        // hack to disable one of the js calls in this control
        if ( isset($vardef['function'])
                && ( $vardef['function'] == 'getCurrencyDropDown'
                    || $vardef['function']['name'] == 'getCurrencyDropDown' ) )
        $contents .= "{literal}<script>function CurrencyConvertAll() { return; }</script>{/literal}";

        // Save it to the cache file
        if($fh = @sugar_fopen($file, 'w')) {
            fputs($fh, $contents);
            fclose($fh);
        }
    }

    // Now render the template we received
    $ss = new Sugar_Smarty();

    // Create Smarty variables for the Calendar picker widget
    global $timedate;
    $time_format = $timedate->get_user_time_format();
    $date_format = $timedate->get_cal_date_format();
    $ss->assign('USER_DATEFORMAT', $timedate->get_user_date_format());
 	$ss->assign('TIME_FORMAT', $time_format);
    $time_separator = ":";
    $match = array();
    if(preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match)) {
        $time_separator = $match[1];
    }
    $t23 = strpos($time_format, '23') !== false ? '%H' : '%I';
    if(!isset($match[2]) || $match[2] == '') {
        $ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . "%M");
    }
    else {
        $pm = $match[2] == "pm" ? "%P" : "%p";
        $ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . "%M" . $pm);
    }

    $ss->assign('CALENDAR_FDOW', $current_user->get_first_day_of_week());

    // populate the fieldlist from the vardefs
    $fieldlist = array();
    if ( !isset($focus) || !($focus instanceof SugarBean) )
        $focus = BeanFactory::getBean($module);
    // create the dropdowns for the parent type fields
    if ( $vardef['type'] == 'parent_type' ) {
        $focus->field_defs[$vardef['name']]['options'] = $focus->field_defs[$vardef['group']]['options'];
    }
    $vardefFields = $focus->getFieldDefinitions();
    foreach ( $vardefFields as $name => $properties ) {
        $fieldlist[$name] = $properties;
        // fill in enums
        if(isset($fieldlist[$name]['options']) && is_string($fieldlist[$name]['options']) && isset($app_list_strings[$fieldlist[$name]['options']]))
            $fieldlist[$name]['options'] = $app_list_strings[$fieldlist[$name]['options']];
        // Bug 32626: fall back on checking the mod_strings if not in the app_list_strings
        elseif(isset($fieldlist[$name]['options']) && is_string($fieldlist[$name]['options']) && isset($mod_strings[$fieldlist[$name]['options']]))
            $fieldlist[$name]['options'] = $mod_strings[$fieldlist[$name]['options']];
        // Bug 22730: make sure all enums have the ability to select blank as the default value.
        if(isset($fieldlist[$name]['options']) && is_array($fieldlist[$name]['options']) && !isset($fieldlist[$name]['options']['']))
            $fieldlist[$name]['options'][''] = '';
    }
    // fill in function return values
    if ( !in_array($fieldname,array('email1','email2')) )
    {
        if (!empty($fieldlist[$fieldname]['function']['returns']) && $fieldlist[$fieldname]['function']['returns'] == 'html')
        {

            $function = $fieldlist[$fieldname]['function']['name'];
            // include various functions required in the various vardefs
            if ( isset($fieldlist[$fieldname]['function']['include']) && is_file($fieldlist[$fieldname]['function']['include']))
                require_once($fieldlist[$fieldname]['function']['include']);
            $value = $function($focus, $fieldname, $value, 'EditView');
            // Bug 22730 - add a hack for the currency type dropdown, since it's built by a function.
            if ( preg_match('/getCurrency.*DropDown/s',$function)  )
                $value = str_ireplace('</select>','<option value="">'.$app_strings['LBL_NONE'].'</option></select>',$value);
        }
        elseif($fieldname == 'assigned_user_name' && empty($value))
        {
            $fieldlist['assigned_user_id']['value'] = $GLOBALS['current_user']->id;
            $value = $GLOBALS['current_user']->full_name;
        }
        elseif($fieldname == 'team_name' && empty($value))
        {
            $value = json_encode(array());
        }
    }
    $fieldlist[$fieldname]['value'] = $value;
    $ss->assign("fields",$fieldlist);
    $ss->assign("form_name",'importstep3');
    $ss->assign("bean",$focus);

    // add in any additional strings
    $ss->assign("MOD", $mod_strings);
    $ss->assign("APP", $app_strings);
    return $ss->fetch($file);
}
