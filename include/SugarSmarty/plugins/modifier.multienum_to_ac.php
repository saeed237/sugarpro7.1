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



function smarty_modifier_multienum_to_ac($value='', $field_options=array()){
	$value = trim($value);
	if(empty($value) || empty($field_options)){
		return '';
	}
	
	$expl = explode("^,^", $value);
	if(count($expl) == 1){
		if(array_key_exists($value, $field_options)){
			return $field_options[$value] . ", ";
		}
		else{
			return '';
		}
	}
	else{
		$final_array = array();
		foreach($expl as $key_val){
			if(array_key_exists($key_val, $field_options)){
				$final_array[] = $field_options[$key_val];
			}
		}
		return implode(", ", $final_array) . ", ";
	}
	
	return '';
}
