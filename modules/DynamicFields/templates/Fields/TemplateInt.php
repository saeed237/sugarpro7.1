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

require_once('modules/DynamicFields/templates/Fields/TemplateRange.php');

class TemplateInt extends TemplateRange
{
	var $type = 'int';
    var $supports_unified_search = true;

	public function __construct(){
		parent::__construct();
		$this->vardef_map['autoinc_next'] = 'autoinc_next';
		$this->vardef_map['autoinc_start'] = 'autoinc_start';
		$this->vardef_map['auto_increment'] = 'auto_increment';
        
        $this->vardef_map['min'] = 'ext1';
        $this->vardef_map['max'] = 'ext2';
        $this->vardef_map['disable_num_format'] = 'ext3';
    }

	function get_html_edit(){
		$this->prepare();
		return "<input type='text' name='". $this->name. "' id='".$this->name."' title='{" . strtoupper($this->name) ."_HELP}' size='".$this->size."' maxlength='".$this->len."' value='{". strtoupper($this->name). "}'>";
	}

	function populateFromPost(){
		parent::populateFromPost();
		if (isset($this->auto_increment))
		{
		    $this->auto_increment = $this->auto_increment == "true" || $this->auto_increment === true;
		}
	}

    function get_field_def(){
		$vardef = parent::get_field_def();
		$vardef['disable_num_format'] = isset($this->disable_num_format) ? $this->disable_num_format : $this->ext3;//40005

        $vardef['min'] = isset($this->min) ? $this->min : $this->ext1;
        $vardef['max'] = isset($this->max) ? $this->max : $this->ext2;
        $vardef['min'] = filter_var($vardef['min'], FILTER_VALIDATE_INT);
        $vardef['max'] = filter_var($vardef['max'], FILTER_VALIDATE_INT);
        if ($vardef['min'] !== false || $vardef['max'] !== false)
        {
            $vardef['validation'] = array(
                'type' => 'range',
                'min' => $vardef['min'],
                'max' => $vardef['max']
            );
        }

        if(!empty($this->auto_increment))
		{
			$vardef['auto_increment'] = $this->auto_increment;
			if ((empty($this->autoinc_next)) && isset($this->module) && isset($this->module->table_name))
			{
				global $db;
                $helper = $db->gethelper();
                $auto = $helper->getAutoIncrement($this->module->table_name, $this->name);
                $this->autoinc_next = $vardef['autoinc_next'] = $auto;
			}
		}
		return $vardef;
    }

    function save($df){
        $next = false;
		if (!empty($this->auto_increment) && (!empty($this->autoinc_next) || !empty($this->autoinc_start)) && isset($this->module))
        {
            if (!empty($this->autoinc_start) && $this->autoinc_start > $this->autoinc_next)
			{
				$this->autoinc_next = $this->autoinc_start;
			}
			if(isset($this->module->table_name)){
				global $db;
	            $helper = $db->gethelper();
	            //Check that the new value is greater than the old value
	            $oldNext = $helper->getAutoIncrement($this->module->table_name, $this->name);
	            if ($this->autoinc_next > $oldNext)
	            {
	                $helper->setAutoIncrementStart($this->module->table_name, $this->name, $this->autoinc_next);
				}
			}
			$next = $this->autoinc_next;
			$this->autoinc_next = false;
        }
		parent::save($df);
		if ($next)
		  $this->autoinc_next = $next;
    }
}


?>
