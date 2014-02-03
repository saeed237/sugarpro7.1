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


require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
require_once('modules/Currencies/Currency.php');

class SugarFieldInt extends SugarFieldBase
{
    public function formatField($rawField, $vardef){
        if ( !empty($vardef['disable_num_format']) ) {
            return $rawField;
        }
        if ( $rawField === '' || $rawField === NULL ) {
            return '';
        }

        return format_number($rawField,0,0);
    }

    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties){
        $data[$fieldName] = isset($bean->$fieldName) && is_numeric($bean->$fieldName)
                            ? (int)$bean->$fieldName : null;
    }

    public function unformatField($formattedField, $vardef){
        if ( $formattedField === '' || $formattedField === NULL ) {
            return '';
        }
        return (int)unformat_number($formattedField);
    }

    /**
     * getSearchWhereValue
     *
     * Checks and returns a sane value based on the field type that can be used when building the where clause in a
     * search form.
     *
     * @param $value Mixed value being searched on
     * @return Int the value for the where clause used in search
     */
    function getSearchWhereValue($value) {
        $newVal = parent::getSearchWhereValue($value);
        if (!is_numeric($newVal)){
            if(strpos($newVal, ',') > 0) {
                $multiVals = explode(',', $newVal);
                 $newVal = '';
                 foreach($multiVals as $key => $val) {
                     if (!empty($newVal))
                         $newVal .= ',';
                     if(!empty($val) && !(is_numeric($val)))
                         $newVal .= -1;
                     else
                         $newVal .= $val;
                 }
                 return $newVal;
            } else {
                return -1;
            }
        }
        return $newVal;
    }

    public function unformatSearchRequest(&$inputData, &$field) {
        $field['value'] = $this->unformatField($field['value'],$field);
    }

    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        // Use the basic field type for searches, no need to format/unformat everything... for now
    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        if($this->isRangeSearchView($vardef)) {
           $id = isset($displayParams['idName']) ? $displayParams['idName'] : $vardef['name'];
 		   $this->ss->assign('original_id', "{$id}");
           $this->ss->assign('id_range', "range_{$id}");
           $this->ss->assign('id_range_start', "start_range_{$id}");
           $this->ss->assign('id_range_end', "end_range_{$id}");
           $this->ss->assign('id_range_choice', "{$id}_range_choice");
           return $this->fetch('include/SugarFields/Fields/Int/RangeSearchForm.tpl');
        }

    	return $this->fetch($this->findTemplate('SearchForm'));
    }

    /**
     * @see SugarFieldBase::importSanitize()
     */
    public function importSanitize(
        $value,
        $vardef,
        $focus,
        ImportFieldSanitize $settings
        )
    {
        $value = str_replace($settings->num_grp_sep,"",$value);
        if (!is_numeric($value) || strstr($value,".")) {
            return false;
        }

        return $value;
    }
}