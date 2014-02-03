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


/**
 * @param $focus
 * @param $field
 * @param $value
 * @param $view
 * @return string
 */
function getDurationMinutesOptions($focus, $field, $value, $view) {

    if (isset($_REQUEST['duration_minutes'])) {
        $focus->duration_minutes = $_REQUEST['duration_minutes'];
    }
    
	if (!isset($focus->duration_minutes)) {
		$focus->duration_minutes = $focus->minutes_value_default;
	}   
    
    global $timedate;
    //setting default date and time
	if (is_null($focus->date_start))
		$focus->date_start = $timedate->to_display_date(gmdate($timedate->get_date_time_format()));
	if (is_null($focus->duration_hours))
		$focus->duration_hours = "0";
	if (is_null($focus->duration_minutes))
		$focus->duration_minutes = "1";
	
    if($view == 'EditView' || $view == 'MassUpdate' || $view == "QuickCreate"
    || ($view == 'wirelessedit' && $focus->ACLFieldAccess($field, 'write'))
    ) {
       $html = '<select id="duration_minutes" ';
       if($view != 'MassUpdate' 
       		&& $view != 'wirelessedit'
       	 ) {
            $html .= 'onchange="SugarWidgetScheduler.update_time();" ';
       }

       $html .=  'name="duration_minutes">';
       $html .= get_select_options_with_id($focus->minutes_values, $focus->duration_minutes);
       $html .= '</select>';
       return $html;	
    }

    return $focus->duration_minutes;		
}

/**
 * @param $focus
 * @param $field
 * @param $value
 * @param $view
 * @return string
 *
 * @deprecated 6.5.0
 */
function getReminderTime($focus, $field, $value, $view) {

	global $current_user, $app_list_strings;
	$reminder_t = -1;
    
	if (!empty($_REQUEST['full_form']) && !empty($_REQUEST['reminder_time'])) {
		$reminder_t = $_REQUEST['reminder_time'];
	} else if (isset($focus->reminder_time)) {
		$reminder_t = $focus->reminder_time;
	} else if (isset($value)) {
        $reminder_t = $value;
    }

	if($view == 'EditView' || $view == 'MassUpdate' || $view == "SubpanelCreates" || $view == "QuickCreate"
    || $view == 'wirelessedit'
    ) {
		global $app_list_strings;
        $html = '<select id="reminder_time" name="reminder_time">';
        $html .= get_select_options_with_id($app_list_strings['reminder_time_options'], $reminder_t);
        $html .= '</select>';
        return $html;
    }
 
    if($reminder_t == -1) {
       return "";
    }
       
    return translate('reminder_time_options', '', $reminder_t);    
}

?>
