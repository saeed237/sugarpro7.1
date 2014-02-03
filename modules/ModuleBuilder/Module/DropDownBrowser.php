<?php
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


class DropDownBrowser
{
    // Restrict the full dropdown list to remove some options that shouldn't be edited by the end users
    public static $restrictedDropdowns = array(
        'eapm_list',
        'eapm_list_documents',
        'eapm_list_import',
        'extapi_meeting_password',
        'Elastic_boost_options',
        'commit_stage_dom',
        'commit_stage_custom_dom',
        'commit_stage_binary_dom',
        'forecasts_config_ranges_options_dom',
        'forecasts_timeperiod_types_dom',
        'forecast_schedule_status_dom',
        'forecasts_chart_options_group',
        'forecasts_config_worksheet_layout_forecast_by_options_dom',
        'forecasts_timeperiod_options_dom',
        // 'moduleList', // We may want to put this in at a later date
        // 'moduleListSingular', // Same with this
    );

    function getNodes()
    {
	    global $mod_strings, $app_list_strings;
		$nodes = array();
//      $nodes[$mod_strings['LBL_EDIT_DROPDOWNS']] = array( 'name'=>$mod_strings['LBL_EDIT_DROPDOWNS'], 'action' =>'module=ModuleBuilder&action=globaldropdown&view_package=studio', 'imageTitle' => 'SPUploadCSS', 'help' => 'editDropDownBtn');
   //     $nodes[$mod_strings['LBL_ADD_DROPDOWN']] = array( 'name'=>$mod_strings['LBL_ADD_DROPDOWN'], 'action'=>'module=ModuleBuilder&action=globaldropdown&view_package=studio','imageTitle' => 'SPSync', 'help' => 'addDropDownBtn');
        
        $my_list_strings = $app_list_strings;
        foreach($my_list_strings as $key=>$value){
        	if(!is_array($value)){
        		unset($my_list_strings[$key]);
        	}
        }

        foreach ( self::$restrictedDropdowns as $restrictedDropdown ) {
            unset($my_list_strings[$restrictedDropdown]);
        }

        $dropdowns = array_keys($my_list_strings);
        asort($dropdowns);
        foreach($dropdowns as $dd)
        {
            if (!empty($dd))
            {
                $nodes[$dd] = array( 'name'=>$dd, 'action'=>"module=ModuleBuilder&action=dropdown&view_package=studio&dropdown_name=$dd",'imageTitle' => 'SPSync', 'help' => 'editDropDownBtn');
            }
        }
        return $nodes;
    }

}
?>
