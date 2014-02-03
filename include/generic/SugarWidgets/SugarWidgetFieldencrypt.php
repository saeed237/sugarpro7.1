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


class SugarWidgetFieldEncrypt extends SugarWidgetReportField
{
    public function SugarWidgetFieldEncrypt($layout_manager) {
        parent::SugarWidgetReportField($layout_manager);
    }

    function queryFilterEquals(&$layout_def)
    {
        require_once("include/utils/encryption_utils.php");
        $search_value = blowfishEncode(blowfishGetKey('encrypt_field'),$layout_def['input_name0']);
        return $this->_get_column_select($layout_def)."='".$GLOBALS['db']->quote($search_value)."'\n";
    }

    function queryFilterNot_Equals_Str(&$layout_def)
    {
        require_once("include/utils/encryption_utils.php");
        $search_value = blowfishEncode(blowfishGetKey('encrypt_field'),$layout_def['input_name0']);
        return $this->_get_column_select($layout_def)."!='".$GLOBALS['db']->quote($search_value)."'\n";
    }

    function displayList($layout_def) {
            return $this->displayListPlain($layout_def);
    }

    function displayListPlain($layout_def) {
            $value= $this->_get_list_value($layout_def);

            require_once("include/utils/encryption_utils.php");

            $value = blowfishDecode(blowfishGetKey('encrypt_field'), $value);
            return $value;
    }
       
}