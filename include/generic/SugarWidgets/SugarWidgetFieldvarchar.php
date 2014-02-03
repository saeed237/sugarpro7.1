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


class SugarWidgetFieldVarchar extends SugarWidgetReportField
{
 function SugarWidgetFieldVarchar(&$layout_manager) 
 {
        parent::SugarWidgetReportField($layout_manager);
 }
 
 function queryFilterEquals(&$layout_def)
 {
		return $this->_get_column_select($layout_def)."='".$GLOBALS['db']->quote($layout_def['input_name0'])."'\n";
 }

 function queryFilterNot_Equals_Str(&$layout_def)
 {
		return $this->_get_column_select($layout_def)."!='".$GLOBALS['db']->quote($layout_def['input_name0'])."'\n";
 }

 function queryFilterContains(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." LIKE '%".$GLOBALS['db']->quote($layout_def['input_name0'])."%'\n";
 }
  function queryFilterdoes_not_contain(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." NOT LIKE '%".$GLOBALS['db']->quote($layout_def['input_name0'])."%'\n";
 }

 function queryFilterStarts_With(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." LIKE '".$GLOBALS['db']->quote($layout_def['input_name0'])."%'\n";
 }

 function queryFilterEnds_With(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." LIKE '%".$GLOBALS['db']->quote($layout_def['input_name0'])."'\n";
 }
 
 function queryFilterone_of(&$layout_def)
 {
    foreach($layout_def['input_name0'] as $key => $value) {
        $layout_def['input_name0'][$key] = $GLOBALS['db']->quote($value); 
    }
    return $this->_get_column_select($layout_def) . " IN ('" . implode("','", $layout_def['input_name0']) . "')\n";
 }
  
 function displayInput(&$layout_def) 
 {
 		$str = '<input type="text" size="20" value="' . $layout_def['input_name0'] . '" name="' . $layout_def['name'] . '">';
 		return $str;
 }
}

?>
