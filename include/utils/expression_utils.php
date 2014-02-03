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



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

//utility functions for use with the expression object



function translate_operator($operator, $type="php"){
	$php_operator_array = array(
		"More Than" => ">",
		"Less Than" => "<",
		"Equals" => "=",
		"Does not Equal" => "!=",	
	);
	
	$sql_operator_array = array(
	"More Than" => ">",
	"Less Than" => "<",
	"Equals" => "=",
	"Does not Equal" => "!=",
	);
	
	//two types.  PHP and SQL
	
	if($type=="php"){
		return $php_operator_array[$operator];
	}
	if($type=="sql"){

		return $sql_operator_array[$operator];
	}		
	

	
//end function translate_operator
}	

function setup_filter_records($target_list, $target_exp_array, $type="php"){
	
	$optional_where['lhs_field'] = $target_exp_array['lhs_field'];
	$optional_where['operator'] = translate_operator($target_exp_array['operator'], $type);
	$optional_where['rhs_value'] = $target_exp_array['rhs_value'];
	//remove the unnecessary rel_list items
	return filter_out_linked_records($target_list, $optional_where['lhs_field'], $optional_where['operator'], $optional_where['rhs_value']);

//end function setup_filter_records
}	


function filter_out_linked_records($rel_list, $lhs_field, $operator, $rhs_value){
	
		$new_rel_list = array();
	
	
	foreach($rel_list as $key => $rel_object){

		if(compare_values($rel_object, $lhs_field, $operator, $rhs_value)===false){
			unset($rel_list[$key]);
		}	
	}
	$rel_list = array_values($rel_list);
	return $rel_list;
	
	
//end function filter_out_linked_records
}	

function compare_values(& $target_object, $lhs_field, $operator, $rhs_value){

	if($rhs_value=="bool_true" || $rhs_value=="bool_false"){
		return compare_bool_values($target_object, $lhs_field, $operator, $rhs_value);
	}
	if($operator=="="){
		if($target_object->$lhs_field == $rhs_value) return true;
	}
	if($operator=="!="){
		if($target_object->$lhs_field != $rhs_value) return true;	
	}	
	if($operator=="<"){
		if($target_object->$lhs_field < $rhs_value) return true;
	}
	if($operator==">"){
		if($target_object->$lhs_field > $rhs_value) return true;
	}
	
		return false;
	
//end function compare_values
}	

function compare_bool_values(& $target_object, $lhs_field, $operator, $rhs_value){
		
	if($rhs_value == "bool_true"){
			if(
			$target_object->$lhs_field == "on" || 
			$target_object->$lhs_field==1 ||
			$target_object->$lhs_field==true
			 ) return true;
		} 
		if($rhs_value == "bool_false"){
			if(
			$target_object->$lhs_field == "off" || 
			$target_object->$lhs_field==0 ||
			$target_object->$lhs_field==false
			 ) return true;
		}		
		
		return false;
		
//end function compare_bool_values
}

//rrs - bug 10466
function convert_bool($value, $type="", $dbType = ''){
	if($value=="bool_true"){
		if($type=="relate" || ($type == 'bool' && empty($dbType))){
			return "1";
		} else {	
			return "on";
		}
	}
	if($value=="bool_false"){
		if($type=="relate" || ($type == 'bool' && empty($dbType))){
			return "0";
		} else {	
			return "off";
		}
	}
		return $value;	
	
//end function convert_bool
}



function build_filter_where($table_name, $where, $filter_array){
	
	if($where!=""){
		$where .= " AND ";	
	}	
	
	//field
	$where .= $table_name.".".$filter_array['lhs_field']." ";
	
	//operator
	$where .= translate_operator($filter_array['operator'], "sql");
	
	//value
	$where .= "'".$filter_array['rhs_value']."'";
	
	return $where;
	
//end function build_filter_where
}	



function compare_values_number($lhs_field, $operator, $rhs_value){
	
	if($operator=="="){
		if($lhs_field == $rhs_value) return true;
	}
	if($operator=="!="){
		if($lhs_field != $rhs_value) return true;	
	}	
	if($operator=="<"){
		if($lhs_field < $rhs_value) return true;
	}
	if($operator==">"){
		if($lhs_field > $rhs_value) return true;
	}

		return false;
	
//end function compare_values
}	


function process_rel_type($target_type, $target_filter, $target_list, $action_array, $type_override=false){
	
	if($type_override==true){
		$type_value = $target_type;
	} else {
		$type_value = $action_array[$target_type];
	}		

	//process related list based on target_type (all, first, filter)
	
	if($type_value=="first"){
		
		
		$new_list[0] = $target_list[0];
		return $new_list;
	
	}
	
	if($type_value=="filter"){
		return setup_filter_records($target_list, $action_array[$target_filter]);

	}

	//return the whole list if the type is all
	return $target_list;
	
//end process_rel_type	
}


?>
