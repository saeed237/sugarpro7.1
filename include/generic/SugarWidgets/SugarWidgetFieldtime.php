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


class SugarWidgetFieldTime extends SugarWidgetFieldDateTime
{
        function displayList($layout_def)
        {
                global $timedate;
                // i guess qualifier and column_function are the same..
                if (! empty($layout_def['column_function']))
                 {
                        $func_name = 'displayList'.$layout_def['column_function'];
                        if ( method_exists($this,$func_name))
                        {
                                return $this->$func_name($layout_def)." \n";
                        }
                }
                
                // Get the date context of the time, important for DST
                $layout_def_date = $layout_def;
                $layout_def_date['name'] = str_replace('time', 'date', $layout_def_date['name']);
                $date = $this->displayListPlain($layout_def_date);
                
                $content = $this->displayListPlain($layout_def);
                
                if(!empty($date)) { // able to get the date context of the time            	
                	$td = explode(' ', $timedate->to_display_date_time($date . ' ' . $content));
	                return $td[1];
                }
                else { // assume there is no time context
                 	return $timedate->to_display_time($content);
                }
        }
}

?>
