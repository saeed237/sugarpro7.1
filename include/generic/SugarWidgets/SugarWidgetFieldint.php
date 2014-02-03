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



class SugarWidgetFieldInt extends SugarWidgetReportField
{
 function displayList($layout_def)
 {

 	return $this->displayListPlain($layout_def);
 }

 function queryFilterEquals(&$layout_def)
 {
                return $this->_get_column_select($layout_def)."= ".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterNot_Equals(&$layout_def)
 {
                return $this->_get_column_select($layout_def)."!=".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterGreater(&$layout_def)
 {
                return $this->_get_column_select($layout_def)." > ".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterLess(&$layout_def)
 {
                return $this->_get_column_select($layout_def)." < ".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterBetween(&$layout_def)
 {
 	             return $this->_get_column_select($layout_def)." BETWEEN ".$GLOBALS['db']->quote($layout_def['input_name0']). " AND " . $GLOBALS['db']->quote($layout_def['input_name1']) . "\n";
 }

    public function queryFiltergreater_equal(&$layout_def)
    {
        return $this->_get_column_select($layout_def) . " >= " . $GLOBALS['db']->quote($layout_def['input_name0']) . "\n";
    }

    public function queryFilterLess_Equal(&$layout_def)
    {
        return $this->_get_column_select($layout_def) . " <= " . $GLOBALS['db']->quote($layout_def['input_name0']) . "\n";
    }

 function queryFilterStarts_With(&$layout_def)
 {
 	return $this->queryFilterEquals($layout_def);
 }

 function displayInput(&$layout_def)
 {
 	 return '<input type="text" size="20" value="' . $layout_def['input_name0'] . '" name="' . $layout_def['name'] . '">';

 }
 
 function display($layout_def)
 {
	   //Bug40995
	   if(isset($obj->layout_manager->defs['reporter']->focus->field_name_map[$layout_def['name']]['precision']))
	   {
		   $precision=$obj->layout_manager->defs['reporter']->focus->field_name_map[$layout_def['name']]['precision'];
		   $layout_def['precision']=$precision;
	   }
	   //Bug40995
       return parent::display($layout_def);
 } 

}
