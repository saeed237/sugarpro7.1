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

require_once('soap/SoapErrorDefinitions.php');
class SoapError{
	var $name;
	var $number;
	var $description;

	function SoapError(){
		$this->set_error('no_error');
	}

	function set_error($error_name){
		global $error_defs;
		if(!isset($error_defs[$error_name])){
			$this->name = 'An Undefined Error - ' . $error_name . ' occurred';
			$this->number = '-1';
			$this->description = 'There is no error definition for ' . 	$error_name;
		}else{
			$this->name = $error_defs[$error_name]['name'];
			$this->number = $error_defs[$error_name]['number'];
			$this->description = $error_defs[$error_name]['description'];
		}
	}

	function get_soap_array(){
		return Array('number'=>$this->number,
					 'name'=>$this->name,
					 'description'=>$this->description);

	}

	function getName() {
		return $this->name;
	} // fn

	function getFaultCode() {
		return $this->number;
	} // fn

	function getDescription() {
		return $this->description;
	} // fn


}

?>