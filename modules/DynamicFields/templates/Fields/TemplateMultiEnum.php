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

require_once('modules/DynamicFields/templates/Fields/TemplateEnum.php');
require_once('include/utils/array_utils.php');
class TemplateMultiEnum extends TemplateEnum{
	var $type = 'text';

	function get_html_edit(){
		$this->prepare();
		$xtpl_var = strtoupper( $this->name);
		// MFH BUG#13645
		return "<input type='hidden' name='". $this->name. "' value='0'><select name='". $this->name . "[]' size='5' title='{" . $xtpl_var ."_HELP}' MULTIPLE=true>{OPTIONS_".$xtpl_var. "}</select>";
	}

	function get_xtpl_edit(){
		$name = $this->name;
		$value = '';
		if(isset($this->bean->$name)){
			$value = $this->bean->$name;
		}else{
			if(empty($this->bean->id)){
				$value= $this->default_value;
			}
		}
		if(!empty($this->help)){
		    $returnXTPL[strtoupper($this->name . '_help')] = translate($this->help, $this->bean->module_dir);
		}

		global $app_list_strings;
		$returnXTPL = array();

		$returnXTPL[strtoupper($this->name)] = str_replace('^,^', ',', $value);
		if(empty($this->ext1)){
			$this->ext1 = $this->options;
		}
		$returnXTPL[strtoupper('options_'.$this->name)] = get_select_options_with_id($app_list_strings[$this->ext1], unencodeMultienum( $value));

		return $returnXTPL;


	}
	function prepSave(){

	}
	function get_xtpl_list(){
		return $this->get_xtpl_detail();

	}
	function get_xtpl_detail(){

		$name = $this->name;
		$value = '';
		if(isset($this->bean->$name)){
			$value = $this->bean->$name;
		}else{
			if(empty($this->bean->id)){
				$value= $this->default_value;
			}
		}
		$returnXTPL = array();
		if(empty($value)) return $returnXTPL;
		global $app_list_strings;

        $values = unencodeMultienum( $value);
        $translatedValues = array();

        foreach($values as $val){
            $translated = translate($this->options, '', $val);
            if(is_string($translated))$translatedValues[] = $translated;
        }

		$returnXTPL[strtoupper($this->name)] = implode(', ', $translatedValues);
		return $returnXTPL;




}

	function get_field_def(){
		$def = parent::get_field_def();
		if ( !empty ( $this->ext4 ) )
		{
			// turn off error reporting in case we are unpacking a value that hasn't been packed...
			// this is kludgy, but unserialize doesn't throw exceptions correctly
			if($this->ext4[0] == 'a' && $this->ext4[1] == ':') {
			    $unpacked = @unserialize ( $this->ext4 ) ;
			} else {
			    $unpacked = false;
			}

			// if we have a new error, then unserialize must have failed => we don't have a packed ext4
			// safe to assume that false means the unpack failed, as ext4 will either contain an imploded string of default values, or an array, not a boolean false value
			if ( $unpacked === false && !isset($this->no_default) ) {
				$def [ 'default' ] = $this->ext4 ;
			}
			else
			{
				// we have a packed representation containing one or both of default and dependency
                if ( isset ( $unpacked [ 'default' ] ) && !isset($this->no_default))
					$def [ 'default' ] = $unpacked [ 'default' ] ;
				if ( isset ( $unpacked [ 'dependency' ] ) )
					$def [ 'dependency' ] = $unpacked [ 'dependency' ] ;
			}
		}
		$def['isMultiSelect'] = true;
		unset($def['len']);
		return $def;
	}

	function get_db_default(){
    	return '';
	}

	function save($df) {
		if ( isset ( $this->default ) )
		{
			if ( is_array ( $this->default ) )
				$this->default = encodeMultienumValue($this->default);
			$this->ext4 = ( isset ( $this->dependency ) ) ? serialize ( array ( 'default' => $this->default , 'dependency' => html_entity_decode($this->dependency) ) )  : $this->default ;
		} else
		{
			if ( isset ( $this->dependency ) )
				$this->ext4 = serialize ( array ( 'dependency' => html_entity_decode($this->dependency) ) ) ;
		}
		parent::save($df);
	}
}


?>
