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

require_once('modules/DynamicFields/templates/Fields/TemplateId.php');
class TemplateCurrencyId extends TemplateId{
    var $max_size = 25;
    var $type='currency_id';
    
    function get_field_def(){
		$def = parent::get_field_def();
		$def['type'] = $this->type;
        $def['dbType'] = 'id';
		$def['studio'] = 'visible';
		$def['function'] = array('name'=>'getCurrencyDropDown', 'returns'=>'html');
		return $def;	
	}
	
	function save($df){
		if(!$df->fieldExists($this->name))
			parent::save($df);
	}
	
	function delete($df){
        if(!$df->fieldExists(null, 'currency'))
        {
            parent::delete($df);
        }
	}
}


?>
