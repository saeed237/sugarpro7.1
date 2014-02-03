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

class ViewJson extends SugarView{
	var $type ='detail';
	function ViewJson(){
 		parent::SugarView();
 	}
 	
	function display(){
 		global $beanList;
		$module = $GLOBALS['module'];
		$json = getJSONobj();
		$bean = $this->bean;
		$all_fields = array_merge($bean->column_fields,$bean->additional_column_fields);
		
		$js_fields_arr = array();
		foreach($all_fields as $field) {
			if(isset($bean->$field)) {
				$bean->$field = from_html($bean->$field);
				$bean->$field = preg_replace('/\r\n/','<BR>',$bean->$field);
				$bean->$field = preg_replace('/\n/','<BR>',$bean->$field);
				$js_fields_arr[$field] = addslashes($bean->$field);
			}
		}
		$out = $json->encode($js_fields_arr, true);
		ob_clean();
		print($out);
		sugar_cleanup(true);
	}
}
?>
