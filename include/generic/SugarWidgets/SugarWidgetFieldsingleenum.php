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



 
class SugarWidgetFieldSingleEnum extends SugarWidgetFieldEnum {
    
    function displayInput(&$layout_def) {
        global $app_list_strings;

        if(!empty($layout_def['remove_blank']) && $layout_def['remove_blank']) {
            if ( is_array($layout_def['options']) ) {
                $ops = $layout_def['options'];
            }
            elseif (isset($layout_def['options']) && isset($app_list_strings[$layout_def['options']])){ 
            	$ops = $app_list_strings[$layout_def['options']];
                if(array_key_exists('', $app_list_strings[$layout_def['options']])) {
             	   unset($ops['']);
	            }
            }
            else{
            	$ops = array();
            }
        }
        else {
            $ops = $app_list_strings[$layout_def['options']];
        }
        
        $str = '<select name="' . $layout_def['name'] . '">';
        $str .= get_select_options_with_id($ops, $layout_def['input_name0']);
        $str .= '</select>';
        return $str;
    }
}
?>