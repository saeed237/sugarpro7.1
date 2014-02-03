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


require_once('include/generic/SugarWidgets/SugarWidgetFieldvarchar.php');

class SugarWidgetFieldText extends SugarWidgetFieldVarchar
{
    function SugarWidgetFieldText(&$layout_manager) {
        parent::SugarWidgetFieldVarchar($layout_manager);
    }

    function queryFilterEquals($layout_def)
    {
        return $this->reporter->db->convert($this->_get_column_select($layout_def), "text2char").
        	" = ".$this->reporter->db->quoted($layout_def['input_name0']);
    }

    function queryFilterNot_Equals_Str($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        return "($column IS NULL OR ". $this->reporter->db->convert($column, "text2char")." != ".
            $this->reporter->db->quoted($layout_def['input_name0']).")";
    }

    function queryFilterNot_Empty($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        return "($column IS NOT NULL AND ".$this->reporter->db->convert($column, "length")." > 0)";
    }

    function queryFilterEmpty($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        return "($column IS NULL OR ".$this->reporter->db->convert($column, "length")." = 0)";
    }
	
    function displayList($layout_def) {
        return nl2br(parent::displayListPlain($layout_def));
    }
}
