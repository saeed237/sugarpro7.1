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


function get_expression($express_type, $first, $second){
	
	if($express_type=="+"){
		return express_add($first, $second);
	}	
	if($express_type=="-"){
		return express_subtract($first, $second);
	}		
	if($express_type=="*"){
		return express_multiple($first, $second);
	}		
	if($express_type=="/"){
		return express_divide($first, $second);
	}			
//end function get_expression
}

function express_add($first, $second){
	return $first + $second;
}	

function express_subtract($first, $second){
	return $first - $second;
}

function express_multiple($first, $second){
	return $first * $second;
}

function express_divide($first, $second){
	return $first / $second;
}



?>
