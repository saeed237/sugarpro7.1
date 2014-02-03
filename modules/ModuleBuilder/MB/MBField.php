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

class MBField{
	var $type = 'varchar';
	var $name = false;
	var $label = false;
	var $vname = false;
	var $options = false;
	var $length = false;
	var $error = '';
	var $required = false;
	var $reportable = true;
	var $default = 'MSI1';
	var $comment = '';
	
	
	
	function getFieldVardef(){
		if(empty($this->name)){
			$this->error = 'A name is required to create a field';
			return false;
		}		
		if(empty($this->label))$this->label = $this->name;
		$this->name = strtolower($this->getDBName($this->name));
		$vardef = array();
		$vardef['name']=$this->name;
		if(empty($this->vname))$this->vname = 'LBL_' . strtoupper($this->name);
		$vardef['vname'] = $this->addLabel();
		if(!empty($this->required))$vardef['required'] = $this->required;
		if(empty($this->reportable))$vardef['reportable'] = false;
		if(!empty($this->comment))$vardef['comment'] = $this->comment;
		if($this->default !== 'MSI1')$vardef['default'] = $this->default;
		switch($this->type){
			case 'date':
			case 'datetime':
			case 'float':
			case 'int':
				$vardef['type']=$this->type;
				return $vardef;
			case 'bool':
				$vardef['type'] = 'bool';
				$vardef['default'] = (empty($vardef['default']))?0:1;
				return $vardef;
			case 'enum':
				$vardef['type']='enum';
				if(empty($this->options)){
					$this->options = $this->name . '_list';
				}
				$vardef['options'] = $this->addDropdown();
				return $vardef;
			default:
				$vardef['type']='varchar';
				return $vardef;
			
		}
	}
	
	function addDropDown(){
		return $this->options;
	}
	
	function addLabel(){
		return $this->vname;
	}
	
}
?>