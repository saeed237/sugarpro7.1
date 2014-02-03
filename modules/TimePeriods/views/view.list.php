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


require_once('include/MVC/View/views/view.list.php');

class TimePeriodsViewList extends ViewList
{
    /**
     * Return the "breadcrumbs" to display at the top of the page
     *
     * @param  bool $show_help optional, true if we show the help links
     * @return HTML string containing breadcrumb title
     */
     public function getModuleTitle(
         $show_help = true
         )
    {
    	global $app_list_strings, $mod_strings;

        $warningText = string_format($mod_strings['LBL_LIST_WARNING'], array(
            $app_list_strings['moduleList']['Forecasts'],
            $app_list_strings['moduleList'][$this->module],
        ));

        $float = SugarThemeRegistry::current()->directionality == 'rtl' ? 'right' : 'left';

        $title = '<div><div class="moduleTitle"><h2>' . $app_list_strings['moduleList'][$this->module] . '</h2></div>';
        $title .= "<div class='overdueTask' style='float:{$float}; padding-bottom:10px;'>{$warningText}</div></div>";
        return $title;
    }


 	public function preDisplay()
 	{
 	    global $current_user;
        
        if ( !is_admin($current_user) 
                && !is_admin_for_module($current_user,'Forecasts')
                && !is_admin_for_module($current_user,'ForecastSchedule') )
            sugar_die("Unauthorized access to administration.");
 	    
 		$this->lv = new ListViewSmarty();
 		$this->lv->showMassupdateFields = false;
 	}
}
