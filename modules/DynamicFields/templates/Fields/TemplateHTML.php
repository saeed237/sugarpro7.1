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


class TemplateHTML extends TemplateField{
    var $data_type = 'html';
    var $type = 'html';
    // Size and Len need to be empty to prevent validation errors on the client
    var $size = '';
    var $len = '';
    
    function save($df){
		$this->ext3 = 'text';
		parent::save($df);
	}
	
	function set($values){
       parent::set($values);
       if(!empty($this->ext4)){
           $this->default_value = $this->ext4;
           $this->default = $this->ext4;
       }
        
    }
    
    function get_html_detail(){
      
        return '<div title="' . strtoupper($this->name . '_HELP'). '" >{'.strtoupper($this->name) . '}</div>';
    }
    
    function get_html_edit(){
        return $this->get_html_detail();
    }
    
    function get_html_list(){
        return $this->get_html_detail();
    }
    
    function get_html_search(){
        return $this->get_html_detail();
    }
    
    function get_xtpl_detail(){
        
        return from_html(nl2br($this->ext4));   
    }
    
    function get_xtpl_edit(){
       return  $this->get_xtpl_detail();
    }
    
    function get_xtpl_list(){
        return  $this->get_xtpl_detail();
    }
    function get_xtpl_search(){
        return  $this->get_xtpl_detail();
    }
    
    function get_db_add_alter_table($table){
        return '';
    }

    function get_db_modify_alter_table($table){
        return '';
    }
    

    function get_db_delete_alter_table($table)
    {
        return '' ;
    }
    
    function get_field_def() {
        $def = parent::get_field_def();
        if(!empty($this->ext4)){
       		$def['default_value'] = $this->ext4;
        	$def['default'] = $this->ext4;
        }
        $def['studio'] = 'visible';
        $def['source'] = 'non-db';
		$def['dbType'] = isset($this->ext3) ? $this->ext3 : 'text' ;
        return array_merge($def, $this->get_additional_defs());
    }
    
    
}


?>
